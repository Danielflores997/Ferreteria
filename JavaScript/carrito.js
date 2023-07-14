// Obtener los productos del carrito desde el almacenamiento local
var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];

function agregarAlCarrito(titulo, imagen, precio) {
  // Verificar si el producto ya existe en el carrito
  var index = carritoProductos.findIndex(function (producto) {
    return producto.titulo === titulo;
  });

  if (index === -1) {
    // Crear un objeto producto con los detalles
    var producto = {
      titulo: titulo,
      imagen: imagen,
      precio: precio,
      cantidad: 1 // Agregar la cantidad inicial como 1
    };

    // Agregar el producto al arreglo del carrito
    carritoProductos.push(producto);
  } else {
    // Si el producto ya existe, incrementar la cantidad
    carritoProductos[index].cantidad++;
  }

  // Guardar los productos del carrito en el almacenamiento local
  localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));

  // Actualizar el carrito
  mostrarCarrito();
}

function mostrarCarrito() {
  var carritoItems = document.getElementById('carrito-items');
  carritoItems.innerHTML = '';

  // Recorrer los productos en el carrito y generar el HTML
  carritoProductos.forEach(function (producto, index) {
    var nuevoItem = document.createElement('div');
    nuevoItem.classList.add('carrito-item');

    var contenido = `
      <img src="${producto.imagen}" alt="" width="80px">
      <div class="carrito-item-detalles">
        <span class="carrito-item-titulo">${producto.titulo}</span>
        <div class="selector-cantidad">
          <button class="btn-restar" data-index="${index}"><i class="fa-solid fa-minus"></i></button>
          <input type="text" value="${producto.cantidad}" class="carrito-item-cantidad" disabled>
          <button class="btn-sumar" data-index="${index}"><i class="fa-solid fa-plus"></i></button>
        </div>
        <span class="carrito-item-precio">$${producto.precio}</span>
      </div>
      <button class="btn-eliminar" data-index="${index}"><i class="fa-solid fa-trash"></i></button>
    `;

    nuevoItem.innerHTML = contenido;
    carritoItems.appendChild(nuevoItem);

    // Restar cantidad
    var restarCantidadBtn = nuevoItem.querySelector('.btn-restar');
    restarCantidadBtn.addEventListener('click', function (event) {
      var index = event.target.getAttribute('data-index');
      restarCantidad(index);
    });

    // Sumar cantidad
    var sumarCantidadBtn = nuevoItem.querySelector('.btn-sumar');
    sumarCantidadBtn.addEventListener('click', function (event) {
      var index = event.target.getAttribute('data-index');
      sumarCantidad(index);
    });

    // Eliminar producto
    var eliminarBtn = nuevoItem.querySelector('.btn-eliminar');
    eliminarBtn.addEventListener('click', function (event) {
      var index = event.target.getAttribute('data-index');
      eliminarProducto(index);
    });
  });

  actualizarTotal();
}

function restarCantidad(index) {
  if (carritoProductos[index].cantidad > 1) {
    carritoProductos[index].cantidad--;
    mostrarCarrito();
  }
}

function sumarCantidad(index) {
  carritoProductos[index].cantidad++;
  mostrarCarrito();
}

function eliminarProducto(index) {
  carritoProductos.splice(index, 1);
  mostrarCarrito();
}

function actualizarTotal() {
  var total = 0;

  // Calcular el total sumando los precios de los productos
  carritoProductos.forEach(function (producto) {
    total += producto.precio * producto.cantidad;
  });

  var carritoPrecioTotal = document.querySelector('.carrito-precio-total');
  carritoPrecioTotal.innerText = '$' + total.toFixed(2);
}

mostrarCarrito();
