<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Service\Validation;
use RaceTracker\View\ImportView;

/**
 * ImportController class
 */
class ImportController
{
    /**
     * validate import form
     *
     * @return void
     */
    public function handleFormValidation(): void
    {
        $request = Validation::validateImportForm($_POST, $_FILES['csv-file']);

        if (!empty($request['errors'])) {
            $this->displayImportForm($request['errors']);
        } else {
            $displayResults = getenv('APP_ROOT_PATH').'/display-results';
            $_SESSION['POST'] = $request['fields'];
            header("location: ${displayResults}");
            exit;
        }
    }

    /**
     * display import form and show errors if any field is invalid
     *
     * @param array $errors
     * @return void
     */
    public function displayImportForm(array $errors): void
    {
        $importView = new ImportView($errors);

        $importView->showImportForm();
    }
}