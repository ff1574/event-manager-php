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
}
