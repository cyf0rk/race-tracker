<?php

declare(strict_types=1);

namespace RaceTracker\Model;

use RaceTracker\Model\Result;

/**
 * Race class
 * 
 * @property int $id race_id for relation between race and results
 */
class Race extends Result
{
    /**
     * race_id for relation between race and results
     *
     * @var integer
     */
    protected int $id;

    /**
     * get race_id
     *
     * @return integer
     */
    protected function getRaceId(): int
    {
        return $this->id;
    }

    /**
     * fetch data about a race with a specific id from database
     *
     * @return array
     */
    protected function getRace(): array
    {
        $raceId = $this->getRaceId();
        $sql = "SELECT * FROM race WHERE id = ?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$raceId]);

        $results = $statement->fetchAll();
        return $results;
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
        $id = rand(100, 100000);
        $this->id = $id;
    }

    /**
     * generate id for a race and insert new data about a race into database
     *
     * @param string $raceName
     * @param string $raceDate
     * @return void
     */
    protected function setRace(string $raceName, string $raceDate): void
    {
        $this->setRaceId();
        $raceId = $this->getRaceId();
        $sql = "INSERT INTO race(id, race_name, race_date) VALUES (?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$raceId, $raceName, $raceDate]);
    }

    /**
     * loop through race and use method from Result class to insert each result into database
     *
     * @param array $race
     * @return void
     */
    protected function setResults(array $race): void
    {
        foreach ($race as $result) {
            $fullName = $result[0];
            $raceTime = $result[2];
            $distance = $result[1];
            $placement = $result[3];
            $raceId = $this->getRaceId();
            $this->setResult($fullName, $raceTime, $distance, $placement, $raceId);
        }
    }
}