<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $id_sales = $_POST['id_sales'];
    $id_produk = $_POST['id_produk'];
    $nama_lead = $_POST['nama_lead'];
    $no_wa = $_POST['no_wa'];
    $kota = $_POST['kota'];

    try {
        $pdo = Config::getInstance();
        $sql = "INSERT INTO leads_management.leads (tanggal, id_sales, id_produk, nama_lead, no_wa, kota) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tanggal, $id_sales, $id_produk, $nama_lead, $no_wa, $kota]);
        header("Location: ../add_leads.php?status=success");
        exit();
    } catch (Exception $e) {
        header("Location: ../add_leads.php?status=error");
        exit();
    }
}