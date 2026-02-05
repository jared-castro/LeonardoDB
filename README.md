# 🎨 LeonardoDB - Database Designer

Database Designer - Diseñador visual de bases de datos MySQL con exportación SQL y migracion laravel

## Características

- Diseño visual interactivo con drag & drop
- Relaciones entre columnas
- Gestión de columnas e índices
- Exportación a SQL
- Preview SQL con syntax highlighting
- Exportación a laravel
- Múltiples proyectos

## Requisitos

- PHP >= 7.3
- Composer >= 2.0
- Node.js >= 18
- MySQL >= 8.0
- XAMPP (recomendado para Windows)

## Instalación

### 1. Clonar repositorio
```bash
git clone https://github.com/jared-castro/leonardodb.git
cd leonardodb
```

### 2. Instalar dependencias
```bash
composer install
npm install
cd server
npm install
cd ..
```

### 3. Configurar entorno
```bash
copy .env.example .env
php artisan key:generate
```

### 4. Configurar base de datos

Edita `.env`:
```env
DB_DATABASE=leonardodb
DB_USERNAME=root
DB_PASSWORD=tu_password
```

Crea la base de datos en MySQL:
```sql
CREATE DATABASE leonardodb;
```

### 5. Migrar base de datos
```bash
php artisan migrate
```

### 6. Compilar assets
```bash
npm run build
```

### 7. Iniciar servidores

**Terminal 1 - Laravel:**
```bash
php artisan serve:all
```

**Terminal 2 - Vite (desarrollo):**
```bash
npm run dev
```

Visita: `http://localhost:8000`

##  Dependencias Principales

### Backend
- Laravel 8.75
- Laravel Sanctum (autenticación)
- MySQL

### Frontend
- Vue.js 3.5
- Vite
- Axios
- jsPlumb (conexiones visuales)
- CodeMirror (editor SQL)
- Monaco Editor (preview SQL)

##  Licencia

MIT License

##  Autor
Jared Castro - [jared-castro](https://github.com/jared-castro)