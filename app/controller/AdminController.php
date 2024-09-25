<?php

class AdminController extends Controller
{
    public function index()
    {
        // Load the EventModel to fetch the data from the database
        $model = new EventModel();

        // Fetch all venues and events from the database
        $venues = $model->getAllVenues();
        $events = $model->getEvents();

        // Pass the data to the admin view
        $this->view('admin/admin', ['venues' => $venues, 'events' => $events]);
    }
}
