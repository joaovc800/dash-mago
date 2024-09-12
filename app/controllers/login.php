<?php
session_start();
require_once realpath(dirname(__DIR__, 1) . '/core/DB.php');
require_once realpath(dirname(__DIR__, 1) . '/models/User.php');

$user = new User([
    "email" => $_POST['username'],
    "password" => $_POST['password']
]);

$informations = $user->getUser();


if(!isset($informations['erro'])){

    if(!$informations['signature']){
        header("Location: ../../public/index.php?error=1&message=Sua assinatura não está mais ativa.");
        die();
    }

    $maturity = new DateTime($informations['maturity']);
    $current = new DateTime(date('Y-m-d')); 

    if($current > $maturity){
        header("Location: ../../public/index.php?error=1&message=Sua assinatura passou do vencimento.");
        die();
    }

    $_SESSION["auth"] = $informations;

    header("Location: ../views/dashboard.php");
    die();
}

header("Location: ../../public/index.php?error=1&message=Usuário ou senha inválido.");
die();