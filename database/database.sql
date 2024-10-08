CREATE DATABASE IF NOT EXISTS leads_management;
USE leads_management;

CREATE TABLE leads
(
    id_leads  INT PRIMARY KEY,
    tanggal   DATE,
    id_sales  INT,
    id_produk INT,
    no_wa     VARCHAR(15),
    nama_lead VARCHAR(50),
    kota      VARCHAR(50),
    id_user   INT
);

CREATE TABLE produk
(
    id_produk   INT PRIMARY KEY,
    nama_produk VARCHAR(100)
);

CREATE TABLE sales
(
    id_sales   INT PRIMARY KEY,
    nama_sales VARCHAR(50)
);

INSERT INTO produk (id_produk, nama_produk)
VALUES (1, 'Cipta Residence 2'),
       (2, 'The Rich'),
       (3, 'Namorambe City'),
       (4, 'Grand Banten'),
       (5, 'Turi Mansion'),
       (6, 'Cipta Residence 1');

INSERT INTO sales (id_sales, nama_sales)
VALUES (1, 'Sales 1'),
       (2, 'Sales 2'),
       (3, 'Sales 3');


