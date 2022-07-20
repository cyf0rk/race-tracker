<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

interface RaceControllerInterface
{
    public function fetchRace(): array;
    
    public function saveRace(string $raceName, string $date): void;
    
    public function saveResults(array $results): void;
}