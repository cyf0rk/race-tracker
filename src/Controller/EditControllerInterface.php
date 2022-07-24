<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

/**
 * EditController interface
 */
interface EditControllerInterface
{
    /**
     * display edit form and show errors if any field is invalid
     *
     * @param array $errors
     * @return void
     */
    public function displayEditForm(array $result, array $errors): void;

    /**
     * handle client edit request
     *
     * @param int $id
     * @return void
     */
    public function handleEditRequest(int $id): void;

    /**
     * handle edit result form submission
     *
     * @return void
     */
    public function handleEditFormSubmit(array $post): void;
}