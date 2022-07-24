<?php

declare(strict_types=1);

namespace RaceTracker\Service;

/**
 * Validation class
 */
class Validation
{
    /**
     * method for validating import form data
     *
     * @param array $post
     * @param array $file
     * @return array $request
     */
    public static function validateImportForm(array $post, array $file): array
    {
        $request = [
            'errors' => [],
            'fields' => []
        ];
        $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
    
        if (empty($post['race-name'])) {
            $request['errors']['race-name-err'] = 'Name is required';
        } else {
            $request['fields']['race-name'] = self::testInput($post['race-name']);
        }

        if (empty($post['date'])) {
            $request['errors']['date-err'] = 'Date is required';
        } else {
            $request['fields']['date'] = self::testInput($post['date']);
        }

        if (empty($request['errors'])) {
            if ($fileType != "csv") {
                $request['errors']['file-err'] = 'Uploaded file is not a valid csv file';
            } else {
                $tmpFileName = uniqid('', true).'.'.$fileType;
                $tmpLocation = 'public/tmp_csv/'.$tmpFileName;

                move_uploaded_file($file['tmp_name'], $tmpLocation);

                $request['fields']['csv-file'] = $tmpLocation;
            }
        }

        return $request;
    }

    /**
     * sanitize input
     *
     * @param string $data
     * @return string
     */
    public static function testInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}