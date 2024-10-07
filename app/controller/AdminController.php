<?php

class AdminController extends Controller
{
    public function index()
    {
        $eventModel = new EventModel();
        $venues = $eventModel->getAllVenues();
        $events = $eventModel->getAllEvents();

        $userModel = new UserModel();
        $users = $userModel->getAllUsers();

        $this->view('admin/admin', ['venues' => $venues, 'events' => $events, 'users' => $users]);
    }

    // Function to sanitize inputs
    private function sanitizeInput($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    // Function to validate event data
    private function validateEventData($eventData)
    {
        var_dump($eventData);
        if (empty($eventData['name']) || strlen($eventData['name']) > 50) {
            return "Invalid event name. It must be between 1 and 50 characters.";
        }
        if (empty($eventData['start_date']) || empty($eventData['end_date']) || strtotime($eventData['end_date']) <= strtotime($eventData['start_date'])) {
            return "Invalid date range. The end date must be after the start date.";
        }
        if (!is_numeric($eventData['allowed_number']) || (int)$eventData['allowed_number'] <= 0) {
            return "Allowed attendees must be a positive number.";
        }
        if (empty($eventData['venue_id']) || !is_numeric($eventData['venue_id'])) {
            return "Invalid venue ID.";
        }

        // Check if the number of allowed attendees is less than or equal to the venue capacity
        $model = new EventModel();
        $venue = $model->getVenueById($eventData['venue_id']);
        if ($venue && (int)$eventData['allowed_number'] > (int)$venue['capacity']) {
            return "The number of allowed attendees cannot exceed the venue capacity of " . $venue['capacity'] . ".";
        }

        return true;
    }

    private function validateVenueData($venueData)
    {
        if (empty($venueData['name']) || strlen($venueData['name']) > 50) {
            return "Invalid venue name. It must be between 1 and 50 characters.";
        }
        if (!is_numeric($venueData['capacity']) || (int)$venueData['capacity'] <= 0) {
            return "Capacity must be a positive number.";
        }
        return true;
    }

    private function validateUserData($userData)
    {
        if (empty($userData['first_name']) || strlen($userData['first_name']) > 45) {
            return "Invalid first name. It must be between 1 and 45 characters.";
        }
        if (empty($userData['last_name']) || strlen($userData['last_name']) > 45) {
            return "Invalid last name. It must be between 1 and 45 characters.";
        }
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address.";
        }
        if (empty($userData['username']) || strlen($userData['username']) < 2 || strlen($userData['username']) > 20 || !preg_match("/^[a-zA-Z0-9_]+$/", $userData['username'])) {
            return "Invalid username. It must be between 2 and 20 characters and can only contain letters, numbers, and underscores.";
        }
        if (isset($userData['password']) && (strlen($userData['password']) < 4 || strlen($userData['password']) > 60)) {
            return "Password must be between 4 and 60 characters.";
        }
        if (empty($userData['role_id']) || !in_array($userData['role_id'], [1, 2])) {
            return "Invalid role selected.";
        }
        return true;
    }

