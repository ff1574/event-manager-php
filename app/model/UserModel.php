<?php

class UserModel extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    private $validationRules = [
        'username' => [
            'required' => true,
            'min_length' => 2,
            'max_length' => 20,
            'regex' => "/^[a-zA-Z0-9_]+$/"
        ],
        'password' => [
            'required' => true,
            'min_length' => 4,
            'max_length' => 60 // Updated max length to accommodate longer passwords if needed
        ],
    ];

    public function getViewModel()
    {
        // 1. Sanitize input data
        $username = $this->sanitize($_POST['username']);
        $password = $this->sanitize($_POST['password']);

        // 2. Validate data
        $data = [
            'username' => $username,
            'password' => $password
        ];
        if (!$this->validate($data, $this->validationRules)) {
            return false;
        }

        // 3. Retrieve user information from the database
        $query = "SELECT a.*, r.name AS role_name FROM attendee a
                  INNER JOIN role r ON a.role_id = r.role_id
                  WHERE a.username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 4. Validate credentials (plain text comparison)
        if ($user && $user['password'] === $password) {
            return [
                'user_id' => $user['attendee_id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'isAdmin' => $user['role_name'] === 'admin'
            ];
        }

        return null;
    }

    public function getAllUsers()
    {
        $query = "SELECT a.*, r.name AS role_name FROM attendee a
              INNER JOIN role r ON a.role_id = r.role_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId)
    {
        if (!is_numeric($userId)) {
            throw new Exception("Invalid user ID.");
        }

        $query = "DELETE FROM attendee WHERE attendee_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Failed to delete user.");
        }
    }

    public function updateUser($userData)
    {
        try {
            $query = "UPDATE attendee 
                      SET first_name = :first_name, last_name = :last_name, email = :email, username = :username, role_id = :role_id
                      WHERE attendee_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':first_name', $userData['first_name']);
            $stmt->bindParam(':last_name', $userData['last_name']);
            $stmt->bindParam(':email', $userData['email']);
            $stmt->bindParam(':username', $userData['username']);
            $stmt->bindParam(':role_id', $userData['role_id']);
            $stmt->bindParam(':user_id', $userData['user_id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true; // Return true on successful update
            } else {
                return "Failed to update user."; // Return error message on failure
            }
        } catch (Exception $e) {
            return "Exception occurred: " . $e->getMessage(); // Return exception message on error
        }
    }

    public function registerUser($data)
    {
        // 1. Sanitize input data
        $firstName = $this->sanitize($data['first_name']);
        $lastName = $this->sanitize($data['last_name']);
        $email = $this->sanitize($data['email']);
        $username = $this->sanitize($data['username']);
        $password = $this->sanitize($data['password']);
        $roleId = (int) $data['role_id'];

        // 2. Check if the username already exists
        $query = "SELECT * FROM attendee WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            return "Username or email already exists.";
        }

        // 3. Insert new user data
        $query = "INSERT INTO attendee (first_name, last_name, email, username, password, role_id) 
                  VALUES (:first_name, :last_name, :email, :username, :password, :role_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return "Registration failed. Please try again.";
    }
}
