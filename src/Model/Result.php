<?php

declare(strict_types=1);

namespace RaceTracker\Model;

use RaceTracker\Service\Dbh;

/**
 * Result class
 * 
 * @property string $fullName
 * @property string $raceTime
 * @property string $distance
 */
class Result extends Dbh
{

    protected function getResult()
    {
    }

    public function setResult(string $fullName, string $raceTime, string $distance, int $placement, int $raceId): void
    {
        $sql = "INSERT INTO results(full_name, race_time, distance, placement, race_id) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$fullName, $raceTime, $distance, $placement, $raceId]);
    }
}