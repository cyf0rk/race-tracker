<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

/**
 * RaceController interface
 */
interface RaceControllerInterface
{
    /**
     * fetch race data from database
     *
     * @return array
     */
    public function fetchRace(): array;
    
    /**
     * insert data about race into database
     *
     * @param string $raceName
     * @param string $date
     * @return void
     */
    public function saveRace(string $raceName, string $date): void;
    
    /**
     * insert race results data into database
     *
     * @param array $results
     * @return void
     */
    public function saveResults(array $results): void;
}