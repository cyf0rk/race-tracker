<?php

declare(strict_types=1);

namespace RaceTracker\View;

use RaceTracker\Controller\RaceController;

/**
 * EditView class
 */
class EditView extends RaceController
{
    protected array $result;
    protected array $errors;

    public function __construct(array $result, array $errors)
    {
        $this->result = $result;
        $this->errors = $errors;
    }

    /**
     * display result edit form
     *
     * @return void
     */
    public function showEditForm(): void
    {
        $template = __DIR__.'/../../templates/edit_result.php';

        if (file_exists($template)) {
            require $template;
        } else {
            echo 'Something went wrong, please try again.';
        }

    }
}