<?php

declare(strict_types=1);

namespace RaceTracker\Service;

/**
 * Sorter class
 */
class Sorter
{
    /**
     * sort race array by runners finish time
     *
     * @param array $race
     * @return array
     */
    public function sortResultsByPlacement(array $race): array {
        $finishTimes = [];

        foreach ($race as $runner) {
            if ($runner[2]) {
                $runnerTime = strtotime($runner[2]);
                $finishTimes[] = $runnerTime;
            } elseif ($runner['race_time']) {
                $runnerTime = strtotime($runner['race_time']);
                $finishTimes[] = $runnerTime;
            }
        }

        array_multisort($finishTimes, $race);

        if (!$race[0]['placement']) {
            foreach ($race as $key => $runner) {
                array_push($race[$key], $key + 1);
            }
        }

        return $race;
    }

    /**
     * separate given race into an array of results by distance value
     *
     * @param array $race
     * @return array
     */
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