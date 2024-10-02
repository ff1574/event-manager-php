<?php
$events = $data['events'];
$venues = $data['venues'];
?>

<div class="fade-in">

    <!-- Navigation Menu -->
    <div class="admin-nav">
        <a href="javascript:void(0);" id="events-tab" class="active" onclick="showSection('events')">Manage Events</a>
        <a href="javascript:void(0);" id="venues-tab" onclick="showSection('venues')">Manage Venues</a>
    </div>

    <!-- Toggle View Switch -->
    <div class="toggle-view">
        <span class="view-label">Card View</span>
        <label class="switch">
            <input type="checkbox" id="view-switch" onclick="toggleView()">
            <span class="slider"></span>
        </label>
        <span class="view-label">Table View</span>
    </div>

    <!-- Events Section -->
    <section id="events-section" class="section-content">
        <h2 class="section-title">Manage Events</h2>

        <!-- Card View for Events -->
        <div id="events-card-view" class="card-view grid grid-2">
            <?php foreach ($events as $event) { ?>
                <div class="card slide-in">
                    <h3><?php echo $event['name']; ?></h3>
                    <p><strong>Event ID:</strong> <?php echo $event['event_id']; ?></p>
                    <p><strong>Start Date:</strong> <?php echo $event['start_date']; ?></p>
                    <p><strong>End Date:</strong> <?php echo $event['end_date']; ?></p>
                    <p><strong>Allowed Attendees:</strong> <?php echo $event['allowed_number']; ?></p>
                    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>

                    <div class="flex space-between">
                        <form method="POST" action="<?php echo PROJECT_URL;
                                                    echo "/admin/index/editEvent/" . $event['event_id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                        </form>
                        <form method="POST" action="<?php echo PROJECT_URL;
                                                    echo "/admin/index/deleteEvent/" . $event['event_id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Table View for Events (Initially Hidden) -->
        <div id="events-table-view" class="hidden table-view">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Allowed Attendees</th>
                        <th>Venue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event) { ?>
                        <tr>
                            <td><?php echo $event['event_id']; ?></td>
                            <td><?php echo $event['name']; ?></td>
                            <td><?php echo $event['start_date']; ?></td>
                            <td><?php echo $event['end_date']; ?></td>
                            <td><?php echo $event['allowed_number']; ?></td>
                            <td><?php echo $event['venue']; ?></td>
                            <td>
                                <form method="POST" action="<?php echo PROJECT_URL;
                                                            echo "/admin/index/editEvent/" . $event['event_id']; ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                </form>
                                <form method="POST" action="<?php echo PROJECT_URL;
                                                            echo "/admin/index/deleteEvent/" . $event['event_id']; ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Venues Section -->
    <section id="venues-section" class="section-content hidden">
        <h2 class="section-title">Manage Venues</h2>

        <!-- Card View for Venues -->
        <div id="venues-card-view" class="card-view grid grid-3">
            <?php foreach ($venues as $venue) { ?>
                <div class="card slide-in">
                    <h3><?php echo $venue['name']; ?></h3>
                    <p><strong>Venue ID:</strong> <?php echo $venue['venue_id']; ?></p>
                    <p><strong>Capacity:</strong> <?php echo $venue['capacity']; ?></p>

                    <div class="flex space-between">
                        <form method="POST" action="<?php echo PROJECT_URL;
                                                    echo "/admin/index/editVenue/" . $venue['venue_id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                            <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                        </form>
                        <form method="POST" action="<?php echo PROJECT_URL;
                                                    echo "/admin/index/deleteVenue/" . $venue['venue_id']; ?>">
                            <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Table View for Venues (Initially Hidden) -->
        <div id="venues-table-view" class="hidden table-view">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Venue ID</th>
                        <th>Venue Name</th>
                        <th>Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($venues as $venue) { ?>
                        <tr>
                            <td><?php echo $venue['venue_id']; ?></td>
                            <td><?php echo $venue['name']; ?></td>
                            <td><?php echo $venue['capacity']; ?></td>
                            <td>
                                <form method="POST" action="<?php echo PROJECT_URL;
                                                            echo "/admin/index/editVenue/" . $venue['venue_id']; ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                                    <button type="submit" name="edit" class="btn btn-primary">Edit</button>
                                </form>
                                <form method="POST" action="<?php echo PROJECT_URL;
                                                            echo "/admin/index/deleteVenue/" . $venue['venue_id']; ?>" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $venue['venue_id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    function showSection(section) {
        const eventsSection = document.getElementById('events-section');
        const venuesSection = document.getElementById('venues-section');
        const eventsTab = document.getElementById('events-tab');
        const venuesTab = document.getElementById('venues-tab');

        if (section === 'events') {
            eventsSection.classList.remove('hidden');
            venuesSection.classList.add('hidden');
            eventsTab.classList.add('active');
            venuesTab.classList.remove('active');
        } else {
            venuesSection.classList.remove('hidden');
            eventsSection.classList.add('hidden');
            venuesTab.classList.add('active');
            eventsTab.classList.remove('active');
        }
    }

    function toggleView() {
        const isTableView = document.getElementById('view-switch').checked;
        // Events View Toggle
        document.getElementById('events-card-view').classList.toggle('hidden', isTableView);
        document.getElementById('events-table-view').classList.toggle('hidden', !isTableView);
        // Venues View Toggle
        document.getElementById('venues-card-view').classList.toggle('hidden', isTableView);
        document.getElementById('venues-table-view').classList.toggle('hidden', !isTableView);
    }
</script>