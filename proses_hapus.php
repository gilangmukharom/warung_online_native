<?php
include 'db.php';

if (isset($_GET['idk'])) {
    $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '" . $_GET['idk'] . "'");
    echo '<script>alert("Data Berhasil dihapus!")</script>';
    echo '<script>window.location="data_kategori.php"</script>';
}

if (isset($_GET['idp'])) {

    //memanggil query untuk menghapus data yang ada pada tabel product_image berdasarkan id_product
    $produk = mysqli_query($conn, "SELECT product_images FROM tb_product WHERE product_id = '" . $_GET['idp'] . "'");
    //menampilkan data produk yang akan dihapus
    $p      = mysqli_fetch_object($produk);

    //menghapus file image yang ada di dalam variable produk
    unlink('./produk/' . $p->product_images);

    $delete = mysqli_query($conn, "DELETE FROM tb_product WHERE product_id = '" . $_GET['idp'] . "'");
    echo '<script>alert("Data Berhasil dihapus!")</script>';
    echo '<script>window.location="data_produk.php"</script>';
}

?>