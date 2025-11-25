  <section class="productos">
        <div class="contenedor">
            <h3>Productos Destacados</h3>
            <div class="grid-productos"></div>
        </div>
    </section>

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



