<?php

namespace App\Traits;

trait ValidationTrait {

    // Sanitize input data
    public function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    // Check for empty fields
    public function isEmpty(array $fields, array $requiredFields = []) {
        $errors = [];

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $fields) || empty(trim($fields[$field]))) {
                $errors[] = "The field '{$field}' cannot be empty.";
            }
        }

        return empty($errors) ? $fields : $errors;
    }

    // Validate fields with specific rules and methods
    public function validateField(array $validateFields) {
        $errors = [];
        $validatedData = [];

        foreach ($validateFields as $fieldName => $details) {
            $value = $details['data'] ?? null;
            $method = $details['validateMethod'] ?? 'stringValidate'; // Default to 'stringValidate'
            echo ("<pre>");
            var_dump($method);
            echo ("</pre>");
            $customRules = $details['rules'] ?? [];

            if (method_exists($this, $method)) {
                $result = $this->$method($value, $customRules);

                if ($result === false) {
                    $errors[] = $this->getCustomErrorMessage($fieldName, $value, $customRules, $method);
                } else {
                    $validatedData[$fieldName] = $result;
                }
            } else {
                $errors[] = "No validation method found for '{$method}' for field '{$fieldName}'.";
            }
        }

        return empty($errors) ? $validatedData : $errors;
    }

    // String validation with length rules
    private function stringValidate($data, array $rules = []) {
        $minLength = $rules['min_length'] ?? 3;
        $maxLength = $rules['max_length'] ?? 30;

        $length = strlen($data);
        if ($length >= $minLength && $length <= $maxLength) {
            return $data;
        }

        return false;
    }

    // Email validation
    private function emailValidate($data) {
        return filter_var($data, FILTER_VALIDATE_EMAIL) ? $data : false;
    }

    // Digit validation
    private function digitValidate($data) {
        return preg_match('/^\d+$/', $data) ? (int) $data : false;
    }

    // Password validation
    private function passwordValidate($data) {
        return preg_match('/^[a-zA-Z0-9_@+.]+$/', $data) ? $data : false;
    }

    // Mobile number validation with optional length rule
    public function mobileValidate($mobile, $rules = []) {
        $pattern = "/^\+?[0-9]{10,15}$/";

        if (isset($rules['length'])) {
            $pattern = "/^\+?[0-9]{" . $rules['length'] . "}$/";
        }

        if (preg_match($pattern, $mobile)) {
            return $mobile;
        }

        return false;
    }

    // Generate custom error messages
    private function getCustomErrorMessage($field, $value, $rules, $method) {
        switch ($method) {
            case 'stringValidate':
                $minLength = $rules['min_length'] ?? 3;
                $maxLength = $rules['max_length'] ?? 30;
                return "The '{$field}' field must be between {$minLength} and {$maxLength} characters long.";

            case 'digitValidate':
                return "The '{$field}' field must contain only digits.";

            case 'mobileValidate':
                return "The '{$field}' field must be a valid mobile number.";

            case 'emailValidate':
                return "The '{$field}' field must be a valid email address.";

            case 'passwordValidate':
                return "The '{$field}' field must contain only valid characters (letters, digits, _ + . @).";

            default:
                return "The '{$field}' field is invalid.";
        }
    }
}
