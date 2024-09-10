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

    $_SESSION["auth"] = $informations;

    header("Location: ../views/dashboard.php");
    die();
}

header("Location: ../../public/index.php?error=1&message=Usuário ou senha inválido");
die();