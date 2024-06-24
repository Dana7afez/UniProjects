<?php
session_start();
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

// Check if learner email is set in the session
if(isset($_SESSION['email'])) {
    $tutor_email = $_SESSION['email'];

    // Check if status parameter is set in the URL
    if(isset($_GET['status'])) {
        // Retrieve status from the URL
        $status = $_GET['status'];
        // Prepare SQL query based on the status and tutor's email
        $query = "SELECT * FROM request WHERE status = '$status' AND tutorEmail = '$tutor_email' ORDER BY date";
    } else {
        // Default query to fetch pending requests for the tutor
        $query = "SELECT * FROM request WHERE status = 'pending' AND tutorEmail = '$tutor_email' ORDER BY date";
    }

    $result = mysqli_query($mysql, $query);
    // Update status of pending requests that have timed out
    $currentTimestamp = time();

    while($row = $result->fetch_assoc()) {
        // Convert request date and time to timestamp
        $requestTimestamp = strtotime($row['date'] . ' ' . $row['time']);
        
        // Check if request is pending and 1 hour or more in the past, *3 for UTC
        if ($row['status'] === 'pending' && ($requestTimestamp - $currentTimestamp) <= (3*3600)) {
            // Update status to rejected
            $requestId = $row['ReqId']; // ReqId is the primary key of the request table
            $updateQuery = "UPDATE request SET status = 'rejected' WHERE ReqId = $requestId";
            mysqli_query($mysql, $updateQuery);
        }
    }
} else {
    // Redirect if tutor email is not set in the session
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Requests
        </title>
        <link rel = "stylesheet" href = "styles.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <nav>
                    <a href ="tutorHome.php"><img src="images/webLogo1.png" alt="logo"></a>
                    <div class ="nav-links">
                        <ul>
                            <li><a href = "tutorHome.php">Home</a></li>
                            <li><a href = "tutorReq.php">Requests</a></li>
                            <li><a href = "tutorSessions.php">Sessions</a></li>
                            <li><a href = "tutorRatings.php">Ratings/Reviews</a></li>
                        </ul>
                    </div>
                    <div class="user-profile">
                        <div class="menutoggle">
                        <img class="img2" src="../Web-Phase2/tutorImages/<?php echo $_SESSION['photo']; ?>" alt="User Profile Picture">
                             <div class="menu">
                                 <ul class="list">
                                     <li><a href="TutorPM.php">manage profile</a></li>
                                     <li class="hehe"><a href="logout.php">Log out</a></li>
                                  </ul>
                                </div>
                              </div>
                    </div>
                </nav>
                <h1 class="header1">Lanturn</h1>
            </header>
            <div class="wrapper-requests">
                <h2 class="header4">Requests</h2>
                <button class="sqbu" onclick="window.location.href='tutorReq.php?status=pending';">Pending</button>
                <button class="sqbu" onclick="window.location.href='tutorReq.php?status=accepted';">Accepted</button>
                <button class="sqbu" onclick="window.location.href='tutorReq.php?status=rejected';">Rejected</button>
                <?php
            if($result->num_rows > 0){
                mysqli_data_seek($result, 0);
                while($row = $result->fetch_assoc()) { ?>
                <div class="reqViewcontaine">
                    <h3> Learner Request </h3>
                    <p><label class="req-mainLabels">Name:</label>
                    <label name="name">
                    <?php
                // Get the tutor's email from the current row
                $learner_email = $row['LearnerEmail'];
                
                // Prepare SQL query to retrieve tutor's name based on their email
                $query_learner_name = "SELECT fname, lname FROM learner WHERE email = ?";
                if ($stmt = $mysql->prepare($query_learner_name)) {
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
                        echo $learner_fname . " " . $learner_lname;
                    } else {
                        echo "Learner not found";
                    }
                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error in prepared statement: " . $mysql->error;
                }
                ?>
                </label><br>
                        <label class="req-mainLabels">Date/Time:</label>
                        <label name="date"><?php echo $row['date'] . " " . $row['time']; ?></label><br>
                        <label class="req-mainLabels">Duration:</label>
                        <label  name="duration"><?php echo $row['duration']; ?> Hr</label><br>
                        <label class="req-mainLabels">Status:</label>
                        <label><?php echo $row['status']; ?></label><br>
                        <!-- Trigger/Open The Modal -->
                        <button class="edit" onclick="openModal('modal<?php echo $row['ReqId']; ?>')">View Details</button>
                        <?php
                        if ($row['status'] === 'pending') {
                            ?>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="ReqId" value="<?php echo $row['ReqId']; ?>">
                                <button type="submit" name="accept" class="accept">Accept Request</button>
                                <button type="submit" name="reject" class="reject">Reject Request </button>
                            </form>
                            <?php
                        }
                        ?>

                        <!-- The Modal -->
                        <div id="modal<?php echo $row['ReqId']; ?>" class="modal">

                            <!-- Modal content -->
                            <div class="modal-content">
                                <h3>Details</h3>
                                <span class="close" onclick="closeModal('modal<?php echo $row['ReqId']; ?>')">&times;</span>
                                <label class="req-mainLabels">Language:</label>
                                <label><?php echo $row['language']; ?></label><br>
                                <label class="req-mainLabels">Proficiency Level:</label>
                                <label><?php echo $row['prolevel']; ?></label><br>
                                <label class="req-mainLabels">Date/Time:</label>
                                <label name="date"><?php echo $row['date'] . " " . $row['time']; ?></label><br>
                                <label class="req-mainLabels">Duration:</label>
                                <label  name="duration"><?php echo $row['duration']; ?> Hr</label><br>
                                <label class="req-mainLabels">Status:</label>
                                <label><?php echo $row['status']; ?></label><br>
                            </div>
                            <script>
                                // Function to open modal
                                function openModal(modalId) {
                                    var modal = document.getElementById(modalId);
                                    if (modal) {
                                        modal.style.display = "block";
                                    }
                                }

                                // Function to close modal
                                function closeModal(modalId) {
                                    var modal = document.getElementById(modalId);
                                    if (modal) {
                                        modal.style.display = "none";
                                    }
                                }
                            </script>
                        </div>
                    </p>
                    </div>
                    <?php
            }}
            else{
                echo "No Requests";
            }
            ?>
                    <?php
               // Check if a request can be accepted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accept'])) {
        $request_id = $_POST['ReqId'];

        // Get details of the request being accepted
        $acceptQuery = "SELECT * FROM request WHERE ReqId = $request_id";
        $acceptResult = mysqli_query($mysql, $acceptQuery);
        $acceptRow = mysqli_fetch_assoc($acceptResult);

        // Convert duration to hours
        $duration_hours = (int)$acceptRow['duration'];

        // Calculate end time based on the duration of the accepted session
        $endTime = date('Y-m-d H:i:s', strtotime($acceptRow['date'] . ' ' . $acceptRow['time']) + $duration_hours * 3600);

        // Check for overlapping sessions
        $overlapQuery = "SELECT * FROM request WHERE status = 'accepted' AND date = ? AND ((time >= ? AND time < ?) OR (time <= ? AND ? < (time + duration)))";
        $stmt = $mysql->prepare($overlapQuery);
        $stmt->bind_param("sssss", $acceptRow['date'], $acceptRow['time'], $endTime, $acceptRow['time'], $acceptRow['time']);
        $stmt->execute();
        $overlapResult = $stmt->get_result();

        if ($overlapResult->num_rows > 0) {
            echo '<script>alert("Another session is already scheduled at the same date and overlapping time range.");</script>';;
        } else {
            // Prepare and execute update statement
            $update_query = "UPDATE request SET status = 'accepted' WHERE ReqId = ?";
            $stmt = $mysql->prepare($update_query);
            $stmt->bind_param("i", $request_id);
            if ($stmt->execute()) {
                echo "Request accepted successfully.";
            } else {
                echo "Error accepting request: " . $stmt->error;
            }
        }
        $stmt->close();
    } elseif (isset($_POST['reject'])) {
        $request_id = $_POST['ReqId'];
        // Prepare and execute update statement
        $update_query = "UPDATE request SET status = 'rejected' WHERE ReqId = ?";
        $stmt = $mysql->prepare($update_query);
        $stmt->bind_param("i", $request_id);
        if ($stmt->execute()) {
            echo "Request rejected successfully.";
        } else {
            echo "Error rejecting request: " . $stmt->error;
        }
        $stmt->close();
    }
}
                ?> 
                    
                </div>
            <footer>
                <a href = "contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
            </footer>
        </div>
    </body>
</html>