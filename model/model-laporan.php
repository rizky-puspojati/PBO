<?php
require_once "model/model.php";

class Laporan extends Model
{
    public function totalPenghasilan()
    {
        $result = $this->conn->query("SELECT SUM(jumlah_bayar) as total FROM transaksi");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    public function jumlahKamarTersedia()
    {
        $result = $this->conn->query("SELECT COUNT(*) as jumlah FROM kamar WHERE status = 'Tersedia'");
        $row = $result->fetch_assoc();
        return $row['jumlah'] ?? 0;
    }

    public function jumlahKamarTidakTersedia()
    {
        $result = $this->conn->query("SELECT COUNT(*) as jumlah FROM kamar WHERE status = 'Terisi'");
        $row = $result->fetch_assoc();
        return $row['jumlah'] ?? 0;
    }

    public function detailKamarTidakTersedia()
    {
        return $this->conn->query("SELECT * FROM kamar WHERE status = 'Terisi'");
    }
}
?>