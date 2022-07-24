<?php

declare(strict_types=1);

namespace RaceTracker\Service;

use RaceTracker\Service\Sorter;

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
    public static function calculateAvgFinishTime(array $race): string
    {
        $raceTimes = [];

        foreach ($race as $runner) {
            $raceTimes[] = strtotime($runner['race_time']);
        }

        $averageTime = intval(array_sum($raceTimes) / count($raceTimes));

        return date('h:i:s', $averageTime);
    }

    /**
     * take results array and recalculate placements then return array in ascending order by result placement
     *
     * @param array $results
     * @return array
     */
    public static function calculatePlacements(array $results): array
    {
        $results = Sorter::separateResultsByDistance($results);
        $mediumDistanceResults = Sorter::sortResultsByPlacement($results['medium_distance']);
        $longDistanceResults = Sorter::sortResultsByPlacement($results['long_distance']);
        $results = array_merge($mediumDistanceResults, $longDistanceResults);

        return $results;
    }
}