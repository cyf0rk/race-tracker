<?php

declare(strict_types=1);

namespace RaceTracker\Model;

use RaceTracker\Service\Dbh;

/**
 * Result class
 * 
 * @property int $id
 * @property string $fullName
 * @property string $raceTime
 * @property string $distance
 * @property int $placement
 * @property int $raceId
 */
class Result extends Dbh
{

    private int $id;

    private string $fullName;

    private string $raceTime;

    private string $distance;
    
    private int $placement;

    private int $raceId;

    protected function getResult(): array
    {
        $result = [
            'id' => $this->id,
            'full_name' => $this->fullName,
            'race_time' => $this->raceTime,
            'distance' => $this->distance,
            'placement' => $this->placement,
            'race_id' => $this->raceId
        ];

        return $result;
    }

    /**
     * generate id for a result
     *
     * @return void
     */
    protected function setResultId(): void
    {
        $id = rand(100, 10000000);
        $this->id = $id;
    }

    /**
     * insert result into database
     *
     * @param string $fullName
     * @param string $raceTime
     * @param string $distance
     * @param integer $placement
     * @param integer $raceId
     * @return void
     */
    protected function setResult(string $fullName, string $raceTime, string $distance, int $placement, int $raceId): void
    {
        $this->setResultId();
        $this->fullName = $fullName;
        $this->raceTime = $raceTime;
        $this->distance = $distance;
        $this->placement = $placement;
        $this->raceId = $raceId;

        $sql = "INSERT INTO results(id, full_name, race_time, distance, placement, race_id) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$this->id, $fullName, $raceTime, $distance, $placement, $raceId]);
    }
}