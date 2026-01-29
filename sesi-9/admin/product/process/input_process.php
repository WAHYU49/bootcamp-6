<?php
    // proses.php - handle form submission from index.php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $nama_produk = $_POST['nama_produk'];
        $harga_produk = $_POST['harga_produk'];
        $deskripsi_produk = $_POST['deskripsi_produk'];
        $kategori_produk = $_POST['kategori_produk'];

        //data validation
        if (empty($nama_produk) || empty($harga_produk) || empty($deskripsi_produk) || empty($kategori_produk)) {
            die("All fields are required.");
        }
        // Handle file upload
        if (isset($_FILES['image_produk']) && $_FILES['image_produk']['error'] === 
        UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_produk']['tmp_name'];
            $fileName = $_FILES['image_produk']['name'];
            $fileSize = $_FILES['image_produk']['size'];
            $fileType = $_FILES['image_produk']['type'];
            // jersey.jpg ===> ['jersey', 'jpg']
            $fileNameCmps = explode(".", $fileName); // Split file name by dot
            $fileExtension = strtolower(end($fileNameCmps));

            // Sanitize file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Check if the file has one of the allowed extensions
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg', 'webp');
            if (!in_array($fileExtension, $allowedfileExtensions)) {
                die("Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions));
            }

            // Directory in which the uploaded file will be moved
            $uploadFileDir = '../../../uploaded_files/';
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $message ='File is successfully uploaded.';
            } else {
                $message = 'There was some error moving the file to upload directory.';
            }
        } else {
            $message = 'No file uploaded or there was an upload error.';
        }

        //php code to insert data into database
        include '../../../config/koneksi.php';
       try {
            $stmt = $koneksi->prepare("INSERT INTO products 
            (nama_produk, harga, deskripsi, kategori, image) 
            VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sisss", $nama_produk, $harga_produk, 
            $deskripsi_produk, $kategori_produk, $newFileName);
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            die("Error inserting data: " . $e->getMessage());
        }

        // Redirect back to the product list page after processing with success message
        header("Location: ../index.php?message=Product+added+successfully");
        exit();
    } else {
        echo "Invalid request method.";
    }
?>