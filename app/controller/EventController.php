<?php

class EventController extends Controller
{

    public function index()
    {
        // Fetch data from the model
        $userId = Session::get('user_id') ?? null;
        $data = $this->model()->getEventsForUser($userId);

        // Pass the data to the 'events' view
        $this->view('event/events', ['events' => $data]);
    }


    public function register($params = [])
    {
        if (!Session::get('username')) {
            header('Location: ' . PROJECT_URL . '/user/login?message=Please log in to register for an event.&status=error');
            exit();
        }

        $eventId = $params[0] ?? null;
        if ($eventId) {
            $userId = Session::get('user_id');
            $model = new EventModel();
            $result = $model->registerUserToEvent($userId, $eventId);

            if ($result === true) {
                header('Location: ' . PROJECT_URL . '/event/index?message=Successfully registered for the event.&status=success');
            } else {
                header('Location: ' . PROJECT_URL . '/event/index?message=' . urlencode($result) . '&status=error');
            }
            exit();
        }

        header('Location: ' . PROJECT_URL . '/event/index?message=Invalid event.&status=error');
        exit();
    }

    public function unregister($params = [])
    {
        if (!Session::get('username')) {
            header('Location: ' . PROJECT_URL . '/user/login?message=Please log in to unregister from an event.&status=error');
            exit();
        }

        $eventId = $params[0] ?? null;
        if ($eventId) {
            $userId = Session::get('user_id');
            $model = new EventModel();
            $result = $model->unregisterUserFromEvent($userId, $eventId);

            if ($result === true) {
                header('Location: ' . PROJECT_URL . '/event/index?message=Successfully unregistered from the event.&status=success');
            } else {
                header('Location: ' . PROJECT_URL . '/event/index?message=' . urlencode($result) . '&status=error');
            }
            exit();
        }

        header('Location: ' . PROJECT_URL . '/event/index?message=Invalid event.&status=error');
        exit();
    }
}
