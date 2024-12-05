<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/TiketTransportasiOnline/database/db_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/path/to/tcpdf/tcpdf.php';

// Mengambil ID pemesanan dari URL parameter
$id_pemesanan = $_GET['id'] ?? null;

// Memastikan ID pemesanan ada
if ($id_pemesanan) {
    // Ambil detail pemesanan berdasarkan ID pemesanan
    $stmt = $pdo->prepare("
        SELECT p.id_pemesanan, u.username, b.nama AS bus, t1.nama_terminal AS rute_keberangkatan, t2.nama_terminal AS rute_tujuan, 
               p.nomor_kursi, p.status, p.id_user, j.id_jadwal_bus
        FROM pemesanan p
        JOIN user u ON p.id_user = u.id_user
        JOIN jadwal_bus j ON p.id_jadwal_bus = j.id_jadwal_bus
        JOIN bus b ON j.id_bus = b.id_bus
        JOIN terminal t1 ON j.rute_keberangkatan = t1.id_terminal
        JOIN terminal t2 ON j.rute_tujuan = t2.id_terminal
        WHERE p.id_pemesanan = :id_pemesanan
    ");
    $stmt->execute(['id_pemesanan' => $id_pemesanan]);
    $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek jika data pemesanan ditemukan
    if ($pemesanan) {
        // Cek apakah tiket sudah ada
        $checkTicketStmt = $pdo->prepare("
            SELECT id_tiket FROM tiket WHERE id_pemesanan = :id_pemesanan
        ");
        $checkTicketStmt->execute(['id_pemesanan' => $id_pemesanan]);
        $existingTicket = $checkTicketStmt->fetch(PDO::FETCH_ASSOC);

        if ($existingTicket) {
            echo "Tiket ini sudah pernah digenerate sebelumnya.";
        } else {
            // Generate nomor tiket unik
            $ticketNumber = strtoupper(uniqid('TKT')); // Buat nomor tiket unik

            // Menyimpan data tiket ke dalam tabel tiket
            $insertStmt = $pdo->prepare("
                INSERT INTO tiket (id_pemesanan, id_user, id_jadwal_bus, nomor_kursi)
                VALUES (:id_pemesanan, :id_user, :id_jadwal_bus, :nomor_kursi)
            ");
            $insertStmt->execute([
                'id_pemesanan' => $pemesanan['id_pemesanan'],
                'id_user' => $pemesanan['id_user'],
                'id_jadwal_bus' => $pemesanan['id_jadwal_bus'],
                'nomor_kursi' => $pemesanan['nomor_kursi']
            ]);

            // Membuat PDF
            $pdf = new TCPDF();
            $pdf->AddPage();

            // Menambahkan konten tiket ke PDF
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Cell(0, 10, 'Tiket Bus - ' . htmlspecialchars($ticketNumber), 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->Cell(0, 10, 'Nomor Tiket: ' . htmlspecialchars($ticketNumber), 0, 1);
            $pdf->Cell(0, 10, 'Nama Pengguna: ' . htmlspecialchars($pemesanan['username']), 0, 1);
            $pdf->Cell(0, 10, 'Bus: ' . htmlspecialchars($pemesanan['bus']), 0, 1);
            $pdf->Cell(0, 10, 'Rute: ' . htmlspecialchars($pemesanan['rute_keberangkatan']) . ' - ' . htmlspecialchars($pemesanan['rute_tujuan']), 0, 1);
            $pdf->Cell(0, 10, 'Nomor Kursi: ' . htmlspecialchars($pemesanan['nomor_kursi']), 0, 1);
            $pdf->Cell(0, 10, 'Status Pemesanan: ' . htmlspecialchars($pemesanan['status']), 0, 1);

            // Menghasilkan file PDF
            $pdfFileName = 'tiket_' . $ticketNumber . '.pdf';
            $pdf->Output($pdfFileName, 'I');  // Output file ke browser untuk diunduh
        }
    } else {
        echo "Pemesan dengan ID tersebut tidak ditemukan.";
    }
} else {
    echo "ID pemesanan tidak ditemukan.";
}
?>