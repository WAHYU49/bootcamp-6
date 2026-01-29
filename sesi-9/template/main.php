<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ??'My Website' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<body>
<div class="min-vh-100 d-flex flex-column">
    <?php include __DIR__ . '/partials/navbar.php'; ?>
    <div class="container mt-4 flex-grow-1">
        <?php
            // INI MIRIP @YIELD DI LARAVEL
            echo $content ?? '';
        ?>
    </div>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>