<?php
include 'db.php';

if (isset($_GET['idk'])) {
    $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '" . $_GET['idk'] . "'");
    echo '<script>alert("Data Berhasil dihapus!")</script>';
    echo '<script>window.location="data_kategori.php"</script>';
}