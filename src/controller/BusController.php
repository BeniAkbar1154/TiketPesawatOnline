<?php

require_once __DIR__ . '/../model/BusModel.php';

class BusController
{
    private $busModel;

    public function __construct($pdo)
    {
        $this->busModel = new BusModel($pdo);
    }

    public function getAllBuses()
    {
        return $this->busModel->getAllBuses();
    }

    public function getBusById($id)
    {
        return $this->busModel->getBusById($id);
    }

    public function createBus($data, $file)
    {
        $uploadDir = __DIR__ . '/../../public/gambar/bus/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (isset($file['gambar']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
            $tempPath = $file['gambar']['tmp_name'];
            $fileName = uniqid() . '.jpg';
            $destination = $uploadDir . $fileName;

            if ($this->resizeImage($tempPath, $destination, 400, 400)) {
                $data['gambar'] = 'public/gambar/bus/' . $fileName;
            } else {
                throw new Exception("Gagal memproses gambar.");
            }
        } else {
            throw new Exception("Gagal mengunggah gambar.");
        }

        $this->busModel->createBus($data);
    }

    private function resizeImage($sourcePath, $destinationPath, $width, $height)
    {
        list($originalWidth, $originalHeight) = getimagesize($sourcePath);
        $image = imagecreatefromstring(file_get_contents($sourcePath));
        $resizedImage = imagecreatetruecolor($width, $height);

        imagecopyresampled(
            $resizedImage,
            $image,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $originalWidth,
            $originalHeight
        );

        $result = imagejpeg($resizedImage, $destinationPath, 90);
        imagedestroy($image);
        imagedestroy($resizedImage);

        return $result;
    }

    public function updateBus($id, $data, $file)
    {
        // Ambil data bus lama
        $oldBus = $this->busModel->getBusById($id);
        if (!$oldBus) {
            throw new Exception("Bus tidak ditemukan.");
        }

        // Jika ada file gambar baru yang diunggah
        if (isset($file['gambar']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/gambar/bus/';
            $tempPath = $file['gambar']['tmp_name'];
            $fileName = uniqid() . '.jpg';
            $destination = $uploadDir . $fileName;

            // Resize dan simpan gambar baru
            if ($this->resizeImage($tempPath, $destination, 400, 400)) {
                $data['gambar'] = 'gambar/bus/' . $fileName;

                // Hapus gambar lama jika ada
                if (!empty($oldBus['gambar']) && file_exists(__DIR__ . '/../../public/' . $oldBus['gambar'])) {
                    unlink(__DIR__ . '/../../public/' . $oldBus['gambar']);
                }
            } else {
                throw new Exception("Gagal memproses gambar baru.");
            }
        } else {
            // Gunakan gambar lama jika tidak ada file baru
            $data['gambar'] = $oldBus['gambar'];
        }

        // Update data bus di database
        $this->busModel->updateBus($id, $data);
    }


    public function deleteBus($id)
    {
        $this->busModel->deleteBus($id);
    }
}
