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
    public static function sortResultsByPlacement(array $race): array {
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

        foreach ($race as $key => $runner) {
            if ($runner['placement']) {
                $runner['placement'] = $key + 1;
                $race[$key] = $runner;
            } else {
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
    public static function separateResultsByDistance(array $race): array
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

    /**
     * create associative array
     *
     * @param array $targetArray
     * @param array $appendArray
     * @param string $arrayName
     * @return array
     */
    public static function createAssociativeRaceArray(array $targetArray, array $appendArray, string $arrayName): array
    {
        foreach ($appendArray as $column) {
            $targetArray[$arrayName][] = $column;
        }

        return $targetArray;
    }
}