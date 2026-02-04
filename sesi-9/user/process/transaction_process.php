<?php
include '../../config/koneksi.php';
session_start();

// cek cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Keranjang belanja Anda kosong.");
}

$cartItems = $_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];

    // mulai transaksi DB
    $koneksi->begin_transaction();

    try {
        // 1️⃣ simpan user
        $stmt = $koneksi->prepare(
            "INSERT INTO users (name, email, phone, address) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $phone, $address);
        $stmt->execute();
        $userId = $stmt->insert_id;
        $stmt->close();

        // 2️⃣ hitung total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        // 3️⃣ simpan transaksi
        $status = 'pending';
        $stmt = $koneksi->prepare(
            "INSERT INTO transactions (user_id, total, status)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("ids", $userId, $total, $status);
        $stmt->execute();
        $transactionId = $stmt->insert_id;
        $stmt->close();

        // 4️⃣ simpan item transaksi
        $stmt = $koneksi->prepare(
            "INSERT INTO transaction_items
            (transaction_id, product_id, quantity, total_price)
            VALUES (?, ?, ?, ?)"
        );

        foreach ($cartItems as $productId => $item) {
            $totalPriceItem = $item['harga'] * $item['quantity'];

            $stmt->bind_param(
                "iiid",
                $transactionId,
                $productId,
                $item['quantity'],
                $totalPriceItem
            );
            $stmt->execute();
        }

        $stmt->close();

        // commit
        $koneksi->commit();

        // kosongkan cart
        unset($_SESSION['cart']);

        header(
            "Location: ../transaction_status.php?message=Transaction+successful&transaction_id=$transactionId"
        );
        exit;

    } catch (Exception $e) {
        $koneksi->rollback();
        die("Transaksi gagal: " . $e->getMessage());
    }

} else {
    die("Metode request tidak valid.");
}
