<?php
    session_start();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Mago</title>
    <link rel="stylesheet" href="./src/assets/css/styles.css">

    <meta property="og:title" content="Dashboard de método de análise e leituras">
    <meta property="og:description" content="Explore nosso dashboard completo com roletas e métodos de análise avançados. Visualize dados, faça leituras e tome decisões informadas com nossa ferramenta poderosa.">
    <meta property="og:image" content="https://mago.iamonstro.com.br/public/src/assets/images/logo-main.jpg">
    <meta property="og:url" content="https://mago.iamonstro.com.br/public/">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Método de análise e leituras">
    <meta property="og:locale" content="pt_BR">
</head>

<body>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-5-tablet is-5-desktop is-5-widescreen">
                        <?php
                            if(isset($_GET["error"])):
                        ?>
                            <article class="message is-danger">
                                <div class="message-body">
                                    <?php echo $_GET["message"] ?>
                                </div>
                            </article>
                        <?php
                            endif;
                        ?>
                        <form method="post" action="../app/controllers/login.php" class="box">
                            <img class="image py-2 is-16by9" src="./src/assets/images/logo-main.jpg">
                            <div class="field">
                                <label for="username" class="label">Email</label>
                                <div class="control has-icons-left">
                                    <input name="username" id="username" type="email" placeholder="email@dominio.com" class="input" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <label for="password" class="label">Senha</label>
                                <div class="control has-icons-left">
                                    <input name="password" id="password" type="password" placeholder="**********" class="input" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <a href="./password-solicitation.php">Esqueci minha senha</a>
                            </div>
                            <div class="field">
                                <button type="submit" class="button is-fullwidth has-background-green-medium py-2">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>