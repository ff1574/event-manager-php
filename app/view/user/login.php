<div class="card fade-in login-form">
    <div class="avatar-container">
        <img src="<?php echo PROJECT_URL; ?>/public/img/avatar.png" alt="Avatar" class="avatar">
    </div>
    <form method="POST" action="<?php echo PROJECT_URL; ?>/user/welcome" class="login-form-body">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
</div>