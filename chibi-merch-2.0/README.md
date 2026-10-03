# Chibi Merch 2.0

Tienda de productos kawaii hecha con **Laravel + MySQL**, pensada para un proyecto
académico de Programación Web.

Esta versión es **simple a propósito**: solo usa lo básico de Laravel
(modelos, controladores, rutas y vistas Blade). No hay capas extra,
ni panel administrativo con login, ni JavaScript complejo.

---

## Que incluye

- Catalogo de productos con imagenes.
- Ficha de cada producto.
- Carrito de compras con sesion (guardado en el navegador, no en MySQL).
- Formulario de contacto que guarda mensajes en MySQL.
- CRUD completo de productos (crear, leer, editar, eliminar).
- Productos iniciales que se cargan automaticamente.

---

## Que NO incluye

- No hay usuarios ni inicio de sesion.
- No hay pagos reales.
- El carrito se guarda en la sesion, asi que se pierde si cierras el navegador.
- Las personas queLean `/productos` pueden editar productos (no hay proteccion).

Si necesitas iniciar sesion o proteger el CRUD, eso se agrega despues con
Laravel Breeze. No se incluyo aqui para mantener el proyecto entendible.

---

## Rutas principales

| Ruta | Para que sirve |
|------|----------------|
| `/` | Tienda (catalogo) |
| `/producto/{id}` | Ficha de un producto |
| `/carrito` | Ver y modificar el carrito |
| `/contacto` | Formulario de contacto |
| `/productos` | CRUD de productos |
| `/productos/create` | Crear producto |
| `/productos/{id}/edit` | Editar producto |

---

## Como ejecutarlo en GitHub Codespaces

### 1. Subir los archivos

Sube todo el contenido de esta carpeta a tu repositorio de GitHub.

**Importante:** GitHub no deja subir carpetas que empiezan con punto.
Por eso el proyecto trae dos carpetas:

- `.devcontainer/` (la que usa Codespaces)
- `devcontainer/` (copia sin punto, para subirla)

Si subiste `devcontainer/`, despues renombrala a `.devcontainer`
(borra la que tiene el punto y ponle el nombre con punto).

Tambien sube la carpeta `public/img/` completa: ahi van las 6 imagenes.

### 2. Crear el Codespace

- Ve a tu repositorio en GitHub.
- Click en **Code** -> **Codespaces** -> **Create codespace on main**.

### 3. Instalar

En la terminal del Codespace ejecuta:

```bash
bash install.sh
```

El script hace todo automaticamente:

1. Crea Laravel.
2. Restaura los archivos que Composer sobrescribe (rutas, bootstrap, seeder).
3. Configura MySQL en el archivo `.env`.
4. Genera la clave de la aplicacion.
5. Espera a que MySQL arranque.
6. Crea las tablas y carga los 6 productos.
7. Muestra las rutas para verificar.

### 4. Ver la pagina

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Luego:

1. Abre la pestana **PORTS** (abajo en Codespaces).
2. Click en el icono del **globo** junto al puerto 8000.
3. Se abre la tienda.

---

## Estructura del proyecto

```
app/
  Models/
    Producto.php
    Mensaje.php
  Http/Controllers/
    CatalogoController.php     catalogo y ficha
    ProductoController.php     CRUD
    CarritoController.php      carrito con sesion
    ContactoController.php     formulario
database/
  migrations/                  tablas de productos y mensajes
  seeders/                     6 productos iniciales
resources/views/
  layouts/app.blade.php        menu y estructura base
  parciales/alertas.blade.php  mensajes de exito y error
  catalogo/                    tienda y ficha
  productos/                   CRUD
  carrito/                     carrito
  contacto/                    formulario
routes/web.php                 rutas
public/
  css/chibi-merch.css          estilos
  js/chibi-merch.js            solo el menu en celular
  img/productos/               las 6 imagenes
install.sh                     instalador automatico
```

---

## Productos iniciales

| Producto | Precio |
|----------|--------|
| Libreta Momonga | $149.00 MXN |
| Llavero Usagi | $89.00 MXN |
| Pack de Stickers Kawaii | $69.00 MXN |
| Peluche Chiikawa | $329.00 MXN |
| Peluche Hachiware | $349.00 MXN |
| Taza de Menta Chibi | $179.00 MXN |

---

## Problemas comunes

**`could not find driver`**
MySQL no esta listo. Espera unos segundos y repite:
```bash
php artisan migrate --force
```

**`SQLSTATE[HY000] [2002] Connection refused`**
El contenedor de MySQL no ha arrancado. Revisa la pestana PORTS y espera.

**`419 Page Expired`**
Se vencio la sesion. Recarga la pagina con F5.

**No aparece la imagen del producto**
El archivo `.avif` (Peluche Hachiware) no lo soporta Safari viejo.
Cambia la extension o prueba con Chrome o Firefox.

**La pagina no carga y dice 502**
El servidor no esta corriendo. Ejecuta otra vez:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```