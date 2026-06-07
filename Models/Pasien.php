<?php

abstract class Pasien
{
    protected $idPasien;
    protected $nama;
    protected $usia;
    protected $lamaRawat;
    protected $biayaKamarPerHari;

    public function __construct($idPasien, $nama, $usia, $lamaRawat, $biayaKamarPerHari)
    {
        $this->idPasien = $idPasien;
        $this->nama = $nama;
        $this->usia = $usia;
        $this->lamaRawat = $lamaRawat;
        $this->biayaKamarPerHari = $biayaKamarPerHari;
    }

    public function getIdPasien()
    {
        return $this->idPasien;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getUsia()
    {
        return $this->usia;
    }

    public function getLamaRawat()
    {
        return $this->lamaRawat;
    }

    public function getBiayaKamarPerHari()
    {
        return $this->biayaKamarPerHari;
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function setUsia($usia)
    {
        $this->usia = $usia;
    }

    public function setLamaRawat($lamaRawat)
    {
        $this->lamaRawat = $lamaRawat;
    }

    public function setBiayaKamarPerHari($biayaKamarPerHari)
    {
        $this->biayaKamarPerHari = $biayaKamarPerHari;
    }

    public function hitungBiayaDasar()
    {
        return $this->lamaRawat * $this->biayaKamarPerHari;
    }

    abstract public function hitungTotalBiaya();

    abstract public function cetakKlaimLayanan();
}