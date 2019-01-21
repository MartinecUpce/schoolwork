<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'Rando');
define('DB_PASSWORD', 'rando');
define('DB_NAME', 'vem_database');
define('BASE_URL', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
define('CURRENT_URL', $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']);
