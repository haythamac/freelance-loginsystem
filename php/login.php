<?php
include_once('connection.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM student WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("ss", $email, $password);

    // Execute SQL statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch the row as an associative array
            echo "Logged in successfully";
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['student_id'] = $row['id']; // Access id from the fetched row
            echo $row['id']; // Echoing the id for testing
            header('location: ../');
        } else {
            echo "<script> alert('Wrong username or password'); history.go(-1);</script>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}


