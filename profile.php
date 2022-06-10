<?php
session_start();
include('db.php');
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>'; //alihkan ke halaman dashboard.php
}

$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id = '" . $_SESSION['id'] . "'");
$d = mysqli_fetch_object($query); //data ditampung dalam variabel object ($d)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Profile | Bukawarung</title>
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
            <h2>Profile</h2>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" class="control" name=" nama" placeholder="Nama Lengkap"
                        value="<?php echo $d->admin_name ?>" required>
                    <input type="text" class="control" name=" user" placeholder="Username"
                        value="<?php echo $d->username ?>" required>
                    <input type=" text" class="control" name=" hp" placeholder="No. HP"
                        value="<?php echo $d->admin_telp ?>" required>
                    <input type=" text" class="control" name=" email" placeholder="Email"
                        value="<?php echo $d->admin_email ?>" required>
                    <input type=" text" class="control" name=" alamat" placeholder="Alamat"
                        value="<?php echo $d->admin_address ?>" required>
                    <button type="submit" name="submit" class="btn-confirm">Ubah Profile</button>
                </form>
                <?php
                if (isset($_POST['submit'])) { //mengirim menggunakan php

                    $nama   = ucwords($_POST['nama']);
                    $user   = $_POST['user'];
                    $hp     = $_POST['hp'];
                    $email  = $_POST['email'];
                    $alamat = ucwords($_POST['alamat']);

                    //query update
                    $update = mysqli_query($conn, "UPDATE tb_admin SET 
                        admin_name = '$nama', 
                        username = '$user', 
                        admin_telp = '$hp', 
                        admin_email = '$email', 
                        admin_address = '$alamat' 
                        WHERE admin_id = '" . $_SESSION['id'] . "'");

                    //cek apakah query update berhasil
                    if ($update) {
                        echo '<script>alert("Sukses update profile!")</script>';
                        echo '<script>window.location="profile.php"</script>';
                    } else {
                        echo '<script>alert("Gagal mengubah data")</script>';
                        mysqli_error($conn);
                    }
                }
                ?>
            </div>
            <h2>Ubah Password</h2>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" class="control" name="pass1" placeholder="password" required>
                    <input type="password" class="control" name="pass2" placeholder="konfirmasi password" required>
                    <button type="submit" name="ubah_password" class="btn-confirm">Ubah Password</button>
                </form>
                <?php
                if (isset($_POST['ubah_password'])) { //mengirim menggunakan php

                    $pass1   = ($_POST['pass1']);
                    $pass2   = ($_POST['pass2']);

                    if ($pass2 != $pass1) {
                        echo '<script>alert("Password tidak sama!")</script>';
                    } else {
                        //query update password
                        $u_pass = mysqli_query($conn, "UPDATE tb_admin SET
                                    password = '" . MD5($pass1) . "'
                                    WHERE admin_id = '" . $_SESSION['id'] . "'");
                        if ($u_pass) {
                            echo '<script>alert("Sukses ubah password!")</script>';
                            echo '<script>window.location="profile.php"</script>';
                        } else {
                            echo '<script>alert("Gagal mengubah password!")</script>';
                            mysqli_error($conn);
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
</body>

</html>