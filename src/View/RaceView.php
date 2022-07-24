<?php

declare(strict_types=1);

namespace RaceTracker\View;

use RaceTracker\Controller\RaceController;

/**
 * RaceView class
 */
class RaceView extends RaceController
{
    protected array $race;

    protected array $raceAvgTimes;

    public function __construct(array $race, array $raceAvgTimes)
    {
        $this->race = $race;
        $this->raceAvgTimes = $raceAvgTimes;
    }

    /**
     * display template that will use race data
     *
     * @return void
     */
    public function showRace(): void
    {
        $template = __DIR__.'/../../templates/display_results.php';

        if (file_exists($template)) {
            require $template;
        } else {
            echo 'Something went wrong, please try again.';
        }
    }
}