<?php

declare(strict_types=1);

namespace RaceTracker\Controller;

use RaceTracker\Model\Result;
use RaceTracker\Service\Validation;
use RaceTracker\View\EditView;

/**
 * EditController class
 */
class EditController extends Result implements EditControllerInterface
{
    /**
     * display edit form and show errors if any field is invalid
     *
     * @param array $errors
     * @return void
     */
    public function displayEditForm(array $result, array $errors): void
    {
        $importView = new EditView($result, $errors);

        $importView->showEditForm();
    }

    /**
     * handle client edit request
     *
     * @param int $id
     * @return void
     */
    public function handleEditRequest(int $id): void
    {
        $result = $this->getResult($id);
        $this->displayEditForm($result, []);
    }

    /**
     * handle edit result form submission
     *
     * @return void
     */
    public function handleEditFormSubmit(array $post): void
    {
        $request = Validation::validateEditForm($post);

        if (!empty($request['errors'])) {
            $this->displayEditForm($post, $request['errors']);
        } else {
            $this->updateResult($request['fields']['id'], $request['fields']['full_name'], $request['fields']['race_time']);
            $displayResults = getenv('APP_ROOT_PATH').'/display-results';
            $_SESSION['POST'] = $request['fields'];
            header("location: ${displayResults}");
            exit;
        }
    }
}