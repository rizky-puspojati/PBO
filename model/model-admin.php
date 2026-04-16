<?php
require_once "model.php";

class Admin extends Model
{
    protected $table = "admin";

    public function info()
    {
        return "Data Admin";
    }

    public function tampil()
    {
        return $this->conn->query("SELECT * FROM {$this->table}");
    }

    public function tambah($password, $nama, $email, $nomor_telp)
    {
        $password = md5($password);
        return $this->conn->query("
            INSERT INTO {$this->table} (password, nama, email, nomor_telp)
            VALUES ('$password', '$nama', '$email', '$nomor_telp')
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

    public function update($id, $password, $name, $email, $nomor_telp)
    {
        $password = md5($password);
        return $this->conn->query("
            UPDATE {$this->table} SET
            password='$password',
            name='$name',
            email='$email',
            nomor_telp='$nomor_telp'
            WHERE id='$id'
        ");
    }


}
?>