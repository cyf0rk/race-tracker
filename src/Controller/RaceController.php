<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Controller\RaceControllerInterface;
use RaceTracker\Model\Race;
use RaceTracker\Service\Calculator;
use RaceTracker\Service\Sorter;
use RaceTracker\View\RaceView;

/**
 * RaceController class
 */
class RaceController extends Race implements RaceControllerInterface
{
    /**
     * display race by given id
     *
     * @param integer $raceId
     * @return void
     */
    public function displayRace(int $raceId): void
    {
        $race = $this->getRaceInfo($raceId);
        $results = $this->getResults($raceId);
        $results = Calculator::calculatePlacements($results);
        $raceAvgTimes = $this->getAvgFinishTimes($results);
        $race = Sorter::createAssociativeRaceArray($race, $results, 'results');

        $raceView = new RaceView($race, $raceAvgTimes);
        $raceView->showRace();
    }
}