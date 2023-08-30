<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".boton-item").on("click", function() {
                const titulo = $(this).data("titulo");
                const imagen = $(this).data("imagen");
                const precio = parseFloat($(this).data("precio"));

                agregarAlCarrito(titulo, imagen, precio);
            });

            function agregarAlCarrito(titulo, imagen, precio) {
                var producto = {
                    titulo: titulo,
                    imagen: imagen,
                    precio: precio,
                    cantidad: 1
                };

                var carritoProductos = JSON.parse(localStorage.getItem('carritoProductos')) || [];
                carritoProductos.push(producto);
                localStorage.setItem('carritoProductos', JSON.stringify(carritoProductos));
            }
        });
    </script>