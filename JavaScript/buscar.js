$(document).ready(function() {
    // Agregar el evento de clic al botón de búsqueda
    $("#buscar button").click(function() {
        // Obtener el valor del campo de búsqueda
        var searchTerm = $("#ip-buscar").val();

        // Realizar la petición AJAX al servidor
        $.ajax({
            url: "../compartido/buscar.php", // Archivo PHP que manejará la búsqueda
            method: "POST",
            data: { searchTerm: searchTerm }, // Enviar el término de búsqueda al servidor
            success: function(response) {
                // Insertar los resultados de la búsqueda en el cuerpo de la tabla
                $("#tabla table tbody").html(response);

                // Asegurarse de que la fila de encabezado se mantenga visible
                $("#tabla table thead").show();
            }
        });
    });
});

