<?php
include_once('connection.php');
session_start();

// Get student ID from session
$student_id = $_SESSION['student_id'];

// Fetch student information and attendance records from the database
$sql = "SELECT student.first_name, student.last_name, student.course, student.section, student_attendance.time_in, student_attendance.time_out FROM student INNER JOIN student_attendance ON student.id = student_attendance.student_id WHERE student.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all rows as an associative array
$rows = $result->fetch_all(MYSQLI_ASSOC);

// Return data as JSON
echo json_encode($rows);
?>
