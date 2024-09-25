<?php

class UserModel extends Model
{

    /**
     * Validation rules for user input. This array contains the validation rules
     * for the fields in the UserModel. Each key represents a field name and the
     * value is an array of rules to validate that field.
     *
     * @var array
     */
    private $validationRules = [
        'username' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 20,
            'regex' => "/^[a-zA-Z0-9_]+$/"
        ],
        'password' => [
            'required' => true,
            // Changed numeric to false for testing
            'numeric' => false,
            'min_length' => 4,
            'max_length' => 8
        ],
        'email' => [
            'required' => true
        ]
    ];

    /**
     * Hard-coded list of registered users for demonstration purposes. This array
     * maps usernames to their corresponding passwords. This is used to simulate
     * a user database in the absence of a real database connection.
     *
     * @var array
     */
    private $registeredUsers = [
        'kmarasovic' => [
            'email' => 'kmarasovic@example.com',
            'password' => '1234',
            'isAdmin' => true
        ],
        'jane' => [
            'email' => 'jane@example.com',
            'password' => '4321',
            'isAdmin' => false
        ],
        'franko' => [
            'email' => 'ff1574@rit.edu',
            'password' => 'admin',
            'isAdmin' => true
        ],
    ];

    /**
     * Retrieves the user information after sanitizing and validating the input.
     *
     * This method is responsible for processing user input (username and password)
     * from the form, sanitizing the inputs to ensure they are safe, and then
     * validating the data against the predefined rules in the `$validationRules`
     * array.
     *
     * If the input data passes the validation, the method checks whether the
     * provided username exists in the list of registered users and if the password
     * matches. If successful, the method returns an associative array containing the
     * username and the user's email.
     *
     * If validation fails or the credentials are incorrect, it returns `false` or
     * `null` respectively.
     *
     * @return array|null|bool Returns an array with `username` and `email` if
     * credentials are correct, `false` if validation fails, or `null` if the
     * credentials do not match.
     */
    public function getViewModel()
    {
        // 1. Sanitize input data
        $username = $this->sanitize($_POST['username']);
        $password = $this->sanitize($_POST['password']);
        // 2. Define an array to hold the data to be validated
        $data = [
            'username' => $username,
            'password' => $password
        ];
        // 3. Validate the data
        if (!$this->validate($data, $this->validationRules)) {
            return false;
        }
        // 4 .Check if username exists and password matches
        if (isset($this->registeredUsers[$username]) && $this->registeredUsers[$username]['password'] === $password) {
            $data = [
                'username' => $username,
                'email' => $this->registeredUsers[$username]['email'],
                'isAdmin' => $this->registeredUsers[$username]['isAdmin']
            ];
            return $data;
        }
        return null;
    }
}
