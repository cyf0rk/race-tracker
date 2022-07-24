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
     * @param string $file
     * @return void
     */
    public function handleSubmit(array $post, string $file): void;

    /**
     * handle result edit
     *
     * @param int $id
     * @return void
     */
    public function handleEditRequest(int $id): void;

    /**
     * handle result edit
     *
     * @param array $post
     * @param int $id
     * @return void
     */
    public function handleResultEdit(array $post, int $id): void;

    /**
     * display race data
     *
     * @param integer $raceId
     * @return void
     */
    public function displayRace($raceId): void;
    
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