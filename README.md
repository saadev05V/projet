<<<<<<< HEAD
<<<<<<< HEAD
# React + Vite

This template provides a minimal setup to get React working in Vite with HMR and some ESLint rules.

Currently, two official plugins are available:

- [@vitejs/plugin-react](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react) uses [Babel](https://babeljs.io/) for Fast Refresh
- [@vitejs/plugin-react-swc](https://github.com/vitejs/vite-plugin-react/blob/main/packages/plugin-react-swc) uses [SWC](https://swc.rs/) for Fast Refresh

## Expanding the ESLint configuration

If you are developing a production application, we recommend using TypeScript with type-aware lint rules enabled. Check out the [TS template](https://github.com/vitejs/vite/tree/main/packages/create-vite/template-react-ts) for information on how to integrate TypeScript and [`typescript-eslint`](https://typescript-eslint.io) in your project.
=======
=======
>>>>>>> f925514cd9ad5606b62940b8a4a204fa8910fd95
# Collaborative Task Manager

A full-stack collaborative task management application built with Laravel (backend) and React (frontend).

## Features

- **User Authentication**: Register, login, and secure token-based authentication
- **Project Management**: Create, update, and delete projects
- **Collaborative Workspaces**: Add multiple users as project members
- **Task Management**: Create, assign, and track tasks within projects
- **Task Status Tracking**: pending → in progress → completed/overdue
- **Role-based Permissions**: Different permissions for project creators vs members

## Tech Stack

### Backend
- **Laravel 11** - PHP framework
- **Laravel Sanctum** - API authentication
- **SQLite** - Database
- **RESTful API** - Clean API design

### Frontend
- **React 19** - Frontend framework
- **React Router** - Navigation
- **Axios** - HTTP client

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

## Installation

### Backend Setup

1. Navigate to the backend directory:
```bash
cd backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run database migrations:
```bash
php artisan migrate
```

6. Start the Laravel development server:
```bash
php artisan serve
```

The backend will be available at `http://127.0.0.1:8000`

### Frontend Setup

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install Node.js dependencies:
```bash
npm install
```

3. Start the React development server:
```bash
npm start
```

The frontend will be available at `http://localhost:3000`

## Database Schema

### Users Table
- id, name, email, password, timestamps

### Projects Table
- id, name, description, user_id (creator), timestamps

### Tasks Table
- id, project_id, user_id (creator), title, description, due_date, status, timestamps

### Project-User Pivot Table
- project_id, user_id, timestamps (for collaboration)

## Authorization

- **Project Creators**: Can update/delete projects and manage members
- **Project Members**: Can view projects and manage tasks
- **Task Creators**: Can edit their own tasks
- **Project Creators**: Can delete any task in their projects

## Testing

The backend includes test scripts for API validation:

```bash
# Run API tests
php test_api.php
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available under the [MIT License](LICENSE).
<<<<<<< HEAD
>>>>>>> f925514cd9ad5606b62940b8a4a204fa8910fd95
=======
>>>>>>> f925514cd9ad5606b62940b8a4a204fa8910fd95
