# 🎨 LeonardoDB - Database Designer

# LeonardoDB 3.0

**Un diseñador moderno de bases de datos self-hosted creado para desarrolladores.**

LeonardoDB permite diseñar bases de datos de forma visual, exportar esquemas reales, generar migraciones de Laravel e interactuar con la estructura de la base de datos mediante IA configurable por el usuario.

Este proyecto fue creado como una potente alternativa abierta a herramientas como DrawSQL, dbdiagram y DBDesigner, pero totalmente local, personalizable y enfocado en desarrolladores.

## ¿Qué hay de nuevo en 3.0?

- **Soporte para PostgreSQL** - Diseña, exporta esquemas `.postgresql.sql` y genera migraciones Laravel adaptadas a PostgreSQL con tipos nativos como `SERIAL`, `BIGSERIAL`, `JSONB`, `UUID` y más
- **Soporte para MongoDB** - Diseña colecciones, exporta esquemas `.mongodb.js` con validación `$jsonSchema` y genera migraciones Laravel usando el paquete `mongodb/laravel-mongodb`
- **Multi-motor** - Elige entre MySQL, PostgreSQL y MongoDB según tu proyecto, cada uno con su propio canvas de preview y exportación

## Características Principales

- **Diseñador visual de bases de datos en canvas** - Interfaz intuitiva con drag & drop
- **Exportación SQL / NoSQL** - Compatible con MySQL, PostgreSQL y MongoDB
- **Generador de migraciones Laravel** - Soporte para los tres motores de base de datos
- **Canvas de preview en tiempo real** - Visualiza tu esquema con syntax highlighting antes de exportar
- **Entorno local en tiempo real** - Sin dependencias de servicios externos
- **Soporte para IA configurable** - Conecta tu propio proveedor de IA para consultas y análisis
- **Interfaz moderna** - Construida con Laravel + Vue.js
- **Self-hosted y código abierto** - Control total sobre tus datos y diseños

### Funcionalidades Avanzadas

- Relaciones visuales entre tablas con conectores interactivos
- Gestión completa de columnas, tipos de datos e índices
- Preview en tiempo real con syntax highlighting para SQL, PostgreSQL y MongoDB
- Soporte para múltiples proyectos simultáneos
- Barra de búsqueda de tablas en el sidebar
- Contador de tablas por proyecto

## Motores Soportados

| Motor | Exportación | Migraciones Laravel |
|-------|-------------|-------------------|
| MySQL | `.sql` | ✅ |
| PostgreSQL | `.postgresql.sql` | ✅ |
| MongoDB | `.mongodb.js` | ✅ (`mongodb/laravel-mongodb`) |



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