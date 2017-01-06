<?php
/**
 * After passing basic authentication login,
 * set an admin cookie (expires one hour)
 * and send user back from where they came.
 */

// Determine return location
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'http://www.cubberleyballroom.com/calendar/';

// Set the admin cookie
setcookie("Calendar", "Admin", time()+3600, "/calendar/");

// Redirect back
header("Location: $referer");

