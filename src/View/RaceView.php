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
    public function showRace(): void
    {
        $template = __DIR__.'/../../app/templates/results.php';
        $race = $this->fetchRace();
        $results = $this->calculator->separateResultsByDistance($race[0]['0']);
        $mediumDistanceAvgTime = $this->calculator->calculateAvgFinishTime($results['medium_distance']);
        $longDistanceAvgTime = $this->calculator->calculateAvgFinishTime($results['long_distance']);

        if (file_exists($template)) {
            require $template;
        }
    }

    public function saveRaceData(array $post): void
    {
        $raceName = $this->sanitizeInput($post['race-name']);
        $raceDate = $this->sanitizeInput($post['date']);
        $this->saveRace($raceName, $raceDate);
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

            if ($line) {
                $results[] = $line;
            }
        }

        fclose($csvFile);

        unset($results[0]);

        $this->saveResults($results);
    }

    protected function sanitizeInput(string $input)
    {
        $filterOptions = array('options'=>array('regexp'=>'/^[a-zA-Z0-9 :-]*$/'));
        $sanitizedInput = htmlspecialchars($input);
        $sanitizedInput = filter_var($sanitizedInput, FILTER_VALIDATE_REGEXP, $filterOptions);

        // Remove any invalid or hidden characters
        $sanitizedInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $sanitizedInput);

        return $sanitizedInput;
    }
}