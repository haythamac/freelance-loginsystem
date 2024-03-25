<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_attendance";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}