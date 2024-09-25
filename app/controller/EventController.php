<?php

class EventController extends Controller
{

    public function index()
    {
        // Fetch mock data from the model
        $data = $this->model()->getEvents();
        // Pass the data to the 'events' view
        $this->view('event/events', ['events' => $data]);
    }
}
