<?php

declare(strict_types=1);

namespace RaceTracker\View;

use RaceTracker\Controller\RaceController;

/**
 * ImportView class
 */
class ImportView extends RaceController
{
    protected array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * display import form
     *
     * @return void
     */
    public function showImportForm(): void
    {
        $template = __DIR__.'/../../templates/import_results.php';

        if (file_exists($template)) {
            require $template;
        } else {
            echo 'Something went wrong, please try again.';
        }

    }
}