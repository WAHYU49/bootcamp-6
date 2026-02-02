<?php
session_start();
require __DIR__ . '/../../config/koneksi.php';

// Inisialisasi cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Pastikan POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Metode request tidak valid.");
}

$action    = $_POST['action'] ?? '';
$productId = $_POST['product_id'] ?? null;

if (!$productId) {
    die("ID produk tidak diberikan.");
}

// =====================
// UPDATE QUANTITY
// =====================
if ($action === 'update') {
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $quantity;
    }

// =====================
// DELETE ITEM
// =====================
} elseif ($action === 'delete') {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }

// =====================
// ADD ITEM (DEFAULT)
// =====================
} else {
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        $stmt = $koneksi->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            die("Produk tidak ditemukan.");
        }

        $_SESSION['cart'][$productId] = [
            'id'          => $product['id'],
            'nama_produk' => $product['nama_produk'],
            'harga'       => $product['harga'],
            'quantity'    => 1
        ];
    }
}

// Redirect kembali ke cart
header("Location: ../cart.php");
exit;
