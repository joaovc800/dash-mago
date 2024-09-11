<?php
require_once realpath(dirname(__DIR__, 1) . '/models/User.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Hash.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$token = json_decode(Hash::decrypt($json['token']), true);

if (empty($token)) {
    Response::fail([], 'Token inválido ou não informado');
}

if ($token['ip'] != $_SERVER['REMOTE_ADDR']) {
    Response::fail([], 'Identificamos que a troca de senha não foi solicitada por você');
}

$exp = $token['timestamp'];
$current = time();

if($current > $exp){
    Response::fail([], 'Token expirado, por favor solicite um novo resete de senha');
}

$user = new User([
    "email" => $token['email'],
    "passwordhash" => $token['password']
]);

$update = $user->updatePassword($json['password'], $token['id']);

if($update['statement']){
    Response::success([], 'Senha atualizada com sucesso!');
}

Response::fail([], 'Houve um erro ao atualizar a senha, por favor tente novamente!');