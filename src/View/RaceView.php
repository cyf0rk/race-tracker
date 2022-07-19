<?php

declare(strict_types=1);

namespace RaceTracker\View;

use RaceTracker\Controller\RaceController;
use RaceTracker\Service\Calculator;

/**
 * RaceView class
 */
class RaceView extends RaceController
{
    public function showRace($raceName)
    {
        $results = $this->getRace($raceName);
        echo 'Race name: ' . $results[0]['race_name'];
        echo '<br/>';
        echo 'Race date: ' . $results[0]['race_date'];
    }

    public function saveRaceData($post): void
    {
        $raceName = $this->sanitizeInput($post['race-name']);
        $raceDate = $this->sanitizeInput($post['date']);
        $this->saveRace($raceName, $raceDate);
    }
    
    protected function sanitizeInput($input)
    {
        $filterOptions = array('options'=>array('regexp'=>'/^[a-zA-Z0-9 -]*$/'));
        $sanitizedInput = htmlspecialchars($input);
        // $sanitizedInput = filter_var($sanitizedInput, FILTER_VALIDATE_REGEXP, $filterOptions);

        // Remove any invalid or hidden characters
        // $sanitizedInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $sanitizedInput);

        return $sanitizedInput;
    }

    public function saveResultsData($csvFile): void
    {
        $results = [];
        $csvFile = fopen($csvFile, 'r');

        while (!feof($csvFile)) {
            $row = fgetcsv($csvFile);
            $line = [];
            
            foreach ($row as $field) {
                $field = $this->sanitizeInput($field);
                $line[] = $field;
            }

            $results[] = $line;
        }

        fclose($csvFile);

        $results = $this->sortResults($results);
        unset($results[0]);
        unset($results[1]);

        $this->saveResults($results);
    }

    public function sortResults(array $results): array
    {
        $sorter = new Calculator();

        $results = $sorter->sortResultsByPlacement($results);

        return $results;
    }
}