// --- carrito.js ---
// Botón de vaciar carrito (idéntico al original)

btnVaciar.addEventListener("click", () => {
  carrito.forEach(item => {
    const original = productos.find(p => p.id === item.id);
    if (original) original.stock += 1;
  });
  carrito = [];
  renderProductos();
  renderCarrito();
});
