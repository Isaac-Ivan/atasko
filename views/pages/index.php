

    <!-- Sección Hero -->
    <section class="hero">
        <div class="contenedor">
            <h2>Todo para consentir a tu mascota</h2>
            <p>Encuentra los mejores productos para perros y gatos</p>
            <a href="#" class="boton-principal">Ver Productos</a>
        </div>
    </section>

    <!-- Categorías -->
    <section class="categorias">
        <div class="contenedor">
            <h3>Categorías Populares</h3>
            <div class="grid-categorias">
                <div class="categoria-item">
                    <img src="public/images/alimentos.png" alt="Alimentos" />
                    <h4>Alimentos</h4>
                    <p>Nutrición de calidad</p>
                </div>
                <div class="categoria-item">
                    <img src="public/images/juguetes.png" alt="Juguetes" />
                    <h4>Juguetes</h4>
                    <p>Diversión garantizada</p>
                </div>
                <div class="categoria-item">
                    <img src="public/images/accesorios.png" alt="Accesorios" />
                    <h4>Accesorios</h4>
                    <p>Estilo y comodidad</p>
                </div>
                <div class="categoria-item">
                    <img src="public/images/salud.png" alt="Salud" />
                    <h4>Salud</h4>
                    <p>Cuidado integral</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Destacados -->
    <section class="productos">
        <div class="contenedor">
            <h3>Productos Destacados</h3>
            <div class="grid-productos"></div>
        </div>
    </section>

    <!-- Inicio Footer -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

</body>

<script>
    let titulo = document.querySelector(".grid-productos");
    const getInfo = () => {
      fetch("http://localhost/atasko/src/api/Productos.php")
        .then((response) => response.json())
        .then((data) => {
          for (let producto of data) {
            titulo.innerHTML += ` <div class="producto-item">
            <img src="" alt="Producto 1" />
            <h4>Tipo de producto: ${producto.categoria}</h4>
            <h4>${producto.nombre}</h4>
            <p class="precio">${producto.precio}</p>
            <button class="boton-comprar">Agregar al Carrito</button>
          </div>`;
          }
        })
        .catch((error) => console.error("Error:", error));
    };
    getInfo();
</script>

