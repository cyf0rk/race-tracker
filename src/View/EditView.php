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

    public function __construct(array $result)
    {
        $this->result = $result;
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