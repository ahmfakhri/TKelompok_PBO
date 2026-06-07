<?php

require_once __DIR__ . "/../config/Koneksi.php";
require_once __DIR__ . "/../models/PasienBPJS.php";
require_once __DIR__ . "/../models/PasienAsuransiSwasta.php";
require_once __DIR__ . "/../models/PasienUmum.php";

class PasienDAL extends Koneksi
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSemuaPasien()
    {
        $query = "
            SELECT 
                pasien.id_pasien,
                pasien.nama,
                pasien.usia,
                pasien.lama_rawat,
                pasien.biaya_kamar_per_hari,
                pasien.jenis_pasien,

                pasien_bpjs.nomor_pbi,
                pasien_bpjs.faskes_asal,
                pasien_bpjs.kelas_kamar,

                pasien_asuransi_swasta.nama_provider,
                pasien_asuransi_swasta.nomor_polis,
                pasien_asuransi_swasta.limit_cover,

                pasien_umum.nik,
                pasien_umum.metode_pembayaran

            FROM pasien
            LEFT JOIN pasien_bpjs 
                ON pasien.id_pasien = pasien_bpjs.id_pasien
            LEFT JOIN pasien_asuransi_swasta 
                ON pasien.id_pasien = pasien_asuransi_swasta.id_pasien
            LEFT JOIN pasien_umum 
                ON pasien.id_pasien = pasien_umum.id_pasien
            ORDER BY pasien.id_pasien ASC
        ";

        $result = $this->conn->query($query);

        $daftarPasien = [];

        while ($row = $result->fetch_assoc()) {
            $daftarPasien[] = $this->ubahKeObjekPasien($row);
        }

        return $daftarPasien;
    }

    public function getPasienById($idPasien)
    {
        $query = "
            SELECT 
                pasien.id_pasien,
                pasien.nama,
                pasien.usia,
                pasien.lama_rawat,
                pasien.biaya_kamar_per_hari,
                pasien.jenis_pasien,

                pasien_bpjs.nomor_pbi,
                pasien_bpjs.faskes_asal,
                pasien_bpjs.kelas_kamar,

                pasien_asuransi_swasta.nama_provider,
                pasien_asuransi_swasta.nomor_polis,
                pasien_asuransi_swasta.limit_cover,

                pasien_umum.nik,
                pasien_umum.metode_pembayaran

            FROM pasien
            LEFT JOIN pasien_bpjs 
                ON pasien.id_pasien = pasien_bpjs.id_pasien
            LEFT JOIN pasien_asuransi_swasta 
                ON pasien.id_pasien = pasien_asuransi_swasta.id_pasien
            LEFT JOIN pasien_umum 
                ON pasien.id_pasien = pasien_umum.id_pasien
            WHERE pasien.id_pasien = ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $idPasien);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            return $this->ubahKeObjekPasien($row);
        }

        return null;
    }

    private function ubahKeObjekPasien($row)
    {
        if ($row["jenis_pasien"] == "BPJS") {
            return new PasienBPJS(
                $row["id_pasien"],
                $row["nama"],
                $row["usia"],
                $row["lama_rawat"],
                $row["biaya_kamar_per_hari"],
                $row["nomor_pbi"],
                $row["faskes_asal"],
                $row["kelas_kamar"]
            );
        }

        if ($row["jenis_pasien"] == "ASURANSI") {
            return new PasienAsuransiSwasta(
                $row["id_pasien"],
                $row["nama"],
                $row["usia"],
                $row["lama_rawat"],
                $row["biaya_kamar_per_hari"],
                $row["nama_provider"],
                $row["nomor_polis"],
                $row["limit_cover"]
            );
        }

        if ($row["jenis_pasien"] == "UMUM") {
            return new PasienUmum(
                $row["id_pasien"],
                $row["nama"],
                $row["usia"],
                $row["lama_rawat"],
                $row["biaya_kamar_per_hari"],
                $row["nik"],
                $row["metode_pembayaran"]
            );
        }

        return null;
    }

    public function tambahPasien($data)
    {
        $this->conn->begin_transaction();

        try {
            $queryPasien = "
                INSERT INTO pasien 
                (id_pasien, nama, usia, lama_rawat, biaya_kamar_per_hari, jenis_pasien)
                VALUES (?, ?, ?, ?, ?, ?)
            ";

            $stmtPasien = $this->conn->prepare($queryPasien);
            $stmtPasien->bind_param(
                "ssiids",
                $data["id_pasien"],
                $data["nama"],
                $data["usia"],
                $data["lama_rawat"],
                $data["biaya_kamar_per_hari"],
                $data["jenis_pasien"]
            );
            $stmtPasien->execute();

            $this->tambahDetailPasien($data);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    private function tambahDetailPasien($data)
    {
        if ($data["jenis_pasien"] == "BPJS") {
            $query = "
                INSERT INTO pasien_bpjs
                (id_pasien, nomor_pbi, faskes_asal, kelas_kamar)
                VALUES (?, ?, ?, ?)
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(
                "ssss",
                $data["id_pasien"],
                $data["nomor_pbi"],
                $data["faskes_asal"],
                $data["kelas_kamar"]
            );
            $stmt->execute();
        }

        if ($data["jenis_pasien"] == "ASURANSI") {
            $query = "
                INSERT INTO pasien_asuransi_swasta
                (id_pasien, nama_provider, nomor_polis, limit_cover)
                VALUES (?, ?, ?, ?)
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(
                "sssd",
                $data["id_pasien"],
                $data["nama_provider"],
                $data["nomor_polis"],
                $data["limit_cover"]
            );
            $stmt->execute();
        }

        if ($data["jenis_pasien"] == "UMUM") {
            $query = "
                INSERT INTO pasien_umum
                (id_pasien, nik, metode_pembayaran)
                VALUES (?, ?, ?)
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param(
                "sss",
                $data["id_pasien"],
                $data["nik"],
                $data["metode_pembayaran"]
            );
            $stmt->execute();
        }
    }

    public function updatePasien($idPasien, $data)
    {
        $this->conn->begin_transaction();

        try {
            $queryPasien = "
                UPDATE pasien
                SET nama = ?, 
                    usia = ?, 
                    lama_rawat = ?, 
                    biaya_kamar_per_hari = ?, 
                    jenis_pasien = ?
                WHERE id_pasien = ?
            ";

            $stmtPasien = $this->conn->prepare($queryPasien);
            $stmtPasien->bind_param(
                "siidss",
                $data["nama"],
                $data["usia"],
                $data["lama_rawat"],
                $data["biaya_kamar_per_hari"],
                $data["jenis_pasien"],
                $idPasien
            );
            $stmtPasien->execute();

            $this->hapusDetailPasien($idPasien);

            $data["id_pasien"] = $idPasien;
            $this->tambahDetailPasien($data);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    private function hapusDetailPasien($idPasien)
    {
        $queryBPJS = "DELETE FROM pasien_bpjs WHERE id_pasien = ?";
        $stmtBPJS = $this->conn->prepare($queryBPJS);
        $stmtBPJS->bind_param("s", $idPasien);
        $stmtBPJS->execute();

        $queryAsuransi = "DELETE FROM pasien_asuransi_swasta WHERE id_pasien = ?";
        $stmtAsuransi = $this->conn->prepare($queryAsuransi);
        $stmtAsuransi->bind_param("s", $idPasien);
        $stmtAsuransi->execute();

        $queryUmum = "DELETE FROM pasien_umum WHERE id_pasien = ?";
        $stmtUmum = $this->conn->prepare($queryUmum);
        $stmtUmum->bind_param("s", $idPasien);
        $stmtUmum->execute();
    }

    public function hapusPasien($idPasien)
    {
        $query = "DELETE FROM pasien WHERE id_pasien = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $idPasien);

        return $stmt->execute();
    }
}