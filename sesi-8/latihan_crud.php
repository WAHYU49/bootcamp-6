<?php
    include 'koneksi.php';

    // Create
    // $sql = "INSERT INTO products (nama_produk, harga, deskripsi, kategori, image) VALUES 
    // ('Produk A', 100000, 'Deskripsi Produk A', 'elektronik', 'image_a.jpg')";

    // $koneksi->query($sql);
    // echo "Data produk berhasil ditambahkan.";    
    // Read
    $sql = "SELECT * FROM products";
    $result = $koneksi->query($sql);
    
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Nama Produk: " . $row['nama_produk'] . " - Harga: " . $row['harga'] . "<br>";
    }

    //foreach ($result as $row) {echo $row['nama_produk'] . " - " . $row['harga'] . "<br>";}

    // Update
    $sql = "UPDATE products SET harga = 15000000 WHERE id = 2";
    $koneksi->query($sql);
    echo "Data produk berhasil diupdate.";

    // Delete
    $sql = "DELETE FROM products WHERE id = 3";
    $koneksi->query($sql);
    echo "Data produk berhasil dihapus.";

?>
