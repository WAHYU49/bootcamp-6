<?php
$title = "Detail Produk";

ob_start(); // mirip @section('content')
?>
<?php
// code for fetching cart items from session
session_start();
$cartItems = $_SESSION['cart'] ?? [];
?>
<div class="container py-4">
    <h2 class="mb-4">Keranjang Belanja</h2>
    <?php if (empty($cartItems)): ?>
        <p>Keranjang Anda kosong.</p>
    <?php else: ?>
        <table class="table">
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
                    <td>
                        <form method="post" action="process/cart_process.php" class="d-inline">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">
                            <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" min="1" style="width:60px;">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                        <form method="post" action="process/cart_process.php" class="d-inline ms-1">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId) ?>">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini dari keranjang?')">Hapus</button>
                        </form>
                    </td>
                    <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Grand Total:</th>
                    <th>Rp <?= number_format($grandTotal, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean(); // simpan konten
require __DIR__ . '/../template/main.php'; // load template utama
?>