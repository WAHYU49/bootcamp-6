<?php
include '../../../config/koneksi.php';
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}
$id = $_GET['id'];

// First, retrieve the product to get the image filename
$query = mysqli_query($koneksi, "SELECT image FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($query);

if ($product) {
    // Delete the image file from the server (jika ada)
    if (!empty($product['image'])) {
        $imagePath = "../../../uploaded_files/" . $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    // Delete the product from the database
    $deleteQuery = "DELETE FROM products WHERE id = $id";
    mysqli_query($koneksi, $deleteQuery);
    // Redirect back to product list page after deletion with success message
    header("Location: ../index.php?message=Product+deleted+successfully");
    exit();
} else {
    die("Produk dengan ID: $id tidak ditemukan.");
}
?>