<?php
require_once "model.php";

class Kamar extends Model
{
    protected $table = "kamar";

    public function info()
    {
        return "Data Kamar";
    }

    public function tampil()
    {
        return $this->conn->query("SELECT * FROM {$this->table}");
    }

    public function tambah($nama_kamar, $harga, $status)
    {
        return $this->conn->query("
            INSERT INTO {$this->table} (nama_kamar, harga, status)
            VALUES ('$nama_kamar', '$harga', '$status')
        ");
    }

    public function hapus($id)
    {
        return $this->conn->query("DELETE FROM {$this->table} WHERE id='$id'");
    }

    public function getById($id)
    {
        return $this->conn->query("SELECT * FROM {$this->table} WHERE id='$id'");
    }

    public function update($id, $nama_kamar, $harga, $status)
    { 
        return $this->conn->query("
            UPDATE {$this->table} SET
            nama_kamar='$nama_kamar',
            harga='$harga',
            status='$status'
            WHERE id='$id'
        ");
    }
}
?>