<section class="fade-in hero">
    <div class="container">
        <h2>Organize Your Events with Ease</h2>
        <p>Event Manager is your all-in-one solution for planning, managing, and executing successful events. From small gatherings to large conferences, we've got you covered.</p>
        <a href="#login-form" class="btn btn-primary">Get Started</a>
    </div>
</section>

<section id="features" class="card fade-in features">
    <div class="container">
        <h3>Why Choose Event Manager?</h3>
        <div class="feature-grid">
            <div class="feature-item">
                <img src="<?php echo PROJECT_URL; ?>/public/img/calendar.png" alt="Calendar Icon">
                <h4>Easy Scheduling</h4>
                <p>Effortlessly plan and schedule your events with our intuitive calendar interface.</p>
            </div>
            <div class="feature-item">
                <img src="<?php echo PROJECT_URL; ?>/public/img/attendees.png" alt="Attendees Icon">
                <h4>Attendee Management</h4>
                <p>Keep track of your guests, send invitations, and manage RSVPs all in one place.</p>
            </div>
            <div class="feature-item">
                <img src="<?php echo PROJECT_URL; ?>/public/img/analytics.png" alt="Analytics Icon">
                <h4>Insightful Analytics</h4>
                <p>Gain valuable insights into your events with detailed analytics and reporting.</p>
            </div>
        </div>
    </div>
</section>

<div id="login-form" class="card fade-in login-form">
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
    <p class="text-center">
        Don't have an account? <a href="<?php echo PROJECT_URL; ?>/user/register">Register here</a>
    </p>
</div>

<script src="<?php echo PROJECT_URL; ?>/public/js/login.js"></script>