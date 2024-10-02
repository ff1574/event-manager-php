<?php

class Session
{
    private static $sessionExpiryTime = 300; // (seconds)

    // Start the session
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the session has expired
        if (self::isExpired()) {
            self::destroy();
            header('Location: ' . PROJECT_URL . '/user/logout');
            exit();
        }

        // Update last activity timestamp to the current time
        self::set('last_activity', time());
    }

    // Set a session variable
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    // Get a session variable
    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Check if a session variable is set
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    // Unset a session variable
    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    // Destroy the session
    public static function destroy()
    {
        if (session_status() != PHP_SESSION_NONE) {
            session_unset();
            session_destroy();
        }
    }

    // Check if the session has expired
    public static function isExpired()
    {
        // If 'last_activity' is set, check how much time has passed
        if (self::has('last_activity')) {
            $inactiveTime = time() - self::get('last_activity');
            if ($inactiveTime > self::$sessionExpiryTime) {
                return true; // Session has expired
            }
        }
        return false; // Session is still active
    }
}
