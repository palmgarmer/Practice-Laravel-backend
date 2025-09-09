<?php

namespace App\Models;

/**
 * Task Model
 * 
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     required={"title"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Complete project documentation"),
 *     @OA\Property(property="description", type="string", example="Write comprehensive API documentation using Swagger"),
 *     @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}, example="pending"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Task
{
    protected $table = 'tasks';
    protected $fillable = ['title', 'description', 'status'];
    
    public static function all()
    {
        return \DB::table('tasks')->get();
    }
    
    public static function find($id)
    {
        return \DB::table('tasks')->find($id);
    }
    
    public static function create($data)
    {
        // Add timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $id = \DB::table('tasks')->insert($data);
        return self::find($id);
    }
    
    public static function update($id, $data)
    {
        // Update timestamp
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $success = \DB::table('tasks')->update($id, $data);
        return $success ? self::find($id) : false;
    }
    
    public static function delete($id)
    {
        return \DB::table('tasks')->delete($id);
    }
    
    public static function validate($data, $isUpdate = false)
    {
        $errors = [];
        
        if (!$isUpdate && empty($data['title'])) {
            $errors[] = 'Title is required';
        }
        
        if (isset($data['title']) && strlen($data['title']) > 255) {
            $errors[] = 'Title must not exceed 255 characters';
        }
        
        if (isset($data['status']) && !in_array($data['status'], ['pending', 'in_progress', 'completed'])) {
            $errors[] = 'Status must be one of: pending, in_progress, completed';
        }
        
        return $errors;
    }
}