<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Model\Race;
use RaceTracker\Controller\RaceControllerInterface;
use RaceTracker\Service\Calculator;

/**
 * RaceController class
 * 
 * @property $calculator instance of Calculator service
 */
class RaceController extends Race implements RaceControllerInterface
{
    /**
     * instance of Calculator service
     */
    protected $calculator;

    public function __construct()
    {
       $this->calculator = new Calculator();
    }

    /**
     * fetch race and race data from database
     *
     * @return array
     */
    public function fetchRace(): array
    {
        $race = $this->getRace();
        $results = $this->getResults();
        array_push($race[0], $results);

        return $race;
    }

    /**
     * save data about a race to database
     *
     * @param string $raceName
     * @param string $date
     * @return void
     */
    public function saveRace(string $raceName, string $date): void
    {
        $this->setRace($raceName, $date);
    }

    /**
     * save race results to database
     *
     * @param array $results
     * @return void
     */
    public function saveResults(array $results): void
    {
        $results = $this->sortResultsByPlacement($results);
        $this->setResults($results);
    }

    /**
     *  sort results by placement
     *
     * @param array $race
     * @return array
     */
    protected function sortResultsByPlacement(array $race): array
    {
        $race = $this->calculator->separateResultsByDistance($race);
        $mediumDistanceResults = $this->calculator->sortResultsByPlacement($race['medium_distance']);
        $longDistanceResults = $this->calculator->sortResultsByPlacement($race['long_distance']);
        $race = array_merge($mediumDistanceResults, $longDistanceResults);

        return $race;
    }
}