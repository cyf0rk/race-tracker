<?php
session_start();

use RaceTracker\Controller\ImportController;
use RaceTracker\Model\Route;
use RaceTracker\Controller\RaceController;
use RaceTracker\Service\Validation;

Route::set('index.php', function() {
    $importController = new ImportController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
        $importController->handleFormValidation();
    } else {
        $importController->displayImportForm([]);
    }

});

Route::set('display-results', function() {
    $controller = new RaceController;

    if (isset($_POST['result-edit-submit'])) {
        $controller->handleResultEdit($_POST, $_POST['result-id']);
    } else {
        $controller->handleSubmit($_SESSION['POST'], $_SESSION['POST']['csv-file']);
    }
});

Route::set('edit-result', function() {
    $controller = new RaceController;
    $controller->handleEditRequest($_POST['result-id']);
});