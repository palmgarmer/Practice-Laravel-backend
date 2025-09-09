<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../app/Http/Controllers/TaskController.php';
require_once __DIR__ . '/../app/Models/Task.php';

use App\Http\Controllers\TaskController;

// Simple router
class Router 
{
    private static $routes = [];
    
    public static function get($path, $callback) {
        self::$routes['GET'][$path] = $callback;
    }
    
    public static function post($path, $callback) {
        self::$routes['POST'][$path] = $callback;
    }
    
    public static function put($path, $callback) {
        self::$routes['PUT'][$path] = $callback;
    }
    
    public static function delete($path, $callback) {
        self::$routes['DELETE'][$path] = $callback;
    }
    
    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Handle CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($method === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
        
        // Check for exact match
        if (isset(self::$routes[$method][$path])) {
            $callback = self::$routes[$method][$path];
            if (is_array($callback)) {
                $controller = new $callback[0]();
                return call_user_func([$controller, $callback[1]]);
            }
            return call_user_func($callback);
        }
        
        // Check for parameterized routes
        foreach (self::$routes[$method] ?? [] as $route => $callback) {
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches); // Remove full match
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    return call_user_func_array([$controller, $callback[1]], $matches);
                }
                return call_user_func_array($callback, $matches);
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }
}

// API Routes
Router::get('/api/tasks', [TaskController::class, 'index']);
Router::get('/api/tasks/{id}', [TaskController::class, 'show']);
Router::post('/api/tasks', [TaskController::class, 'store']);
Router::put('/api/tasks/{id}', [TaskController::class, 'update']);
Router::delete('/api/tasks/{id}', [TaskController::class, 'destroy']);

// Swagger documentation routes
Router::get('/api/documentation', function() {
    include __DIR__ . '/../public/swagger-ui.html';
});

Router::get('/api/swagger.json', function() {
    header('Content-Type: application/json');
    echo file_get_contents(__DIR__ . '/../public/swagger.json');
});

// Default route
Router::get('/', function() {
    echo response([
        'message' => 'Practice Laravel Backend API',
        'version' => '1.0.0',
        'endpoints' => [
            'GET /api/tasks' => 'Get all tasks',
            'GET /api/tasks/{id}' => 'Get specific task',
            'POST /api/tasks' => 'Create new task',
            'PUT /api/tasks/{id}' => 'Update task',
            'DELETE /api/tasks/{id}' => 'Delete task',
            'GET /api/documentation' => 'Swagger UI documentation'
        ]
    ]);
});

// Dispatch the request
Router::dispatch();