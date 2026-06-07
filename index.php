<?php

require_once __DIR__ . "/controllers/ManajemenRumahSakit.php";

$manajemenRumahSakit = new ManajemenRumahSakit();

$page = $_GET["page"] ?? "dashboard";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Rumah Sakit</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        .navbar {
            background: linear-gradient(135deg, #0f4c81, #1f7a8c);
            color: white;
            padding: 26px 50px 18px;
        }

        .navbar h1 {
            margin: 0;
            font-size: 28px;
        }

        .navbar p {
            margin: 8px 0 22px;
            color: #e6f4f8;
            font-size: 15px;
        }

        .menu {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .menu a {
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 14px;
            font-weight: bold;
        }

        .menu a:hover {
            background: rgba(255, 255, 255, 0.28);
        }

        .menu a.active {
            background: white;
            color: #0f4c81;
        }

        .container {
            width: 94%;
            max-width: 1300px;
            margin: 30px auto;
        }

        .info-box {
            background: white;
            border-left: 6px solid #1f7a8c;
            padding: 20px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(15, 76, 129, 0.08);
            margin-bottom: 24px;
        }

        .info-box h2 {
            margin: 0 0 8px;
            font-size: 20px;
            color: #0f4c81;
        }

        .info-box p {
            margin: 0;
            color: #5b6472;
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 18px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(15, 76, 129, 0.08);
            border: 1px solid #e5edf5;
        }

        .stat-card p {
            margin: 0;
            font-size: 14px;
            color: #64748b;
        }

        .stat-card h3 {
            margin: 10px 0 6px;
            color: #0f4c81;
            font-size: 28px;
        }

        .stat-card span {
            font-size: 13px;
            color: #7b8794;
        }

        .wide h3 {
            font-size: 24px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 28px;
            box-shadow: 0 8px 24px rgba(15, 76, 129, 0.08);
            border: 1px solid #e5edf5;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .section-header h2 {
            margin: 0;
            color: #0f4c81;
            font-size: 22px;
        }

        .section-header p {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #d8e3ef;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 900px;
        }

        .data-table th {
            background: #0f4c81;
            color: white;
            padding: 14px 16px;
            text-align: left;
            font-size: 14px;
            white-space: nowrap;
        }

        .data-table td {
            padding: 13px 16px;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
            vertical-align: top;
        }

        .data-table tr:hover {
            background: #f8fbff;
        }

        .name-cell {
            font-weight: bold;
            color: #1f2937;
        }

        .total-cell {
            font-weight: bold;
            color: #0f4c81;
            white-space: nowrap;
        }

        .desc-cell {
            min-width: 420px;
            line-height: 1.5;
            color: #475569;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .badge-bpjs {
            background: #e1f5ea;
            color: #16794c;
        }

        .badge-asuransi {
            background: #e8f0ff;
            color: #2454a6;
        }

        .badge-umum {
            background: #fff3dd;
            color: #9a5a00;
        }

        .footer {
            text-align: center;
            color: #7b8794;
            font-size: 13px;
            padding: 10px 0 30px;
        }

        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 24px;
            }

            .navbar h1 {
                font-size: 22px;
            }

            .container {
                width: 92%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h1>Sistem Manajemen Layanan Medis & BPJS Rumah Sakit</h1>
        <p>Implementasi PHP OOP, MySQL, Polymorphic Collection, dan Dynamic Binding</p>

        <div class="menu">
            <a href="index.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
            <a href="index.php?page=pasien" class="<?= $page == 'pasien' ? 'active' : '' ?>">Semua Pasien</a>
            <a href="index.php?page=bpjs" class="<?= $page == 'bpjs' ? 'active' : '' ?>">Pasien BPJS</a>
            <a href="index.php?page=asuransi" class="<?= $page == 'asuransi' ? 'active' : '' ?>">Pasien Asuransi</a>
            <a href="index.php?page=umum" class="<?= $page == 'umum' ? 'active' : '' ?>">Pasien Umum</a>
            <a href="index.php?page=laporan" class="<?= $page == 'laporan' ? 'active' : '' ?>">Laporan Klaim</a>
        </div>
    </div>

    <div class="container">

        <?php if ($page == "dashboard") : ?>

            <div class="info-box">
                <h2>Dashboard Laporan Pasien Rawat Inap</h2>
                <p>
                    Sistem ini menampilkan data pasien BPJS, pasien asuransi swasta, dan pasien umum.
                    Data pasien diambil dari database MySQL, lalu dibentuk menjadi object berdasarkan model masing-masing.
                    Perhitungan biaya dilakukan melalui method <b>hitungTotalBiaya()</b> yang dioverride di setiap subclass.
                </p>
            </div>

            <?php $manajemenRumahSakit->tampilkanRingkasanStatistik(); ?>

            <div class="card">
                <?php $manajemenRumahSakit->cetakLaporanKlaimLayanan(); ?>
            </div>

        <?php elseif ($page == "pasien") : ?>

            <div class="card">
                <?php $manajemenRumahSakit->tampilkanSemuaPasien(); ?>
            </div>

        <?php elseif ($page == "bpjs") : ?>

            <div class="card">
                <?php $manajemenRumahSakit->tampilkanDataPasienBPJS(); ?>
            </div>

        <?php elseif ($page == "asuransi") : ?>

            <div class="card">
                <?php $manajemenRumahSakit->tampilkanDataPasienAsuransi(); ?>
            </div>

        <?php elseif ($page == "umum") : ?>

            <div class="card">
                <?php $manajemenRumahSakit->tampilkanDataPasienUmum(); ?>
            </div>

        <?php elseif ($page == "laporan") : ?>

            <div class="card">
                <?php $manajemenRumahSakit->cetakLaporanKlaimLayanan(); ?>
            </div>

        <?php else : ?>

            <div class="info-box">
                <h2>Halaman tidak ditemukan</h2>
                <p>Menu yang dipilih tidak tersedia.</p>
            </div>

        <?php endif; ?>

    </div>

    <div class="footer">
        Projek UAS Praktikum Pemrograman Berorientasi Objek - Kasus B Rumah Sakit
    </div>

</body>
</html>