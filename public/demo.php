<?php

/**
 * API Demo - Shows all CRUD operations within a single session
 */

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../app/Http/Controllers/TaskController.php';
require_once __DIR__ . '/../app/Models/Task.php';

use App\Http\Controllers\TaskController;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$controller = new TaskController();

echo "API Demo - All CRUD Operations\n\n";

// 1. Create some tasks
echo "1. Creating tasks:\n";
$_SERVER['REQUEST_METHOD'] = 'POST';
file_put_contents('php://input', json_encode(['title' => 'Demo Task 1', 'description' => 'First demo task', 'status' => 'pending']));
echo "Created Task 1: ";
$controller->store();
echo "\n";

file_put_contents('php://input', json_encode(['title' => 'Demo Task 2', 'description' => 'Second demo task', 'status' => 'in_progress']));
echo "Created Task 2: ";
$controller->store();
echo "\n\n";

// 2. Get all tasks
echo "2. Getting all tasks:\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$controller->index();
echo "\n\n";

// 3. Get specific task
echo "3. Getting task #1:\n";
$controller->show(1);
echo "\n\n";

// 4. Update task
echo "4. Updating task #1:\n";
$_SERVER['REQUEST_METHOD'] = 'PUT';
file_put_contents('php://input', json_encode(['status' => 'completed', 'description' => 'Updated description']));
$controller->update(1);
echo "\n\n";

// 5. Delete task
echo "5. Deleting task #2:\n";
$_SERVER['REQUEST_METHOD'] = 'DELETE';
$controller->destroy(2);
echo "\n\n";

// 6. Final state
echo "6. Final state of all tasks:\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$controller->index();
echo "\n";