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
2. Importa `BD_FERRETERIA.sql` → BD `ferreterianuevo`.
3. Haz una copia de seguridad y aplica una vez
   `database/migrations/20261107_001_multitenant.sql`.
4. Revisa `app/config/config.php` (`BASE_URL=/Ferreteria/public`).
5. Crea el primer superadmin siguiendo la sección de migración.
6. Abre `http://localhost/Ferreteria/public/`.

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
- `4` Superadmin — administración global de ferreterías

## Migración multi-tenant

`BD_FERRETERIA.sql` conserva el esquema original. Para actualizar una instalación
existente:

1. Haz una copia de seguridad de la base `ferreterianuevo`.
2. Revisa las consultas de preflight comentadas en
   `database/migrations/20261107_001_multitenant.sql`. Resuelve duplicados de
   correo o de código de producto antes de continuar.
3. Importa esa migración **una sola vez** sobre la base original. Los registros
   existentes se asignan a `Ferretería inicial`; las cuentas de rol Cliente
   quedan globales y sin `tenant_id`. Las categorías son globales.
4. Crea el primer superadmin desde PowerShell con secretos temporales en el
   entorno (no los guardes en el repositorio):

   ```powershell
   $env:FERRETERIA_SUPERADMIN_EMAIL = "admin@example.com"
   $env:FERRETERIA_SUPERADMIN_PASSWORD = "<contraseña segura de 12+ caracteres>"
   $env:FERRETERIA_SUPERADMIN_DOCUMENTO = "<documento numérico>"
   php scripts/bootstrap_superadmin.php
   Remove-Item Env:FERRETERIA_SUPERADMIN_EMAIL, Env:FERRETERIA_SUPERADMIN_PASSWORD, Env:FERRETERIA_SUPERADMIN_DOCUMENTO
   ```

El bootstrap crea una cuenta nueva con contraseña hasheada y no eleva una cuenta
existente. Las contraseñas heredadas en texto plano se convierten a hash cuando
el usuario inicia sesión correctamente.

> La migración anterior parte del esquema original. Si la base ya tiene la tabla
> `tenants` o columnas `tenant_id` por una aplicación manual previa, no la
> ejecutes: primero compara la estructura real con el archivo y prepara un patch
> específico para esa versión.
