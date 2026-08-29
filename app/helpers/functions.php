<?php
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function asset($path)
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Build app URLs in a XAMPP-friendly way.
 * Prefer pretty paths; also expose index.php?url= for environments without rewrite.
 */
function url($path = '', $query = [])
{
    $path = trim((string)$path, '/');
    $base = rtrim(BASE_URL, '/');

    // Always route through front controller query string so category
    // filters work even if Apache rewrite is disabled on XAMPP.
    $href = $base . '/index.php';
    if ($path !== '') {
        // Keep slashes in url path for router segments
        $href .= '?url=' . implode('/', array_map('rawurlencode', explode('/', $path)));
    }
    if (!empty($query) && is_array($query)) {
        $sep = (strpos($href, '?') === false) ? '?' : '&';
        $href .= $sep . http_build_query($query);
    }
    return $href;
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
