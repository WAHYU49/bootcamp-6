<?php
$title = "Detail Produk";

ob_start(); // mirip @section('content')
?>
<?php
// Koneksi database
require __DIR__ . '/../config/koneksi.php';
// Ambil ID produk dari query string
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}
$productId = intval($_GET['id']);
// Ambil data produk berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $productId");
if (mysqli_num_rows($query) == 0) {
    die("Produk dengan ID: $productId tidak ditemukan.");
}
$product = mysqli_fetch_assoc($query);
?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <img src="../uploaded_files/<?= htmlspecialchars($product['image']) ?>"
            alt="<?= htmlspecialchars($product['nama_produk']) ?>"
            class="img-fluid"
            style="max-height:400px; object-fit:cover;">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4"><?= htmlspecialchars($product['nama_produk']) ?></h2>
            <h4>Harga: Rp <?= number_format($product['harga'], 0, ',', '.') ?></h4>
            <p class="mt-3"><?= htmlspecialchars($product['deskripsi']) ?></p>
            <span class="badge bg-secondary"><?= htmlspecialchars($product['kategori']) ?></span>
            <div class="mt-4">
                <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
                <!-- button for add to cart -->
                <form action="process/cart_process.php" method="POST" class="d-inline">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                    <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean(); // simpan konten
require __DIR__ . '/../template/main.php'; // load template utama
