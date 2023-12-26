<?php
include_once 'koneksi.php';
include_once 'config.php';
$id = $_GET['id'];
$sql = "DELETE FROM mahasiswa WHERE id = '{$id}'";
$result = mysqli_query($conn, $sql);
header('location: index.php');
?>