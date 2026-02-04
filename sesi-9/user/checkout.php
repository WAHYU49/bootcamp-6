<?php
$title = "Detail Produk";

ob_start(); // mirip @section('content')
?>
<?php
// Ambil data dari session cart
session_start();
$cartItems = $_SESSION['cart'] ?? [];
?>
<div class="container py-4">
    <h2 class="mb-4">Checkout</h2>
    <?php if (count($cartItems) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($cartItems as $productId => $item):
                    $total = $item['harga'] * $item['quantity'];
                    $grandTotal += $total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                    <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end">Grand Total:</td>
                    <td>Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4">
            <!-- Form user info name, email, phone, address -->
             <form action="process/transaction_process.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <button class="btn btn-success" type="submit">Proses Pembayaran 
                (Demo)</button>
             </form>
        </div>
    <?php else: ?>
        <p>Keranjang Belanja Anda kosong.</p>
        <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean(); // simpan konten
require __DIR__ . '/../template/main.php'; // load template utama
?>