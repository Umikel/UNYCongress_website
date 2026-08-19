<?php
// Include database connection
require '../config.php';
session_start(); // Start the session

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Update event status to done
    $sql = "UPDATE events SET status = 'done' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    if ($stmt->execute()) {
          // Redirect to dashboard
          header("Location: view_event.php");
          exit;
    } else {
        echo "No event ID provided.";
    }
} else {
    echo "No event ID provided.";
}
