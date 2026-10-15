<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".boton-item").on("click", function() {
                const titulo = $(this).data("titulo");
                const imagen = $(this).data("imagen");
                const precio = parseFloat($(this).data("precio"));
                const id = parseFloat($(this).data("id")); 
                agregarAlCarrito(titulo, imagen, precio, id);
            });

            function agregarAlCarrito(titulo, imagen, precio, idProducto) {
                var producto = {
                    titulo: titulo,
                    imagen: imagen,
                    precio: precio,
                    id: idProducto,
                    cantidad: 1
                };

                var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
                carritoProductos.push(producto);
                localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
            }
        });
    </script>