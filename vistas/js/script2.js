// La lógica de la tienda ahora está dentro de una función global
function initializeTienda() {
    
    // Productos simulados 
    const productos = [
      { id: 1, nombre: "Juguete para perro", descripcion: "Pelota resistente ideal para juegos al aire libre.", precio: 25.00, imagen: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR08k71IxKbQlyNvTwuYxgGK7KCDcCVZ5rg7g&s", stock: 10 },
      { id: 2, nombre: "Collar ajustable", descripcion: "Collar de nylon con hebilla metálica y diseño moderno.", precio: 15.50, imagen: "https://cdnx.jumpseller.com/ace-comaderas/image/35787577/resize/1200/1200?1693843433", stock: 10 },
      { id: 3, nombre: "Cama para mascotas", descripcion: "Cama acolchada de algodón suave, perfecta para descansar.", precio: 80.00, imagen: "https://rapipet.pe/wp-content/uploads/2022/01/Diseno-sin-titulo-3-3.png", stock: 10 },
      { id: 4, nombre: "Comedero doble", descripcion: "Dos compartimientos para agua y comida de acero inoxidable.", precio: 35.90, imagen: "https://img.ltwebstatic.com/images3_spmp/2024/04/25/39/1714006615c136be308d7db1fdc342a17c695da3f5.webp", stock: 10 },
      { id: 5, nombre: "Rascador para gato", descripcion: "Rascador de sisal con base estable y juguete incluido.", precio: 60.00, imagen:"https://png.pngtree.com/png-vector/20240706/ourmid/pngtree-accessories-for-cats-cat-scratching-post-png-image_13011231.png", stock: 10 },
      { id: 6, nombre: "Arnés reflectante", descripcion: "Seguridad nocturna con materiales reflectantes y cómodos.", precio: 45.00, imagen:"https://papopet.pe/wp-content/uploads/2024/08/416.webp", stock: 10 },
      { id: 7, nombre: "Shampoo para perros", descripcion: "Fórmula suave que cuida el pelaje y elimina los malos olores.", precio: 22.00, imagen: "https://petstorelima.pe/wp-content/uploads/2023/01/shampoo-frescan-piel-sensible-.png", stock: 10 },
      { id: 8, nombre: "Transportadora div tamaños", descripcion: "Caja transportadora ventilada y segura para viajes.", precio: 110.00, imagen: "https://pintospetshop.com/wp-content/uploads/2023/11/Savic-Transportador-Plomo-para-Mascotas-Trotter-1-640x640.png", stock: 10 },
      { id: 9, nombre: "ropa de gato + tallas", descripcion: "Ropa para que tu michi tenga el mejor de los looks.", precio: 50.00, imagen: "https://magavet.co/wp-content/uploads/2021/01/RPC-Gato-DuoDry-Rosa.png", stock: 10 },
      { id: 10, nombre: "ropa de perro + tallas", descripcion: "Lo mejor de lo mejor en ropa para tu amigo canino favorito.", precio: 60.00, imagen: "https://www.macropaparamascotas.com/wp-content/uploads/2025/05/ropa-perro-camisetas.webp", stock: 10 }
    ];

    const listaProductos = document.getElementById("lista-productos");
    const listaCarrito = document.getElementById("lista-carrito");
    const total = document.getElementById("total");
    const btnVaciar = document.getElementById("vaciar-carrito");

    if (!listaProductos || !btnVaciar) return; // Salir si los elementos no están en el DOM

    let carrito = [];

    // Renderiza los productos
    function renderProductos() {
      listaProductos.innerHTML = "";
      productos.forEach(prod => {
        const div = document.createElement("div");
        div.classList.add("producto");
        div.innerHTML = `
          <img src="${prod.imagen}" alt="${prod.nombre}">
          <h3>${prod.nombre}</h3>
          <p class="descripcion">${prod.descripcion}</p>
          <p class="precio">S/ ${prod.precio.toFixed(2)}</p>
          <p class="stock">Stock: ${prod.stock}</p>
          <button ${prod.stock <= 0 ? "disabled" : ""}>${prod.stock > 0 ? "Agregar al carrito 🛍️" : "Sin stock"}</button>
        `;
        const boton = div.querySelector("button");
        boton.addEventListener("click", () => agregarAlCarrito(prod.id));
        listaProductos.appendChild(div);
      });
    }

    // Agregar producto al carrito
    function agregarAlCarrito(id) {
      const producto = productos.find(p => p.id === id);
      if (producto && producto.stock > 0) {
        producto.stock -= 1;
        // Creamos una copia para el carrito
        carrito.push({ ...producto }); 
        renderProductos();
        renderCarrito();
      }
    }

    // Renderizar carrito
    function renderCarrito() {
      listaCarrito.innerHTML = "";
      carrito.forEach((item, i) => {
        const li = document.createElement("li");
        li.textContent = `${item.nombre} - S/ ${item.precio.toFixed(2)}`;
        listaCarrito.appendChild(li);
      });
      const totalCompra = carrito.reduce((acc, item) => acc + item.precio, 0);
      total.textContent = `Total: S/ ${totalCompra.toFixed(2)}`;
    }

    // Vaciar carrito
    btnVaciar.addEventListener("click", () => {
      // Repone el stock
      carrito.forEach(item => {
        const original = productos.find(p => p.id === item.id);
        if (original) original.stock += 1;
      });
      carrito = [];
      renderProductos();
      renderCarrito();
    });

    renderProductos();
}
