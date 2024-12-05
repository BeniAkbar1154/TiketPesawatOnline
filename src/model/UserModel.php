<?php

class UserModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Mendapatkan semua user
    public function fetchAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Ambil data user berdasarkan ID
     *
     * @param int $id
     * @return array|null
     */
    /******  ab7a060d-f2cd-4b4e-b33d-e9bd5ca6188b  *******/    // Menambahkan user baru
    public function insertUser($data)
    {
        // Periksa apakah email sudah ada
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetchColumn() > 0) {
            return false; // Email sudah terdaftar
        }

        // Jika belum ada, masukkan data user
        $stmt = $this->pdo->prepare("INSERT INTO user (username, email, password, level) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['username'], $data['email'], $data['password'], $data['level']]);
    }

    // Mendapatkan user berdasarkan ID
    public function fetchUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update data user
    public function updateUser($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE user SET username = ?, email = ?, password = ?, level = ? WHERE id_user = ?");
        return $stmt->execute([$data['username'], $data['email'], $data['password'], $data['level'], $id]);
    }

    // Hapus user berdasarkan ID
    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM user WHERE id_user = ?");
        return $stmt->execute([$id]);
    }
}
?>