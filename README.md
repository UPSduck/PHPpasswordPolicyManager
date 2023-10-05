# PHPpasswordPolicyManager
Welcome to the Password Policy Manager for PHP! This lightweight PHP module allows you to easily enforce password policies within your applications. Enhance security and ensure that your users create strong and secure passwords.

## Getting Started
1. **Clone the Repository**
   Clone the "PHPpasswordPolicyManager" repository to your project's directory:

  ```
   git clone https://github.com/UPSduck/PHPpasswordPolicyManager.git
  ```

3. **Include the Password Policy Manager**
   To include the Password Policy Manager in your PHP script, use the following code:

```php
require 'PHPpasswordPolicyManager/PasswordPolicyManager.php';
use PasswordPolicyManager;
```

## Configuration

Customize the password policy to meet your application's security requirements using one of the following methods:

#### Method 1: Using Constructor Parameters
```php
// Create a new PasswordPolicyManager instance with configuration options
$passwordPolicy = new PasswordPolicyManager([
    'minimumLength' => 10,
    'maximumLength' => 32,
    'requireUppercase' => true,
    'requireLowercase' => true,
    'requireDigits' => true,
    'requireSpecialChars' => true,
    'specialChars' => '!@#%'
]);
```

#### Method 2: Using Setters
```php
$passwordPolicy = new PasswordPolicyManager();

$passwordPolicy->setMinimumLength(10);
$passwordPolicy->setMaximumLength(32);
$passwordPolicy->requireUppercase();
$passwordPolicy->requireLowercase();
$passwordPolicy->requireDigits();
$passwordPolicy->requireSpecialChars();
$passwordPolicy->setSpecialChars('!@#%');
```

## Usage
Validate passwords against the configured policy:
```php
$password = 'StrongP@ssw0rd'; // Replace with the password to validate

// returns an array of errors or true
$result = $passwordPolicy->validatePassword($password);

if ($result === true) {
    echo "Password meets the policy requirements.";
    // Go and do things with it
} else {
    echo "Password validation failed. Errors:";
    print_r($result);
    // Go and display these error messages to your user
}
```

## Custom Error Messages

The Password Policy Manager allows you to set custom error messages to provide user-friendly feedback when password validation fails. This feature allows you to tailor error messages to match your application's user experience. Below, you'll find details on how to set custom error messages and a list of error keys with their meanings.

#### Setting Custom Error Messages

To set custom error messages for the Password Policy Manager, you can use the `setCustomErrorMessages` method. Here's how you can do it:

```php
// Define custom error messages
$customErrorMessages = [
    'min_length' => 'Your password is too short. It must be at least {{min_length}} characters long.',
    'max_length' => 'Your password is too long. It cannot exceed {{max_length}} characters.',
    'uppercase' => 'Your password must contain at least one uppercase letter.',
    // Add custom error messages for other policy checks
];

// Set custom error messages
$passwordPolicy->setCustomErrorMessages($customErrorMessages);
```
In the example above, we define an associative array with custom error messages, where each key corresponds to an error key, and the value contains the custom error message. You can include placeholders like {{min_length}} and {{max_length}} to dynamically insert policy-specific values into your messages.

List of Error Keys and Meanings
Here's a list of error keys used by the Password Policy Manager, along with their meanings:

* min_length: Password does not meet the minimum length requirement.
* max_length: Password exceeds the maximum length allowed.
* uppercase: Password does not contain at least one uppercase letter.
* lowercase: Password does not contain at least one lowercase letter.
* digits: Password does not contain at least one digit.
* special_chars: Password does not contain at least one special character.
  
These error keys are used to identify which specific policy check failed during password validation. You can set custom error messages for any of these error keys to provide clear and user-friendly feedback to your application's users.
