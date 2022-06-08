<?php
session_start();
include('db.php');
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>'; //alihkan ke halaman dashboard.php
}

//menampilkan data kategori
$kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id ='" . $_GET['id'] . "'");

if (mysqli_num_rows($kategori) == 0) {
    echo '<script>window.location="data_kategori.php"</script>';
}

//membuat variabel $kategori yang menampung data dari database
$k = mysqli_fetch_object($kategori);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Tambah Kategori | Bukawarung</title>
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
            <h2>Edit Data Kategori</h2>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" class="control" name="nama" placeholder="Nama Kategori"
                        value="<?php echo $k->category_name ?>" required>
                    <button type=" submit" name="submit" class="btn-login">Submit</button>
                </form>

                <!--proses tambah data kategori-->
                <?php
                if (isset($_POST['submit'])) {
                    $nama = ucwords($_POST['nama']);

                    //query update data kategori
                    $update = mysqli_query($conn, "UPDATE tb_category SET category_name = '$nama' WHERE category_id = '" . $_GET['id'] . "'");

                    //mengecek apakah query update berhasil
                    if ($update) {
                        echo '<script>alert("Edit Data Berhasil.");</script> <script>window.location="data_kategori.php"</script>';
                    } else {
                        echo '<script>alert("Gagal Diedit.");</script> <script>window.location="edit_kategori.php"</script>';
                    }
                }
                ?>

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