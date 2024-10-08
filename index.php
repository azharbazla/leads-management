<?php
session_start();
require 'php/config.php';
$pdo = Config::getInstance();

$leads = isset($_SESSION['leads']) ? $_SESSION['leads'] : [];
$id_sales_filter = isset($_SESSION['id_sales_filter']) ? $_SESSION['id_sales_filter'] : null;
$id_produk_filter = isset($_SESSION['id_produk_filter']) ? $_SESSION['id_produk_filter'] : null;
$bulan_filter = isset($_SESSION['bulan_filter']) ? $_SESSION['bulan_filter'] : null;

if (empty($leads) &&
    (!$id_sales_filter || $id_sales_filter == "") &&
    (!$id_produk_filter || $id_produk_filter == "") &&
    (!$bulan_filter || $bulan_filter == "")) {

    $leadsQuery = $pdo->query('SELECT leads_management.leads.*, leads_management.sales.nama_sales, leads_management.produk.nama_produk 
                                FROM leads_management.leads 
                                INNER JOIN leads_management.sales ON leads_management.leads.id_sales = leads_management.sales.id_sales 
                                INNER JOIN leads_management.produk ON leads.id_produk = leads_management.produk.id_produk');
    $leads = $leadsQuery->fetchAll();
}

unset($_SESSION['id_sales_filter'], $_SESSION['id_produk_filter'], $_SESSION['bulan_filter']);

$salesQuery = $pdo->query('SELECT id_sales, nama_sales FROM leads_management.sales');
$sales = $salesQuery->fetchAll();

$produkQuery = $pdo->query('SELECT id_produk, nama_produk FROM leads_management.produk');
$produk = $produkQuery->fetchAll();

$bulanQuery = $pdo->query("SELECT DISTINCT MONTH(tanggal) AS bulan FROM leads_management.leads");
$bulan = $bulanQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads Management</title>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Daftar Leads</h2>
    <form class="mb-4" action="php/search.php" method="POST">
        <div class="row align-items-center">
            <div class="col-md-3">
                <label for="id_sales" class="form-label">Cari berdasarkan Sales</label>
                <select class="form-select" id="id_sales" name="id_sales">
                    <option value="" <?= $id_sales_filter ? '' : 'selected'; ?>>-- Semua Sales --</option>
                    <?php foreach ($sales as $sale): ?>
                        <option value="<?= $sale['id_sales']; ?>" <?= $id_sales_filter == $sale['id_sales'] ? 'selected' : ''; ?>><?= $sale['nama_sales']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="id_produk" class="form-label">Cari berdasarkan Produk</label>
                <select class="form-select" id="id_produk" name="id_produk">
                    <option value="" <?= $id_produk_filter ? '' : 'selected'; ?>>-- Semua Produk --</option>
                    <?php foreach ($produk as $proyek): ?>
                        <option value="<?= $proyek['id_produk']; ?>" <?= $id_produk_filter == $proyek['id_produk'] ? 'selected' : ''; ?>><?= $proyek['nama_produk']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="bulan" class="form-label">Cari berdasarkan Bulan</label>
                <select class="form-select" id="bulan" name="bulan">
                    <option value="" <?= $bulan_filter ? '' : 'selected'; ?>>-- Semua Bulan --</option>
                    <?php foreach ($bulan as $bln): ?>
                        <option value="<?= $bln['bulan']; ?>" <?= $bulan_filter == $bln['bulan'] ? 'selected' : ''; ?>><?= date('F', mktime(0, 0, 0, $bln['bulan'], 10)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col mt-3 d-flex align-items-center">
                <button type="submit" class="btn btn-primary me-2">Cari</button>
                <a href="add_leads.php" class="btn btn-success border-0">Tambah Leads</a>
            </div>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead>
        <tr class="text-center">
            <th>No.</th>
            <th>ID Input</th>
            <th>Tanggal</th>
            <th>Sales</th>
            <th>Produk</th>
            <th>Nama Leads</th>
            <th>No Wa</th>
            <th>Kota</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        if (empty($leads)):
            echo "<tr><td colspan='8' class='text-center'>Pencarian tidak ditemukan.</td></tr>";
        else:
            foreach ($leads as $lead): ?>
                <tr class="text-center">
                    <td><?= $no++; ?></td>
                    <td><?= str_pad($lead['id_leads'], 3, '0', STR_PAD_LEFT); ?></td>
                    <td><?= date('d/m/Y', strtotime($lead['tanggal'])); ?></td>
                    <td><?= $lead['nama_sales']; ?></td>
                    <td><?= $lead['nama_produk']; ?></td>
                    <td><?= $lead['nama_lead']; ?></td>
                    <td><?= $lead['no_wa']; ?></td>
                    <td><?= $lead['kota']; ?></td>
                </tr>
            <?php endforeach;
        endif;
        ?>
        </tbody>
    </table>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
