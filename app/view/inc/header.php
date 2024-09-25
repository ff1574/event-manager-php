<!DOCTYPE html>
<html>

<head>
    <title><?php echo TITLE; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo PROJECT_URL; ?>/public/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo PROJECT_URL; ?>/public/css/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo PROJECT_URL; ?>/public/css/events.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo PROJECT_URL; ?>/public/css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <header>
        <h1>Venue Management</h1>

        <?php
        // Show the navigation bar only if the URL postfix is not exactly '/Index.php'
        $currentUri = str_replace(BASE_PATH, '', $_SERVER['REQUEST_URI']);
        if (!($currentUri === '/')) {
        ?>
            <nav>
                <a href="<?php echo PROJECT_URL; ?>/event/index">Events</a>
                <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) { ?>
                    | <a href="<?php echo PROJECT_URL; ?>/admin/index">Admin</a>
                <?php } ?>
                | <a href="<?php echo PROJECT_URL; ?>/user/logout">Sign Out</a>
            </nav>
        <?php
        }
        ?>
    </header>