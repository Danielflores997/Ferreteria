<?php
servername = "localhost";
username = "root";
password = "";
dbname = "registro";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("conexion fallida: " . mysqli_connect_error());
}
echo "conexion exitosa";
?>