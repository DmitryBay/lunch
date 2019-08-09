<?php

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = null)
{
    $value = getenv($key) ?? $_ENV[$key] ?? $_SERVER[$key];
    if ($value === false) {
        return $default;
    }
    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
    }
    return $value;
}

/**
 * Load application environment from .env file (only on dev env)
 */
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();
}

/**
 * Init application constants
 */
defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV', 'prod'));