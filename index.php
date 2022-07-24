<?php 
    require_once realpath('vendor/autoload.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/form.css">
    <link rel="stylesheet" href="public/css/results.css">
    <script src="public/js/validate.js" defer></script>
    <title>Race tracker</title>
</head>
<body>
    <?php 
        require_once __DIR__ . '/src/Routes/Routes.php';
    ?>
</body>
</html>