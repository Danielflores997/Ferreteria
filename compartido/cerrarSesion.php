<?php
session_start();
session_unset();
session_destroy();
header('Location: ../Php/index.php'); // Redirigir después de cerrar sesión
exit();
?>
