<?php
// Fetch product data based on the provided ID
if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}
$product_id = $_GET['id'];
include __DIR__ . '/../../config/koneksi.php';
// Query produk
$query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $product_id");
if (mysqli_num_rows($query) == 0) {
    die("Produk dengan ID: $product_id tidak ditemukan.");
}
$product = mysqli_fetch_assoc($query);
?>
<?php
$title = "Edit Produk Admin";

ob_start(); // mirip @section('content')
?>
<div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1>Form Edit Data Produk</h1>
                <form action="process/edit_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>">
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= htmlspecialchars($product['nama_produk']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="harga_produk" name="harga_produk" value="<?= htmlspecialchars($product['harga']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3" required><?= htmlspecialchars($product['deskripsi']) ?></textarea>
                    </div>
                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="kategori_produk" class="form-label">Kategori Produk</label>
                        <select class="form-select" id="kategori_produk" name="kategori_produk" required>
                            <option value="" disabled>Pilih Kategori</option>
                            <option value="elektronik" <?= $product['kategori'] == 'elektronik' ? 'selected' : '' ?>>Elektronik</option>
                            <option value="pakaian" <?= $product['kategori'] == 'pakaian' ? 'selected' : '' ?>>Pakaian</option>
                            <option value="makanan" <?= $product['kategori'] == 'makanan' ? 'selected' : '' ?>>Makanan</option>
                            <option value="perabotan" <?= $product['kategori'] == 'perabotan' ? 'selected' : '' ?>>Perabotan</option>
                        </select>
                    </div>
                    <!-- Produk Image -->
                    <div class="mb-3">
                        <label for="image_produk" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image_produk" name="image_produk" accept="image/*">
                        <?php if (!empty($product['image'])): ?>
                        <div class="mt-2">
                            <img src="../../uploaded_files/<?= htmlspecialchars($product['image']) ?>" 
                            alt="Current Product Image" style="width:150px; height:auto;">
                        </div>
                        <?php endif; ?>
                    </div>    
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        // form validation
        let form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            let namaProduk = document.getElementById('nama_produk').value;
            let hargaProduk = document.getElementById('harga_produk').value;
            let deskripsiProduk = document.getElementById('deskripsi_produk').value;
            let kategoriProduk = document.getElementById('kategori_produk').value;

            if (!namaProduk || !hargaProduk || !deskripsiProduk || !kategoriProduk) {
                event.preventDefault();
                alert('All fields except image are required.');
            }
        });
    </script>
</div>

<?php
$content = ob_get_clean(); // simpan konten
require __DIR__ . '/../../template/main.php';
?>