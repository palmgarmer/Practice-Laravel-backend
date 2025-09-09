<?php

/**
 * Laravel Practice Backend Entry Point
 * 
 * This file serves as the main entry point for our Laravel-like
 * backend application with CRUD operations, MVC structure, and Swagger UI.
 */

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the routes and bootstrap
require_once __DIR__ . '/../routes/api.php';