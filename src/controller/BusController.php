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
        // Path folder tempat menyimpan gambar
        $uploadDir = __DIR__ . '/../../public/gambar/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Proses upload gambar
        $uploadedFile = $file['gambar'];
        if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
            $tempPath = $uploadedFile['tmp_name'];
            $fileName = uniqid() . '.jpg'; // Nama file unik
            $destination = $uploadDir . $fileName;

            // Resize gambar ke ukuran 400x400
            if ($this->resizeImage($tempPath, $destination, 400, 400)) {
                // Update data gambar
                $data['gambar'] = 'public/gambar/' . $fileName;
            } else {
                throw new Exception("Gagal memproses gambar.");
            }
        } else {
            throw new Exception("Gagal mengunggah gambar.");
        }

        // Simpan data ke database
        return $this->busModel->createBus($data);
    }


    private function resizeImage($sourcePath, $destinationPath, $width, $height)
    {
        list($originalWidth, $originalHeight) = getimagesize($sourcePath);
        $image = imagecreatefromstring(file_get_contents($sourcePath));
        $resizedImage = imagecreatetruecolor($width, $height);

        // Resize gambar
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

        // Simpan gambar ke path tujuan
        $result = imagejpeg($resizedImage, $destinationPath, 90); // 90 adalah kualitas JPEG
        imagedestroy($image);
        imagedestroy($resizedImage);

        return $result;
    }

    public function updateBus($id, $data)
    {
        return $this->busModel->updateBus($id, $data);
    }

    public function deleteBus($id)
    {
        return $this->busModel->deleteBus($id);
    }
}
?>