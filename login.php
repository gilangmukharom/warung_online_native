<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman | Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="bg-login">
    <div class="box-login">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username</label>
            <input class="control" type="text" name="username" id="username">
            <label for="password">Password</label>
            <input class="control" type="password" name="password" id="password">
            <button class="btn-login" type="submit" name="submit">Login</button>
        </form>
        <?php

            if(isset($_POST['submit'])){
                session_start();
                include('db.php');
                
                $user = $_POST['username']; //deklarasi variabel user
                $pass = $_POST['password']; //deklarasi variabel pass

                $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$user' AND password = '".MD5($pass)."'");
                if(mysqli_num_rows($cek) > 0){
                    //membuat sesi
                    $d = mysqli_fetch_object($cek);
                    $_SESSION['status_login'] = true;
                    $_SESSION['a_global'] = $d;
                    $_SESSION['id'] = $d->admin_id;
                    echo "<script>window.location='dashboard.php';</script>"; //alihkan ke halaman dashboard.php
                }
                else {
                    echo "<script>alert('Login gagal');</script>";
                }
            }
        ?>
    </div>
</body>

</html>