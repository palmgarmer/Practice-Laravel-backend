<?php

namespace App\Http\Controllers;

use App\Models\Task;

/**
 * @OA\Info(
 *     title="Practice Laravel Backend API",
 *     version="1.0.0",
 *     description="A simple CRUD API for task management with MVC structure",
 *     @OA\Contact(
 *         email="developer@example.com"
 *     )
 * )
 */
class TaskController
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Get all tasks",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="List of tasks",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Task")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $tasks = Task::all();
            echo response($tasks);
        } catch (Exception $e) {
            echo response(['error' => 'Failed to fetch tasks'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Get a specific task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task details",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $task = Task::find($id);
            
            if (!$task) {
                echo response(['error' => 'Task not found'], 404);
                return;
            }
            
            echo response($task);
        } catch (Exception $e) {
            echo response(['error' => 'Failed to fetch task'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Create a new task",
     *     tags={"Tasks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="New task"),
     *             @OA\Property(property="description", type="string", example="Task description"),
     *             @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function store()
    {
        try {
            $data = request()->json();
            
            // Validate input
            $errors = Task::validate($data);
            if (!empty($errors)) {
                echo response(['errors' => $errors], 400);
                return;
            }
            
            $task = Task::create($data);
            echo response($task, 201);
        } catch (Exception $e) {
            echo response(['error' => 'Failed to create task'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Update a task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated task"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, example="completed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Task")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function update($id)
    {
        try {
            $task = Task::find($id);
            
            if (!$task) {
                echo response(['error' => 'Task not found'], 404);
                return;
            }
            
            $data = request()->json();
            
            // Validate input
            $errors = Task::validate($data, true);
            if (!empty($errors)) {
                echo response(['errors' => $errors], 400);
                return;
            }
            
            $updatedTask = Task::update($id, $data);
            echo response($updatedTask);
        } catch (Exception $e) {
            echo response(['error' => 'Failed to update task'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Delete a task",
     *     tags={"Tasks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $task = Task::find($id);
            
            if (!$task) {
                echo response(['error' => 'Task not found'], 404);
                return;
            }
            
            Task::delete($id);
            echo response(['message' => 'Task deleted successfully']);
        } catch (Exception $e) {
            echo response(['error' => 'Failed to delete task'], 500);
        }
    }
}