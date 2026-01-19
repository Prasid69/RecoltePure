<?php
/**
 * Simple .env file loader
 * Loads environment variables from .env file into $_ENV and getenv()
 */

function loadEnvironmentVariables($envFilePath) {
    if (!file_exists($envFilePath)) {
        throw new Exception(".env file not found at: " . $envFilePath);
    }
    
    $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        // Skip invalid lines
        if (strpos($line, '=') === false) {
            continue;
        }
        
        // Parse key=value
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        // Remove quotes from value
        $value = trim($value, '"\'');
        
        // Set environment variable
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
    
    return true;
}

// Load .env file from project root
try {
    loadEnvironmentVariables(__DIR__ . '/../.env');
} catch (Exception $e) {
    die("Environment Error: " . $e->getMessage());
}
?>
