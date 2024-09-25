<?php

class UserController extends Controller
{

    public function login($params = [])
    {
        $this->view("user/login");
    }

    public function logout()
    {
        // Destroy the session
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . PROJECT_URL . '');
        exit();
    }


    public function welcome()
    {
        $data = $this->model()->getViewModel();
        if ($data) {

            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['isAdmin'] = $data['isAdmin'];

            // Redirect based on admin status
            if ($_SESSION['isAdmin']) {
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
