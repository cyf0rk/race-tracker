<?php

declare(strict_types=1);

namespace RaceTracker\Service;

/**
 * Calculator class
 */
class Calculator
{
    /**
     * get average finish time for a given race
     *
     * @param array $race
     * @return string
     */
    public function calculateAvgFinishTime(array $race): string
    {
        $raceTimes = [];

        foreach ($race as $runner) {
            $raceTimes[] = strtotime($runner['race_time']);
        }

        $averageTime = intval(array_sum($raceTimes) / count($raceTimes));

        return date('h:i:s', $averageTime);
    }
}