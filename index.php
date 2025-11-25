<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atasko - Tienda para Mascotas</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <link rel="stylesheet" href="public/css/header.css">
    <link rel="stylesheet" href="public/css/footer.css">
    <link rel="stylesheet" href="public/css/mainContent.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body>

    <!-- Inicico Header -->
    <?php include __DIR__ . '/views/partials/header.php'; ?>
    <!-- Fin Header -->

    <?php
    include __DIR__ . '/views/pages/index.php';
    ?>
</body>

</html>
