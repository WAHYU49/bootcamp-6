<?php
$title = "Transaction Status";
ob_start();

// koneksi DB
require __DIR__ . '/../config/koneksi.php';

// validasi GET
if (!isset($_GET['message'])) {
    die("Message not found.");
}
$message = $_GET['message'];

if (!isset($_GET['transaction_id'])) {
    die("Transaction ID not found.");
}
$transactionId = (int) $_GET['transaction_id'];

// ambil data transaksi
$stmt = $koneksi->prepare(
    "SELECT t.id, t.total, t.status,
            u.name, u.email, u.phone, u.address
     FROM transactions t
     JOIN users u ON t.user_id = u.id
     WHERE t.id = ?"
);
$stmt->bind_param("i", $transactionId);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

if (!$transaction) {
    die("Transaction with ID $transactionId not found.");
}

// Fetch transaction items
// Fetch transaction items (MySQLi)
$stmtItems = $koneksi->prepare(
    "SELECT 
        ti.product_id,
        p.nama_produk,
        ti.quantity,
        ti.total_price
     FROM transaction_items ti
     JOIN products p ON ti.product_id = p.id
     WHERE ti.transaction_id = ?"
);
$stmtItems->bind_param("i", $transactionId);
$stmtItems->execute();
$resultItems = $stmtItems->get_result();

?>

<div class="container py-4">
    <div class="alert alert-success">
        <?= htmlspecialchars($message) ?>
    </div>

    <h2>Transaction Details</h2>
    <p><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction['id']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($transaction['status']) ?></p>
    <p><strong>Total Amount:</strong> Rp <?= number_format($transaction['total'], 0, ',', '.') ?></p>
    <h3>Items:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $resultItems->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                    <td>
                        Rp <?= number_format(
                            $item['total_price'] / $item['quantity'],
                            0, ',', '.'
                        ) ?>
                    </td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>Rp <?= number_format($item['total_price'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
    <h3>User Information</h3>
    <p><strong>Name:</strong> <?= htmlspecialchars($transaction['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($transaction['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($transaction['phone']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($transaction['address']) ?></p>

    <?php
    $whatsappMessage =
        "Hello, I would like to confirm my transaction with the following details:\n\n" .
        "Transaction ID: {$transaction['id']}\n" .
        "Name: {$transaction['name']}\n" .
        "Email: {$transaction['email']}\n" .
        "Phone: {$transaction['phone']}\n" .
        "Address: {$transaction['address']}\n" .
        "Total Amount: Rp " . number_format($transaction['total'], 0, ',', '.') . "\n\n" .
        "Please let me know the next steps.";

$whatsappUrl = "https://wa.me/1234567890?text=" . urlencode($whatsappMessage);


    $whatsappUrl = "https://wa.me/1234567890?text=" . urlencode($whatsappMessage);
    ?>

    <a href="<?= $whatsappUrl ?>" class="btn btn-success mt-3" target="_blank">
        Confirm Transaction via WhatsApp
    </a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../template/main.php';
?>
