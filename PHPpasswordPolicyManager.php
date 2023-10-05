<?php
class PasswordPolicyManager {

    private $minimumLength = 8;
    private $maximumLength = 64;
    private $requireUppercase = true;
    private $requireLowercase = true;
    private $requireDigits = true;
    private $requireSpecialChars = false;
    private $passwordExpirationDays = 0; // 0 means no expiration
    private $passwordHistorySize = 5;
    private $specialChars = '!@#$%^&*()_+-=[]{}|;:\'",./<>?'; // Default special characters
    private $customErrorMessages = []; // Store custom error messages
    
    // Constructor
    public function __construct() {
        // Initialize with default values
    }
    
    // Setters for policy options
    public function setMinimumLength($length) {
        $this->minimumLength = $length;
    }

    public function setMaximumLength($length) {
        $this->maximumLength = $length;
    }

    public function requireUppercase() {
        $this->requireUppercase = true;
    }

    public function requireLowercase() {
        $this->requireLowercase = true;
    }

    public function requireDigits() {
        $this->requireDigits = true;
    }

    public function requireSpecialChars() {
        $this->requireSpecialChars = true;
    }

    public function setSpecialChars($specialChars) {
        $this->specialChars = $specialChars;
    }

    public function setPasswordExpirationDays($days) {
        $this->passwordExpirationDays = $days;
    }

    public function setPasswordHistorySize($size) {
        $this->passwordHistorySize = $size;
    }

    public function setCustomErrorMessages($customErrorMessages) {
        $this->customErrorMessages = $customErrorMessages;
    }

    // Policy validation logic
    public function validatePassword($password) {
        $errors = [];

        // Minimum length check
        if (strlen($password) < $this->minimumLength) {
            $errors[] = $this->getErrorText('min_length');
        }

        // Maximum length check
        if (strlen($password) > $this->maximumLength) {
            $errors[] = $this->getErrorText('max_length');
        }

        // Uppercase letter requirement
        if ($this->requireUppercase && !preg_match('/[A-Z]/', $password)) {
            $errors[] = $this->getErrorText('uppercase');
        }

        // Lowercase letter requirement
        if ($this->requireLowercase && !preg_match('/[a-z]/', $password)) {
            $errors[] = $this->getErrorText('lowercase');
        }

        // Digit requirement
        if ($this->requireDigits && !preg_match('/[0-9]/', $password)) {
            $errors[] = $this->getErrorText('digits');
        }

        // Special character requirement
        if ($this->requireSpecialChars && !$this->containsSpecialChars($password)) {
            $errors[] = $this->getErrorText('special_chars');
        }

        // Additional policy checks can be added here

        if (!empty($errors)) {
            return $errors; // Password does not meet policy requirements
        }

        return true; // Password meets all policy requirements
    }

    // Helper function to get error text
    private function getErrorText($errorKey) {
        // Check if a custom error message exists for the given error key
        if (isset($this->customErrorMessages[$errorKey])) {
            return $this->customErrorMessages[$errorKey];
        }

        // Default error messages
        $defaultErrorMessages = [
            'min_length' => "Password must be at least {$this->minimumLength} characters long.",
            'max_length' => "Password cannot exceed {$this->maximumLength} characters.",
            'uppercase' => "Password must contain at least one uppercase letter.",
            'lowercase' => "Password must contain at least one lowercase letter.",
            'digits' => "Password must contain at least one digit.",
            'special_chars' => "Password must contain at least one special character.",
            'password_expired' => "Your password has expired. Please reset it.",
            'password_history' => "Cannot reuse one of your last {$this->passwordHistorySize} passwords.",
            'account_locked' => "Your account is temporarily locked due to too many failed login attempts. Please try again later.",
            '2fa_required' => "Two-factor authentication is required for added security.",
            // ... (other default error messages)
        ];

        // Use the default error message if no custom message is specified
        return $defaultErrorMessages[$errorKey];
    }

    // Helper function to check for special characters
    private function containsSpecialChars($password) {
        return preg_match("/[" . preg_quote($this->specialChars, '/') . "]/", $password);
    }
}
