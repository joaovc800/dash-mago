<?php
require_once realpath(dirname(__DIR__, 1) . '/core/Hash.php');

/* $a = Hash::encrypt(json_encode([
    'email' => 'teste@teste.com',
    'password' => md5(123),
    'id' => 1,
    'ip' => $_SERVER['REMOTE_ADDR'],
    'timestamp' => time() + (1 * 60)
]));


echo urlencode($a);
exit(); */

if (!isset($_GET['token']) || empty($_GET['token'])) {

    $arguments = http_build_query([
        'message' => 'Token inválido ou não informado',
        'statuscode' => 401,
        'statustext' => 'Unauthorized'
    ]);

    header("Location: ./error.php?$arguments");
    die();
}

$json = json_decode(Hash::decrypt($_GET['token']), true);

$exp = $json['timestamp'];
$current = time();

if ($json['ip'] != $_SERVER['REMOTE_ADDR']) {
    $arguments = http_build_query([
        'message' => 'Identificamos que a troca de senha não foi solicitada por você',
        'statuscode' => 401,
        'statustext' => 'Unauthorized'
    ]);

    header("Location: ./error.php?$arguments");
    die();
}

if($current > $exp){
    $arguments = http_build_query([
        'message' => 'Token expirado, por favor solicite um novo resete de senha',
        'statuscode' => 401,
        'statustext' => 'Unauthorized'
    ]);

    header("Location: ./error.php?$arguments");
    die();
}

?>
<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../public/src/assets/css/styles.css">
</head>

<body>
    <div class="container is-max-tablet p-5">
        <section class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column">
                            <form id="form-reset-password" class="box is-flex is-flex-direction-column is-gap-3">
                                <div class="is-flex is-flex-direction-column is-justify-content-center has-text-centered is-gap-1">
                                    <i class="fa-solid fa-lock is-size-2 has-text-light"></i>
                                    <h1 class="title">Reset de senha</h1>
                                </div>
                                <div class="field">
                                    <label for="password" class="label is-clickable">Nova senha</label>
                                    <div class="control">
                                        <input name="password" id="password" type="password" placeholder="Digite sua nova senha" class="input" required>
                                    </div>
                                    <p class="help">Digite sua nova senha</p>
                                </div>
                                <div class="field">
                                    <button type="submit" class="button is-fullwidth has-background-green-medium py-2">
                                        Trocar senha
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="./assets/js/notify.js"></script>
    <script type="module" src="./assets/js/newpassword.js"></script>
</body>
</html>