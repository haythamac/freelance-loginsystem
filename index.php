<?php
session_start();

// Check if the isLoggedIn session variable is not set
if (!isset($_SESSION['isLoggedIn'])) {
    header('location: html/login.html');
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracking System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav img {
            height: 50px;
            /* Adjust the height of the logo */
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
            /* Add some spacing between links */
        }

        nav a:hover {
            text-decoration: underline;
            /* Underline links on hover */
        }

        .container {
            text-align: center;
            margin-top: 50px;
        }

        #timeButtons {
            margin-bottom: 20px;
        }

        #timeButtons button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            cursor: pointer;
        }

        #timeButtons button:hover {
            background-color: #ddd;
        }

        #timeMessage {
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <nav>
        <img src="logo.png" alt="Logo" height="64">
        <?php
        // Check if user is logged in and show appropriate links
        if ($_SESSION['isLoggedIn']) {
            echo '<a href="php/logout.php">Logout</a>';
        } else {
            echo '<a href="html/login.html">Login</a> / <a href="html/signup.html">Sign Up</a>';
        }
        ?>
    </nav>

    <div class="container">
        <div id="timeButtons">
            <button id="timeInButton" onclick="recordTime('in')">Time In</button>
            <button id="timeOutButton" onclick="recordTime('out')">Time Out</button>
        </div>
        <div id="timeMessage"></div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Time in</th>
                    <th>Time out</th>
                </tr>
            </thead>
            <tbody id="timeRecords">
                <!-- Time records will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Function to fetch data from PHP script and update the table
            function updateTable() {
                $.ajax({
                    url: "php/fetch_data.php",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        // Clear existing table rows
                        $("#timeRecords").empty();

                        // Add new rows from fetched data
                        data.forEach(function(row) {
                            var name = row.first_name + " " + row.last_name;
                            var course = row.course;
                            var section = row.section;
                            var timeIn = row.time_in || '';
                            var timeOut = row.time_out || '';

                            // Set the color of timeIn text to green if it exists, otherwise, set it to black
                            var timeInColor = timeIn ? 'green' : 'black';

                            // Set the color of timeOut text to red if it exists, otherwise, set it to black
                            var timeOutColor = timeOut ? 'red' : 'black';

                            $("#timeRecords").append("<tr><td>" + name + "</td><td>" + course + "</td><td>" + section + "</td><td style='color:" + timeInColor + "'>" + timeIn + "</td><td style='color:" + timeOutColor + "'>" + timeOut + "</td></tr>");
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }

            // Call updateTable function initially
            updateTable();
        });
        $("#timeInButton, #timeOutButton").click(function() {
            var action = $(this).attr("id") === "timeInButton" ? "in" : "out";

            $.ajax({
                url: "php/update_time.php",
                type: "POST",
                data: {
                    action: action
                },
                success: function(data) {
                    $.ajax({
                        url: "php/fetch_data.php",
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            // Clear existing table rows
                            $("#timeRecords").empty();

                            // Add new rows from fetched data
                            data.forEach(function(row) {
                                var name = row.first_name + " " + row.last_name;
                                var course = row.course;
                                var section = row.section;
                                var timeIn = row.time_in || '';
                                var timeOut = row.time_out || '';

                                // Set the color of timeIn text to green if it exists, otherwise, set it to black
                                var timeInColor = timeIn ? 'green' : 'black';

                                // Set the color of timeOut text to red if it exists, otherwise, set it to black
                                var timeOutColor = timeOut ? 'red' : 'black';

                                $("#timeRecords").append("<tr><td>" + name + "</td><td>" + course + "</td><td>" + section + "</td><td style='color:" + timeInColor + "'>" + timeIn + "</td><td style='color:" + timeOutColor + "'>" + timeOut + "</td></tr>");
                            });

                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });
                }
            });


        });

        function recordTime(action) {
            var now = new Date();
            var timeMessage = document.getElementById("timeMessage");
            var timeRecords = document.getElementById("timeRecords");

            var newRow = timeRecords.insertRow();
            var timeInCell = newRow.insertCell(0);
            var timeOutCell = newRow.insertCell(1);

            if (action === 'in') {
                timeMessage.innerText = now.toLocaleString();
                timeMessage.style.color = 'green';
                timeMessage.innerText = 'Time In recorded at ' + now.toLocaleString();
            } else {
                timeMessage.innerText = now.toLocaleString();
                timeMessage.style.color = 'red';
                timeMessage.innerText = 'Time Out recorded at ' + now.toLocaleString();
            }
        }
    </script>
</body>

</html>