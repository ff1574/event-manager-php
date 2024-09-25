<?php
$events = $data['events'];
$venues = $data['venues'];
?>

<h2>Manage Venues</h2>

<div class="venues-grid">
    <?php foreach ($venues as $venue) { ?>
        <div class="venue-card">
            <h3 class="venue-name"><?php echo $venue['name']; ?></h3>
            <p><strong>Capacity:</strong> <?php echo $venue['capacity']; ?></p>

            <div class="venue-actions">
                <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=editVenue"
                    style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                    <button type="submit" name="edit">Edit</button>
                </form>
                <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=deleteVenue"
                    style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=addVenue"
    class="add-venue-form">
    <input type="text" name="name" placeholder="Venue Name" required>
    <input type="number" name="capacity" placeholder="Capacity" required>
    <button type="submit" name="add">Add Venue</button>
</form>

<h2>Manage Events</h2>

<div class="events-grid">
    <?php foreach ($events as $event) { ?>
        <div class="event-card">
            <h3 class="event-title"><?php echo $event['name']; ?></h3>
            <p><strong>Start Date:</strong> <?php echo $event['start_date']; ?></p>
            <p><strong>End Date:</strong> <?php echo $event['end_date']; ?></p>
            <p><strong>Allowed Attendees:</strong> <?php echo $event['allowed_number']; ?></p>
            <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>

            <!-- Clickable registered attendees -->
            <p>
                <strong>Registered Attendees:</strong>
                <a href="javascript:void(0);" onclick="toggleAttendees(<?php echo $event['event_id']; ?>)">
                    <?php echo count($event['attendees']); ?>
                </a>
            </p>

            <!-- Attendees list (initially hidden) -->
            <div id="attendees-<?php echo $event['event_id']; ?>" class="attendees-list" style="display:none;">
                <?php if (!empty($event['attendees'])) { ?>
                    <ul>
                        <?php foreach ($event['attendees'] as $attendee) { ?>
                            <li>
                                <?php echo $attendee['first_name'] . ' ' . $attendee['last_name']; ?>
                                (<?php echo $attendee['email']; ?>) -
                                <?php echo $attendee['paid'] ? 'Paid' : 'Not Paid'; ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No attendees registered yet.</p>
                <?php } ?>
            </div>

            <div class="event-actions">
                <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=editEvent"
                    style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit" name="edit">Edit</button>
                </form>
                <form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=deleteEvent"
                    style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<form method="POST" action="<?php echo PROJECT_URL; ?>/Index.php?controller=admin&action=addEvent"
    class="add-event-form">
    <input type="text" name="name" placeholder="Event Name" required>
    <input type="datetime-local" name="start_date" placeholder="Start Date" required>
    <input type="datetime-local" name="end_date" placeholder="End Date" required>
    <input type="number" name="allowed_number" placeholder="Allowed Number of Attendees" required>
    <select name="venue_id" required>
        <option value="">Select Venue</option>
        <?php foreach ($venues as $venue) { ?>
            <option value="<?php echo $venue['venue_id']; ?>"><?php echo $venue['name']; ?></option>
        <?php } ?>
    </select>
    <button type="submit" name="add">Add Event</button>
</form>

<script>
    function toggleAttendees(eventId) {
        const attendeesDiv = document.getElementById('attendees-' + eventId);
        if (attendeesDiv.style.display === 'none') {
            attendeesDiv.style.display = 'block';
        } else {
            attendeesDiv.style.display = 'none';
        }
    }
</script>