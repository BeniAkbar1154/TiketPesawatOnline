<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/src/controller/NomorKursiController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_bus = $_POST['id_bus'];
    $kapasitas = $_POST['kapasitas'];
    $nomorKursiController = new NomorKursiController($pdo);
    $nomorKursiController->generate($id_bus, $kapasitas);
    header("Location: nomor_bus.php?id_bus=$id_bus");
}
?>
<form method="POST">
    <input type="hidden" name="id_bus" value="<?= htmlspecialchars($_GET['id_bus']) ?>">
    <label for="kapasitas">Kapasitas:</label>
    <input type="number" name="kapasitas" required>
    <button type="submit">Generate Kursi</button>
</form>