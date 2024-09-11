<!DOCTYPE html>
<html lang="pt-br" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
    <link rel="stylesheet" href="../../public/src/assets/css/styles.css">
</head>

<body>
    <div class="container is-max-tablet p-5">

        <h1 class="title is-1">
            <?php echo "{$_GET['statuscode']} {$_GET['statustext']}"; ?>
        </h1>

        <p class="subtitle py-4">
            <?php echo $_GET['message']; ?>
        </p>
        
        <a href="../../public">Página inicial</a>
    </div>
</body>

</html>