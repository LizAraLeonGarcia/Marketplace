# Vaquita Marketplace

**Un sistema de marketplace básico desarrollado con Laravel. Permite a los usuarios gestionar productos y explorar diferentes categorías de manera sencilla.**

---

## Tabla de Contenidos

1. [Descripción](#descripción)
2. [Características](#características)
3. [Requisitos](#requisitos)
4. [Instalación](#instalación)
5. [Uso](#uso)
6. [Estructura del Proyecto](#estructura-del-proyecto)

---

## Descripción

Este **Vaquita Marketplace** es un proyecto desarrollado con Laravel, diseñado para ofrecer una plataforma básica donde los usuarios pueden crear, editar, ver y eliminar productos, además de también tener la opción de explorar productos por categorías, precios y una barra de búsqueda.

---

## Características

- CRUD de productos: Los usuarios autenticados pueden crear, editar, eliminar y visualizar sus propios productos, mientras para productos de otros usuarios solamente podrán verlos o añadirlos al carrito.
- Una vez que el usuario crea su primer producto se le envía un correo electrónico personalizado con la información de dicho producto.
- Gestión de usuarios: Autenticación y autorización implementadas con Laravel Jetstream.
- Categorías dinámicas: Posibilidad de filtrar productos por categorías como *Accesorios, Calzado, Cocina, Coleccionables, Escolar, Hogar, Oficina, Ropa, Videojuegos*.
- Diseño responsivo: Interfaz adaptada para dispositivos móviles y de escritorio utilizando Bootstrap.
- Imágenes para productos: Los usuarios deden subir imágenes asociadas a cada producto, siendo mínimo una el requisito y máximo 10.
- Perfiles: Se cuentan con dos perfiles por usuario, el Perfil como comprador y el Perfil como vendedor.
- Opción de Mi cuenta: Una vez registrado el usuario puede personalizar su información en la sección de Mi cuenta, además están los apartados de Editar cuenta, si es que quiere renovar su información; Cambiar contraseña, Metódo de pago y Eliminar cuenta.

**Importante**
Hay opciones no implementadas en el backend, solamente en el frontend. Las opciones **funcionales** en orden de sección son:
1. Dashboard = todo funcional.
2. Mi cuenta = las secciones de Editar cuenta, Cambiar contraseña y Eliminar mi cuenta son funcionales. La sección del Método de pago solamente tiene implementado para tarjeta de débito/crédito.
3. Perfil como comprador = funcional, además sólo es visual.
4. Perfil como vendedor = funcional, además sólo es visual.
5. Crear producto = todo funcional.
6. Ver productos = los productos se muestran sin filtros por defecto, pero para filtrarlos sólo es funcional hacerlo por alguna de las categorías, por precio o buscando en la barra de búsqueda; el resto de opciones no fue implementado.
7. Carrito = puede tener productos añadidos el usuario, pero el pago no se procesa, aunque sí se eliminan productos.
8. Ayuda = todo funcional.

---

## Requisitos

Antes de instalar este proyecto, asegúrate de contar con los siguientes requisitos:

- PHP >= 8.0
- Composer (para gestionar dependencias)
- MySQL (u otra base de datos compatible)
- Servidor local como **Laragon** o **XAMPP**
- Node.js y npm (opcional, para Laravel Mix o Vite)

---

## Instalación

Sigue estos pasos para configurar el proyecto:

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/tuusuario/Marketplace.git

2. **Acceder al directorio del proyecto**
    Al usar Laragon la carpeta en donde yo guardé el proyecto se encuenctra en:
    ```bash
    D:\Programas\laragon\www\Marketplace

3. **Instalar las dependencias de PHP**
    ```bash
    composer install

4. **Copiar y configura el archivo de entorno**
    ```bash
    cp .env.example .env

5. **Generar la clave de la aplicación**
    ```bash
    php artisan key:generate

6. **Ejecutar las migraciones y seeders**
    ```bash
    php artisan migrate --seed

7. **Levanta el servidor local**
    ```bash
    php artisan serve

**Extra**

Hay 4 tests preparados, éstos los tengo ubicados en la carpeta \laragon\www\Marketplace\tests\Feature y el archivo es MarketplaceTest.

---

## Uso

Todo está creado para que sólo los usuarios autenticados puedan acceder a las funciones implementadas, como:

Ver el dashboard con las opciones de gestión
- Crear nuevos productos.
- Editar productos existentes.
- Eliminar productos.

**Datos iniciales**
Al ejecutar los seeders, se crean:
1. Categorías predeterminadas: Accesorios, Calzado, Cocina, Coleccionables, Escolar, Hogar, Oficina, Ropa, Videojuegos.
2. 2 usuarios iniciales.

---

## Estructura del Proyecto

**Migraciones principales:**
- Categorías: Organización de los productos.
- Países: Organización de los usuarios.
- Users: Gestión de usuarios.
- Productos: Información básica de los productos.
- Imágenes: Relación entre productos e imágenes.

**Seeders utilizados:**
- RegistrarUsuariosSeeder: Crea 2 usuarios iniciales.
- CategoriaSeeder: Población inicial de categorías.
- PaisesSeeder: Población inicial de países.
- Producto1Seeder, Producto2Seeder, Producto3Seeder y Producto4Seeder que corresponden a productos de la categoría Coleccionables;
- ProductosAccesoriosSeeder,
- ProductosCalzadoSeeder,
- ProductosCocinaSeeder,
- ProductosEscolarSeeder,
- ProductosHogarSeeder,
- ProductosOficinaSeeder,
- ProductosRopaSeeder,
- ProductosVideojuegosSeeder.

