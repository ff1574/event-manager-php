<?php
$events = $data['events'];
$venues = $data['venues'];
?>

<div class="fade-in">
    <section>
        <h2 class="section-title">Manage Venues</h2>

        <div class="grid grid-3">
            <?php foreach ($venues as $venue) { ?>
                <div class="card slide-in">
                    <h3><?php echo $venue['name']; ?></h3>
                    <p><strong>Capacity:</strong> <?php echo $venue['capacity']; ?></p>

                    <div class="flex space-between">
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=editVenue">
                            <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                        </form>
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=deleteVenue">
                            <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

        <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=addVenue" class="card">
            <div class="grid grid-2">
                <input type="text" name="name" placeholder="Venue Name" required>
                <input type="number" name="capacity" placeholder="Capacity" required>
            </div>
            <button type="submit" name="add" class="btn btn-success">Add Venue</button>
        </form>
    </section>

    <section>
        <h2 class="section-title">Manage Events</h2>

        <?php foreach ($events as $event) { ?>
            <div class="card slide-in">
                <h3><?php echo $event['name']; ?></h3>
                <p><strong>Start Date:</strong> <?php echo $event['start_date']; ?></p>
                <p><strong>End Date:</strong> <?php echo $event['end_date']; ?></p>
                <p><strong>Allowed Attendees:</strong> <?php echo $event['allowed_number']; ?></p>
                <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>

                <p>
                    <strong>Registered Attendees:</strong>
                    <a href="javascript:void(0);" onclick="toggleAttendees(<?php echo $event['event_id']; ?>)">
                        <?php echo count($event['attendees']); ?>
                    </a>
                </p>

                <div id="attendees-<?php echo $event['event_id']; ?>" class="attendees-list hidden">
                    <?php if (!empty($event['attendees'])) { ?>
                        <ul>
                            <?php foreach ($event['attendees'] as $attendee) { ?>
                                <li>
                                    <?php echo $attendee['first_name'] . ' ' . $attendee['last_name']; ?>
                                    (<?php echo $attendee['email']; ?>) -
                                    <span class="<?php echo $attendee['paid'] ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo $attendee['paid'] ? 'Paid' : 'Not Paid'; ?>
                                    </span>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p>No attendees registered yet.</p>
                    <?php } ?>
                </div>

                <div class="flex space-between">
                    <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=editEvent">
                        <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                        <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                    </form>
                    <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=deleteEvent">
                        <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        <?php } ?>

        <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=addEvent" class="card">
            <div class="grid grid-2">
                <input type="text" name="name" placeholder="Event Name" required>
                <input type="datetime-local" name="start_date" required>
                <input type="datetime-local" name="end_date" required>
                <input type="number" name="allowed_number" placeholder="Allowed Number of Attendees" required>
                <select name="venue_id" required>
                    <option value="">Select Venue</option>
                    <?php foreach ($venues as $venue) { ?>
                        <option value="<?php echo $venue['venue_id']; ?>"><?php echo $venue['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" name="add" class="btn btn-success">Add Event</button>
        </form>
    </section>
</div>

<script>
    function toggleAttendees(eventId) {
        const attendeesDiv = document.getElementById('attendees-' + eventId);
        if (attendeesDiv.classList.contains('hidden')) {
            attendeesDiv.classList.remove('hidden');
            attendeesDiv.classList.add('fade-in');
        } else {
            attendeesDiv.classList.add('hidden');
            attendeesDiv.classList.remove('fade-in');
        }
    }
</script>