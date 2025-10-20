// --- tiendaMain.js ---
// Inicializador principal (idéntico al tuyo)

function initializeTienda() {
  listaProductos = document.getElementById("lista-productos");
  listaCarrito = document.getElementById("lista-carrito");
  total = document.getElementById("total");
  btnVaciar = document.getElementById("vaciar-carrito");

  if (!listaProductos || !btnVaciar) return;

  renderProductos();
}
