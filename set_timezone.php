<?php
session_start();

if (isset($_POST['timezone'])) {
    $_SESSION['user_timezone'] = $_POST['timezone'];
    echo "Timezone set to: " . $_SESSION['user_timezone'];
} else {
    echo "No timezone received";
}