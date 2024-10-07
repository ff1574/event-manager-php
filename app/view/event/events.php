<div class="fade-in">
    <h2 class="section-title">Upcoming Events</h2>

    <?php
    $upcomingEvents = $data['events']['upcoming'];
    $pastEvents = $data['events']['past'];

    if (!empty($upcomingEvents)) { ?>
        <div class="grid grid-3">
            <?php foreach ($upcomingEvents as $event) { ?>
                <div class="card slide-in">
                    <h3><?php echo $event['name']; ?></h3>
                    <p><strong>Start:</strong> <?php echo date('M d, Y H:i', strtotime($event['start_date'])); ?></p>
                    <p><strong>End:</strong> <?php echo date('M d, Y H:i', strtotime($event['end_date'])); ?></p>
                    <p><strong>Attendees Allowed:</strong> <?php echo $event['allowed_number']; ?></p>
                    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>

                    <!-- Register Button or Unregister Button -->
                    <?php if ($event['is_registered']) { ?>
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/event/unregister/<?php echo $event['event_id']; ?>" style="display:inline;" onsubmit="return confirmUnregister();">
                            <button type="submit" class="btn btn-unregister"></button>
                        </form>
                    <?php } else { ?>
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/event/register/<?php echo $event['event_id']; ?>" style="display:inline;">
                            <button type="submit" class="btn btn-primary btn-register">Register</button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No upcoming events available at this time.</p>
    <?php } ?>

    <h2 class="section-title">Past Events</h2>

    <?php if (!empty($pastEvents)) { ?>
        <div class="grid grid-3">
            <?php foreach ($pastEvents as $event) { ?>
                <div class="card slide-in">
                    <h3><?php echo $event['name']; ?></h3>
                    <p><strong>Start:</strong> <?php echo date('M d, Y H:i', strtotime($event['start_date'])); ?></p>
                    <p><strong>End:</strong> <?php echo date('M d, Y H:i', strtotime($event['end_date'])); ?></p>
                    <p><strong>Attendees Allowed:</strong> <?php echo $event['allowed_number']; ?></p>
                    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
                    <button class="btn btn-secondary" disabled>Event Passed</button>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No past events available at this time.</p>
    <?php } ?>
</div>

<script src="<?php echo PROJECT_URL; ?>/public/js/events.js"></script>