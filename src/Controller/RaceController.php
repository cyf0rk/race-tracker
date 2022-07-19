<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Model\Race;
use RaceTracker\Controller\RaceControllerInterface;

class RaceController extends Race implements RaceControllerInterface
{
    public function getRace($raceName): array
    {
        $race = $this->getRace($raceName);

        return $race;
    }

    public function saveRace($raceName, $date): void
    {
        $this->setRace($raceName, $date);
    }

    public function saveResults($results): void
    {
        $this->setResults($results);
    }
}