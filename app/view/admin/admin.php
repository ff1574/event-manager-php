<?php
$events = $data['events'];
$venues = $data['venues'];
$users = $data['users'];
?>

<div class="fade-in">

    <!-- Navigation Menu -->
    <div class="admin-nav">
        <a href="javascript:void(0);" id="events-tab" class="active">Manage Events</a>
        <a href="javascript:void(0);" id="venues-tab">Manage Venues</a>
        <a href="javascript:void(0);" id="users-tab">Manage Users</a>
    </div>

    <!-- Toggle View Switch -->
    <div class="toggle-view">
        <span class="view-label">Card View</span>
        <label class="switch">
            <input type="checkbox" id="view-switch">
            <span class="slider"></span>
        </label>
        <span class="view-label">Table View</span>
    </div>

    <!-- New Event Form (Initially Hidden) -->
    <div id="new-event-form" class="edit-form hidden">
        <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/createEvent" class="card">
            <h3>Add New Event</h3>
            <div class="form-group">
                <label for="new-event-name">Event Name</label>
                <input type="text" id="new-event-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="new-event-start">Start Date</label>
                <input type="datetime-local" id="new-event-start" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="new-event-end">End Date</label>
                <input type="datetime-local" id="new-event-end" name="end_date" required>
            </div>
            <div class="form-group">
                <label for="new-event-allowed">Allowed Attendees</label>
                <input type="number" id="new-event-allowed" name="allowed_number" required>
            </div>
            <div class="form-group">
                <label for="new-event-venue">Venue</label>
                <select id="new-event-venue" name="venue_id" required>
                    <?php foreach ($venues as $venue) { ?>
                        <option value="<?php echo $venue['venue_id']; ?>"><?php echo $venue['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Add Event</button>
                <button type="button" class="btn btn-danger" onclick="hideAddForm('event')">Cancel</button>
            </div>
        </form>
    </div>

    <!-- New Venue Form (Initially Hidden) -->
    <div id="new-venue-form" class="edit-form hidden">
        <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/createVenue" class="card">
            <h3>Add New Venue</h3>
            <div class="form-group">
                <label for="new-venue-name">Venue Name</label>
                <input type="text" id="new-venue-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="new-venue-capacity">Capacity</label>
                <input type="number" id="new-venue-capacity" name="capacity" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Add Venue</button>
                <button type="button" class="btn btn-danger" onclick="hideAddForm('venue')">Cancel</button>
            </div>
        </form>
    </div>

    <!-- New User Form (Initially Hidden) -->
    <div id="new-user-form" class="edit-form hidden">
        <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/createUser" class="card">
            <h3>Add New User</h3>
            <div class="form-group">
                <label for="new-user-first-name">First Name</label>
                <input type="text" id="new-user-first-name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="new-user-last-name">Last Name</label>
                <input type="text" id="new-user-last-name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="new-user-email">Email</label>
                <input type="email" id="new-user-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="new-user-username">Username</label>
                <input type="text" id="new-user-username" name="username" required>
            </div>
            <div class="form-group">
                <label for="new-user-password">Password</label>
                <input type="password" id="new-user-password" name="password" required>
            </div>
            <div class="form-group">
                <label for="new-user-role">Role</label>
                <select id="new-user-role" name="role_id" required>
                    <option value="1">Admin</option>
                    <option value="2">Attendee</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Add User</button>
                <button type="button" class="btn btn-danger" onclick="hideAddForm('user')">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Edit Forms for Events (Initially Hidden) -->
    <?php foreach ($events as $event) { ?>
        <div id="edit-event-<?php echo $event['event_id']; ?>" class="edit-form hidden">
            <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/editEvent/<?php echo $event['event_id']; ?>" class="card">
                <h3>Edit Event: <?php echo $event['name']; ?></h3>
                <div class="form-group">
                    <label for="event-name-<?php echo $event['event_id']; ?>">Event Name</label>
                    <input type="text" id="event-name-<?php echo $event['event_id']; ?>" name="name" value="<?php echo $event['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="event-start-<?php echo $event['event_id']; ?>">Start Date</label>
                    <input type="datetime-local" id="event-start-<?php echo $event['event_id']; ?>" name="start_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>" required>
                </div>
                <div class="form-group">
                    <label for="event-end-<?php echo $event['event_id']; ?>">End Date</label>
                    <input type="datetime-local" id="event-end-<?php echo $event['event_id']; ?>" name="end_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>" required>
                </div>
                <div class="form-group">
                    <label for="event-allowed-<?php echo $event['event_id']; ?>">Allowed Attendees</label>
                    <input type="number" id="event-allowed-<?php echo $event['event_id']; ?>" name="allowed_number" value="<?php echo $event['allowed_number']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="event-venue-<?php echo $event['event_id']; ?>">Venue</label>
                    <select id="event-venue-<?php echo $event['event_id']; ?>" name="venue_id" required>
                        <?php foreach ($venues as $venue) { ?>
                            <option value="<?php echo $venue['venue_id']; ?>" <?php echo $venue['venue_id'] == $event['venue_id'] ? 'selected' : ''; ?>>
                                <?php echo $venue['name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-danger" onclick="hideEditForm('event', <?php echo $event['event_id']; ?>)">Cancel</button>
                </div>
            </form>
        </div>
    <?php } ?>

    <!-- Edit Forms for Venues (Initially Hidden) -->
    <?php foreach ($venues as $venue) { ?>
        <div id="edit-venue-<?php echo $venue['venue_id']; ?>" class="edit-form hidden">
            <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/editVenue/<?php echo $venue['venue_id']; ?>" class="card">
                <h3>Edit Venue: <?php echo $venue['name']; ?></h3>
                <div class="form-group">
                    <label for="venue-name-<?php echo $venue['venue_id']; ?>">Venue Name</label>
                    <input type="text" id="venue-name-<?php echo $venue['venue_id']; ?>" name="name" value="<?php echo $venue['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="venue-capacity-<?php echo $venue['venue_id']; ?>">Capacity</label>
                    <input type="number" id="venue-capacity-<?php echo $venue['venue_id']; ?>" name="capacity" value="<?php echo $venue['capacity']; ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-danger" onclick="hideEditForm('venue', <?php echo $venue['venue_id']; ?>)">Cancel</button>
                </div>
            </form>
        </div>
    <?php } ?>

    <!-- Edit Forms for Users (Initially Hidden) -->
    <?php foreach ($users as $user) { ?>
        <div id="edit-user-<?php echo $user['attendee_id']; ?>" class="edit-form hidden">
            <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/editUser/<?php echo $user['attendee_id']; ?>" class="card">
                <h3>Edit User: <?php echo $user['username']; ?></h3>
                <div class="form-group">
                    <label for="user-first-name-<?php echo $user['attendee_id']; ?>">First Name</label>
                    <input type="text" id="user-first-name-<?php echo $user['attendee_id']; ?>" name="first_name" value="<?php echo $user['first_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="user-last-name-<?php echo $user['attendee_id']; ?>">Last Name</label>
                    <input type="text" id="user-last-name-<?php echo $user['attendee_id']; ?>" name="last_name" value="<?php echo $user['last_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="user-email-<?php echo $user['attendee_id']; ?>">Email</label>
                    <input type="email" id="user-email-<?php echo $user['attendee_id']; ?>" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="user-username-<?php echo $user['attendee_id']; ?>">Username</label>
                    <input type="text" id="user-username-<?php echo $user['attendee_id']; ?>" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="user-role-<?php echo $user['attendee_id']; ?>">Role</label>
                    <select id="user-role-<?php echo $user['attendee_id']; ?>" name="role_id" required>
                        <option value="1" <?php echo $user['role_id'] == 1 ? 'selected' : ''; ?>>Admin</option>
                        <option value="2" <?php echo $user['role_id'] == 2 ? 'selected' : ''; ?>>Attendee</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-danger" onclick="hideEditForm('user', <?php echo $user['attendee_id']; ?>)">Cancel</button>
                </div>
            </form>
        </div>
    <?php } ?>

    <!-- Events Section -->
    <section id="events-section" class="section-content">

        <div class="fade-in section-container">
            <h2 class="section-title">Manage Events</h2>
            <!-- Add New Event Button -->
            <button class="btn btn-success" onclick="showAddForm('event')">Add New Event</button>
        </div>

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
                    <div class="attendees-section">
                        <p><strong>Number of Attendees:</strong>
                            <a href="javascript:void(0);" onclick="toggleAttendeeList(<?php echo $event['event_id']; ?>)"><?php echo count($event['attendees']); ?></a>
                        </p>
                        <div id="attendees-list-<?php echo $event['event_id']; ?>" class="attendees-list hidden">
                            <ul>
                                <?php foreach ($event['attendees'] as $attendee) { ?>
                                    <li>
                                        <?php echo htmlspecialchars($attendee['first_name'] . ' ' . $attendee['last_name'] . ' (' . $attendee['email'] . ')'); ?>
                                        <?php echo $attendee['paid'] ? '<span class="text-success"> (Paid)</span>' : '<span class="text-danger"> (Not Paid)</span>'; ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="flex space-between">
                        <button class="btn btn-primary" onclick="showEditForm('event', <?php echo $event['event_id']; ?>)">Edit</button>
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/deleteEvent/<?php echo $event['event_id']; ?>" style="display:inline;" onsubmit="return confirmDelete('event');">
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
                        <th>Attendees</th>
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
                            <td><?php echo count($event['attendees']); ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="showEditForm('event', <?php echo $event['event_id']; ?>)">Edit</button>
                                <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/deleteEvent/<?php echo $event['event_id']; ?>" style="display:inline;" onsubmit="return confirmDelete('event');">
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

        <div class="fade-in section-container">
            <h2 class="section-title">Manage Venues</h2>
            <!-- Add New Venue Button -->
            <button class="btn btn-success" onclick="showAddForm('venue')">Add New Venue</button>
        </div>

        <!-- Card View for Venues -->
        <div id="venues-card-view" class="card-view grid grid-3">
            <?php foreach ($venues as $venue) { ?>
                <div class="card slide-in">
                    <h3><?php echo $venue['name']; ?></h3>
                    <p><strong>Venue ID:</strong> <?php echo $venue['venue_id']; ?></p>
                    <p><strong>Capacity:</strong> <?php echo $venue['capacity']; ?></p>

                    <div class="flex space-between">
                        <button class="btn btn-primary" onclick="showEditForm('venue', <?php echo $venue['venue_id']; ?>)">Edit</button>
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/deleteVenue/<?php echo $venue['venue_id']; ?>" style="display:inline;" onsubmit="return confirmDelete('venue');">
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
                                <button class="btn btn-primary" onclick="showEditForm('venue', <?php echo $venue['venue_id']; ?>)">Edit</button>
                                <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/deleteVenue/<?php echo $venue['venue_id']; ?>" style="display:inline;" onsubmit="return confirmDelete('venue');">
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

    <!-- Users Section -->
    <section id="users-section" class="section-content hidden">
        <div class="fade-in section-container">
            <h2 class="section-title">Manage Users</h2>
            <!-- Add New User Button -->
            <button class="btn btn-success" onclick="showAddForm('user')">Add New User</button>
        </div>

        <!-- Card View for Users -->
        <div id="users-card-view" class="card-view grid grid-3">
            <?php foreach ($users as $user) { ?>
                <div class="card slide-in">
                    <div class="user-profile">
                        <img src="https://avatar.iran.liara.run/public?username=[<?php echo $user['username'] ?>]" alt="User Profile Picture" class="user-avatar">
                    </div>
                    <h3><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h3>
                    <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    <p><strong>Role:</strong>
                        <span class="<?php echo $user['role_name'] === 'admin' ? 'text-danger' : ''; ?>">
                            <?php echo htmlspecialchars($user['role_name']); ?>
                        </span>
                    </p>
                    <div class="flex space-between">
                        <button class="btn btn-primary" onclick="showEditForm('user', <?php echo $user['user_id']; ?>)">Edit</button>
                        <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/index/deleteUser/<?php echo $user['user_id']; ?>" style="display:inline;" onsubmit="return confirmDelete('user');">
                            <input type="hidden" name="id" value="<?php echo $user['user_id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

            <?php } ?>
        </div>

        <!-- Table View for Users (Initially Hidden) -->
        <div id="users-table-view" class="hidden table-view">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user['attendee_id']; ?></td>
                            <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="<?php echo $user['role_name'] === 'admin' ? 'text-danger' : ''; ?>">
                                <?php echo htmlspecialchars($user['role_name']); ?>
                            </td>
                            <td>
                                <button class="btn btn-primary" onclick="showEditForm('user', <?php echo $user['attendee_id']; ?>)">Edit</button>
                                <form method="POST" action="<?php echo PROJECT_URL; ?>/admin/deleteUser/<?php echo $user['attendee_id']; ?>" style="display:inline;" onsubmit="return confirmDelete('user');">
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

<script src="<?php echo PROJECT_URL; ?>/public/js/admin.js"></script>