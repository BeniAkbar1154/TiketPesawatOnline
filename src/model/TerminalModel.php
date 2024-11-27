<?php

class TerminalModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllTerminals()
    {
        $stmt = $this->pdo->query("SELECT * FROM terminal");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTerminal($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO terminal (lokasi_terminal, nama_terminal) 
            VALUES (:lokasi_terminal, :nama_terminal)
        ");
        return $stmt->execute([
            'lokasi_terminal' => $data['lokasi_terminal'],
            'nama_terminal' => $data['nama_terminal']
        ]);
    }

    public function getTerminalById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM terminal WHERE id_terminal = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTerminal($id, $data)
    {
        $stmt = $this->pdo->prepare("
            UPDATE terminal 
            SET lokasi_terminal = :lokasi_terminal, nama_terminal = :nama_terminal 
            WHERE id_terminal = :id_terminal
        ");
        $data['id_terminal'] = $id;
        return $stmt->execute($data);
    }

    public function deleteTerminal($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM terminal WHERE id_terminal = ?");
        return $stmt->execute([$id]);
    }
}
