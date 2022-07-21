<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

/**
 * RaceController interface
 */
interface RaceControllerInterface
{
    /**
     * handle client form submit
     *
     * @param array $post
     * @param array $file
     * @return void
     */
    public function handleSubmit(array $post, array $file): void;

    /**
     * display race data
     *
     * @return void
     */
    public function displayRace(): void;
    
    /**
     * insert data about race into database
     *
     * @param array $post POST request data
     * @return void
     */
    public function saveRace(array $post): void;
    
    /**
     * insert race results data into database
     *
     * @param array $post POST request data
     * @return void
     */
    public function saveResults(string $file): void;
}