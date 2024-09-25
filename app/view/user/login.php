<form method="POST" action="<?php echo PROJECT_URL; ?>/user/welcome">
    <div class="imgcontainer">
        <img src="<?php echo PROJECT_URL; ?>/public/img/avatar.png" alt="Avatar" class="avatar">
    </div>
    <div class="container">
        <form method="POST" action="<?php echo PROJECT_URL; ?>/user/welcome">
            <div class="container">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <button type="submit">Login</button>
            </div>
        </form>

    </div>
</form>