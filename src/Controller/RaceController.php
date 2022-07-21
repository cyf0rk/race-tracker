<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Controller\RaceControllerInterface;
use RaceTracker\Model\Race;
use RaceTracker\Service\Sorter;
use RaceTracker\View\RaceView;

/**
 * RaceController class
 */
class RaceController extends Race implements RaceControllerInterface
{
    /**
     * handle client form submit
     *
     * @param array $post
     * @param array $file
     * @return void
     */
    public function handleSubmit(array $post, array $file): void
    {
        $csvFileType = pathinfo($file['name'], PATHINFO_EXTENSION);
    
        if ($csvFileType != "csv") {
            echo '<p style="color: red;">uploaded file is not a valid csv file</p>';
        } else {
            $this->saveRace($post);
            $this->saveResults($file['tmp_name']);
            $this->displayRace();
            exit;
        }
    }

    /**
     * get race info, data and average finish times and display it in a view
     *
     * @return void
     */
    public function displayRace(): void
    {
        $race = $this->getRaceInfo();
        $results = $this->getResults();
        $sorter = new Sorter();
        $results = $sorter->sortResultsByPlacement($results);
        $raceAvgTimes = $this->getAvgFinishTimes($results);

        array_push($race, $results);

        $raceView = new RaceView($race, $raceAvgTimes);
        $raceView->showRace();
    }

    /**
     * save data about a race to database
     *
     * @param array $post
     * @return void
     */
    public function saveRace(array $post): void
    {
        $this->setRace($post['race-name'], $post['date']);
    }

    /**
     * save race results to database
     *
     * @param string $file
     * @return void
     */
    public function saveResults(string $file): void
    {
        $results = $this->processCsvFile($file);
        $results = $this->sortResultsByPlacement($results);
        $this->setResults($results);
    }
}