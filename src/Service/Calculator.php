<?php

namespace RaceTracker\Service;

class Calculator
{
    /**
     * get average finish time for a given race
     *
     * @param array $race
     * @return string
     */
    public function getAvgFinishTime(array $race): string
    {
        $raceTimes = [];

        foreach ($race as $runner) {
            $raceTimes[] = strtotime($runner[2]);
        }

        $averageTime = array_sum($raceTimes) / count($raceTimes);

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
            array_push($race[$key], $key - 1);
        }

        return $race;
    }

}