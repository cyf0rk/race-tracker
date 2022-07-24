<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Controller\RaceControllerInterface;
use RaceTracker\Model\Race;
use RaceTracker\Service\Calculator;
use RaceTracker\Service\Sorter;
use RaceTracker\View\EditView;
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
            $raceId = $this->getRaceId();
            $this->displayRace($raceId);
            exit;
        }
    }

    /**
     * get race info, data and average finish times and display it in a view
     *
     * @param integer $raceId
     * @return void
     */
    public function displayRace($raceId): void
    {
        $race = $this->getRaceInfo($raceId);
        $results = $this->getResults($raceId);
        $results = Calculator::calculatePlacements($results);
        $raceAvgTimes = $this->getAvgFinishTimes($results);
        $race = Sorter::createAssociativeRaceArray($race, $results, 'results');

        $raceView = new RaceView($race, $raceAvgTimes);
        $raceView->showRace();
    }

    /**
     * handle client edit request
     *
     * @param int $id
     * @return void
     */
    public function handleEditRequest(int $id): void
    {
        $result = $this->getResult($id);
        $editView = new EditView($result);
        $editView->showEditForm();
    }

    /**
     * handle client table edit
     *
     * @param array $post
     * @param int $id
     * @return void
     */
    public function handleResultEdit(array $post, int $id): void
    {
        $this->updateResult($id, $post['full-name'], $post['race-time']);
        $result = $this->getResult($id);
        $this->updateResults($result['race_id']);
        $this->displayRace($result['race_id']);
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
        $results = Calculator::calculatePlacements($results);
        $this->setResults($results);
    }
}