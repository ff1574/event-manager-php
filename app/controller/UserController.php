<?php

class UserController extends Controller
{

    public function login($params = [])
    {
        $this->view("user/login");
    }

    public function logout()
    {
        Session::destroy();

        header('Location: ' . PROJECT_URL . '/Index.php');
        exit();
    }

    public function welcome()
    {
        $data = $this->model()->getViewModel();
        if ($data) {
            // Set session data using the Session class
            Session::set('user_id', $data['user_id']);
            Session::set('username', $data['username']);
            Session::set('email', $data['email']);
            Session::set('isAdmin', $data['isAdmin']);

            // Redirect based on admin status
            if (Session::get('isAdmin')) {
                header('Location: ' . PROJECT_URL . '/event/index&admin=true');
            } else {
                header('Location: ' . PROJECT_URL . '/event/index');
            }
            exit();
        } else {
            header('Location: ' . PROJECT_URL . '/Index.php');
            exit();
        }
    }

    // Display the registration form
    public function register($params = [])
    {
        $this->view("user/register");
    }

    // Handle registration form submission
    public function create($params = [])
    {
        $model = new UserModel();
        $result = $model->registerUser($_POST);

        if ($result === true) {
            // Check the role to determine where to redirect
            $roleId = $_POST['role_id'];
            if ($roleId == 1) {
                // Redirect to admin page if user registered as an admin
                header('Location: ' . PROJECT_URL . '/event/index&admin=true');
            } else {
                // Redirect to standard user event page
                header('Location: ' . PROJECT_URL . '/event/index');
            }
        } else {
            // Redirect back to the registration page with an error message
            header('Location: ' . PROJECT_URL . '/user/register');
        }
        exit();
    }
}
