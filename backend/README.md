# Task Manager Backend API

Laravel-based REST API for a collaborative task management system.

## Features

- **Authentication**: Laravel Sanctum token-based authentication
- **User Management**: Registration, login, logout
- **Project Management**: CRUD operations with collaboration support
- **Task Management**: Nested task resources under projects
- **Authorization**: Role-based permissions (creators vs members)
- **Validation**: Comprehensive request validation

## Quick Start

1. **Install dependencies:**
```bash
composer install
```

2. **Setup environment:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Run migrations:**
```bash
php artisan migrate
```

4. **Start server:**
```bash
php artisan serve
```

API will be available at `http://127.0.0.1:8000`

## API Endpoints

### Authentication
```
POST /api/register    - User registration
POST /api/login       - User login  
POST /api/logout      - User logout
GET  /api/user        - Get current user
```

### Projects
```
GET    /api/projects           - List user's projects
POST   /api/projects           - Create project
GET    /api/projects/{id}      - Get project details
PUT    /api/projects/{id}      - Update project
DELETE /api/projects/{id}      - Delete project
```

### Tasks
```
GET    /api/projects/{project}/tasks        - List project tasks
POST   /api/projects/{project}/tasks        - Create task
GET    /api/projects/{project}/tasks/{task} - Get task details
PUT    /api/projects/{project}/tasks/{task} - Update task
DELETE /api/projects/{project}/tasks/{task} - Delete task
```

## Database Schema

- **users**: id, name, email, password, timestamps
- **projects**: id, name, description, user_id, timestamps
- **tasks**: id, project_id, user_id, title, description, due_date, status, timestamps
- **project_user**: project_id, user_id, timestamps (pivot table)

## Authorization

- **Project Creators**: Full CRUD on projects, manage members
- **Project Members**: View projects, manage tasks
- **Task Creators**: Edit own tasks
- **Project Creators**: Delete any project task

## Testing

Run the API test script:
```bash
php test_api.php
```

## Tech Stack

- Laravel 11
- Laravel Sanctum (Authentication)
- SQLite Database
- PHP 8.2+
