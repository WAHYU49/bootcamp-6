<?php
 include '../../../config/koneksi.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ambil data dari form
        $product_id = $_POST['product_id'];
        $nama_produk = $_POST['nama_produk'];
        $harga_produk = $_POST['harga_produk'];
        $deskripsi_produk = $_POST['deskripsi_produk'];
        $kategori_produk = $_POST['kategori_produk'];
    
        // Data validation
        if (empty($product_id) || empty($nama_produk) || empty($harga_produk) || empty($deskripsi_produk) || empty($kategori_produk)) {
            die("All fields are required.");
        }
    
        // Initialize image filename variable
        $newFileName = null;
    
        // Handle file upload if a new file is provided
        if (isset($_FILES['image_produk']) && $_FILES['image_produk']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_produk']['tmp_name'];
            $fileName = $_FILES['image_produk']['name'];
            $fileSize = $_FILES['image_produk']['size'];
            $fileType = $_FILES['image_produk']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    
            // Check if the file has one of the allowed extensions
            $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg', 'webp'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Directory in which the uploaded file will be moved
                $uploadFileDir = '../../../uploaded_files/';
                $dest_path = $uploadFileDir . $newFileName;
    
                if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                    die("There was some error moving the file to upload directory.");
                }else {
                    // delete old image file
                    $query = mysqli_query($koneksi, "SELECT image FROM products WHERE id = $product_id");
                    $product = mysqli_fetch_assoc($query);
                    if ($product && !empty($product['image'])) {
                        $oldImagePath = $uploadFileDir . $product['image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
            } else {
                die("Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions));
            }
        }

        // Update database record
        if ($newFileName) {
            // Update with new image
            $updateQuery = "UPDATE products SET nama_produk = ?, harga = ?, deskripsi = ?, kategori = ?, image = ? WHERE id = ?";
            $stmt = mysqli_prepare($koneksi, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'sisssi', $nama_produk, $harga_produk, $deskripsi_produk, $kategori_produk, $newFileName, $product_id);
            mysqli_stmt_execute($stmt);
        } else {
            // Update without changing image
            $updateQuery = "UPDATE products SET nama_produk = ?, harga = ?, deskripsi = ?, kategori = ? WHERE id = ?";
            $stmt = mysqli_prepare($koneksi, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'sissi', $nama_produk, $harga_produk, $deskripsi_produk, $kategori_produk, $product_id);
            mysqli_stmt_execute($stmt);
        }
        // Redirect back to product list page after processing with success message
        header("Location: ../index.php?message=Product+updated successfully");
        exit();
} else {
        die("Invalid request method.");
}
?>