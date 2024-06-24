<?php
$servername= "localhost";
                $username= "root" ;
                $password= "";
                $dbname= "lama" ;
                $connection= mysqli_connect($servername,$username,$password,$dbname);
                $database= mysqli_select_db($connection, $dbname);
                if (!$connection)
                    die("Connection failed: " . mysqli_connect_error());
                
                session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Previous Sessions
    </title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body>
    <div class="wrapper">
        <header>
            <nav>
                <a href="tutorHome.html"><img src="images/webLogo1.png" alt="logo"></a>
                <div class="nav-links">
                    <ul>
                        <li><a href="tutorHome.php">Home</a></li>
                        <li><a href="tutorReq.php">Requests</a></li>
                        <li><a href="tutorSessions.php">Sessions</a></li>
                        <li><a href="tutorRatings.php">Ratings/Reviews</a></li>
                    </ul>
                </div>
                <div class="user-profile">
                    <div class="menutoggle">
                        <img class="img2" src="../Web-Phase2/tutorImages/<?php echo $_SESSION['photo']; ?>" alt="User Profile Picture">
                        <div class="menu">
                            <ul class="list">
                                <li><a href="tutorPM.php">manage profile</a></li>
                                <li class="hehe"><a href="logout.php">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <h1 class="header1">Lanturn</h1>
        </header>
        <div class="wraapper-sessions">
            <div>
                <h2 class="header4">Previous sessions</h2>
                <div class="header-container">

                    <button class="sqbu" onclick="window.location.href= 'tutorSessions.php';">Current Sessions
                    </button>

                    <button class="sqbu" onclick="window.location.href= 'tutorPrevSessions.php';">
                        Previous Sessions
                    </button>
                </div>
                <?php 
                //get accepted seshs
                $temail=$_SESSION['email'];
                $sql = "SELECT *
                FROM request
                INNER JOIN tutor
                ON request.TutorEmail = tutor.email
                WHERE  tutor.email = '$temail' AND status='accepted'  AND date < CURDATE() ";
                $result = $connection->query($sql);
            
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        //code to get learner photo
                        $currentDateTime = date('Y-m-d H:i:s');
                        $duration = $row['duration']; // Duration in hours
                        $startTime = $row['date'] . ' ' . $row['time']; // Start time of the session
                        $endTime = date('Y-m-d H:i:s', strtotime($startTime) + $duration * 3600); // Calculate end time
            
                  // Check if session is a previous session
                 if ($row['date'] < date('Y-m-d') || ($row['date'] == date('Y-m-d') && $currentDateTime > $endTime)) {
                        $learnerEmail = $row['LearnerEmail']; // Make sure 'LearnerEmail' is a column in your 'request' table
                        $sqlPhoto = "SELECT photo
                        FROM learner As L
                        WHERE '$learnerEmail' = L.email ";
                        $resultPhoto = $connection->query($sqlPhoto);

                if ($resultPhoto->num_rows > 0) 
                $rowPhoto = $resultPhoto->fetch_assoc();
                
                $learner_email = $row['LearnerEmail'];
                
                // Prepare SQL query to retrieve tutor's name based on their email
                $query_learner_name = "SELECT fname, lname FROM learner WHERE email = ?";
                if ($stmt = $connection->prepare($query_learner_name)) {
                    // Bind the tutor's email as parameter
                    $stmt->bind_param("s", $learner_email);
                    // Execute the query
                    $stmt->execute();
                    // Store the result
                    $stmt->store_result();
                    
                    // Check if the query returned any rows
                    if ($stmt->num_rows > 0) {
                        // Bind the result variables
                        $stmt->bind_result($learner_fname, $learner_lname);
                        // Fetch the result
                        $stmt->fetch();
                        // Display the tutor's name
                        $lname= $learner_fname . " " . $learner_lname;
                    } else {
                        echo "Learner not found";
                    }
                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error in prepared statement: " . $mysql->error;
                }
                // Display the session card with the learner's photo
                echo '<section class="session-card">
                <h2>Learning Session</h2> '; ?>
                <img src="../Web-Phase2/learnerImages/<?php echo $rowPhoto['photo']; ?>" alt="Session Learner Photo" class="avatar">
                <?php
                echo '<p> Learner name : ' . htmlspecialchars($lname) . '</p>
                <p> Date/Time: ' . htmlspecialchars($row['date']) . ' at ' . htmlspecialchars($row['time']) . '</p>
                <p>Duration: ' . htmlspecialchars($row['duration']) . ' hours</p>
                
                </section>';
                      
                    }else {
                        echo "no sessions found";
                    }
                } }else {
                    echo "no sessions found";
                } ?>
            </div>
        </div>
        <footer>
            <a href="contact.php">Contact us</a>
            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
        </footer>
    </div>
</body>

</html>