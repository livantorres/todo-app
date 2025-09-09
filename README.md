# ToDo CRUD API (PHP 8.3 + MySQL)


Proyecto básico de CRUD de tareas implementado con PHP 8.3 puro y MySQL.


## 🚀 Características
- API REST con rutas CRUD completas.
- Frontend SPA ligero con Bootstrap + Vanilla JS.
- Documentación OpenAPI incluida.
- Buenas prácticas de seguridad y PDO.


## ⚙️ Instalación
```bash
# Clonar repositorio
git clone https://github.com/tuusuario/todo-app.git
cd todo-app


# Crear base de datos
mysql -u root -p < migrations/001_create_todos.sql


# Configurar variables
cp .env.example .env