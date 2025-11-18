<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
    <link rel="stylesheet" href="../../public/css/header.css">
    <link rel="stylesheet" href="../../public/css/footer.css">
    <link rel="stylesheet" href="../../public/css/mainContent.css">
</head>

<body>
    <!-- Inicico Header -->
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <!-- Fin Header -->


    <!-- Inicio content -->
    <div class="contenedor">
        <p>Esta es la página principal de la aplicación.</p>


        <div class="titulo-producto"></div>
    </div>


    <!-- Inicio Footer -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>


</body>

<script>
    let titulo = document.querySelector('.titulo-producto');
    const getInfo = () => {
        fetch('http://localhost/atasko/src/api/Productos.php')
            .then(response => response.json())
            .then(data => {
                for (let producto of data) {
                    titulo.innerHTML += `<h3>${producto.nombre}</h3>`;
                }
            })
            .catch(error => console.error('Error:', error));



       
    };
    getInfo();
</script>

</html>