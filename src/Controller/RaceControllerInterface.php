<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

interface RaceControllerInterface
{
    public function getRace($raceName): array;
    
    public function saveRace($raceName, $date): void;
    
    public function saveResults($results): void;
}