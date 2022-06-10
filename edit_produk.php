<?php
session_start();
include('db.php');
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>'; //alihkan ke halaman dashboard.php
}

//menampilkan data yang ingin diedit
$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '" . $_GET['id'] . "'");
$p      = mysqli_fetch_object($produk);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <title>Edit Data Produk | Bukawarung</title>
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
            <h2>Edit Data Produk</h2>
            <div class="box">
                <!--enctype digunakan untuk mengamankan input file-->
                <form action="" method="POST" enctype="multipart/form-data">
                    <select name="produk" id="" class="control" required>
                        <option value="">--Pilih--</option>

                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_id DESC");

                        while ($r = mysqli_fetch_array($kategori)) {
                        ?>
                        <option value="<?php echo $r['category_id'] ?>"
                            <?php echo ($r['category_id'] == $p->category_id) ? 'selected' : '' ?>>
                            <?php echo $r['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <input type="text" name="nama" class="control" placeholder="Nama Produk"
                        value="<?php echo $p->product_name ?>" required>
                    <!--value digunakan untuk mengisi value pada input-->

                    <input type="text" name="harga" class="control" placeholder="Harga"
                        value="<?php echo $p->product_price ?>" required>

                    <!--Menampilkan gambar yang ada dalam database-->
                    <img src="produk/<?php echo $p->product_images ?>" width="100px"> </img>
                    <input type="hidden" name="foto" value="<?php echo $p->product_images ?>">
                    <input type="file" name="gambar" class="control">

                    <textarea name="deskripsi" class="control" placeholder="Deskripsi" cols="30"
                        rows="10"><?php echo $p->product_description ?></textarea>
                    <br>
                    <select name="status" class="control">
                        <option value="">--Pilih--</option>
                        <option value="1" <?php echo ($p->product_status == 1) ? 'selected' : ''; ?>>--Aktif--</option>
                        <option value="0" <?php echo ($p->product_status == 0) ? 'selected' : ''; ?>>--Nonaktif--
                        </option>
                    </select>
                    <button type="submit" name="submit" class="btn-login">Submit</button>
                </form>

                <!--proses tambah data produk-->
                <?php
                if (isset($_POST['submit'])) {
                    //menampung data inputan dari form
                    $kategori   = $_POST['produk'];
                    $nama       = $_POST['nama'];
                    $harga      = $_POST['harga'];
                    $deskripsi  = $_POST['deskripsi'];
                    $status     = $_POST['status'];
                    $foto       = $_POST['foto'];

                    //tampung juga data gambar yang baru
                    $filename = $_FILES['gambar']['name'];
                    $tmp_name = $_FILES['gambar']['tmp_name'];

                    $newname = 'produk_' . time() . '.' . $type2;

                    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');

                    //jika gambar diubah
                    if ($filename != '') {
                        if (!in_array($type2, $tipe_diizinkan)) {
                            echo '<script>alert("Format file tidak diizinkan")</script>';
                        } else {

                            //hapus gambar yang lama
                            unlink('produk/' . $foto);
                            //upload gambar baru
                            move_uploaded_file($tmp_name, 'produk/' . $newname);
                            $namagambar = $newname;
                        }
                    } else {
                        $namagambar = $foto;
                    }

                    //beri validasi jika gambar tidak diubah
                    $update = "UPDATE tb_product SET 
                    category_id = '$kategori', 
                    product_name = '$nama', 
                    product_price = '$harga', 
                    product_description = '$deskripsi', 
                    product_images = '$namagambar', 
                    product_status = '$status' 
                    WHERE product_id = '$p->product_id'";

                    $sql = mysqli_query($conn, $update);
                    if ($sql) {
                        echo '<script>alert("Data berhasil diubah")</script>';
                        echo '<script>window.location="data_produk.php"</script>';
                    } else {
                        echo '<script>alert("Data gagal diubah")</script>';
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class=" container">
            <small>Copyright &copy; 2020 Bukawarung</small>
        </div>
    </footer>

    <!-- javascript untuk implementasi ckeditor-->
    <script>
    CKEDITOR.replace('deskripsi');
    </script>
</body>

</html>