<?php

class Tenant
{
    private static ?array $current = null;

    /**
     * Resuelve el tenant activo desde ?tenant=slug o $_SESSION['tenant_id'].
     * Si no hay ninguno válido, redirige a la landing.
     */
    public static function resolve(): void
    {
        // 1. Prioridad 1: parámetro ?tenant= en la URL
        if (!empty($_GET['tenant'])) {
            $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['tenant']));
            $tenant = self::findBySlug($slug);
            if ($tenant) {
                $_SESSION['tenant_id'] = (int) $tenant['idTenant'];
                self::$current = $tenant;
                return;
            }
        }

        // 2. Prioridad 2: sesión (ya eligió antes)
        if (!empty($_SESSION['tenant_id'])) {
            $tenant = self::findById((int) $_SESSION['tenant_id']);
            if ($tenant) {
                self::$current = $tenant;
                return;
            }
        }

        // 3. No hay tenant → redirigir a la landing
        header('Location: ' . self::baseUrl() . '/public/landing.php');
        exit();
    }

    public static function current(): ?array
    {
        return self::$current;
    }

    public static function id(): ?int
    {
        return self::$current['idTenant'] ?? null;
    }

    public static function nombre(): string
    {
        return self::$current['nombre'] ?? 'Ferretería';
    }

    public static function logo(): string
    {
        return self::$current['logo'] ?? '../imagenes/ferreteria.jpeg';
    }

    public static function slug(): string
    {
        return self::$current['slug'] ?? '';
    }

    public static function baseUrl(): string
    {
        // si se sube a un subdirectorio, cambiar esta ruta según corresponda
        return '/Ferreteria-mvc';
    }

    private static function findBySlug(string $slug): ?array
    {
        require_once __DIR__ . '/../config/database.php';
        $conn = db();
        $stmt = mysqli_prepare($conn, 'SELECT * FROM tenants WHERE slug = ? AND estado = "Activo" LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $slug);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        return $res ? mysqli_fetch_assoc($res) : null;
    }

    private static function findById(int $id): ?array
    {
        require_once __DIR__ . '/../config/database.php';
        $conn = db();
        $stmt = mysqli_prepare($conn, 'SELECT * FROM tenants WHERE idTenant = ? AND estado = "Activo" LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        return $res ? mysqli_fetch_assoc($res) : null;
    }
}