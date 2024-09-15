<?php

require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Hash.php');
require_once realpath(dirname(__DIR__, 1) . '/service/MailService.php');

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
    'timestamp' => time() + (10 * 60)
]));

$origin = $_SERVER['HTTP_ORIGIN'];
$url = $origin . '/app/views/reset-password.php?token=' . urlencode($token);

$template = "
<div style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f7f7f7; color: #333;'>
    <div style='width: 80%; margin: auto; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center;'>
        <div style='background-color: #9f37fe; color: #ffffff; padding: 10px; border-radius: 8px 8px 0 0; font-size: 24px;'>
            Redefinição de Senha
        </div>
        <div style='padding: 20px;'>
            <p>Olá,</p>
            <p>Recebemos um pedido para redefinir sua senha. Clique no botão abaixo para redefinir sua senha:</p>
            <a href='$url' style='display: inline-block; padding: 15px 30px; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #599501; border: none; border-radius: 5px; text-decoration: none; margin: 20px 0;'>Redefinir Senha</a>
            <p>Se o botão acima não funcionar, copie e cole o seguinte link em seu navegador:</p>
            <p><a href='$url' style='color: #9f37fe; text-decoration: none; word-break: break-all;'>$url</a></p>
        </div>
        <div style='font-size: 14px; color: #777; padding: 10px;'>
            Se você não solicitou a redefinição de senha, ignore este e-mail. 
            <br>
            Se você tiver algum problema, entre em contato com nosso suporte.
        </div>
    </div>
</div>
";

MailService::send(
    $json['email'],
    '[Mago Roulette] Reset de senha ',
    $template
);

Response::success(['url' => $url], 'Foi enviado um link de reset para seu e-mail');