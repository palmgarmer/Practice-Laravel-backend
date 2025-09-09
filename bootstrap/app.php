<?php

require_once __DIR__ . '/../vendor/autoload/autoload.php';

// Simple database configuration
class DB {
    private static $connection = null;
    
    public static function connection() {
        if (self::$connection === null) {
            // Use a file-based SQLite database for persistence
            $dbPath = __DIR__ . '/../storage/database.sqlite';
            
            // Ensure storage directory exists
            $storageDir = dirname($dbPath);
            if (!is_dir($storageDir)) {
                mkdir($storageDir, 0755, true);
            }
            
            self::$connection = new PDO('sqlite:' . $dbPath);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create tasks table for our CRUD demo
            self::$connection->exec('
                CREATE TABLE IF NOT EXISTS tasks (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    title VARCHAR(255) NOT NULL,
                    description TEXT,
                    status VARCHAR(50) DEFAULT "pending",
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )
            ');
        }
        return self::$connection;
    }
    
    public static function table($tableName) {
        return new class($tableName) {
            private $table;
            private $connection;
            
            public function __construct($table) {
                $this->table = $table;
                $this->connection = DB::connection();
            }
            
            public function get() {
                $stmt = $this->connection->query("SELECT * FROM {$this->table}");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            public function find($id) {
                $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = ?");
                $stmt->execute([$id]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            public function insert($data) {
                $columns = implode(',', array_keys($data));
                $placeholders = ':' . implode(', :', array_keys($data));
                
                $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
                $stmt->execute($data);
                
                return $this->connection->lastInsertId();
            }
            
            public function update($id, $data) {
                $set = '';
                foreach ($data as $key => $value) {
                    $set .= "$key = :$key, ";
                }
                $set = rtrim($set, ', ');
                
                $stmt = $this->connection->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
                $data['id'] = $id;
                return $stmt->execute($data);
            }
            
            public function delete($id) {
                $stmt = $this->connection->prepare("DELETE FROM {$this->table} WHERE id = ?");
                return $stmt->execute([$id]);
            }
        };
    }
}