<?php

require_once __DIR__ . "/Koneksi.php";

$database = new Koneksi();
$koneksi = $database->getConnection();

if ($koneksi) {
    echo "Koneksi database berhasil.";
}