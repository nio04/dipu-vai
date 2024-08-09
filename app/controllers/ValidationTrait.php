<?php


namespace App\Traits;

trait ValidationTrait {

    public function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validateUsername(string $username): bool {
        return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
    }

    // public function validatePassword(string $password): bool {
    //     return preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password);
    // }

    public function validateRequiredFields(array $input, array $requiredFields): bool {
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                return false;
            }
        }
        return true;
    }
}
