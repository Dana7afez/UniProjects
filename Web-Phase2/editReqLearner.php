<?php
session_start();
DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'lama');

// Establish database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PSWD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the request ID is set in the URL
if (isset($_GET['ReqID'])) {

    // Get the request ID from the URL
    $reqId = $_GET['ReqID'];

    // Perform database query to retrieve request information
    $sql = "SELECT request.language, request.prolevel, request.date, request.time, request.duration, tutor.fname, tutor.lname 
        FROM request 
        INNER JOIN tutor ON request.TutorEmail = tutor.email 
        WHERE request.ReqId = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reqId); 
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        // Fetch the request information from the database
        $row = $result->fetch_assoc();
        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Request</title>
            <link rel="stylesheet" href="styles.css">
        </head>

        <body>
            <header>
                <nav>
                    <a href="learnerHome.php"><img src="images/webLogo1.png" alt="logo"></a>
                    <div class="nav-links">
                        <ul>
                            <li><a href="learnerHome.php">Home</a></li>
                            <li><a href="learnerReq.php">Requests</a></li>
                            <li><a href="learnerCurrentSessions.php">Sessions</a></li>
                            <li><a href="learnerTutors.php">Tutors</a></li>
                        </ul>
                    </div>
                    <div class="user-profile">
                        <div class="menutoggle">
                            <img class="img2" src="../Web-Phase2/learnerImages/<?php echo $_SESSION['photo']; ?>" alt="User Profile Picture">
                            <div class="menu">
                                <ul class="list">
                                    <li><a href="learnerPM.php">manage profile</a></li>
                                    <li class="hehe"><a href="logout.php">Log out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <h1 class="header1">Lanturn</h1>
            </header>
            <section>
                <div id="arrange">
                    <div class="container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="appoint-form" method="POST">
                            <h2 id="form-head">Edit Request:</h2>
        
                            <label for="tutorname" id="ctutorname" class="format">Select Tutor:</label>
                            <select id="tutorname" name="tutor">
                                <option value="" disabled>Select tutor</option>
                                <?php
                                // Query to retrieve tutor names from the database
                                $sql_tutors = "SELECT email, fname, lname FROM tutor";
                                $result_tutors = mysqli_query($conn, $sql_tutors);

                                if ($result_tutors && mysqli_num_rows($result_tutors) > 0) {
                                    while ($row_tutor = mysqli_fetch_assoc($result_tutors)) {
                                        $tutor_email = $row_tutor['email'];
                                        // Check if this tutor was originally selected based on both TutorEmail and ReqId
                                        $selected = ($tutor_email == $row['TutorEmail'] && $reqId == $row['ReqId']) ? "selected" : "";
                                        echo "<option value='$tutor_email' $selected>" . $row_tutor['fname'] . " " . $row_tutor['lname'] . "</option>";
                                    }
                                }
                                ?>
                            </select>



                            <label for="dropdown" id="city" class="format">Select Language:</label>
                            <select id="dropdown" name="language">
                                <option value="" disabled>Select the language</option>

                                <option value="English" <?php echo ($row['language'] == 'English') ? "selected" : ""; ?>>English
                                </option>
                                <option value="Spanish" <?php echo ($row['language'] == 'Spanish') ? "selected" : ""; ?>>Spanish
                                </option>
                                <option value="French" <?php echo ($row['language'] == 'French') ? "selected" : ""; ?>>French
                                </option>
                            </select>
                            <label for="dropdown2" id="level" class="format">Select Proficiency Level:</label>
                            <select id="dropdown2" name="prolevel">
                                <option value="" disabled>Select the proficiency level</option>
                                <option value="beginner" <?php echo ($row['prolevel'] == 'beginner') ? "selected" : ""; ?>>
                                    Beginner</option>
                                <option value="intermediate" <?php echo ($row['prolevel'] == 'intermediate') ? "selected" : ""; ?>>Intermediate</option>
                                <option value="advance" <?php echo ($row['prolevel'] == 'advance') ? "selected" : ""; ?>>Advance
                                </option>
                            </select>
                            <label for="date" id="date-time" class="format">Select Date and Time:</label>
                            <input type="date" id="date" name="date" class="dtt" value="<?php echo $row['date']; ?>" required>
                            <input type="time" id="time" name="time" min="08:00" max="20:00" value="<?php echo $row['time']; ?>"
                                class="dtt" required>
                            <label for="dropdown3" id="duration" class="format">Select Duration:</label>
                            <select id="dropdown3" name="duration">
                                <option value="" disabled>Select the duration</option>
                                <option value="1" <?php echo ($row['duration'] == '1') ? "selected" : ""; ?>>1hr</option>
                                <option value="1.5" <?php echo ($row['duration'] == '1.5') ? "selected" : ""; ?>>1.5hr</option>
                                <option value="2" <?php echo ($row['duration'] == '2') ? "selected" : ""; ?>>2hr</option>
                            </select>
                            <input type="hidden" name="ReqID" value="<?php echo $reqId; ?>">

                            <button type="submit" name="submit" id="submit" value="Submit">Save Changes</button>
                            <button type="submit"  id="return" name="cancel">Cancel</button>
                        </form>
                    </div>
                </div>
            </section>
            <footer>
                <a href="contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
            </footer>
        </body>

        </html>

        <?php
    } else {
      
        echo "Request not found.";
    }

 
    $stmt->close();
    $conn->close();
} else {
    // Request ID not set in the URL
    echo "Request ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cancel'])) {
        header('Location: learnerReq.php'); 
        exit(); 
    }
    // Retrieve form data
    $language = $_POST['language'];
    $prolevel = $_POST['prolevel'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $duration = $_POST['duration'];
    $tutorEmail = $_POST['tutor']; // Retrieve tutor email from the form
    $reqId = $_POST['ReqID']; // Retrieve ReqId from the form

    // Update the request in the database
    $sql_update = "UPDATE request SET language=?, prolevel=?, date=?, time=?, duration=?, TutorEmail=? WHERE ReqId=?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $language, $prolevel, $date, $time, $duration, $tutorEmail, $reqId); // Adjust parameters accordingly
    $stmt_update->execute();

    // Check if the update was successful
    if ($stmt_update->affected_rows > 0) {
        echo "<script>alert('Request changes saved successfully!'); window.location.href = 'learnerReq.php';</script>";
        exit();
    } else {
        echo "Error updating request: " . $conn->error;
    }

    // Close prepared statement and database connection
    $stmt_update->close();
    $conn->close();
}
?>