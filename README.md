# Ferreteria Meissen — MVC unificado

Fusión de **`feature/mvc-migration`** (base más completa) + lo útil de **`Ferreteria-mvc`** (dashboard con totales, reportes y páginas de soporte).

## Ejecutar con Docker

Requiere Docker Desktop con Docker Compose habilitado.

1. Copia la plantilla de variables y cambia las dos contraseñas por valores
   largos, aleatorios y distintos:

   ```powershell
   Copy-Item .env.example .env
   notepad .env
   ```

2. Construye y levanta la aplicación y MariaDB:

   ```powershell
   docker compose up --build -d
   docker compose ps
   ```

3. Abre `http://localhost:8080` (o el puerto configurado en `APP_PORT`).

En el primer inicio, MariaDB importa `BD_FERRETERIA.sql` y crea los datos de
muestra. La importación se ejecuta únicamente cuando el volumen de la base está
vacío. La base y las fotos de perfil se conservan en volúmenes de Docker al
detener o recrear los contenedores. Para ver los registros:

```powershell
docker compose logs -f app db
```

En este entorno, el volumen Docker ya fue actualizado con la base activa de
XAMPP, incluyendo sus usuarios, productos y cuenta superadmin. `docker compose
down` conserva esos datos; no uses `docker compose down -v` a menos que quieras
borrar también la base y las fotos persistidas.

Para sincronizar de nuevo la base local de XAMPP al contenedor, exporta primero
un respaldo local (no lo subas a Git: contiene datos de usuarios) y luego
restáuralo en MariaDB:

```powershell
New-Item -ItemType Directory -Force .docker-data | Out-Null
& C:\xampp\mysql\bin\mysqldump.exe --host=127.0.0.1 --port=3306 --user=root `
  --single-transaction --routines --triggers --events --hex-blob `
  --default-character-set=utf8mb4 --databases ferreterianuevo `
  > .docker-data\ferreterianuevo.sql
if ($LASTEXITCODE -ne 0) { throw "No se pudo exportar la base de XAMPP" }

docker compose stop app
docker compose cp .docker-data\ferreterianuevo.sql db:/tmp/ferreterianuevo.sql
docker compose exec -T db sh -c 'mariadb -uroot -p"$MARIADB_ROOT_PASSWORD" -e "DROP DATABASE IF EXISTS ferreterianuevo; CREATE DATABASE ferreterianuevo CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"'
docker compose exec -T db sh -c 'mariadb -uroot -p"$MARIADB_ROOT_PASSWORD" < /tmp/ferreterianuevo.sql && rm -f /tmp/ferreterianuevo.sql'
docker compose start app

Remove-Item .docker-data\ferreterianuevo.sql
```

Para detener los servicios sin borrar los datos:

```powershell
docker compose down
```

Este Compose está pensado para desarrollo/pruebas locales. Antes de exponerlo a
Internet, configura HTTPS, secretos administrados, copias de seguridad y revisa
los datos de muestra.

## Acceso público con URL fija (sin dominio propio)

Para esta instalación ya está activa la URL HTTPS fija:
https://ferreteria-marketplace.tail8e3427.ts.net/

Para configurar una instalación nueva:

1. Crea una cuenta en [Tailscale](https://login.tailscale.com/start), inicia
   sesión en la consola de administración y genera una auth key. No la publiques
   ni la subas a Git.
2. Agrégala al `.env` local como `TS_AUTHKEY=tskey-...`.
3. Inicia la app con el servicio de Tailscale:

   ```powershell
   docker compose -f docker-compose.yml -f docker-compose.tailscale.yml up --build -d
   ```

4. Activa Funnel en el nodo del proyecto. Si la consola solicita habilitar la
   política de Funnel o HTTPS para el tailnet, apruébala desde Tailscale Admin:

   ```powershell
   docker compose -f docker-compose.yml -f docker-compose.tailscale.yml exec tailscale tailscale funnel --bg 80
   docker compose -f docker-compose.yml -f docker-compose.tailscale.yml exec tailscale tailscale funnel status
   ```

   El estado mostrará la URL HTTPS fija del hostname y tailnet.

Después de registrar el nodo, elimina `TS_AUTHKEY` del `.env` y revoca esa key
en Tailscale Admin → **Keys**. La identidad queda en el volumen persistente
`tailscale-state`, por lo que los reinicios no requieren guardar la key ni
deberían cambiar la URL. No elimines ese volumen ni borres el nodo de la consola
si quieres conservar la misma identidad. Para reiniciar la configuración:

```powershell
docker compose -f docker-compose.yml -f docker-compose.tailscale.yml down
docker compose -f docker-compose.yml -f docker-compose.tailscale.yml up -d
```

Para dejar de exponer el sitio, desactiva Funnel y detén los servicios:

```powershell
docker compose -f docker-compose.yml -f docker-compose.tailscale.yml exec tailscale tailscale funnel reset
docker compose -f docker-compose.yml -f docker-compose.tailscale.yml down
```

Funnel hace pública la aplicación a cualquiera que tenga la URL. Usa solo datos
de prueba y no reutilices contraseñas personales en el sitio.

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
