<?php
require_once __DIR__ . '/../../src/controller/TerminalController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new TerminalController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'lokasi_terminal' => $_POST['lokasi_terminal'],
        'nama_terminal' => $_POST['nama_terminal']
    ];

    $controller->createTerminal($data);
    header("Location: terminal.php");
    exit();
}
?>

<h1>Tambah Terminal</h1>
<form method="POST">
    <label>Lokasi Terminal:</label>
    <input type="text" name="lokasi_terminal" required>
    <br>
    <label>Nama Terminal:</label>
    <input type="text" name="nama_terminal" required>
    <br>
    <button type="submit">Simpan</button>
</form>