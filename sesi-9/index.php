<?php
    include 'config/koneksi.php';

    // ambil kategori unik untuk filter
    $kategoriQuery = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM products");

    // filter kategori
    $where = "";
    if (isset($_GET['kategori']) && $_GET['kategori'] != '') {
        $kategori = mysqli_real_escape_string($koneksi, $_GET['kategori']);
        $where = "WHERE kategori = '$kategori'";
    }

    // ambil data produk
    $query = mysqli_query($koneksi, "SELECT * FROM products $where");
?>

<?php
$title = "Home";

ob_start(); // mirip @section('content') 
?>


<div class="container my-4">
    <h3 class="mb-4">Daftar Produk</h3>

    <!-- Filter Kategori -->
    <form method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="kategori" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    <?php while ($kat = mysqli_fetch_assoc($kategoriQuery)) : ?>
                        <option value="<?= $kat['kategori']; ?>"
                            <?= (isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori']) ? 'selected' : ''; ?>>
                            <?= ucfirst($kat['kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <!-- Card Produk -->
    <div class="row">
        <?php if (mysqli_num_rows($query) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="uploaded_files/<?= 
                            htmlspecialchars($row['image']); ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['nama_produk']; ?></h5>
                            <p class="text-muted mb-1"><?= ucfirst($row['kategori']); ?></p>
                            <p class="card-text"><?= substr($row['deskripsi'], 0, 80); ?>...</p>
                            <h6 class="text-primary">
                                Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                            </h6>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Produk tidak ditemukan
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean(); // simpan konten
require __DIR__ . '/template/main.php'; // load template utama

