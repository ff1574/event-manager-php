<div class="fade-in">
    <h2 class="section-title">Upcoming Events</h2>

    <?php
    $events = $data['events'];

    if (!empty($events)) { ?>
        <div class="grid grid-3">
            <?php foreach ($events as $event) { ?>
                <div class="card slide-in">
                    <h3><?php echo $event['name']; ?></h3>
                    <p><strong>Start:</strong> <?php echo date('M d, Y H:i', strtotime($event['start_date'])); ?></p>
                    <p><strong>End:</strong> <?php echo date('M d, Y H:i', strtotime($event['end_date'])); ?></p>
                    <p><strong>Attendees:</strong> <?php echo $event['allowed_number']; ?></p>
                    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
                    <button class="btn btn-primary">Register</button>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No upcoming events available at this time.</p>
    <?php } ?>
</div>