<?php

function db(): mysqli
{
    static $conn = null;

    if ($conn === null) {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'ferreterianuevo';

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            die('Conexión fallida: ' . mysqli_connect_error());
        }
    }

    return $conn;
}
