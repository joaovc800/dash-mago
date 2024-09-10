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
                            <img class="image py-2 is-16by9" src="./src/assets/images/roleta-brasileira-playtech.jpg">
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
                                <label for="password" class="label">Password</label>
                                <div class="control has-icons-left">
                                    <input name="password" id="password" type="password" placeholder="**********" class="input" required>
                                    <span class="icon is-small is-left">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="field">
                                <button type="submit" class="button is-success">
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