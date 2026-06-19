<?php
require_once "model.php";

// 1. Class DetailKamar (Digunakan untuk mendemonstrasikan Komposisi)
class DetailKamar
{
    public $ukuran;
    public $tipeKasur;

    public function __construct($ukuran, $tipeKasur)
    {
        $this->ukuran = $ukuran;
        $this->tipeKasur = $tipeKasur;
    }
}

// 2. Class Fasilitas (Digunakan untuk mendemonstrasikan Agregasi)
class Fasilitas
{
    public $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }
}

// 3. Class Penyewa (Digunakan untuk mendemonstrasikan Asosiasi)
class Penyewa
{
    public $nama;

    public function __construct($nama)
    {
        $this->nama = $nama;
    }
}

// 4. Class Kamar (Mewarisi Model - Inheritance)
class Kamar extends Model
{
    protected $table = "kamar";

    // Properti dasar Kamar
    public $id;
    public $nama_kamar;
    public $harga;
    public $status;
    public $tipe_kamar;

    // Properti Penyewa & Status Pembayaran (Database-driven)
    public $nama_penyewa;
    public $prioritas;
    public $status_pembayaran;

    // Properti Relasi OOP
    public $detailKamar;     // Komposisi (DetailKamar dikendalikan siklus hidupnya oleh Kamar)
    public $daftarFasilitas = []; // Agregasi (Fasilitas dibuat terpisah dan ditambahkan)
    public $penyewa;         // Asosiasi (Kamar terasosiasi dengan Penyewa)

    public function info()
    {
        return "Data Kamar Standar";
    }

    // Method pembentuk Komposisi
    public function setDetailKamar($ukuran, $tipeKasur)
    {
        $this->detailKamar = new DetailKamar($ukuran, $tipeKasur);
    }

    // Method pembentuk Agregasi
    public function tambahFasilitas(Fasilitas $f)
    {
        $this->daftarFasilitas[] = $f;
    }

    // Method pembentuk Asosiasi
    public function setPenyewa(Penyewa $p)
    {
        $this->penyewa = $p;
    }

    // Polimorfisme: Perhitungan sewa standard
    public function hitungBiayaSewa($durasiBulan)
    {
        return $this->harga * $durasiBulan;
    }

    public function tampil()
    {
        return $this->conn->query("SELECT * FROM {$this->table}");
    }

