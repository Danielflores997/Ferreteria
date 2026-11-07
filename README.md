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
2. Importa `BD_FERRETERIA.sql` → BD `ferreterianuevo`. Este dump crea directamente
   el esquema multi-tenant para una instalación nueva.
3. Revisa `app/config/config.php` (`BASE_URL=/Ferreteria/public`).
4. Crea el primer superadmin siguiendo la sección de migración.
5. Abre `http://localhost/Ferreteria/public/`.

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

## Alta de ferreterías

1. Inicia sesión con la cuenta de rol `4` y abre **Crear ferretería** desde el panel.
2. Completa los datos de la tienda y los de su administrador. El correo de acceso
   debe ser único y la contraseña inicial debe tener al menos 12 caracteres.
3. Al guardar, la tienda y su administrador se crean en una sola transacción. Si
   falla cualquiera de los dos registros, no queda una tienda incompleta.
4. El administrador inicia sesión con las credenciales creadas y agrega productos
   desde **Gestión Catálogo e Inventario**. Los productos quedan ligados a esa
   ferretería y aparecen en el marketplace mientras la tienda esté activa.

El panel superadmin muestra administradores, estado, productos y ventas por tienda.
Desactivar una ferretería la oculta del marketplace sin borrar sus datos.

## Base de datos multi-tenant

`BD_FERRETERIA.sql` conserva los datos de muestra y crea el esquema multi-tenant
completo, con una ferretería inicial, roles 1–4, correo global único, relaciones
por tenant y campos requeridos por el checkout. Las cuentas antiguas mantienen
sus contraseñas de muestra y se convierten a hash en el primer inicio de sesión.
El dump no crea una cuenta superadmin ni contiene una contraseña inicial.

Para actualizar una instalación existente que aún tiene el esquema original:

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

No ejecutes la migración después de importar `BD_FERRETERIA.sql`: el dump ya
incluye esos cambios y la migración es exclusivamente para bases originales.
