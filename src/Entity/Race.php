<?php

/**
 * Race class
 * 
 * @property string $raceName
 * @property string $date
 */
class Race
{
    private string $raceName;
    private string $date;
    private array $mediumDistanceRace;
    private array $longDistanceRace;

    public function __construct(string $raceName, string $date)
    {
        $this->raceName = $raceName;
        $this->date = $date;
        $this->mediumDistanceRace = [];
        $this->longDistanceRace = [];
    }

    public function getRaceName(): string
    {
        return $this->raceName;
    }

    public function getRaceDate(): string
    {
        return $this->date;
    }

    public function getMediumDistanceRace(): array
    {
        return $this->mediumDistanceRace;
    }

    public function getLongDistanceRace(): array
    {
        return $this->longDistanceRace;
    }

    private function setMediumDistanceRace(array $raceData): void
    {
        $this->mediumDistanceRace[] = $raceData;
    }

    private function setLongDistanceRace(array $raceData): void
    {
        $this->longDistanceRace[] = $raceData;
    }

    /**
     * get average finish time for a given race
     *
     * @param array $race
     * @return string
     */
    public function getAvgFinishTime(array $race): string
    {
        $raceTimes = [];

        foreach ($race as $runner) {
            $raceTimes[] = strtotime($runner[2]);
        }

        $averageTime = array_sum($raceTimes) / count($raceTimes);

        return date('h:i:s', $averageTime);
    }

    /**
     * parse csv file and generate an array for different race type
     *
     * @param string $uploadedCsvFile
     * @return void
     */
    public function processRaceResults(string $uploadedCsvFile): void {
        $csvFile = fopen($uploadedCsvFile, 'r');

        while (!feof($csvFile)) {
            $row = fgetcsv($csvFile);
            
            foreach ($row as $field) {
                $field = htmlspecialchars($field);
                // Remove any invalid or hidden characters
                $field = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $field);
                
                if ($field === 'medium') {
                    $this->setMediumDistanceRace($row);
                } elseif ($field === 'long') {
                    $this->setLongDistanceRace($row);
                }
            }
        }

        fclose($csvFile);
    }

    /**
     * sort race array by runners finish time
     *
     * @param array $race
     * @return array
     */
    public function sortRunnersByPlacement(array $race): array {
        $finishTimes = [];

        foreach ($race as $runner) {
            $runnerTime = strtotime($runner[2]);
            $finishTimes[] = $runnerTime;
        }

        array_multisort($finishTimes, $race);

        return $race;
    }
}