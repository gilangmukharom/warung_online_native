<?php
    session_start();
    session_destroy();
    echo '<script>alert("Anda telah logout");</script>';
    echo '<script>window.location="login.php"</script>'; //alihkan ke halaman dashboard.php
?>