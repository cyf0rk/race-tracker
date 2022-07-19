<?php

declare(strict_types=1);

namespace RaceTracker\Model;

use RaceTracker\Model\Result;

/**
 * Race class
 * 
 * @property string $raceName
 * @property string $date
 */
class Race extends Result
{
    protected int $id;

    protected function getRaceId(): int
    {
        return $this->id;
    }

    protected function setRaceId(): void
    {
        $id = rand(100, 100000);
        $this->id = $id;
    }

    protected function getRace(string $raceName): array
    {
        $sanitizedRaceName = mysqli_real_escape_string($this->mysqli(), $raceName);
        $sql = "SELECT * FROM race WHERE race_name = ?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$sanitizedRaceName]);

        $results = $statement->fetchAll();
        return $results;
    }

    protected function setRace(string $raceName, string $raceDate): void
    {
        $this->setRaceId();
        $raceId = $this->getRaceId();
        $sql = "INSERT INTO race(id, race_name, race_date) VALUES (?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$raceId, $raceName, $raceDate]);
    }

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
}