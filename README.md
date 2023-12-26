# Lab13Web

|  |  |  |
|-----|------|-----|
|Nama|Muhammad Rizqi Maulana|
|NIM|312210360|
|Kelas|TI.22.A.4|
|Mata Kuliah|Pemograman Web|

## Membuat Pencarian Data dan Pagination

```php
// Search query
$q = "";
$sql_where = "";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = " WHERE nama LIKE '{$q}%' OR nim LIKE '{$q}%' OR alamat LIKE '{$q}%'";
}

// Pagination
$sql = 'SELECT * FROM mahasiswa';
$sql_count = "SELECT COUNT(*) FROM mahasiswa";
if (!empty($sql_where)) {
    $sql .= $sql_where;
    $sql_count .= $sql_where;
}

$result_count = mysqli_query($conn, $sql_count);
$count = 0;
if ($result_count) {
    $r_data = mysqli_fetch_row($result_count);
    $count = $r_data[0];
}
$per_page = 3; // Set the number of rows per page to 3
$num_page = ceil($count / $per_page);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $per_page;

$sql .= " LIMIT {$offset}, {$per_page}";
$result = mysqli_query($conn, $sql);
```

Bagian kode ini melakukan hal berikut:

1. Memeriksa apakah formulir pencarian telah dikirimkan ( `isset($_GET["submit'])`) dan apakah permintaan pencarian tidak kosong ( `!empty($_GET['q'])`).
2. Jika ada permintaan pencarian, ia membuat klausa SQL WHERE untuk memfilter hasil berdasarkan permintaan pencarian. Pencarian dilakukan pada kolom "nama", "nim", dan "alamat" menggunakan operator LIKE.
3. Query SQL utama untuk memilih data dari tabel "mahasiswa" kemudian dimodifikasi untuk menyertakan klausa WHERE untuk pencarian.
4. Kode lainnya, termasuk penomoran halaman dan tampilan data, memperhitungkan parameter pencarian.

## Tampilan
https://github.com/rizqimaulana04/Lab13Web/assets/115638135/1ede0415-304f-415a-b69a-630f991a893d