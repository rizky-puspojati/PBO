<?php
require_once "model/model-kamar.php";

if (isset($_GET['id'])) {
    $kamar = new Kamar();
    $id = $_GET['id'];

    if ($kamar->hapus($id)) {
        header("Location: data-kamar.php");
    } else {
        echo "Gagal menghapus data";
    }
}
?>