# Ferreteria Multitenant

Integrantes
- Diego borbon 
- vannesa madrigal
- daniel flores

## Arquitectura

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

## Tecnologia utilizada
- PHP
- Mysql
- Html
- CSS
- JavaScript

## Requisitos

- XAMPP (Apache + MySQL/MariaDB)
- PHP 7.4+ con extensión `mysqli`
- `mod_rewrite` habilitado

## Instalación en XAMPP y ejecución (`C:\xampp\htdocs\Ferreteria`)

1. Copia/clona este repo en `C:\xampp\htdocs\Ferreteria`.
2. Importa `BD_FERRETERIA.sql` en phpMyAdmin (base `ferreterianuevo`).
3. Ajusta credenciales si hace falta en `app/config/config.php`:
   - `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`
   - `BASE_URL` = `/Ferreteria/public` (por defecto)
4. Abre en el navegador:

   `http://localhost/Ferreteria/php/`

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