    public function tambah($nama_kamar, $harga, $status, $tipe_kamar = 'Standard', $ukuran = '3x4', $tipe_kasur = 'Single', $fasilitas = 'Kasur', $nama_penyewa = '-', $prioritas = 'Low', $status_pembayaran = 'Belum Bayar')
    {
        $nama_kamar = $this->conn->real_escape_string($nama_kamar);
        $harga = (double)$harga;
        $status = $this->conn->real_escape_string($status);
        $tipe_kamar = $this->conn->real_escape_string($tipe_kamar);
        $ukuran = $this->conn->real_escape_string($ukuran);
        $tipe_kasur = $this->conn->real_escape_string($tipe_kasur);
        $fasilitas = $this->conn->real_escape_string($fasilitas);
        $nama_penyewa = $this->conn->real_escape_string($nama_penyewa);
        $prioritas = $this->conn->real_escape_string($prioritas);
        $status_pembayaran = $this->conn->real_escape_string($status_pembayaran);

        return $this->conn->query("
            INSERT INTO {$this->table} (nama_kamar, harga, status, tipe_kamar, ukuran, tipe_kasur, fasilitas, nama_penyewa, prioritas, status_pembayaran)
            VALUES ('$nama_kamar', '$harga', '$status', '$tipe_kamar', '$ukuran', '$tipe_kasur', '$fasilitas', '$nama_penyewa', '$prioritas', '$status_pembayaran')
        ");
    }

    public function hapus($id)
    {
        $id = (int)$id;
        return $this->conn->query("DELETE FROM {$this->table} WHERE id='$id'");
    }

    public function getById($id)
    {
        $id = (int)$id;
        return $this->conn->query("SELECT * FROM {$this->table} WHERE id='$id'");
    }

    // Method untuk load objek beserta relasi OOP-nya secara lengkap
    public function getByIdOOP($id)
    {
        $id = (int)$id;
        $res = $this->getById($id);
        if ($res && $row = $res->fetch_assoc()) {
            // Instansiasi objek yang tepat secara Polymorphic
            if ($row['tipe_kamar'] == 'VIP') {
                $obj = new KamarVIP();
            } else {
                $obj = new Kamar();
            }

            // Bind data
            $obj->id = $row['id'];
            $obj->nama_kamar = $row['nama_kamar'];
            $obj->harga = $row['harga'];
            $obj->status = $row['status'];
            $obj->tipe_kamar = $row['tipe_kamar'];
            $obj->nama_penyewa = $row['nama_penyewa'] ?? '-';
            $obj->prioritas = $row['prioritas'] ?? 'Low';
            $obj->status_pembayaran = $row['status_pembayaran'] ?? 'Belum Bayar';

            // 1. Komposisi: Objek DetailKamar diinstansiasi langsung di dalam Kamar
            $obj->setDetailKamar($row['ukuran'], $row['tipe_kasur']);

            // 2. Agregasi: Objek Fasilitas dibuat secara eksternal dan dimasukkan ke Kamar
            $arrFasilitas = explode(',', $row['fasilitas']);
            foreach ($arrFasilitas as $fName) {
                $fName = trim($fName);
                if (!empty($fName)) {
                    $obj->tambahFasilitas(new Fasilitas($fName));
                }
            }

            // 3. Asosiasi: Kamar dikaitkan dengan objek Penyewa secara dinamis berdasarkan database
            if (!empty($obj->nama_penyewa) && $obj->nama_penyewa != '-') {
                $obj->setPenyewa(new Penyewa($obj->nama_penyewa));
            } else {
                $obj->setPenyewa(new Penyewa("-"));
            }

            return $obj;
        }
        return null;
    }

    public function update($id, $nama_kamar, $harga, $status, $tipe_kamar = 'Standard', $ukuran = '3x4', $tipe_kasur = 'Single', $fasilitas = 'Kasur', $nama_penyewa = '-', $prioritas = 'Low', $status_pembayaran = 'Belum Bayar')
    { 
        $id = (int)$id;
        $nama_kamar = $this->conn->real_escape_string($nama_kamar);
        $harga = (double)$harga;
        $status = $this->conn->real_escape_string($status);
        $tipe_kamar = $this->conn->real_escape_string($tipe_kamar);
        $ukuran = $this->conn->real_escape_string($ukuran);
        $tipe_kasur = $this->conn->real_escape_string($tipe_kasur);
        $fasilitas = $this->conn->real_escape_string($fasilitas);
        $nama_penyewa = $this->conn->real_escape_string($nama_penyewa);
        $prioritas = $this->conn->real_escape_string($prioritas);
        $status_pembayaran = $this->conn->real_escape_string($status_pembayaran);

        return $this->conn->query("
            UPDATE {$this->table} SET
            nama_kamar='$nama_kamar',
            harga='$harga',
            status='$status',
            tipe_kamar='$tipe_kamar',
            ukuran='$ukuran',
            tipe_kasur='$tipe_kasur',
            fasilitas='$fasilitas',
            nama_penyewa='$nama_penyewa',
            prioritas='$prioritas',
            status_pembayaran='$status_pembayaran'
            WHERE id='$id'
        ");
    }

    // Method untuk menyimpan update status pembayaran secara permanen ke database
    public function updateStatusPembayaran($id, $status_pembayaran)
    {
        $id = (int)$id;
        $status_pembayaran = $this->conn->real_escape_string($status_pembayaran);
        return $this->conn->query("UPDATE {$this->table} SET status_pembayaran='$status_pembayaran' WHERE id='$id'");
    }
}

// 5. Class KamarVIP (Mewarisi Kamar - Inheritance & Overriding/Polymorphism)
class KamarVIP extends Kamar
{
    public function info()
    {
        return "Data Kamar VIP";
    }

    // Polimorfisme: Override method hitungBiayaSewa untuk menyertakan tambahan charge VIP Rp 150.000
    public function hitungBiayaSewa($durasiBulan)
    {
        $tarifStandar = parent::hitungBiayaSewa($durasiBulan);
        $serviceChargeVIP = 150000;
        return $tarifStandar + $serviceChargeVIP;
    }
}
?>