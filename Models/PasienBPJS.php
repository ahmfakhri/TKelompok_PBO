<?php

require_once __DIR__ . "/Pasien.php";

class PasienBPJS extends Pasien
{
    private $nomorPBI;
    private $faskesAsal;
    private $kelasKamar;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari, $nomorPBI, $faskesAsal, $kelasKamar)
    {
        parent::__construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari);

        $this->nomorPBI = $nomorPBI;
        $this->faskesAsal = $faskesAsal;
        $this->kelasKamar = $kelasKamar;
    }

    public function getNomorPBI()
    {
        return $this->nomorPBI;
    }

    public function getFaskesAsal()
    {
        return $this->faskesAsal;
    }

    public function getKelasKamar()
    {
        return $this->kelasKamar;
    }

    public function hitungTotalBiaya()
    {
        return $this->hitungBiayaDasar() * 0.10;
    }

    public function cetakKlaimLayanan()
    {
        return "Pasien BPJS atas nama {$this->nama} dengan Nomor PBI {$this->nomorPBI} berasal dari {$this->faskesAsal}, menggunakan kamar {$this->kelasKamar}.";
    }
}