<?php
// global.php

// Set the response content type to JSON
header("Content-Type: application/json");

// Include the database configuration
require_once 'config/database.php';

// Start a session if not already started (for session-based auth, etc.)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set default timezone
date_default_timezone_set('UTC');

// You can include other global functions, constants, or autoloaders here.
