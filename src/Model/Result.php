<?php

declare(strict_types=1);

namespace RaceTracker\Model;

use RaceTracker\Model\Dbh;

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

    /**
     * get result by id
     *
     * @param integer $id
     * @return array
     */
    protected function getResult(int $id): array
    {
        $sql = "SELECT * FROM results WHERE id = ?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$id]);

        $result = $statement->fetch();
        return $result;
    }

    /**
     * generate id for a result
     *
     * @return void
     */
    protected function setResultId(): void
    {
        $id = rand(100, 1000000000);
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
        $sql = "INSERT INTO results(id, full_name, race_time, distance, placement, race_id) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$this->id, $fullName, $raceTime, $distance, $placement, $raceId]);
    }

    /**
     * update result by given id
     *
     * @param integer $id
     * @param string $fullName
     * @param string $raceTime
     * @return void
     */
    protected function updateResult(int $id, string $fullName, string $raceTime, int $placement = null): void
    {
        if ($placement) {
            $sql = "UPDATE results SET full_name = ?, race_time = ?, placement = ? WHERE id = ?";
            $statement = $this->connect()->prepare($sql);
            $statement->execute([$fullName, $raceTime, $placement, $id]);
        } else {
            $sql = "UPDATE results SET full_name = ?, race_time = ? WHERE id = ?";
            $statement = $this->connect()->prepare($sql);
            $statement->execute([$fullName, $raceTime, $id]);
        }
    }
}