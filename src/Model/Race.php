<?php

declare(strict_types=1);

namespace RaceTracker\Model;

use RaceTracker\Model\Result;
use RaceTracker\Service\Calculator;
use RaceTracker\Service\Sorter;

/**
 * Race class
 * 
 * @property int $id race_id for relation between race and results
 * @property string $raceName
 * @property string $raceDate
 */
class Race extends Result
{
    private int $id;

    private string $raceName;

    private string $raceDate;

    /**
     * get race id
     *
     * @return integer
     */
    protected function getRaceId(): int
    {
        return $this->id;
    }

    /**
     * get race info
     *
     * @return array
     */
    protected function getRaceInfo(): array
    {
        $raceInfo = [
            'id' => $this->id,
            'race_name' => $this->raceName,
            'race_date' => $this->raceDate
        ];

        return $raceInfo;
    }

    /**
     * fetch race results data from database
     *
     * @return array
     */
    protected function getResults(): array
    {
        $raceId = $this->getRaceId();
        $sql = "SELECT * FROM results WHERE race_id = ?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$raceId]);

        $results = $statement->fetchAll();
        return $results;
    }

    /**
     * generate id for a race
     *
     * @return void
     */
    protected function setRaceId(): void
    {
        $id = rand(100, 10000000);
        $this->id = $id;
    }

    /**
     * generate race id and set race info data
     *
     * @param string $raceName
     * @param string $raceDate
     * @return void
     */
    protected function setRaceInfo(string $raceName, string $raceDate): void
    {
        $this->setRaceId();
        $this->raceName = $raceName;
        $this->raceDate = $raceDate;
    }

    /**
     * set info data for a race and insert new data about a race into database
     *
     * @param string $raceName
     * @param string $raceDate
     * @return void
     */
    protected function setRace(string $raceName, string $raceDate): void
    {
        $this->setRaceInfo($raceName, $raceDate);
        $raceId = $this->getRaceId();
        $sql = "INSERT INTO race(id, race_name, race_date) VALUES (?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$raceId, $raceName, $raceDate]);
    }

    /**
     * loop through race results and use method from Result entity to insert each result into database
     *
     * @param array $results
     * @return void
     */
    protected function setResults(array $results): void
    {
        foreach ($results as $result) {
            $fullName = $result[0];
            $raceTime = $result[2];
            $distance = $result[1];
            $placement = $result[3];
            $raceId = $this->getRaceId();
            $this->setResult($fullName, $raceTime, $distance, $placement, $raceId);
        }
    }

    /**
     * process csv file and return results array
     *
     * @param [type] $csvFile
     * @return array
     */
    public function processCsvFile(string $file): array
    {
        $results = [];
        $csvFile = fopen($file, 'r');

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

        return $results;
    }

    /**
     *  sort results by placement
     *
     * @param array $race
     * @return array
     */
    protected function sortResultsByPlacement(array $race): array
    {
        $sorter = new Sorter();
        $race = $sorter->separateResultsByDistance($race);
        $mediumDistanceResults = $sorter->sortResultsByPlacement($race['medium_distance']);
        $longDistanceResults = $sorter->sortResultsByPlacement($race['long_distance']);
        $race = array_merge($mediumDistanceResults, $longDistanceResults);

        return $race;
    }

    /**
     * create an array of average race finish times depending on race distance type
     *
     * @param array $race
     * @return array
     */
    protected function getAvgFinishTimes(array $race): array
    {
        $sorter = new Sorter();
        $calculator = new Calculator();

        $race = $sorter->separateResultsByDistance($race);
        $mediumDistanceAvgFinishTime = $calculator->calculateAvgFinishTime($race['medium_distance']);
        $longDistanceAvgFinishTime = $calculator->calculateAvgFinishTime($race['long_distance']);

        $avgFinishTimes = [
            'medium_distance_avg_finish_time' => $mediumDistanceAvgFinishTime,
            'long_distance_avg_finish_time' => $longDistanceAvgFinishTime
        ];

        return $avgFinishTimes;
    }

    /**
     * sanitize given string
     *
     * @param string $input
     * @return string
     */
    protected function sanitizeInput(string $input): string
    {
        $filterOptions = array('options'=>array('regexp'=>'/^[a-zA-Z0-9 :-]*$/'));
        $sanitizedInput = htmlspecialchars($input);
        $sanitizedInput = filter_var($sanitizedInput, FILTER_VALIDATE_REGEXP, $filterOptions);

        // Remove any invalid or hidden characters
        $sanitizedInput = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $sanitizedInput);

        return $sanitizedInput;
    }
}