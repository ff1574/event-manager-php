<div class="card fade-in register-form">
    <div class="avatar-container">
        <img src="<?php echo PROJECT_URL; ?>/public/img/avatar.png" alt="Avatar" class="avatar">
    </div>
    <form method="POST" action="<?php echo PROJECT_URL; ?>/user/create" class="register-form-body">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role_id" required>
                <option value="2">Attendee</option>
                <option value="1">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Register</button>
    </form>
</div>