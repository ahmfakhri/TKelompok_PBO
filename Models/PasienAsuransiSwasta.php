<?php

require_once __DIR__ . "/Pasien.php";

class PasienAsuransiSwasta extends Pasien
{
    private $namaProvider;
    private $nomorPolis;
    private $limitCover;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari, $namaProvider, $nomorPolis, $limitCover)
    {
        parent::__construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari);

        $this->namaProvider = $namaProvider;
        $this->nomorPolis = $nomorPolis;
        $this->limitCover = $limitCover;
    }

    public function getNamaProvider()
    {
        return $this->namaProvider;
    }

    public function getNomorPolis()
    {
        return $this->nomorPolis;
    }

    public function getLimitCover()
    {
        return $this->limitCover;
    }

    public function hitungTotalBiaya()
    {
        $biayaDasar = $this->hitungBiayaDasar();

        if ($biayaDasar > $this->limitCover) {
            return $biayaDasar - $this->limitCover;
        }

        return 0;
    }

    public function cetakKlaimLayanan()
    {
        return "Pasien Asuransi Swasta atas nama {$this->nama} menggunakan provider {$this->namaProvider} dengan nomor polis {$this->nomorPolis}.";
    }
}