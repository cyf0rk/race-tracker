<?php

declare(strict_types=1);

namespace RaceTracker\Service;

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

    /**
     * sort race array by runners finish time
     *
     * @param array $race
     * @return array
     */
    public function sortResultsByPlacement(array $race): array {
        $finishTimes = [];

        foreach ($race as $runner) {
            $runnerTime = strtotime($runner[2]);
            $finishTimes[] = $runnerTime;
        }

        array_multisort($finishTimes, $race);

        foreach ($race as $key => $runner) {
            array_push($race[$key], $key + 1);
        }

        return $race;
    }

    public function separateResultsByDistance(array $race): array
    {
        $resultsByDistance = [
            'medium_distance' => [],
            'long_distance' => []
        ];

        foreach ($race as $result) {
            if ($result[1] === 'medium' || $result['distance'] === 'medium') {
                array_push($resultsByDistance['medium_distance'], $result);
            } elseif ($result[1] === 'long' || $result['distance'] === 'long') {
                array_push($resultsByDistance['long_distance'], $result);
            }
        }

        return $resultsByDistance;
    }
}