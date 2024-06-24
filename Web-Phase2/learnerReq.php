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

// Check if learner email is set in the session
if (isset($_SESSION['email'])) {
    $learner_email = $_SESSION['email'];

    // Check if status parameter is set in the URL
    if (isset($_GET['status'])) {
        // Retrieve status from the URL
        $status = $_GET['status'];
        // Prepare SQL query based on the status and learner's email
        $query = "SELECT * FROM request WHERE status = '$status' AND learnerEmail = '$learner_email' ORDER BY date";
    } else {
        // Default query to fetch pending requests for the learner
        $query = "SELECT * FROM request WHERE status = 'pending' AND learnerEmail = '$learner_email' ORDER BY date";
    }

    $result = mysqli_query($conn, $query);
} else {
    // Redirect if learner email is not set in the session
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Retrieve the reqId from the GET request
    $reqId = isset($_POST['ReqId']) ? $_POST['ReqId'] : '';

    // Check if reqId is not empty
    if (!empty($reqId)) {
        // Prepare the DELETE SQL statement using a prepared statement
        $sql = "DELETE FROM request WHERE ReqId = ?";
        
        // Prepare the statement
        $stmt3 = mysqli_prepare($conn, $sql);

        // Bind the parameter
        mysqli_stmt_bind_param($stmt3, "i", $reqId); // Assuming reqId is an integer, use "i" for integer
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt3)) {
            // Deletion successful
            echo "<script>alert('Request deleted successfully!'); window.location.href = 'learnerHome.php';</script>";
            exit();
        
        } else {
            // Error occurred
            echo "Error deleting request: " . mysqli_error($conn);
        }

        // Close the statement
        mysqli_stmt_close($stmt3);
    } else {
        // reqId is empty or not set
        echo "Invalid reqId.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

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
        <div class="wrapper-requests">
            <h2 class="header4">Requests</h2>
            <button class="sqbu" onclick="window.location.href='learnerReq.php?status=pending';">Pending</button>
            <button class="sqbu" onclick="window.location.href='learnerReq.php?status=accepted';">Accepted</button>
            <button class="sqbu" onclick="window.location.href='learnerReq.php?status=rejected';">Rejected</button>

            <?php

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="request-container">
                        <h2 class="request-header">Session Request </h2>
                        <p><label class="req-mainLabels">Tutor name:</label>
                            <label>
                                <?php
                                // Get the tutor's email from the current row
                                $tutor_email = $row['TutorEmail'];

                                // Prepare SQL query to retrieve tutor's name based on their email
                                $query_tutor_name = "SELECT fname, lname FROM tutor WHERE email = ?";
                                if ($stmt = $conn->prepare($query_tutor_name)) {
                                    // Bind the tutor's email as parameter
                                    $stmt->bind_param("s", $tutor_email);
                                    // Execute the query
                                    $stmt->execute();
                                    // Store the result
                                    $stmt->store_result();

                                    // Check if the query returned any rows
                                    if ($stmt->num_rows > 0) {
                                        // Bind the result variables
                                        $stmt->bind_result($tutor_fname, $tutor_lname);
                                        // Fetch the result
                                        $stmt->fetch();
                                        // Display the tutor's name
                                        echo $tutor_fname . " " . $tutor_lname;
                                    } else {
                                        echo "Tutor not found";
                                    }
                                    // Close the statement
                                    $stmt->close();
                                } else {
                                    echo "Error in prepared statement: " . $conn->error;
                                }
                                ?>
                            </label><br>
                            <label class="req-mainLabels">Language:</label>
                            <label><?php echo $row['language']; ?></label><br>
                            <label class="req-mainLabels">Your Proficiency Level:</label>
                            <label><?php echo $row['prolevel']; ?></label><br>
                            <label class="req-mainLabels">Date/Time:</label>
                            <label><?php echo $row['date'] . " " . $row['time']; ?></label><br>
                            <label class="req-mainLabels">Duration:</label>
                            <label><?php echo $row['duration']; ?>hr</label><br>
                            <label class="req-mainLabels">Status:</label>
                            <label><?php echo $row['status']; ?></label><br>
                        </p>
                        <?php
                        if ($row['status'] == 'pending') { ?>
                        <div class="button-container">
                        <form method="get" action="editReqLearner.php">
                             <input type="hidden" name="ReqID" value="<?php echo $row['ReqId']; ?>">
                                <button  type="submit" name="editReq"  id= "sqbuEdit"class="editReq">Edit Request</button>
                                
                            </form>
                             <form  id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                             <input type="hidden" name="ReqId" value="<?php echo $row['ReqId']; ?>">
                             <button type="button" id= "sqbuDelete" onclick="confirmDelete()">Cancel Request</button>
                                
                            </form>
                            </div>

                        <?php } ?>
                    </div>
                <?php } //end while
            } else {
                echo " No Requests";
            } ?>
        </div>
        <script>
function confirmDelete() {
    if (confirm("Are you sure you want to delete this request?")) {
        document.getElementById("deleteForm").submit();
    }
}
</script>
        <footer>
        <a href="contact.php">Contact us</a>
        <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
    </footer>
</div>
</body>

</html>