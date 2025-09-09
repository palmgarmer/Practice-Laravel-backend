# Practice Laravel Backend

A comprehensive Laravel-inspired backend API demonstrating CRUD operations, MVC architecture, and Swagger UI documentation.

## 🚀 Features

- ✅ **Complete CRUD Operations** - Create, Read, Update, Delete for tasks
- ✅ **MVC Architecture** - Proper separation with Models, Controllers, and Routes
- ✅ **RESTful API Design** - Following REST conventions
- ✅ **Swagger/OpenAPI Documentation** - Interactive API documentation
- ✅ **JSON Responses** - All endpoints return structured JSON
- ✅ **Data Validation** - Input validation with comprehensive error messages
- ✅ **CORS Support** - Cross-origin resource sharing enabled
- ✅ **SQLite Database** - Persistent file-based storage
- ✅ **Error Handling** - Proper HTTP status codes and error responses

## 🏗️ Architecture

### MVC Structure
```
app/
├── Models/
│   └── Task.php              # Task model with database operations
└── Http/
    └── Controllers/
        └── TaskController.php # CRUD controller with Swagger annotations

bootstrap/
└── app.php                   # Database configuration and helper functions

routes/
└── api.php                   # API route definitions and router

public/
├── index.php                 # Application entry point
├── swagger.json              # OpenAPI specification
├── swagger-ui.html           # Swagger UI interface
└── overview.html             # API overview page
```

## 📋 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/tasks` | Get all tasks |
| `GET` | `/api/tasks/{id}` | Get specific task |
| `POST` | `/api/tasks` | Create new task |
| `PUT` | `/api/tasks/{id}` | Update existing task |
| `DELETE` | `/api/tasks/{id}` | Delete task |
| `GET` | `/api/documentation` | Swagger UI |
| `GET` | `/swagger.json` | OpenAPI specification |

## 💾 Task Schema

```json
{
  "id": 1,
  "title": "Complete project documentation",
  "description": "Write comprehensive API documentation using Swagger",
  "status": "pending|in_progress|completed",
  "created_at": "2025-09-09 04:59:28",
  "updated_at": "2025-09-09 04:59:28"
}
```

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- SQLite support

### Installation & Running

1. Clone the repository:
```bash
git clone <repository-url>
cd Practice-Laravel-backend
```

2. Start the development server:
```bash
php -S localhost:8000 -t public
```

3. Visit the API:
- **API Overview**: http://localhost:8000/overview.html
- **Swagger Documentation**: http://localhost:8000/api/documentation
- **API Base**: http://localhost:8000/api/tasks

## 🧪 Testing the API

### Create a Task
```bash
curl -X POST -H "Content-Type: application/json" \
  -d '{"title":"My Task","description":"Task description","status":"pending"}' \
  http://localhost:8000/api/tasks
```

### Get All Tasks
```bash
curl http://localhost:8000/api/tasks
```

### Get Single Task
```bash
curl http://localhost:8000/api/tasks/1
```

### Update a Task
```bash
curl -X PUT -H "Content-Type: application/json" \
  -d '{"status":"completed"}' \
  http://localhost:8000/api/tasks/1
```

### Delete a Task
```bash
curl -X DELETE http://localhost:8000/api/tasks/1
```

## 📚 Documentation

- **Swagger UI**: Visit `/api/documentation` for interactive API documentation
- **OpenAPI Spec**: Available at `/swagger.json`
- **API Overview**: Visit `/overview.html` for a comprehensive overview

## 🛠️ Development

### Running Tests
```bash
php tests/crud_test.php
```

### Database
The application uses SQLite with a file-based database stored in `storage/database.sqlite`. The database is automatically created on first run.

## 📝 Validation Rules

### Creating Tasks
- `title`: Required, max 255 characters
- `description`: Optional, text
- `status`: Optional, must be one of: `pending`, `in_progress`, `completed`

### Updating Tasks
- All fields are optional
- Same validation rules apply when provided

## 🔒 Error Handling

The API returns appropriate HTTP status codes:
- `200`: Success
- `201`: Created
- `400`: Bad Request (validation errors)
- `404`: Not Found
- `500`: Internal Server Error

Example error response:
```json
{
  "errors": ["Title is required"]
}
```

## 🎯 Project Structure

This project demonstrates a Laravel-inspired backend with:
- **Clean MVC separation**
- **RESTful API design**
- **Comprehensive documentation**
- **Input validation**
- **Error handling**
- **Database persistence**

Perfect for learning backend development concepts and API design patterns.
