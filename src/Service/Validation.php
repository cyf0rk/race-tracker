<?php

declare(strict_types=1);

namespace RaceTracker\Service;

/**
 * Validation class
 */
class Validation
{
    /**
     * static method for validating import form data
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
    
        if (empty($post['race_name'])) {
            $request['errors']['race_name-err'] = 'Name is required';
        } else {
            $request['fields']['race_name'] = self::sanitizeInput($post['race_name']);
        }

        if (empty($post['date'])) {
            $request['errors']['date-err'] = 'Date is required';
        } else {
            $startDate = date('Y-m-d', strtotime("01/01/2000"));
            $endDate = date('Y-m-d');
            $raceDate = date('Y-m-d', strtotime($post['date']));

            if ($raceDate >= $startDate && $raceDate <= $endDate){
                $request['fields']['date'] = self::sanitizeInput($post['date']);
            }else{
                $request['errors']['date-err'] = 'Valid date is required';
            }
        }

        if (empty($request['errors'])) {
            if ($fileType != "csv") {
                $request['errors']['file-err'] = 'Uploaded file is not a valid csv file';
            } else {
                $tmpFileName = uniqid('', true).'.'.$fileType;
                $tmpLocation = 'public/tmp_csv/'.$tmpFileName;

                move_uploaded_file($file['tmp_name'], $tmpLocation);

                $request['fields']['csv_file'] = $tmpLocation;
            }
        }

        return $request;
    }

    /**
     * static method for validating edit form data
     *
     * @param array $post
     * @return array
     */
    public static function validateEditForm(array $post): array
    {
        $request = [
            'errors' => [],
            'fields' => []
        ];

        if (empty($post['full_name'])) {
            $request['errors']['full_name-err'] = 'Full name is required';
        } else {
            $request['fields']['full_name'] = self::sanitizeInput($post['full_name']);
        }

        $raceTimeRegExp = preg_match("/^(?:2?[0-3]|[01]?[0-9]):[0-5][0-9]:[0-5][0-9]$/", $post['race_time']);

        if (empty($post['race_time'])) {
            $request['errors']['race_time-err'] = 'Race time is required';
        } elseif ($raceTimeRegExp === 0) {
            $request['errors']['race_time-err'] = 'Race time format is hh:mm:ss';
        } else {
            $request['fields']['race_time'] = self::sanitizeInput($post['race_time']);
        }

        if (empty($post['id'])) {
            $request['errors']['id-err'] = 'ID is required';
        } elseif (!ctype_digit($post['id'])) {
            $request['errors']['id-err'] = 'ID is not a valid number';
        } else {
            $request['fields']['id'] = intval(self::sanitizeInput($post['id']));
        }

        return $request;
    }

    /**
     * sanitize input
     *
     * @param string $data
     * @return string
     */
    public static function sanitizeInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}