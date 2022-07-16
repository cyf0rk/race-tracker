<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/form.css">
    <title>Race tracker</title>
</head>
<body>
    <div class="race-tracker-wrapper">
        <h1>Track race results</h1>
        <?php require_once __DIR__.'/templates/import_results.php';?>
    </div>
</body>
</html>