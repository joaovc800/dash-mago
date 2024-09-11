<?php

require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Hash.php');

header('Content-Type: application/json');


$json = json_decode(file_get_contents('php://input'), true);

$result = DB::statement("SELECT * FROM magoautomation WHERE email_login = :username", [
    ":username" => $json['email'],
]);

if (count($result["fetch"]) == 0) {
    Response::fail([], 'Usuário não encontrado');
}

$token = Hash::encrypt(json_encode([
    'email' => $result["fetch"][0]['email_login'],
    'password' => $result["fetch"][0]['senha_login'],
    'id' => $result["fetch"][0]['id'],
    'ip' => $_SERVER['REMOTE_ADDR'],
    'timestamp' => time() + (1 * 60)
]));

$origin = $_SERVER['HTTP_ORIGIN'];
$uriExploded = explode('/', $_SERVER['REQUEST_URI']);
$uri = implode('/', array_slice($uriExploded, 0, 3));
$url = $origin . $uri . '/views/reset-password.php?token=' . urlencode($token);

Response::success(['url' => $url], 'Foi enviado um link de reset para seu e-mail');