    public function createEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'name' => $this->sanitizeInput($_POST['name']),
                'start_date' => $this->sanitizeInput($_POST['start_date']),
                'end_date' => $this->sanitizeInput($_POST['end_date']),
                'allowed_number' => $this->sanitizeInput($_POST['allowed_number']),
                'venue_id' => $this->sanitizeInput($_POST['venue_id']),
            ];

            // Validate event data
            $validationResult = $this->validateEventData($eventData);
            if ($validationResult !== true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($validationResult) . '&status=error');
                exit();
            }

            // Save event if validation is passed
            $model = new EventModel();
            $model->addEvent($eventData);
            header('Location: ' . PROJECT_URL . '/admin/index?message=Event added successfully&status=success');
            exit();
        }
    }

    public function createVenue()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $venueData = [
                'name' => $this->sanitizeInput($_POST['name']),
                'capacity' => $this->sanitizeInput($_POST['capacity']),
            ];

            // Validate venue data
            $validationResult = $this->validateVenueData($venueData);
            if ($validationResult !== true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($validationResult) . '&status=error');
                exit();
            }

            // Save venue if validation is passed
            $model = new EventModel();
            $model->addVenue($venueData);
            header('Location: ' . PROJECT_URL . '/admin/index?message=Venue added successfully&status=success');
            exit();
        }
    }

    public function createUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'first_name' => $this->sanitizeInput($_POST['first_name']),
                'last_name' => $this->sanitizeInput($_POST['last_name']),
                'email' => $this->sanitizeInput($_POST['email']),
                'username' => $this->sanitizeInput($_POST['username']),
                'password' => $this->sanitizeInput($_POST['password']),
                'role_id' => $this->sanitizeInput($_POST['role_id']),
            ];

            // Validate user data
            $validationResult = $this->validateUserData($userData);
            if ($validationResult !== true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($validationResult) . '&status=error');
                exit();
            }

            // Save user if validation passes
            $model = new UserModel();
            $result = $model->registerUser($userData);

            if ($result === true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=User added successfully&status=success');
            } else {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($result) . '&status=error');
            }
            exit();
        }
    }

    public function deleteVenue($params = [])
    {
        $venueId = $params[0] ?? null;
        if ($venueId) {
            $model = new EventModel();
            try {
                $model->deleteVenue($venueId);
                header('Location: ' . PROJECT_URL . '/admin/index?message=Venue deleted successfully&status=success');
            } catch (Exception $e) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($e->getMessage()) . '&status=error');
            }
            exit();
        }
    }

    public function editEvent($params = [])
    {
        $eventId = $params[0] ?? null;
        if ($eventId && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $eventData = [
                'event_id' => $eventId,
                'name' => $this->sanitizeInput($_POST['name']),
                'start_date' => $this->sanitizeInput($_POST['start_date']),
                'end_date' => $this->sanitizeInput($_POST['end_date']),
                'allowed_number' => $this->sanitizeInput($_POST['allowed_number']),
                'venue_id' => $this->sanitizeInput($_POST['venue_id']),
            ];

            // Validate event data
            $validationResult = $this->validateEventData($eventData);
            if ($validationResult !== true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($validationResult) . '&status=error');
                exit();
            }

            // Update event if validation is passed
            $model = new EventModel();
            $model->updateEvent($eventData);
            header('Location: ' . PROJECT_URL . '/admin/index?message=Event updated successfully&status=success');
            exit();
        }
    }

    public function deleteUser($params = [])
    {
        $userId = $params[0] ?? null;
        if ($userId) {
            $model = new UserModel();
            try {
                $model->deleteUser($userId);
                header('Location: ' . PROJECT_URL . '/admin/index?message=User deleted successfully&status=success');
            } catch (Exception $e) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($e->getMessage()) . '&status=error');
            }
            exit();
        }
    }

    public function editVenue($params = [])
    {
        $venueId = $params[0] ?? null;
        if ($venueId && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $venueData = [
                'venue_id' => $venueId,
                'name' => $this->sanitizeInput($_POST['name']),
                'capacity' => $this->sanitizeInput($_POST['capacity']),
            ];

            // Validate venue data
            $validationResult = $this->validateVenueData($venueData);
            if ($validationResult !== true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($validationResult) . '&status=error');
                exit();
            }

            // Update venue if validation is passed
            $model = new EventModel();
            $model->updateVenue($venueData);
            header('Location: ' . PROJECT_URL . '/admin/index?message=Venue updated successfully&status=success');
            exit();
        }
    }

    public function editUser($params = [])
    {
        $userId = $params[0] ?? null;
        if ($userId && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'user_id' => $userId,
                'first_name' => $this->sanitizeInput($_POST['first_name']),
                'last_name' => $this->sanitizeInput($_POST['last_name']),
                'email' => $this->sanitizeInput($_POST['email']),
                'username' => $this->sanitizeInput($_POST['username']),
                'role_id' => $this->sanitizeInput($_POST['role_id']),
            ];

            // Validate user data
            $validationResult = $this->validateUserData($userData);
            if ($validationResult !== true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($validationResult) . '&status=error');
                exit();
            }

            // Update user if validation passes
            $model = new UserModel();
            $result = $model->updateUser($userData);

            if ($result === true) {
                header('Location: ' . PROJECT_URL . '/admin/index?message=User updated successfully&status=success');
            } else {
                header('Location: ' . PROJECT_URL . '/admin/index?message=' . urlencode($result) . '&status=error');
            }
            exit();
        }
    }
}
