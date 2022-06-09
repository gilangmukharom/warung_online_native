<?php
include 'db.php';

session_start();
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>'; //alihkan ke halaman dashboard.php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Data Kategori | Bukawarung</title>
</head>

<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Bukawarung</h1>
            <ul>
                <li><a href="dashboard.php">Dashnoard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="data_kategori.php">Data Kategori</a></li>
                <li><a href="data_produk.php">Data Produk</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h2>Data Kategori</h2>
            <div class="box">

                <p><a href="tambah_kategori.php">Tambah Data</a></p>

                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No.</th>
                            <th>Kategori</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $no = 1;
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");

                        //melakukan looping pada variabel kategori dari database
                        while ($row = mysqli_fetch_array($kategori)) {


                        ?>
                        <tr>
                            <!-- menampilkan data kategori -->
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['category_name'] ?> </td>
                            <td>
                                <!--mengambil id dari data yang di pilih-->
                                <a href="edit_kategori.php?id=<?php echo $row['category_id'] ?>">Edit</a> ||
                                <a href="proses_hapus.php?idk=<?php echo $row['category_id'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2020 Bukawarung</small>
        </div>
    </footer>
</body>

</html>