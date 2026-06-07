<?php

require_once __DIR__ . "/../dal/PasienDAL.php";

class ManajemenRumahSakit
{
    private $pasienDAL;
    private $daftarPasien = [];

    public function __construct()
    {
        $this->pasienDAL = new PasienDAL();
        $this->daftarPasien = $this->pasienDAL->getSemuaPasien();
    }

    private function formatRupiah($angka)
    {
        return "Rp " . number_format($angka, 0, ",", ".");
    }

    private function getJenisPasien($pasien)
    {
        if ($pasien instanceof PasienBPJS) {
            return "BPJS";
        }

        if ($pasien instanceof PasienAsuransiSwasta) {
            return "Asuransi Swasta";
        }

        if ($pasien instanceof PasienUmum) {
            return "Umum";
        }

        return "Tidak Diketahui";
    }

    private function getBadgeClass($pasien)
    {
        if ($pasien instanceof PasienBPJS) {
            return "badge badge-bpjs";
        }

        if ($pasien instanceof PasienAsuransiSwasta) {
            return "badge badge-asuransi";
        }

        if ($pasien instanceof PasienUmum) {
            return "badge badge-umum";
        }

        return "badge";
    }

    public function tampilkanRingkasanStatistik()
    {
        $totalPasien = count($this->daftarPasien);
        $totalBPJS = 0;
        $totalAsuransi = 0;
        $totalUmum = 0;
        $totalBiaya = 0;

        foreach ($this->daftarPasien as $pasien) {
            if ($pasien instanceof PasienBPJS) {
                $totalBPJS++;
            } elseif ($pasien instanceof PasienAsuransiSwasta) {
                $totalAsuransi++;
            } elseif ($pasien instanceof PasienUmum) {
                $totalUmum++;
            }

            $totalBiaya += $pasien->hitungTotalBiaya();
        }

        echo "
            <div class='stats-grid'>
                <div class='stat-card'>
                    <p>Total Pasien</p>
                    <h3>{$totalPasien}</h3>
                    <span>Seluruh data pasien</span>
                </div>

                <div class='stat-card'>
                    <p>Pasien BPJS</p>
                    <h3>{$totalBPJS}</h3>
                    <span>Subsidi 90%</span>
                </div>

                <div class='stat-card'>
                    <p>Pasien Asuransi</p>
                    <h3>{$totalAsuransi}</h3>
                    <span>Berdasarkan limit cover</span>
                </div>

                <div class='stat-card'>
                    <p>Pasien Umum</p>
                    <h3>{$totalUmum}</h3>
                    <span>Administrasi tambahan</span>
                </div>

                <div class='stat-card wide'>
                    <p>Total Tagihan Pasien</p>
                    <h3>" . $this->formatRupiah($totalBiaya) . "</h3>
                    <span>Hasil perhitungan seluruh subclass</span>
                </div>
            </div>
        ";
    }

