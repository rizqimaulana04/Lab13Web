<?php
error_reporting(E_ALL);
include_once '../class/koneksi.php';
include_once '../class/config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM mahasiswa WHERE id = '{$id}'";
$result = mysqli_query($conn, $sql);
if (!$result) die('Error: Data tidak tersedia');
$data = mysqli_fetch_array($result);

if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    $sql = "UPDATE data_mahasiswa SET ";
    $sql .= "nim = '{$nim}', nama = '{$nama}', alamat = '{$alamat}' ";
    $sql .= "WHERE id = '{$id}'";
    $result = mysqli_query($conn, $sql);

    header('location: index.php');
}
?>
<div class="container">
    <?php require('../template/header.php'); ?>

    <h1>Ubah Mahasiswa</h1>
    <form method="post" action="ubah.php">
        <label>NIM:</label>
        <input type="text" name="nim" value="<?php echo $data['nim']; ?>" required><br>

        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required><br>

        <label>Alamat:</label>
        <textarea name="alamat" required><?php echo $data['alamat']; ?></textarea><br>

        <input type="submit" name="submit" value="Simpan">
    </form>

    <br>
    <br>
    <?php require('../template/footer.php'); ?>

</div>