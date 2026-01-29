<?php
include __DIR__ . '/../../config/koneksi.php';
$title = "Daftar Produk Admin";
// Ambil daftar produk
$query = mysqli_query($koneksi, "SELECT * FROM products ORDER BY id DESC");
ob_start(); // mirip @section('content')
?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>

<!-- Display success message if available -->
<?php if (isset($_GET['message'])): ?>
    <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<div class="container py-4">
    <h2 class="mb-4">Daftar Produk</h2>
    <a href="input_page.php" class="btn btn-primary mb-4">Tambah Produk</a>

    <!-- Tabel Products -->
    <table id="tabel-produk" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Image</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['nama_produk']; ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= ucfirst($row['kategori']); ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']); ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="../../uploaded_files/<?= 
                            htmlspecialchars($row['image']); ?>" alt="Gambar Produk" style="max-width:80px;max-height:80px;object-fit:cover;">
                        <?php else: ?>
                            <span class="text-muted">(Tidak ada gambar)</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_page.php?id=<?= $row['id']; ?>" class="btn btn-sm 
                        btn-warning">Edit</a>
                        <a href="delete_process.php?id=<?= $row['id']; ?>" class="btn btn-sm 
                        btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')
                        ">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        </table>
    </div>


<?php
$content = ob_get_clean(); // simpan konten
?>
<!-- jQuery harus di-load sebelum DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tabel-produk').DataTable();
    });
</script>
<?php
require __DIR__ . '/../../template/main.php'; 
?>