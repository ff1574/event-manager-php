<div class="events-list">
    <h2>Upcoming Events</h2>

    <?php
    $events = $data['events'];

    if (!empty($events)) { ?>
        <div class="events-grid">
            <?php foreach ($events as $event) { ?>
                <div class="event-card">
                    <h3 class="event-title"><?php echo $event['name']; ?></h3>
                    <p><strong>Start:</strong> <?php echo date('M d, Y H:i', strtotime($event['start_date'])); ?></p>
                    <p><strong>End:</strong> <?php echo date('M d, Y H:i', strtotime($event['end_date'])); ?></p>
                    <p><strong>Attendees:</strong> <?php echo $event['allowed_number']; ?></p>
                    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
                    <button>Register</button>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No upcoming events available at this time.</p>
    <?php } ?>
</div>