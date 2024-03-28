<?php
include_once('connection.php');


$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$birthdate = date("Y-m-d", strtotime($_POST["birthdate"]));
$password = $_POST['password'];
$course = $_POST['course'];
$section = $_POST['section'];


echo $firstName;    
echo $lastName;
echo $email;
echo $mobile;
echo $gender;
echo $birthdate;
echo $password;
echo "<br/>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // $firstName = $_POST['firstName'];
    // $lastName = $_POST['lastName'];
    // Add other form fields as needed

    // Prepare and bind SQL statement
    $sql = "INSERT INTO student (first_name, last_name, email, phone_number, gender, birth_date, password, course, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $mobile, $gender, $birthdate, $password, $course, $section);
    // Bind other parameters as needed

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

$sql = "SELECT * FROM student";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row["id"]} - Name: {$row["first_name"]} {$row["last_name"]} Email: {$row["email"]} Phone: {$row["phone_number"]} Gender: {$row["gender"]} Birthday: {$row["birth_date"]} Course: {$row["course"]} Section: {$row["section"]}<br>";
    }
} else {
    echo "haha0 haharesults";
}

// Close connection
$conn->close();

header('location: ../html/login.html');
?>