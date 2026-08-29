# Ferreteria Meissen — MVC unificado

Fusión de **`feature/mvc-migration`** (base más completa) + lo útil de **`Ferreteria-mvc`** (dashboard con totales, reportes y páginas de soporte).

## Comparación de ramas

| Aspecto | Ferreteria-mvc | feature/mvc-migration | Resultado unificado |
|---------|----------------|-----------------------|---------------------|
| Router front-controller | Parcial (scripts en `public/*.php`) | Completo (`public/index.php`) | Completo |
| CRUD inventario | Vista básica | Completo + AJAX | Completo |
| Usuarios/clientes | Listado | CRUD + búsqueda + alta | Completo |
| Proveedores | Listado | CRUD + búsqueda | Completo |
| Ventas | Parcial | CRUD + AJAX + CSV | Completo |
| Compras carrito | No | Sí | Sí + mis compras cliente |
| Peticiones PQRS | Stub | Completo | Completo |
| Dashboard totales | Sí (simple) | Perfil | Totales + recientes + accesos |
| Reportes | Inventario HTML | CSV | HTML imprimible + CSV |
| Recuperar contraseña | Página | No | Sí (`auth/recuperar`) |

## Estructura

```
app/
  config/ core/ controllers/ models/ views/ helpers/
public/          # document root (index.php, css, imagenes)
BD_FERRETERIA.sql
Php/ compartido/ # legacy de referencia
```

## Instalación XAMPP

1. Clona/copia en `C:\xampp\htdocs\Ferreteria`
2. Importa `BD_FERRETERIA.sql` → BD `ferreterianuevo`
3. Revisa `app/config/config.php` (`BASE_URL=/Ferreteria/public`)
4. Abre `http://localhost/Ferreteria/public/`

## Rutas

- Público: `home/index`, `home/categoria/{slug}`, `home/nosotros`, `contacto/index`
- Auth: `auth/login`, `auth/register`, `auth/recuperar`, `auth/logout`
- Admin/Vendedor: `admin/index` (dashboard), `inventario`, `catalogo`, `proveedores`, `ventas`, `compras`, `peticiones`, `reportes`
- Solo Admin: `admin/usuarios` (+ crear usuario)
- Cliente: `cliente/perfil`, `cliente/carrito`, `cliente/misCompras`, `cliente/procesarCompra`

## Roles

- `1` Administrador — menú completo (incluye usuarios)
- `2` Vendedor — sin gestión de usuarios
- `3` Cliente — catálogo, carrito, perfil y mis compras
