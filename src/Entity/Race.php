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

    public function getMediumDistanceRaces(): array
    {
        return $this->mediumDistanceRace;
    }

    public function getLongDistanceRaces(): array
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
     * get average finish time for given race
     *
     * @param array $raceTimes
     * @return string
     */
    public function getAvgFinishTime(array $raceTimes): string
    {
        $unixTimes = [];

        foreach ($raceTimes as $time) {
            $unixTimes[] = strtotime($time);
        }

        $averageTime = array_sum($unixTimes) / count($unixTimes);

        return date('h:i:s', $averageTime);
    }

    /**
     * parse csv file and generate an array for different type of race
     *
     * @param string $uploadedCsvFile
     * @return void
     */
    public function processRaceResults(string $uploadedCsvFile): void {
        $csvFile = fopen($uploadedCsvFile, 'r');

        while (!feof($csvFile)) {
            $row = fgetcsv($csvFile);
            
            foreach ($row as $field) {
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
}