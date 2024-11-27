<?php
require_once __DIR__ . '/../../src/controller/TerminalController.php';
require_once __DIR__ . '/../../database/db_connection.php';

$controller = new TerminalController($pdo);

if (isset($_GET['id'])) {
    $id_terminal = $_GET['id'];
    $terminal = $controller->getTerminalById($id_terminal);
} else {
    die("Terminal tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'lokasi_terminal' => $_POST['lokasi_terminal'],
        'nama_terminal' => $_POST['nama_terminal']
    ];

    $controller->updateTerminal($id_terminal, $data);
    header("Location: terminal.php");
    exit();
}
?>

<h1>Edit Terminal</h1>
<form method="POST">
    <label>Lokasi Terminal:</label>
    <input type="text" name="lokasi_terminal" value="<?= htmlspecialchars($terminal['lokasi_terminal']) ?>" required>
    <br>
    <label>Nama Terminal:</label>
    <input type="text" name="nama_terminal" value="<?= htmlspecialchars($terminal['nama_terminal']) ?>" required>
    <br>
    <button type="submit">Simpan</button>
</form>