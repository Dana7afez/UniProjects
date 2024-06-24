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

// Check if tutor email is set in the session
if(isset($_SESSION['email'])) {
    $tutor_email = $_SESSION['email'];

    
    $query = "SELECT rate.*, learner.fname, learner.lname FROM rate 
    INNER JOIN learner ON rate.learnerEmail = learner.email
    WHERE rate.tutorEmail = '$tutor_email' ORDER BY rate.dateAndtime";;
   

    $result = mysqli_query($mysql, $query);

    $totalRating = 0;
    $numRates = 0;
    while ($row = $result->fetch_assoc()) {
        $totalRating += $row['star'];
        $numRates++;
    }
    $avgRating = $numRates > 0 ? $totalRating / $numRates : 0;
    
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
        Ratings
    </title>
    <link rel="stylesheet" href="styles.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <nav>
                <a href="tutorHome.php"><img src="images/webLogo1.png" alt="logo"></a>
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
        <div class="wrapper-ratings">
            <h2 class="header4"> Ratings and Reviews </h2>
            <h3 class="header5">Your overall rating:
                <?php
                // Display overall rating stars
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $avgRating) {
                        echo '<span class="fa fa-star checked"></span>';
                    } else {
                        echo '<span class="fa fa-star"></span>';
                    }
                }
                ?>
                (<?php echo $avgRating; ?> Based on <?php echo $numRates; ?> rates)
            </h3>
                <?php
                mysqli_data_seek($result, 0);
                if(mysqli_num_rows($result) > 0) {
                // Loop through each row in the result set
                while($row = mysqli_fetch_assoc($result)) {
                    // Output HTML for each rating
                    ?>
                    <div class="firstDiv">
                        <div class="secondDiv">
                            <div class="thirdDiv">
                                <h4 class="Reviewer"><?php
                // Get the learner's email from the current row
                $learner_email = $row['learnerEmail'];
                
                // Prepare SQL query to retrieve learner's name based on their email
                $query_learner_name = "SELECT fname, lname FROM learner WHERE email = ?";
                if ($stmt = $mysql->prepare($query_learner_name)) {
                    // Bind the learner's email as parameter
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
                        // Display the learner's name
                        echo $learner_fname . " " . $learner_lname;
                    } else {
                        echo "Learner not found";
                    }
                    // Close the statement
                    $stmt->close();
                } else {
                    echo "Error in prepared statement: " . $mysql->error;
                }
                ?></h4>
                                <p class="date"><?php echo $row['dateAndtime']; ?></p>
                                <!-- Display stars based on the rating -->
                                <?php
                                $rating = $row['star'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<span class="fa fa-star checked"></span>';
                                    } else {
                                        echo '<span class="fa fa-star"></span>';
                                    }
                                }
                                ?>
                                <p><?php echo $row['feedback']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No ratings available.";
            }
            ?>
        </div>
        <footer>
            <a href="contact.php">Contact us</a>
            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
        </footer>
    </div>
</body>

</html>