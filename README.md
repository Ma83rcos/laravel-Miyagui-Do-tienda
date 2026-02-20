# 🥋 Miyagui-Do Shop

[![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php)](https://php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)](https://www.docker.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

> **Proyecto Final - Desarrollo de Aplicaciones Web (DAW)**

Es una tienda en línea de productos especializados para karate, desarrollada con Laravel 12. Incluye todo lo necesario para manejar un negocio en línea: gestión de productos, promociones, carrito de compras y un panel de administración para controlar la tienda de manera sencilla. Está dockerizada usando Laravel Sail, lo que permite levantar el proyecto en cualquier equipo de forma rápida y sin complicaciones.

## ✨ Características Principales

- 🛍️ **Catálogo de productos** por categorías con sistema de ofertas
- 🛒 **Carrito de compras** funcional para usuarios e invitados
- ⭐ **Lista de favoritos** (wishlist) persistente
- 👥 **Sistema de roles** (admin/usuario) con Laravel Breeze
- 📦 **Control de stock** en tiempo real
- 💰 **Descuentos automáticos** por ofertas
- 👨‍💼 **Panel de administración** completo (CRUD)
- 📧 **Formulario de contacto**
- 🔍 **Laravel Telescope** para debugging

## 🛠️ Tecnologías

- **Backend**: Laravel 12, Laravel Breeze, PHP 8.4
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js, Vite
- **Base de datos**: MySQL 8 (Docker) / SQLite (local)
- **Cache/Sesiones**: Redis
- **Entorno**: Docker, Laravel Sail
- **Calidad**: PHPStan, Laravel Pint, PHP CodeSniffer
- **Testing**: PHPUnit

## 📦 Requisitos

### Opción 1: Docker (Recomendado)
- Docker Desktop
- Docker Compose

### Opción 2: Local
- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x
- MySQL/SQLite

## 🐳 Instalación con Docker (Recomendado)

### 1. Clonar el repositorio
```bash
git clone https://github.com/Ma83rcos/laravel-Miyagui-Do-tienda.git
cd laravel-Miyagui-Do-tienda
```

### 2. Configurar entorno
```bash
cp .env.example .env
```

Verifica estas variables en `.env`:
```env
APP_NAME="Miyagui-Do Shop"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

### 3. Levantar contenedores
```bash
./vendor/bin/sail up -d
```

Servicios disponibles:
- **Laravel** (PHP 8.4)
- **MySQL** 8
- **Redis**

### 4. Instalar dependencias
```bash
./vendor/bin/sail composer install
./vendor/bin/sail npm install
```

### 5. Configuración inicial
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
./vendor/bin/sail npm run dev
```

### 6. Acceder a la aplicación
🌐 **http://localhost**

## 💻 Instalación Local (sin Docker)

```bash
# Clonar e instalar
git clone https://github.com/Ma83rcos/laravel-Miyagui-Do-tienda.git
cd Miyagui_DoShop
composer install
npm install

# Configurar
cp .env.example .env
php artisan key:generate

# Base de datos SQLite
touch database/database.sqlite

# Migrar y sembrar
php artisan migrate --seed
php artisan storage:link

# Iniciar
npm run dev
php artisan serve
```

## 👤 Usuarios de Prueba

**Administrador**
```
Email: admin@miyagui.com
Password: admin
```

**Usuario Regular**
```
Email: user@miyagui.com
Password: user123
```

## 📂 Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── CartController.php        # Gestión del carrito
│   │   ├── CategoryController.php    # Gestión de categorías
│   │   ├── OfferController.php       # Gestión de ofertas
│   │   ├── ProductController.php     # Gestión de productos
│   │   ├── WishlistController.php    # Lista de favoritos
│   │   ├── ContactController.php     # Formulario de contacto
│   │   ├── ProfileController.php     # Gestión de perfil de usuario
│   │   └── WelcomeController.php     # Página principal
│   ├── Middleware/
│   │   ├── AdminMiddleware.php       # Control de acceso por rol (admin)
│   │   └── LogUserActivity.php       # Registro de actividad de usuarios
│   └── Requests/
│       ├── Auth/
│       │   └── LoginRequest.php      # Validación de inicio de sesión
│       └── ProfileUpdateRequest.php  # Validación de actualización de perfil
├── Models/
│   ├── Category.php                  # Categorías
│   ├── Offer.php                     # Ofertas y descuentos
│   ├── Product.php                   # Productos
│   ├── ProductVariant.php            # Variantes (talla, color, stock independiente)
│   └── User.php                      # Usuarios con roles              # Usuarios con roles
```

## 🗄️ Base de Datos

**Tablas:**
- `users` - Usuarios con rol (admin/user)
- `categories` - Categorías de productos
- `offers` - Ofertas con % de descuento
- `products` - Productos (nombre, precio, stock, imagen)
- `product_user` - Carrito de compras (pivot)
- `wishlist_user` - Lista de favoritos (pivot)

**Relaciones:**
- Product → belongsTo → Category, Offer
- Product → belongsToMany → User (carrito y wishlist)

## ⚡ Comandos Útiles

### Docker (Sail)
```bash
# Levantar/Detener contenedores
./vendor/bin/sail up -d
./vendor/bin/sail down

# Base de datos
./vendor/bin/sail artisan migrate:fresh --seed

# Limpiar caché
./vendor/bin/sail artisan optimize:clear

# Testing
./vendor/bin/sail artisan test

# Hot reload
./vendor/bin/sail npm run dev

# Acceder al contenedor
./vendor/bin/sail shell
```

### Local
```bash
# Desarrollo con hot reload
composer run dev

# Base de datos
php artisan migrate:fresh --seed

# Testing
php artisan test

# Formatear código
./vendor/bin/pint
```

## 🎯 Funcionalidades por Rol

### Usuario Regular
✅ Navegar catálogo de productos  
✅ Añadir al carrito sin registro  
✅ Gestionar lista de favoritos  
✅ Ver ofertas con descuentos aplicados  
✅ Enviar mensajes de contacto  

### Administrador
✅ Todas las funciones de usuario  
✅ CRUD completo de productos, categorías y ofertas  
✅ Gestión de stock e imágenes  
✅ Asignación de ofertas a productos  
✅ Dashboard administrativo  
✅ Acceso a Laravel Telescope  

## 🔒 Seguridad

- ✅ Protección CSRF en formularios
- ✅ Middleware de autenticación y roles
- ✅ Hash de contraseñas con Bcrypt
- ✅ Validación de stock antes de checkout
- ✅ Sanitización de inputs del usuario

## 🧪 Debugging y Desarrollo

- **Laravel Telescope** - Monitoreo de requests, queries y logs
- **Hot Reload** con Vite - Cambios en tiempo real
- **Redis** - Cache y sesiones optimizadas
- **Docker Logs** - `./vendor/bin/sail logs`

## 📝 Roadmap

- [ ] Integración con pasarela de pago (Stripe/PayPal)
- [ ] Historial de pedidos para usuarios
- [ ] Sistema de valoraciones y reseñas
- [ ] Notificaciones por email
- [ ] Sistema de cupones de descuento
- [ ] API REST para apps móviles

## 🤝 Contribución

Este es un proyecto educativo. Las sugerencias son bienvenidas:

1. Fork el proyecto
2. Crea tu rama (`git checkout -b feature/mejora`)
3. Commit cambios (`git commit -m 'Agrega nueva feature'`)
4. Push a la rama (`git push origin feature/mejora`)
5. Abre un Pull Request

## 👨‍💻 Autor

**Marcos Moya Maldonado** - Proyecto Final DAW

- GitHub: [@Ma83rcos](https://github.com/Ma83rcos)
- Repositorio: [Miyagui-Do Tienda](https://github.com/Ma83rcos/laravel-Miyagui-Do-tienda)

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

---

<div align="center">

### ⭐ Digamos qu es un inicio de proyecto muy escalable y con mucho que añadir a  Miyagi-Do🥋 tienda-online 


*Desarrollado con ❤️ como Proyecto Final de DAW*

</div>
