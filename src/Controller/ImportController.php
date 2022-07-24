<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Model\Race;
use RaceTracker\Service\Validation;
use RaceTracker\View\ImportView;
use RaceTracker\Service\Calculator;

/**
 * ImportController class
 */
class ImportController extends Race implements ImportControllerInterface
{
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

    /**
     * handle client import form submission
     *
     * @return void
     */
    public function handleFormSubmit(): void
    {
        $request = Validation::validateImportForm($_POST, $_FILES['csv_file']);

        if (!empty($request['errors'])) {
            $this->displayImportForm($request['errors']);
        } else {
            $this->saveRace($request['fields']);
            $this->saveResults($request['fields']['csv_file']);
            $displayResults = getenv('APP_ROOT_PATH').'/display-results';
            $raceId = $this->getRaceId();
            $_SESSION['race_id'] = $raceId;
            header("location: ${displayResults}");
            exit;
        }
    }

    /**
     * save data about a race to database
     *
     * @param array $post
     * @return void
     */
    public function saveRace(array $post): void
    {
        $this->setRace($post['race_name'], $post['date']);
    }

    /**
     * save race results to database
     *
     * @param string $file
     * @return void
     */
    public function saveResults(string $file): void
    {
        $results = $this->processCsvFile($file);
        $results = Calculator::calculatePlacements($results);
        $this->setResults($results);
    }
}