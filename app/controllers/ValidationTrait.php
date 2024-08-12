<?php


namespace App\Traits;

trait ValidationTrait {

    public function sanitizeInput($input) {
        return htmlspecialchars($input);
    }

    public function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validateUsername(string $username): bool {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
    }

    // public function validatePassword(string $password): bool {
    //     return preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password);
    // }

    /**
     * if return yes, meaning all the required fields are filled up
     * if retrun false, meaning required fields were not filled up
     */
    public function checkEmpty($fields) {
        foreach ($fields as $field) {
            if (empty($field)) {
                return false;
            }
        }
        return true;
    }

    public function validateRequiredFields(array $input, array $requiredFields): bool {
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                return false;
            }
        }
        return true;
    }
}
