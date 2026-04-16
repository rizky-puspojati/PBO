<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "KyKos";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }
    }

    public function runQuery($query, $errorMessage = "Query failed")
    {
        $result = $this->conn->query($query);
        if (!$result) {
            throw new Exception($errorMessage . ": " . $this->conn->error);
        }
        return $result;
    }
}
?>