    public function tampilkanSemuaPasien()
    {
        echo "
            <div class='section-header'>
                <div>
                    <h2>Data Seluruh Pasien</h2>
                    <p>Data pasien rawat inap berdasarkan jenis penjamin layanan.</p>
                </div>
            </div>
        ";

        echo "<div class='table-wrapper'>";
        echo "<table class='data-table'>";
        echo "
            <tr>
                <th>ID Pasien</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Lama Rawat</th>
                <th>Biaya Kamar / Hari</th>
                <th>Jenis Pasien</th>
            </tr>
        ";

        foreach ($this->daftarPasien as $pasien) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($pasien->getIdPasien()) . "</td>";
            echo "<td class='name-cell'>" . htmlspecialchars($pasien->getNama()) . "</td>";
            echo "<td>" . htmlspecialchars($pasien->getUsia()) . " tahun</td>";
            echo "<td>" . htmlspecialchars($pasien->getLamaRawat()) . " hari</td>";
            echo "<td>" . $this->formatRupiah($pasien->getBiayaKamarPerHari()) . "</td>";
            echo "<td><span class='" . $this->getBadgeClass($pasien) . "'>" . $this->getJenisPasien($pasien) . "</span></td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }

    public function tampilkanDataPasienBPJS()
    {
        echo "
            <div class='section-header'>
                <div>
                    <h2>Data Model Pasien BPJS</h2>
                    <p>Data pasien yang dibentuk dari class PasienBPJS.php.</p>
                </div>
            </div>
        ";

        echo "<div class='table-wrapper'>";
        echo "<table class='data-table'>";
        echo "
            <tr>
                <th>ID Pasien</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Lama Rawat</th>
                <th>Biaya Kamar / Hari</th>
                <th>Nomor PBI</th>
                <th>Faskes Asal</th>
                <th>Kelas Kamar</th>
                <th>Total Biaya</th>
            </tr>
        ";

        foreach ($this->daftarPasien as $pasien) {
            if ($pasien instanceof PasienBPJS) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($pasien->getIdPasien()) . "</td>";
                echo "<td class='name-cell'>" . htmlspecialchars($pasien->getNama()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getUsia()) . " tahun</td>";
                echo "<td>" . htmlspecialchars($pasien->getLamaRawat()) . " hari</td>";
                echo "<td>" . $this->formatRupiah($pasien->getBiayaKamarPerHari()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getNomorPBI()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getFaskesAsal()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getKelasKamar()) . "</td>";
                echo "<td class='total-cell'>" . $this->formatRupiah($pasien->hitungTotalBiaya()) . "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>";
    }

    public function tampilkanDataPasienAsuransi()
    {
        echo "
            <div class='section-header'>
                <div>
                    <h2>Data Model Pasien Asuransi Swasta</h2>
                    <p>Data pasien yang dibentuk dari class PasienAsuransiSwasta.php.</p>
                </div>
            </div>
        ";

        echo "<div class='table-wrapper'>";
        echo "<table class='data-table'>";
        echo "
            <tr>
                <th>ID Pasien</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Lama Rawat</th>
                <th>Biaya Kamar / Hari</th>
                <th>Nama Provider</th>
                <th>Nomor Polis</th>
                <th>Limit Cover</th>
                <th>Total Biaya</th>
            </tr>
        ";

        foreach ($this->daftarPasien as $pasien) {
            if ($pasien instanceof PasienAsuransiSwasta) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($pasien->getIdPasien()) . "</td>";
                echo "<td class='name-cell'>" . htmlspecialchars($pasien->getNama()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getUsia()) . " tahun</td>";
                echo "<td>" . htmlspecialchars($pasien->getLamaRawat()) . " hari</td>";
                echo "<td>" . $this->formatRupiah($pasien->getBiayaKamarPerHari()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getNamaProvider()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getNomorPolis()) . "</td>";
                echo "<td>" . $this->formatRupiah($pasien->getLimitCover()) . "</td>";
                echo "<td class='total-cell'>" . $this->formatRupiah($pasien->hitungTotalBiaya()) . "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>";
    }

    public function tampilkanDataPasienUmum()
    {
        echo "
            <div class='section-header'>
                <div>
                    <h2>Data Model Pasien Umum</h2>
                    <p>Data pasien yang dibentuk dari class PasienUmum.php.</p>
                </div>
            </div>
        ";

        echo "<div class='table-wrapper'>";
        echo "<table class='data-table'>";
        echo "
            <tr>
                <th>ID Pasien</th>
                <th>Nama</th>
                <th>Usia</th>
                <th>Lama Rawat</th>
                <th>Biaya Kamar / Hari</th>
                <th>NIK</th>
                <th>Metode Pembayaran</th>
                <th>Total Biaya</th>
            </tr>
        ";

        foreach ($this->daftarPasien as $pasien) {
            if ($pasien instanceof PasienUmum) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($pasien->getIdPasien()) . "</td>";
                echo "<td class='name-cell'>" . htmlspecialchars($pasien->getNama()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getUsia()) . " tahun</td>";
                echo "<td>" . htmlspecialchars($pasien->getLamaRawat()) . " hari</td>";
                echo "<td>" . $this->formatRupiah($pasien->getBiayaKamarPerHari()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getNik()) . "</td>";
                echo "<td>" . htmlspecialchars($pasien->getMetodePembayaran()) . "</td>";
                echo "<td class='total-cell'>" . $this->formatRupiah($pasien->hitungTotalBiaya()) . "</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
        echo "</div>";
    }

    public function cetakLaporanKlaimLayanan()
    {
        echo "
            <div class='section-header'>
                <div>
                    <h2>Laporan Klaim Layanan dan Total Biaya</h2>
                    <p>Perhitungan biaya dilakukan melalui method overriding pada masing-masing subclass pasien.</p>
                </div>
            </div>
        ";

        echo "<div class='table-wrapper'>";
        echo "<table class='data-table'>";
        echo "
            <tr>
                <th>ID Pasien</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Biaya Dasar</th>
                <th>Total Biaya</th>
                <th>Keterangan Klaim</th>
            </tr>
        ";

        foreach ($this->daftarPasien as $pasien) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($pasien->getIdPasien()) . "</td>";
            echo "<td class='name-cell'>" . htmlspecialchars($pasien->getNama()) . "</td>";
            echo "<td><span class='" . $this->getBadgeClass($pasien) . "'>" . $this->getJenisPasien($pasien) . "</span></td>";
            echo "<td>" . $this->formatRupiah($pasien->hitungBiayaDasar()) . "</td>";
            echo "<td class='total-cell'>" . $this->formatRupiah($pasien->hitungTotalBiaya()) . "</td>";
            echo "<td class='desc-cell'>" . htmlspecialchars($pasien->cetakKlaimLayanan()) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }
}