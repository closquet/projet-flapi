<?php
session_start();

if (!file_exists(DB_INI_FILE)){
    die(json_encode(['erreur' => $e->getMessage()], JSON_UNESCAPED_UNICODE));
}

$routes = include 'configs/routes.php';
$default_routes = $routes['default'];
$default_routes_parts = explode('/', $default_routes);

$method = $_SERVER['REQUEST_METHOD'];
$r = $_REQUEST['r'] ?? $default_routes_parts[1];
$a = $_REQUEST['a'] ?? $default_routes_parts[2];

if (!in_array($method . '/' . $r . '/' . $a, $routes)){
    die(json_encode(['erreur' => 'Action interdite !'], JSON_UNESCAPED_UNICODE));
}

$controller_name = 'Controllers\\' . ucfirst($r);
$controller = new $controller_name;

$data = call_user_func([$controller, $a]);
echo json_encode($data, JSON_UNESCAPED_UNICODE);