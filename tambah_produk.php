<?php
session_start();
include('db.php');
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
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <title>Tambah Data Produk | Bukawarung</title>
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
            <h2>Tambah Data Produk</h2>
            <div class="box">
                <!--enctype digunakan untuk mengamankan input file-->
                <form action="" method="POST" enctype="multipart/form-data">
                    <select name="produk" id="" class="control" required>
                        <option value="">--Pilih--</option>

                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");

                        while ($r = mysqli_fetch_array($kategori)) {
                        ?>
                        <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="control" placeholder="Nama Produk" required>
                    <input type="text" name="harga" class="control" placeholder="Harga" required>
                    <input type="file" name="gambar" class="control" required>
                    <textarea name="deskripsi" class="control" placeholder="Deskripsi" cols="30" rows="10"></textarea>
                    <br>
                    <select name="status" class="control">
                        <option value="">--Pilih--</option>
                        <option value="1">--Aktif--</option>
                        <option value="0">--Nonaktif--</option>
                    </select>
                    <button type="submit" name="submit" class="btn-login">Submit</button>
                </form>

                <!--proses tambah data produk-->
                <?php
                if (isset($_POST['submit'])) {

                    //print_r($_FILES['gambar']);
                    //menampung inputan dari form

                    $kategori = $_POST['produk'];
                    $nama = $_POST['nama'];
                    $harga = $_POST['harga'];
                    $deskripsi = $_POST['deskripsi'];
                    $status = $_POST['status'];

                    //menampung data file(gambar)
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    //memisahkan string dengan titik ('.')
                    $type1 = explode('.', $filename);
                    $type2 = $type1[1];

                    $newname = 'produk_' . time() . '.' . $type2;

                    //echo $type2; isi type2 adalah format file

                    //menampung data format file yang diijinkan
                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    //validasi format file
                    if (!in_array($type2, $tipe_diizinkan)) {
                        echo '<script>alert("Format file tidak diizinkan")</script>';
                    } else {
                        //upload file
                        move_uploaded_file($tmp_name, './produk/' . $newname);
                        echo '<script>alert("Format file diizinkan")</script>';

                        //proses insert data ke database
                        $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES ('','$kategori','$nama','$harga','$deskripsi','$newname','$status',null)");

                        if ($insert) {
                            echo '<script>alert("Data berhasil ditambahkan")</script>';
                            echo '<script>window.location="data_produk.php"</script>';
                        } else {
                            echo '<script>alert("Data gagal ditambahkan")</script>';
                        }
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

    <!-- javascript untuk implementasi ckeditor-->
    <script>
    CKEDITOR.replace('deskripsi');
    </script>
</body>

</html>