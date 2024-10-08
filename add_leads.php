<?php
require 'php/config.php';
$pdo = Config::getInstance();
$salesQuery = $pdo->query('SELECT id_sales, nama_sales FROM leads_management.sales');
$sales = $salesQuery->fetchAll();
$produkQuery = $pdo->query('SELECT id_produk, nama_produk FROM leads_management.produk');
$produk = $produkQuery->fetchAll();

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success')
        echo '<div class="alert alert-success" role="alert"> Data berhasil disimpan! </div>';
    elseif ($_GET['status'] === 'error')
        echo '<div class="alert alert-danger" role="alert"> Terjadi kesalahan saat menyimpan data! </div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Leads</title>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Selamat Datang Di Tambah Leads</h2>
    <form class="border border-2 border-black rounded-4 p-3 pb-5" action="php/simpan.php" method="POST">
        <a href="index.php" type="submit" class="m-1 btn btn-primary border-0"
           style="background-color: limegreen; border-radius: 30px;">Kembali</a>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <div class="col-md-4">
                <label for="id_sales" class="form-label">Sales</label>
                <select class="form-select" id="id_sales" name="id_sales" required>
                    <option value="" selected disabled>--Pilih Sales--</option>
                    <?php foreach ($sales as $sale): ?>
                        <option value="<?= $sale['id_sales']; ?>"><?= $sale['nama_sales']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="nama_lead" class="form-label">Nama Lead</label>
                <input type="text" class="form-control" id="nama_lead" name="nama_lead" placeholder="Nama Lead" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_produk" class="form-label">Produk</label>
                <select class="form-select" id="id_produk" name="id_produk" required>
                    <option value="" selected disabled>--Pilih Proyek--</option>
                    <?php foreach ($produk as $proyek): ?>
                        <option value="<?= $proyek['id_produk']; ?>"><?= $proyek['nama_produk']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="no_wa" class="form-label">No. Whatsapp</label>
                <input type="text" class="form-control" id="no_wa" name="no_wa" placeholder="No. Whatsapp" required>
            </div>
            <div class="col-md-4">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" placeholder="Asal Kota" required>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary border-0" style="background-color: rebeccapurple;">Simpan</button>
            <a href="index.php" class="btn btn-light text-black">Cancel</a>
        </div>
    </form>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>