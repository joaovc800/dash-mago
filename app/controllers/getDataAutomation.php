<?php
require_once realpath(dirname(__DIR__, 1) . '/models/User.php');
require_once realpath(dirname(__DIR__, 1) . '/core/Response.php');

header('Content-Type: application/json');

$json = json_decode(file_get_contents('php://input'), true);

$result = DB::statement("SELECT * FROM magoautomation where email_login = {$json['email']}");

if($result['statement']){

    $user = new User([
        "email" => $result['fetch'][0]['email_login'],
        "passwordhash" => $result['fetch'][0]['senha_login']
    ]);

    $informations = $user->getDetails();

    if(!$informations['signature']){
        Response::fail([], 'Parece que sua assinatura não está ativa, renove para continuar usando os benefícios');
    }

    $maturity = new DateTime(datetime: $informations['maturity']);
    $current = new DateTime(date('Y-m-d')); 

    if($current > $maturity){
        Response::fail([], 'Parece que sua assinatura não está ativa, renove para continuar usando os benefícios');
    }

    Response::success($informations, 'Dados retornados com sucesso');
}

Response::fail([], 'Ocorreu um erro interno, por favor entre em contato com o administrador');