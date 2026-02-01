<?php

/**
 * ICLABS - Laboratory Information System
 * Front Controller
 */

// 1. SET TIMEZONE WITA (MAKASSAR)
date_default_timezone_set('Asia/Makassar');

// Start session
session_start();

// Define constants
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('BASE_URL', 'http://localhost/iclabs/public');

// Autoload
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/config/constants.php';
require_once APP_PATH . '/config/database.php';
require_once APP_PATH . '/helpers/functions.php';
require_once __DIR__ . '/../vendor/autoload.php';

// Initialize Router
$router = new Router();

// Define routes
require_once APP_PATH . '/config/routes.php';

// Run router
$router->dispatch();
