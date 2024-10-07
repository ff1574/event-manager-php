<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo TITLE; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo PROJECT_URL; ?>/public/css/modern-ui.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <header>
        <div class="container">
            <h1>Venue Management</h1>

            <?php
            $currentUri = str_replace(BASE_PATH, '', $_SERVER['REQUEST_URI']);
            if (!($currentUri === '/' || $currentUri === '/Index.php' || $currentUri === '/user/register')) {
            ?>
                <nav>
                    <a href="<?php echo PROJECT_URL; ?>/event/index">Events</a>
                    <?php if (Session::get('isAdmin')) { ?>
                        <a href="<?php echo PROJECT_URL; ?>/admin/index">Admin</a>
                    <?php } ?>
                    <a href="<?php echo PROJECT_URL; ?>/user/logout">Sign Out</a>
                </nav>
            <?php
            }
            ?>

        </div>
    </header>
    <main class="container">

        <!-- Display Messages -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert <?php echo $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>