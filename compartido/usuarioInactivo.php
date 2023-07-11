<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error de Acceso</title>
  <style>
    body {
      background-color: #f9f9f9;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .error-container {
      max-width: 400px;
      text-align: center;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 4px;
    }

    .error-container h2 {
      margin-top: 0;
      color: #e74c3c;
    }

    .error-container p {
      margin-bottom: 20px;
      color: #555;
    }

    .error-container a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #3498db;
      color: #fff;
      text-decoration: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .error-container a:hover {
      background-color: #2980b9;
    }

    /* Animación */
    @keyframes fadeIn {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    .animated {
      animation-duration: 0.8s;
      animation-fill-mode: both;
    }

    .fadeIn {
      animation-name: fadeIn;
    }
  </style>
</head>

<body>
  <div class="error-container animated fadeIn">
    <h2>Error de Acceso</h2>
    <p>Tu cuenta está inactiva.</p>
    <a href="../Php/loginCliente.php">Volver al Inicio de Sesión</a>
  </div>
</body>
</html>
