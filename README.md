# Ferreteria Meissen — estructura MVC

Migración del proyecto monolítico (`Php/` + `compartido/`) a una arquitectura **MVC** sencilla en PHP.

## Estructura

```
Ferreteria/
├── app/
│   ├── config/          # config.php, database.php
│   ├── core/            # App, Controller, Model (front controller)
│   ├── controllers/     # Home, Auth, Admin, Cliente, Contacto
│   ├── models/          # Usuario, Producto, Cliente, Proveedor, Venta, ...
│   ├── views/
│   │   ├── admin/       # Panel administrador completo
│   │   ├── auth/        # Login / registro
│   │   ├── catalogo/
│   │   ├── home/
│   │   ├── layouts/
│   │   └── partials/    # menú, footer, menú lateral
│   └── helpers/
├── public/              # Document root (CSS, imágenes, index.php)
│   ├── index.php
│   ├── css/
│   └── imagenes/
├── BD_FERRETERIA.sql
├── Php/                 # Código legacy (referencia)
└── compartido/          # Código legacy (referencia)
```

## Requisitos

- XAMPP (Apache + MySQL/MariaDB)
- PHP 7.4+ con extensión `mysqli`
- `mod_rewrite` habilitado

## Instalación en XAMPP (`C:\xampp\htdocs\Ferreteria`)

1. Copia/clona este repo en `C:\xampp\htdocs\Ferreteria`.
2. Importa `BD_FERRETERIA.sql` en phpMyAdmin (base `ferreterianuevo`).
3. Ajusta credenciales si hace falta en `app/config/config.php`:
   - `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`
   - `BASE_URL` = `/Ferreteria/public` (por defecto)
4. Abre en el navegador:

   `http://localhost/Ferreteria/public/`

   o

   `http://localhost/Ferreteria/` (redirige vía `.htaccess` raíz)

## Rutas principales

| URL | Descripción |
|-----|-------------|
| `/home/index` | Catálogo público |
| `/auth/login` | Login |
| `/auth/register` | Registro cliente |
| `/admin/index` | Panel admin / vendedor |
| `/admin/inventario` | Inventario y alta de productos |
| `/admin/catalogo` | Vista catálogo admin |
| `/admin/usuarios` | Usuarios y clientes |
| `/admin/proveedores` | Proveedores |
| `/admin/ventas` | Ventas |
| `/admin/compras` | Compras del carrito |
| `/admin/peticiones` | PQRS / peticiones |
| `/cliente/carrito` | Carrito |
| `/contacto/index` | Formulario PQRS |

El enrutado es: `public/index.php?url=Controlador/metodo/param`

## Módulos migrados

- **Auth**: login, registro, logout, usuario inactivo
- **Catálogo público** y categorías
- **Admin**: dashboard/perfil, inventario (CRUD + búsqueda + stock bajo + reporte CSV), catálogo, usuarios/clientes (CRUD + búsqueda), proveedores (CRUD + búsqueda), ventas (AJAX cliente/producto, listado, edición, reporte CSV), compras carrito, peticiones
- **Cliente**: perfil, carrito y procesar compra
- **Contacto** PQRS

## Notas

- Las carpetas `Php/` y `compartido/` se mantienen como referencia del sistema anterior; el front controller nuevo es `public/`.
- Si las imágenes de productos en BD apuntan a rutas viejas (`../imagenes/...`), actualízalas a rutas bajo `public/imagenes/` o URLs absolutas.
