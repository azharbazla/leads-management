<?php
session_start();
require 'config.php';
$pdo = Config::getInstance();

$id_sales = isset($_POST['id_sales']) ? $_POST['id_sales'] : null;
$id_produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : null;
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : null;

$_SESSION['id_sales_filter'] = $id_sales;
$_SESSION['id_produk_filter'] = $id_produk;
$_SESSION['bulan_filter'] = $bulan;

$query = "SELECT leads_management.leads.*, leads_management.sales.nama_sales, leads_management.produk.nama_produk 
          FROM leads_management.leads
          INNER JOIN leads_management.sales ON leads.id_sales = sales.id_sales 
          INNER JOIN leads_management.produk ON leads.id_produk = produk.id_produk WHERE 1=1";

if ($id_sales && $id_sales != "") $query .= " AND leads.id_sales = :id_sales";
if ($id_produk && $id_produk != "") $query .= " AND leads.id_produk = :id_produk";
if ($bulan && $bulan != "") $query .= " AND MONTH(leads.tanggal) = :bulan";

$stmt = $pdo->prepare($query);

if ($id_sales && $id_sales != "") $stmt->bindParam(':id_sales', $id_sales);
if ($id_produk && $id_produk != "") $stmt->bindParam(':id_produk', $id_produk);
if ($bulan && $bulan != "") $stmt->bindParam(':bulan', $bulan);

$stmt->execute();
$leads = $stmt->fetchAll();

if (!empty($leads)) $_SESSION['leads'] = $leads;
else $_SESSION['leads'] = [];

header('Location: ../index.php');
exit();
