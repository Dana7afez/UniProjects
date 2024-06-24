<?php
session_start();

// Check if the email is stored in the session
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if email is not found in the session
    header("Location: loginLearner.php");
    exit();
}

$email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "lama";

// Create connection
$mysql = new mysqli($servername, $username, $password, $database);

// Check connection
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

// Function to fetch current sessions
function getCurrentSessions($email) {
    global $mysql;

    // Query to fetch current sessions
    $sql = "SELECT request.*, tutor.fname AS tutor_fname, tutor.lname AS tutor_lname, tutor.photo AS tutor_photo
            FROM request 
            JOIN tutor ON request.TutorEmail = tutor.email 
            WHERE LearnerEmail = '$email' AND status = 'accepted' AND (date = CURDATE() AND time >= CURTIME() OR date > CURDATE())";

    // Execute query
    $result = $mysql->query($sql);

    // Check if query executed successfully
    if ($result) {
        // Fetch data from the result set
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
        return $sessions; // Return current sessions
    } else {
        echo "Error: " . $mysql->error;
        return null; // Error in query execution
    }
}

// Main code to handle fetching current sessions
$currentSessions = getCurrentSessions($email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Sessions</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
<div class="wrapper">
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

    <div class="wraapper-sessions">
        <h2 class="header4">Current sessions</h2>
        <div class="header-container">
            <button class="sqbu" onclick="window.location.href= 'learnerCurrentSessions.php';">
                Current Sessions
            </button>
            <button class="sqbu" onclick="window.location.href= 'learnerPrevSessions.php';">
                Previous Sessions
            </button>
        </div>

        <?php if ($currentSessions && count($currentSessions) > 0): ?>
            <?php foreach ($currentSessions as $session): ?>
                <section class="session-card">
                    <h2>Learning Session </h2>
                    <img src="../Web-Phase2/tutorImages/<?php echo $session['tutor_photo']; ?>" alt="Session Partner Photo" class="sqimg">
                    <p>Your Language Partner : <?php echo $session['tutor_fname'] . ' ' . $session['tutor_lname']; ?></p>
                    <p>Date/Time: <?php echo $session['date'] . ' ' . $session['time']; ?></p>
                    <p>Duration: <?php echo $session['duration']; ?> hours</p>
                    <button class="sqbu" onclick="window.location.href='rateTutor.php';">Rate Now</button>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="error-message">No current sessions found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <a href="contact.php">Contact us</a>
        <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
    </footer>
</div>
</body>
</html>
