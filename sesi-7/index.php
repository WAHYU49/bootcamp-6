<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1>Form Input Data Produk</h1>
                <form action="proses.php" method="POST"
                enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="harga_produk" name="harga_produk" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi_produk" name="deskripsi_produk" rows="3" required></textarea>
                    </div>
                    <!-- Kategori -->
                    <div class="mb-3">
                        <label for="kategori_produk" class="form-label">Kategori Produk</label>
                        <select class="form-select" id="kategori_produk" name="kategori_produk" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="pakaian">Pakaian</option>
                            <option value="makanan">Makanan</option>
                            <option value="perabotan">Perabotan</option>
                        </select>
                    </div>
                    <!-- Produk Image -->
                    <div class="mb-3">
                        <label for="image_produk" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image_produk" name="image_produk" accept="image/*" required>    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
<script>
    // form validation
    let form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let namaProduk = document.getElementById('nama_produk').value;
        let hargaProduk = document.getElementById('harga_produk').value;
        let deskripsiProduk = document.getElementById('deskripsi_produk').value;
        let kategoriProduk = document.getElementById('kategori_produk').value;
        let imageProduk = document.getElementById('image_produk').value;

        if (!namaProduk || !hargaProduk || !deskripsiProduk || !kategoriProduk || !imageProduk) {
            event.preventDefault();
            alert('All fields are required.');
        }
    }); 
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>