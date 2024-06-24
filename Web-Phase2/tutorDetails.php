<?php
session_start();

// Check if tutor name is submitted
if (isset($_POST['tutorName'])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lama";
    $connection = mysqli_connect($servername, $username, $password, $dbname);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve full tutor name from form submission
    $tutorName = $_POST['tutorName'];

    // Query to fetch tutor details including rating
    $sql = "SELECT tutor.fname, tutor.lname, tutor.photo, tutor.bio, 
            (SELECT COUNT(*) FROM rate WHERE TutorEmail = tutor.email) AS reviews, 
            (SELECT IFNULL(AVG(star), 0) FROM rate WHERE TutorEmail = tutor.email) AS rating, 
            request.prolevel, 
            tutor.price 
            FROM tutor 
            LEFT JOIN request ON tutor.email = request.TutorEmail 
            WHERE CONCAT(tutor.fname, ' ', tutor.lname) = '$tutorName'";
    $result = mysqli_query($connection, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tutorName = $row['fname'] . " " . $row['lname'];
        $bio = $row['bio'];
        $reviews = $row['reviews'];
        $rating = round($row['rating'], 1); // Round to 1 decimal place
        $price = $row['price'];
        $proficiency = $row['prolevel'];
        $photo = $row['photo'];
    } else {
        // Tutor not found
        $tutorName = "Tutor Not Found";
        $bio = "This tutor does not exist or has no details available.";
        $reviews = 0;
        $rating = "N/A";
        $price = "N/A";
        $proficiency = "N/A";
        $photo = "default.jpg"; // Default photo
    }

    // Close database connection
    mysqli_close($connection);
} else {
    // Redirect if tutor name is not submitted
    header("Location: learnerTutors.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor details</title>
    <link rel="stylesheet" href="main.css">
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

    <h2 class="header4">Tutor details</h2>
    <div class="card">
        <div class="left-container">
            <img class="img1" src="../Web-Phase2/tutorImages/<?php echo $photo; ?>" alt="Profile Image">
            <h2 id="h2" class="gradienttext"><?php echo $tutorName; ?></h2>
            <br>
            <button class="edit" onclick="window.location.href='learnerTutors.php';">Return</button>
        </div>
        <div class="right-container">
            <h3 id="h3" class="gradienttext">Profile Details</h3>
            <br>
            <div class="profile-section">
                <h4 class="h4">Bio including languages spoken and cultural knowledge</h4>
                <p class="p"><?php echo $bio; ?></p>
            </div>
 
            <div class="profile-section">
                <h4 class="h4">Rating & Reviews</h4>
                <p class="p">Rated <?php echo $rating; ?>/5 based on <?php echo $reviews; ?> reviews.</p>
            </div>
            <div class="profile-section">
                <h4 class="h4">Price</h4>
                <p class="p">$<?php echo $price; ?> / hour</p> <!-- Retrieve price from request table -->
            </div>
        </div>
    </div>

    <footer>
        <a href="contact.php">Contact us</a>
        <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
    </footer>
</body>

</html>
