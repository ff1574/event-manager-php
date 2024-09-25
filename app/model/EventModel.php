<?php

class EventModel extends Model
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllVenues()
    {
        $query = "SELECT * FROM venue";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEvents()
    {
        // Fetch all events along with venue names and attendee information
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
}
