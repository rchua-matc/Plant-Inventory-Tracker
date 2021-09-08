<?php
    session_start();
    // If the user is logged in, delete session variables to log them out
    if (isset($_SESSION['user_id']))
    {
        $_SESSION = array();

        // Delete any session cookies
        if (isset($COOKIE[session_name()]))
        {
            setcookie(session_name(), '', time() - 3600);
        }

        session_destroy();
    }

    // Delete the user ID and username cookies
    setcookie('user_id', '', time() - 3600);
    setcookie('username', '', time() - 3600);

    // Redirect to the home page
    $home_url = 'http://' . $_SERVER['HTTP_HOST']
            . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Location: ' . $home_url);
?>
