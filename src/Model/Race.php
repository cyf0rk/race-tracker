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
     * @param int $id
     * @return array
     */
    protected function getRaceInfo(int $id): array
    {
        $sql = "SELECT * FROM race WHERE id = ?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$id]);

        $raceInfo['race_info'] = $statement->fetchAll()[0];
        return $raceInfo;
    }

    /**
     * fetch race results data from database
     *
     * @param int $raceId
     * @return array
     */
    protected function getResults(int $raceId): array
    {
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
        $id = rand(100, 1000000000);
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
     * loop through race results and use method from Result entity to update each result in database
     *
     * @param integer $raceId
     * @return void
     */
    protected function updateResults(int $raceId): void
    {
        $results = $this->getResults($raceId);
        $results = Calculator::calculatePlacements($results);

        foreach ($results as $result) {
            $id = $result['id'];
            $fullName = $result['full_name'];
            $raceTime = $result['race_time'];
            $placement = $result['placement'];
            $this->updateResult($id, $fullName, $raceTime, $placement);
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
        // delete temporary file after processing
        unlink($file);
        session_destroy();

        unset($results[0]);

        return $results;
    }

    /**
     * create an array of average race finish times depending on race distance type
     *
     * @param array $race
     * @return array
     */
    protected function getAvgFinishTimes(array $race): array
    {

        $race = Sorter::separateResultsByDistance($race);
        $mediumDistanceAvgFinishTime = Calculator::calculateAvgFinishTime($race['medium_distance']);
        $longDistanceAvgFinishTime = Calculator::calculateAvgFinishTime($race['long_distance']);

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
        $sanitizedInput = mysqli_real_escape_string($this->mysqli(), $sanitizedInput);

        return $sanitizedInput;
    }
}