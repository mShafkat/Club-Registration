<?php
// Redirect to login if not authenticated
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}
?>