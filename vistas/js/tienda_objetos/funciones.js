// --- funciones.js ---
// Funciones de renderizado y lógica de carrito (idénticas a las originales)

let carrito = [];

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

function agregarAlCarrito(id) {
  const producto = productos.find(p => p.id === id);
  if (producto && producto.stock > 0) {
    producto.stock -= 1;
    carrito.push({ ...producto }); 
    renderProductos();
    renderCarrito();
  }
}

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
