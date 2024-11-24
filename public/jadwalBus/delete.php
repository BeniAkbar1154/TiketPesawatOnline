<!-- public/jadwalBus/delete.php -->
<?php
require_once '../../src/controller/JadwalBusController.php';
$controller = new JadwalBusController();

$id = $_GET['id'];

if ($controller->deleteSchedule($id)) {
    header("Location: jadwalBus.php");
} else {
    echo "Gagal menghapus jadwal bus.";
}
?>