<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

/**
 * ImportController interface
 */
interface ImportControllerInterface
{
    /**
     * display import form and show errors if any field is invalid
     *
     * @param array $errors
     * @return void
     */
    public function displayImportForm(array $errors): void;

    /**
     * handle client import form submission
     *
     * @return void
     */
    public function handleFormSubmit(): void;

    /**
     * save data about a race to database
     *
     * @param array $post
     * @return void
     */
    public function saveRace(array $post): void;

    /**
     * save race results to database
     *
     * @param string $file
     * @return void
     */
    public function saveResults(string $file): void;
}