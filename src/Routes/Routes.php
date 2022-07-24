<?php
session_start();

use RaceTracker\Controller\EditController;
use RaceTracker\Controller\ImportController;
use RaceTracker\Model\Route;
use RaceTracker\Controller\RaceController;

Route::set('index.php', function() {
    $importController = new ImportController();
    session_reset();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit-import']) { 
        $importController->handleFormSubmit();
    } else {
        $importController->displayImportForm([]);
    }

});

Route::set('display-results', function() {
    $controller = new RaceController;

    $controller->displayRace($_SESSION['race_id']);
});

Route::set('edit-result', function() {
    $controller = new EditController;

    if ($_POST['result-edit-submit']) {
        $controller->handleEditFormSubmit($_POST);
    } else {
        $controller->handleEditRequest($_POST['id']);
    }
});