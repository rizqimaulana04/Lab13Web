<?php
// Fungsi untuk membuat koneksi ke database
function createConnection() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $db_name = "mobildb";

    $conn = new mysqli($host, $user, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}


include_once '../class/form.php';


// Container untuk membungkus konten form
echo "<div class='container'>";
require("../template/header.php");

$form = new Form("", "Tambah Mahasiswa");
$form->addField("nim", "NIM");
$form->addField("nama", "Nama");
$form->addField("alamat", "Alamat");

echo "<h2>Silahkan isi form berikut ini :</h2>";

$form->displayForm();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    echo "<p>Data yang dimasukkan:</p>";
    echo "<p>NIM: $nim</p>";
    echo "<p>Nama: $nama</p>";
    echo "<p>Alamat: $alamat</p>";

    // Membuat koneksi ke database
    $conn = createConnection();

    // Query INSERT untuk menyimpan data ke database
    $sql = "INSERT INTO mahasiswa (nim, nama, alamat) VALUES ('$nim', '$nama', '$alamat')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Data berhasil diinput ke database. Terima kasih!</p>";
    } else {
        echo "<p>Gagal input data ke database: " . $conn->error . "</p>";
    }

    // Menutup koneksi ke database
    $conn->close();
}

// Menutup container
echo "</div>";
echo "<br>";
echo "<br>";
require("../template/footer.php");
?>
