<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect using JavaScript
echo "<script>
    alert('You have been logged out.');
    window.location.href = '../../sign-in/';
</script>";
?>
