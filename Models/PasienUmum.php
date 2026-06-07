<?php

require_once __DIR__ . "/Pasien.php";

class PasienUmum extends Pasien
{
    private $nik;
    private $metodePembayaran;
    private $biayaAdministrasi = 150000;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari, $nik, $metodePembayaran)
    {
        parent::__construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari);

        $this->nik = $nik;
        $this->metodePembayaran = $metodePembayaran;
    }

    public function getNik()
    {
        return $this->nik;
    }

    public function getMetodePembayaran()
    {
        return $this->metodePembayaran;
    }

    public function hitungTotalBiaya()
    {
        return $this->hitungBiayaDasar() + $this->biayaAdministrasi;
    }

    public function cetakKlaimLayanan()
    {
        return "Pasien Umum atas nama {$this->nama} dengan NIK {$this->nik}, melakukan pembayaran melalui {$this->metodePembayaran}.";
    }
}