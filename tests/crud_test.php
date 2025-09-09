<?php

/**
 * Simple test file to verify CRUD operations
 */

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../app/Models/Task.php';

use App\Models\Task;

echo "Testing CRUD Operations...\n\n";

// Test CREATE
echo "1. Testing CREATE:\n";
$newTask = Task::create([
    'title' => 'Test Task',
    'description' => 'This is a test task',
    'status' => 'pending'
]);
echo "Created task: " . json_encode($newTask) . "\n\n";

// Test READ ALL
echo "2. Testing READ ALL:\n";
$allTasks = Task::all();
echo "All tasks: " . json_encode($allTasks) . "\n\n";

// Test READ ONE
echo "3. Testing READ ONE:\n";
$task = Task::find(1);
echo "Task #1: " . json_encode($task) . "\n\n";

// Test UPDATE
echo "4. Testing UPDATE:\n";
$updatedTask = Task::update(1, [
    'status' => 'completed',
    'description' => 'Updated description'
]);
echo "Updated task: " . json_encode($updatedTask) . "\n\n";

// Test DELETE
echo "5. Testing DELETE:\n";
$deleted = Task::delete(1);
echo "Delete result: " . ($deleted ? 'Success' : 'Failed') . "\n\n";

// Verify deletion
echo "6. Verifying deletion:\n";
$allTasksAfterDelete = Task::all();
echo "Tasks after deletion: " . json_encode($allTasksAfterDelete) . "\n\n";

echo "CRUD tests completed!\n";