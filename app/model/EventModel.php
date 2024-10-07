<?php

class EventModel extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getVenueById($venueId)
    {
        $query = "SELECT * FROM venue WHERE venue_id = :venue_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':venue_id', $venueId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllVenues()
    {
        $query = "SELECT * FROM venue";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllEvents()
    {
        // Fetch all events along with venue names
        $query = "SELECT e.*, v.name AS venue 
              FROM event e
              INNER JOIN venue v ON e.venue_id = v.venue_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each event and add the attendees
        foreach ($events as &$event) {
            $event['attendees'] = $this->getAttendeesForEvent($event['event_id']);
        }

        return $events;
    }

    public function getEventsForUser($userId = null)
    {
        $events = $this->getAllEvents();
        $upcomingEvents = [];
        $pastEvents = [];

        // Split events into upcoming and past
        $currentDateTime = date('Y-m-d H:i:s');
        foreach ($events as &$event) {
            $event['is_registered'] = false;

            // Check if the user is already registered
            if ($userId) {
                $query = "SELECT * FROM attendee_event WHERE attendee_id = :attendee_id AND event_id = :event_id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':attendee_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':event_id', $event['event_id'], PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->fetch()) {
                    $event['is_registered'] = true;
                }
            }

            // Categorize as upcoming or past
            if ($event['end_date'] >= $currentDateTime) {
                $upcomingEvents[] = $event;
            } else {
                $pastEvents[] = $event;
            }
        }

        return [
            'upcoming' => $upcomingEvents,
            'past' => $pastEvents
        ];
    }


    public function getAttendeesForEvent($event_id)
    {
        $query = "SELECT a.first_name, a.last_name, a.email, ae.paid
                  FROM attendee a
                  INNER JOIN attendee_event ae ON a.attendee_id = ae.attendee_id
                  WHERE ae.event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoles()
    {
        $query = "SELECT * FROM role";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to register logged in user to event
    public function registerUserToEvent($userId, $eventId)
    {
        // Check if user is already registered for this event
        $query = "SELECT * FROM attendee_event WHERE attendee_id = :attendee_id AND event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':attendee_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch()) {
            return "User is already registered for this event.";
        }

        // Register the user for the event
        $query = "INSERT INTO attendee_event (attendee_id, event_id, paid) VALUES (:attendee_id, :event_id, 0)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':attendee_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return "Failed to register for the event.";
    }

    public function unregisterUserFromEvent($userId, $eventId)
    {
        // Check if the user is registered for the event
        $query = "SELECT * FROM attendee_event WHERE attendee_id = :attendee_id AND event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':attendee_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            return "User is not registered for this event.";
        }

        // Unregister the user from the event
        $query = "DELETE FROM attendee_event WHERE attendee_id = :attendee_id AND event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':attendee_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return "Failed to unregister from the event.";
    }

    public function addEvent($eventData)
    {
        $query = "INSERT INTO event (name, start_date, end_date, allowed_number, venue_id) 
              VALUES (:name, :start_date, :end_date, :allowed_number, :venue_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $eventData['name']);
        $stmt->bindParam(':start_date', $eventData['start_date']);
        $stmt->bindParam(':end_date', $eventData['end_date']);
        $stmt->bindParam(':allowed_number', $eventData['allowed_number']);
        $stmt->bindParam(':venue_id', $eventData['venue_id']);
        $stmt->execute();
    }

    public function addVenue($venueData)
    {
        $query = "INSERT INTO venue (name, capacity) VALUES (:name, :capacity)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $venueData['name']);
        $stmt->bindParam(':capacity', $venueData['capacity']);
        $stmt->execute();
    }

    public function deleteEvent($eventId)
    {
        $query = "DELETE FROM event WHERE event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteVenue($venueId)
    {
        $query = "DELETE FROM venue WHERE venue_id = :venue_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':venue_id', $venueId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateEvent($eventData)
    {
        $query = "UPDATE event SET name = :name, start_date = :start_date, end_date = :end_date, allowed_number = :allowed_number, venue_id = :venue_id WHERE event_id = :event_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $eventData['name']);
        $stmt->bindParam(':start_date', $eventData['start_date']);
        $stmt->bindParam(':end_date', $eventData['end_date']);
        $stmt->bindParam(':allowed_number', $eventData['allowed_number']);
        $stmt->bindParam(':venue_id', $eventData['venue_id']);
        $stmt->bindParam(':event_id', $eventData['event_id'], PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateVenue($venueData)
    {
        $query = "UPDATE venue SET name = :name, capacity = :capacity WHERE venue_id = :venue_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $venueData['name']);
        $stmt->bindParam(':capacity', $venueData['capacity']);
        $stmt->bindParam(':venue_id', $venueData['venue_id'], PDO::PARAM_INT);
        $stmt->execute();
    }
}
