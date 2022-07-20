<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Model\Race;
use RaceTracker\Controller\RaceControllerInterface;
use RaceTracker\Service\Calculator;

class RaceController extends Race implements RaceControllerInterface
{
    protected $calculator;

    public function __construct()
    {
       $this->calculator = new Calculator();
    }

    public function fetchRace(): array
    {
        $race = $this->getRace();
        $results = $this->getResults();
        array_push($race[0], $results);

        return $race;
    }

    public function saveRace(string $raceName, string $date): void
    {
        $this->setRace($raceName, $date);
    }

    public function saveResults(array $results): void
    {
        $results = $this->sortResultsByPlacement($results);
        $this->setResults($results);
    }

    protected function sortResultsByPlacement($race): array
    {
        $race = $this->calculator->separateResultsByDistance($race);
        $mediumDistanceResults = $this->calculator->sortResultsByPlacement($race['medium_distance']);
        $longDistanceResults = $this->calculator->sortResultsByPlacement($race['long_distance']);
        $race = array_merge($mediumDistanceResults, $longDistanceResults);

        return $race;
    }
}