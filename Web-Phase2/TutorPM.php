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

// Check if the email is stored in the session
if (isset($_SESSION['email'])) {
    // Retrieve the email from the session
    $email = $_SESSION['email'];
} else {
    // Redirect to the login page if email is not found in the session
    header("Location: loginTutor.php");
    exit();
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to fetch tutor profile information
function getTutorProfile($email) {
    global $mysql;

    // Query to fetch tutor profile including photo
    $sql = "SELECT *, photo FROM tutor WHERE email = '$email'";

    // Execute query
    $result = $mysql->query($sql);

    // Check if query executed successfully
    if ($result) {
        // Fetch data from the result set
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row; // Return tutor profile
        } else {
            return null; // Tutor not found
        }
    } else {
        echo "Error: " . $mysql->error;
        return null; // Error in query execution
    }
}

// Function to update tutor profile information
function updateTutorProfile($email, $firstName, $lastName, $age, $gender, $password, $city, $bio, $price, $photo) {
    global $mysql;

    // Sanitize input data
    $firstName = sanitize($firstName);
    $lastName = sanitize($lastName);
    $age = sanitize($age);
    $gender = sanitize($gender);
    $password = sanitize($password);
    $city = sanitize($city);
    $bio = sanitize($bio);
    $price = sanitize($price);
    $photo = sanitize($photo);

    // If a new photo is uploaded, update the photo in the database
    if ($photo) {
        // Move uploaded photo to the tutorImages folder
        $upload_dir = "tutorImages/";
        $photo_path = $upload_dir . $photo;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            // Update the tutor's profile with the new photo name
            $sql = "UPDATE tutor SET fname = '$firstName', lname = '$lastName', age = '$age', gender = '$gender', password = '$password', city = '$city', bio = '$bio', price = '$price', photo = '$photo' WHERE email = '$email'";
        } else {
            echo "Failed to move uploaded file.";
            return false; // Failed to move uploaded file
        }
    } else {
        // No new photo uploaded, retain the existing photo name
        $sql = "UPDATE tutor SET fname = '$firstName', lname = '$lastName', age = '$age', gender = '$gender', password = '$password', city = '$city', bio = '$bio', price = '$price' WHERE email = '$email'";
    }

    // Execute query
    if ($mysql->query($sql) === TRUE) {
        return true; // Profile updated successfully
    } else {
        echo "Error updating record: " . $mysql->error;
        return false; // Error in query execution
    }
}

// Function to delete tutor account
function deleteTutorAccount($email) {
    global $mysql;

    // Query to delete tutor account
    $sql = "DELETE FROM tutor WHERE email = '$email'";

    // Execute query
    if ($mysql->query($sql) === TRUE) {
        return true; // Account deleted successfully
    } else {
        echo "Error deleting record: " . $mysql->error;
        return false; // Error in query execution
    }
}

// Main code to handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['saveChanges'])) {
        // Validate mandatory fields
        if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['age']) && !empty($_POST['gender']) && !empty($_POST['password']) && !empty($_POST['city']) && !empty($_POST['bio']) && !empty($_POST['price'])) {
            // Display confirmation message
            echo "<script>
                if (confirm('Are you sure you want to save changes?')) {
                    // No redirect here
                } else {
                    event.preventDefault(); // Cancel form submission
                }
            </script>";

            // Update tutor profile
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $password = $_POST['password'];
            $city = $_POST['city'];
            $bio = $_POST['bio'];
            $price = $_POST['price'];
            $photo = $_FILES['photo']['name']; // Get photo filename
            updateTutorProfile($email, $firstName, $lastName, $age, $gender, $password, $city, $bio, $price, $photo);
        } else {
            echo "<script>alert('Please fill out all mandatory fields.');</script>";
        }
    } elseif (isset($_POST['deleteAccount'])) {
        // Display confirmation message
        echo "<script>
            if (confirm('Are you sure you want to delete your account?')) {
                window.location.href = 'tutorPM.php?delete=true'; // Redirect to process deletion
            }
        </script>";
    }
}

// Process account deletion if confirmed
if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
    deleteTutorAccount($email);
    header("Location: index.php"); // Redirect to homepage after deletion
    exit();
}

// Display tutor profile information
$tutorProfile = getTutorProfile($email);
if (!$tutorProfile) {
    // No redirection here, just output an error message
    echo "Error: Email not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile management</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        .mandatory {
            color: red;
            margin-left: 5px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // JavaScript code for displaying selected photo
            document.getElementById("photo").addEventListener("change", function(e) {
                let reader = new FileReader();
                reader.onload = function() {
                    let output = document.getElementById('photoPreview');
                    output.src = reader.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <header>
            <nav>
                <a href="tutorHome.php"><img src="images/webLogo1.png" alt="logo"></a>
                <div class="nav-links">
                    <ul>
                        <li><a href="tutorHome.php">Home</a></li>
                        <li><a href="tutorRequests.php">Requests</a></li>
                        <li><a href="tutorSessions.php">Sessions</a></li>
                        <li><a href="tutorRatings.php">Ratings/Reviews</a></li>
                    </ul>
                </div>
                <div class="user-profile">
                    <div class="menutoggle">
                        <img class="img2" src="../Web-Phase2/tutorImages/<?php echo $tutorProfile['photo']; ?>" alt="User Profile Picture">
                        <div class="menu">
                            <ul class="list">
                                <li><a href="tutorPM.php">manage profile</a></li>
                                <li class="hehe"><a href="index.php">Log out</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <h1 class="header1">Lanturn</h1>
        </header>
        <section>
            <div class="profile-form">
                <h2 class="header3">Profile management</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <label class="bb3" for="firstName">First Name<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="firstName" placeholder="John" value="<?php echo $tutorProfile['fname']; ?>">

                    <label class="bb3" for="lastName">Last Name<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="lastName" placeholder="Doe" value="<?php echo $tutorProfile['lname']; ?>">

                    <label class="bb3" for="age">Age<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="age" placeholder="22" value="<?php echo $tutorProfile['age']; ?>">

                    <label class="bb3" for="gender">Gender<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="gender" placeholder="female or male" value="<?php echo $tutorProfile['gender']; ?>">

                    <label class="bb3" for="email">Email Address<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="email" name="email" required placeholder="name@example.com" value="<?php echo $tutorProfile['email']; ?>" readonly>

                    <label class="bb3" for="password">Password<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="password" placeholder="**********" value="<?php echo $tutorProfile['password']; ?>">

                    <label class="bb3" for="city">City<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="city" placeholder="Riyadh" value="<?php echo $tutorProfile['city']; ?>">

                    <label class="bb3" for="bio">Bio<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="bio" placeholder="Short bio including languages spoken and cultural knowledge" value="<?php echo $tutorProfile['bio']; ?>">

                    <label class="bb3" for="price">Price<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="price" placeholder="50" value="<?php echo $tutorProfile['price']; ?>">

                    <div class="bb3">
                        <button id="saveChangesButton" class="accept" name="saveChanges">Save Changes</button>
                        <button id="deleteAccountButton" class="reject" name="deleteAccount">Delete Account</button>
                    </div>
                </form>
            </div>
            <div class="right-column">
                <label class="label" for="photo">Upload Photo<br>(JPG/PNG, max 5 MB):</label>
                <input type="file" id="photo" name="photo" accept=".jpg, .png">
                <img id="photoPreview" src="../Web-Phase2/tutorImages/<?php echo $tutorProfile['photo']; ?>" alt="Photo Preview" class="default-preview">
            </div>
        </section>
        <footer>
            <a href="contact.php">Contact us</a>
            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
        </footer>
    </div>
</body>
</html>