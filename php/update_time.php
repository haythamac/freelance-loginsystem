<?php
include_once('connection.php');
session_start();

date_default_timezone_set('Asia/Singapore');

// Get student ID from session
$student_id = $_SESSION['student_id'];
$current_time = date("Y-m-d H:i:s");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] === 'in') {
        // Prepare and bind SQL statement
        $sql = "INSERT INTO student_attendance (student_id, time_in) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $student_id, $current_time);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Time in recorded successfully";
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } elseif ($_POST['action'] === 'out') {
        // Prepare and bind SQL statement
        $sql = "INSERT INTO student_attendance (student_id, time_out) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $student_id, $current_time);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Time out recorded successfully";
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}
?>
