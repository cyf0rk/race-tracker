<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

/**
 * RaceController interface
 */
interface RaceControllerInterface
{
    /**
     * display race by given id
     *
     * @param integer $raceId
     * @return void
     */
    public function displayRace(int $raceId): void;
}