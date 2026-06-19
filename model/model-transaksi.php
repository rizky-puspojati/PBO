<?php
require_once "model-kamar.php";

// Class InvoicePrinter (Digunakan untuk mendemonstrasikan Dependensi)
class InvoicePrinter
{
    public function format(Transaksi $transaksi)
    {
        $tipe = ($transaksi->kamar instanceof KamarVIP) ? "VIP" : "Standard";
        $str = "========================================\n";
        $str .= "             STRUK SEWA KYKOS           \n";
        $str .= "========================================\n";
        $str .= "Kamar        : " . $transaksi->kamar->nama_kamar . " (" . $tipe . ")\n";
        $str .= "Harga Dasar  : Rp " . number_format($transaksi->kamar->harga, 0, ',', '.') . "/bulan\n";
        $str .= "Tgl Bayar    : " . $transaksi->tanggal_pembayaran . "\n";
        $str .= "Jumlah Bayar : Rp " . number_format($transaksi->jumlah_bayar, 0, ',', '.') . "\n";
        $str .= "----------------------------------------\n";
        $str .= "Kalkulasi sewa selesai. Terima kasih!\n";
        $str .= "========================================\n";
        return $str;
    }
}

// Class Transaksi (Asosiasi & Dependensi)
class Transaksi
{
    public $id;
    public $kamar; // Asosiasi: Transaksi menyimpan objek Kamar sebagai referensi
    public $tanggal_pembayaran;
    public $jumlah_bayar;

    public function __construct(Kamar $kamar, $tanggal_pembayaran, $jumlah_bayar, $id = null)
    {
        $this->id = $id;
        $this->kamar = $kamar; // Asosiasi
        $this->tanggal_pembayaran = $tanggal_pembayaran;
        $this->jumlah_bayar = $jumlah_bayar;
    }

    // Dependensi: Transaksi bergantung secara penuh pada objek InvoicePrinter di parameter ini
    public function printInvoice(InvoicePrinter $printer)
    {
        return $printer->format($this);
    }
}
?>
