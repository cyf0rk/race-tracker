<?php

use RaceTracker\Model\Route;
use RaceTracker\Controller\RaceController;

Route::set('index.php', function() {
    require_once 'templates/import_results.php';
});

Route::set('display-results', function() {
    $controller = new RaceController;

    if (isset($_POST['result-edit-submit'])) {
        $controller->handleResultEdit($_POST, $_POST['result-id']);
    } else {
        $controller->handleSubmit($_POST, $_FILES['csv-file']);
    }
});

Route::set('edit-result', function() {
    $controller = new RaceController;
    $controller->handleEditRequest($_POST['result-id']);
});