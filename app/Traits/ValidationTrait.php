<?php

namespace App\Traits;

trait ValidationTrait {

    /**
     * Sanitize input data.
     *
     * This method sanitizes input by trimming whitespace and converting special characters to HTML entities.
     * It can accept either a single value or an array of values.
     *
     * **Usage:**
     * 
     * **Single value:**
     * ```php
     * $cleaned = $this->sanitize('<script>alert("XSS")</script>');
     * // Output: '&lt;script&gt;alert("XSS")&lt;/script&gt;'
     * ```
     *
     * **Array of values:**
     * ```php
     * $cleaned = $this->sanitize(['<script>alert("XSS")</script>', '   Example  ']);
     * // Output: ['&lt;script&gt;alert("XSS")&lt;/script&gt;', 'Example']
     * ```
     *
     * @param string|array $data The input data to sanitize, either as a string or an array.
     * @return string|array The sanitized data.
     */
    public function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Check for empty fields.
     *
     * This method checks if required fields are present and not empty in the provided array.
     *
     * **Usage:**
     * ```php
     * $fields = ['name' => 'John', 'email' => ''];
     * $requiredFields = ['name', 'email'];
     * $result = $this->isEmpty($fields, $requiredFields);
     * // Output: ['The field \'email\' cannot be empty.']
     * ```
     *
     * @param array $fields The array of input fields.
     * @param array $requiredFields The list of required fields to check.
     * @return array The validated fields or an array of error messages.
     */
    public function isEmpty(array $fields, array $requiredFields = []) {
        $errors = [];

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $fields) || empty(trim($fields[$field]))) {
                $errors[] = "The field '{$field}' cannot be empty.";
            }
        }

        return empty($errors) ? $fields : $errors;
    }

    /**
     * Validate fields with specific rules and methods.
     *
     * This method validates an array of fields using specified validation methods and custom rules.
     *
     * **Usage:**
     * ```php
     * $validateFields = [
     *     'username' => [
     *         'data' => 'john_doe',
     *         'validateMethod' => 'stringValidate',
     *         'rules' => ['min_length' => 5, 'max_length' => 15]
     *     ],
     *     'email' => [
     *         'data' => 'john.doe@example.com',
     *         'validateMethod' => 'emailValidate'
     *     ]
     * ];
     * $result = $this->validateField($validateFields);
     * // Output: ['username' => 'john_doe', 'email' => 'john.doe@example.com']
     * ```
     *
     * @param array $validateFields An array of fields with validation methods and rules.
     * @return array The validated data or an array of error messages.
     */
    public function validateField(array $validateFields) {
        $errors = [];
        $validatedData = [];

        foreach ($validateFields as $fieldName => $details) {
            $value = $details['data'] ?? null;
            $method = $details['validateMethod'] ?? 'stringValidate'; // Default to 'stringValidate'
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

    /**
     * String validation with length rules.
     *
     * This method validates that a string is within the specified minimum and maximum length.
     *
     * **Usage:**
     * ```php
     * $result = $this->stringValidate('username123', ['min_length' => 5, 'max_length' => 15]);
     * // Output: 'username123'
     * ```
     *
     * @param string $data The string to validate.
     * @param array $rules An array containing 'min_length' and 'max_length'.
     * @return string|false The validated string or false if validation fails.
     */
    private function stringValidate($data, array $rules = []) {
        $minLength = $rules['min_length'] ?? 3;
        $maxLength = $rules['max_length'] ?? 30;

        $length = strlen($data);
        if ($length >= $minLength && $length <= $maxLength) {
            return $data;
        }

        return false;
    }

    /**
     * Email validation.
     *
     * This method validates an email address format.
     *
     * **Usage:**
     * ```php
     * $result = $this->emailValidate('john.doe@example.com');
     * // Output: 'john.doe@example.com'
     * ```
     *
     * @param string $data The email address to validate.
     * @return string|false The validated email or false if validation fails.
     */
    private function emailValidate($data) {
        return filter_var($data, FILTER_VALIDATE_EMAIL) ? $data : false;
    }

    /**
     * Digit validation.
     *
     * This method validates that a string contains only digits.
     *
     * **Usage:**
     * ```php
     * $result = $this->digitValidate('12345');
     * // Output: 12345
     * ```
     *
     * @param string $data The string to validate.
     * @return int|false The validated integer or false if validation fails.
     */
    private function digitValidate($data) {
        return preg_match('/^\d+$/', $data) ? (int) $data : false;
    }

    /**
     * Password validation.
     *
     * This method validates that a password contains only valid characters (letters, digits, _ + . @).
     *
     * **Usage:**
     * ```php
     * $result = $this->passwordValidate('Password123');
     * // Output: 'Password123'
     * ```
     *
     * @param string $data The password to validate.
     * @return string|false The validated password or false if validation fails.
     */
    private function passwordValidate($data) {
        return preg_match('/^[a-zA-Z0-9_@+.]+$/', $data) ? $data : false;
    }

    /**
     * Mobile number validation with optional length rule.
     *
     * This method validates that a mobile number matches a specific pattern, with an optional length rule.
     *
     * **Usage:**
     * ```php
     * // Without custom length:
     * $result = $this->mobileValidate('+12345678901');
     * // Output: '+12345678901'
     *
     * // With custom length:
     * $result = $this->mobileValidate('1234567890', ['length' => 10]);
     * // Output: '1234567890'
     * ```
     *
     * @param string $mobile The mobile number to validate.
     * @param array $rules An array containing optional validation rules like 'length'.
     * @return string|false The validated mobile number or false if validation fails.
     */
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
    /**
     * Generate custom error messages.
     *
     * This method generates custom error messages based on the validation method used.
     *
     * **Usage:**
     * ```php
     * $message = $this->getCustomErrorMessage('username', 'user', ['min_length' => 5], 'stringValidate');
     * // Output: "The 'username' field must be between 5 and 30 characters long."
     * ```
     *
     * @param string $field The name of the field being validated.
     * @param string $value The value of the field being validated.
     * @param array $rules The validation rules applied.
     * @param string $method The validation method used.
     * @return string The generated error message.
     */
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
