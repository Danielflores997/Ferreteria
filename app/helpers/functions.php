<?php
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function asset($path)
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function url($path = '')
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function money($n)
{
    return number_format((float)$n, 0, ',', '.');
}

function isLoggedIn()
{
    return !empty($_SESSION['correo']);
}

function currentRole()
{
    return isset($_SESSION['rol']) ? (int)$_SESSION['rol'] : 0;
}
