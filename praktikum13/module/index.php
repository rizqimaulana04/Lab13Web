<div class="container">
    <?php
    include_once '../class/koneksi.php';

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
    ?>

    <?php require('../template/header.php'); ?>
    <h2>Data Mahasiswa</h2>

    <!-- Search form -->
    <form class="search" action="" method="GET">
        <label for="q">Search:</label>
        <input type="text" id="q" name="q" class="input-q" value="<?php echo $q ?>">
        <input type="submit" name="submit" value="Search" class="btn btn-primary">
    </form>

    <?php if ($page == 1 && $result): ?>
        <table>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php 
            $row_count = 0;
            while ($row = mysqli_fetch_array($result)): 
                // Check if the row matches the search criteria
                if (!empty($q) && stripos($row['nama'], $q) === false) {
                    continue; // Skip this row if it doesn't match the search query
                }
                $row_count++;
            ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['nim']; ?></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['alamat']; ?></td>
                    <td>
                        <a class="ubah" href="ubah.php?id=<?= $row['id']; ?>">Ubah</a>
                        <a class="hapus" href="hapus.php?id=<?= $row['id']; ?>">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php elseif ($page == 1 && !$result): ?>
        <p>No data found.</p>
    <?php else: ?>
        <p>No data found.</p>
    <?php endif; ?>

    <ul class="pagination">
        <?php if ($page > 1): ?>
            <li><a href="?page=<?= $page - 1 ?>&q=<?= $q; ?>">&laquo; Previous</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $num_page; $i++): ?>
            <?php
            $link = "?page={$i}&q={$q}";
            $class = ($page == $i ? 'active' : '');
            ?>
            <li><a class="<?= $class ?>" href="<?= $link ?>"><?= $i ?></a></li>
        <?php endfor; ?>

        <?php if ($page < $num_page): ?>
            <li><a href="?page=<?= $page + 1 ?>&q=<?= $q; ?>">Next &raquo;</a></li>
        <?php endif; ?>
    </ul>

    <?php require('../template/footer.php'); ?>
</div>
