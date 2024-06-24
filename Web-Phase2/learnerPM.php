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
    header("Location: loginLearner.php");
    exit();
}

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to fetch learner profile information
function getLearnerProfile($email) {
    global $mysql;

    // Query to fetch learner profile
    $sql = "SELECT * FROM learner WHERE email = '$email'";

    // Execute query
    $result = $mysql->query($sql);

    // Check if query executed successfully
    if ($result) {
        // Fetch data from the result set
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row; // Return learner profile
        } else {
            return null; // Learner not found
        }
    } else {
        echo "Error: " . $mysql->error;
        return null; // Error in query execution
    }
}

// Function to update learner profile information
function updateLearnerProfile($email, $firstName, $lastName, $city, $password, $location, $photo) {
    global $mysql;

    // Sanitize input data
    $firstName = sanitize($firstName);
    $lastName = sanitize($lastName);
    $city = sanitize($city);
    $password = sanitize($password);
    $location = sanitize($location);
    $photo = sanitize($photo);

    // Query to update learner profile
    $sql = "UPDATE learner SET fname = '$firstName', lname = '$lastName', city = '$city', password = '$password', location = '$location', photo = '$photo' WHERE email = '$email'";

    // Execute query
    if ($mysql->query($sql) === TRUE) {
        return true; // Profile updated successfully
    } else {
        echo "Error updating record: " . $mysql->error;
        return false; // Error in query execution
    }
}

// Function to delete learner account
function deleteLearnerAccount($email) {
    global $mysql;

    // Query to delete learner account
    $sql = "DELETE FROM learner WHERE email = '$email'";

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
        if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['city']) && !empty($_POST['password']) && !empty($_POST['location'])) {
            // Display confirmation message
            echo "<script>
                if (confirm('Are you sure you want to save changes?')) {
                    // No redirect here
                } else {
                    event.preventDefault(); // Cancel form submission
                }
            </script>";

            // Update learner profile
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $city = $_POST['city'];
            $password = $_POST['password'];
            $location = $_POST['location'];
            
            // Check if a photo was uploaded
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photo_name = $_FILES['photo']['name'];
                $photo_temp = $_FILES['photo']['tmp_name'];
                $upload_dir = "learnerImages/";
                $photo_path = $upload_dir . $photo_name;

                // Move uploaded photo to the learnerImages folder
                if (move_uploaded_file($photo_temp, $photo_path)) {
                    // Update the learner's profile with the new photo name
                    updateLearnerProfile($email, $firstName, $lastName, $city, $password, $location, $photo_name);
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                // No new photo uploaded, retain the existing photo name
                $learnerProfile = getLearnerProfile($email);
                $photo_name = $learnerProfile['photo'];
                updateLearnerProfile($email, $firstName, $lastName, $city, $password, $location, $photo_name);
            }
        } else {
            echo "<script>alert('Please fill out all mandatory fields.');</script>";
        }
    } elseif (isset($_POST['deleteAccount'])) {
        // Display confirmation message
        echo "<script>
            if (confirm('Are you sure you want to delete your account?')) {
                window.location.href = 'learnerPM.php?delete=true'; // Redirect to process deletion
            }
        </script>";
    }
}

// Process account deletion if confirmed
if (isset($_GET['delete']) && $_GET['delete'] == 'true') {
    deleteLearnerAccount($email);
    header("Location: index.php"); // Redirect to homepage after deletion
    exit();
}

// Display learner profile information
$learnerProfile = getLearnerProfile($email);
if (!$learnerProfile) {
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
                        <img class="img2" src="../Web-Phase2/learnerImages/<?php echo $learnerProfile['photo']; ?>" alt="User Profile Picture">
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
            <div class="profile-form">
                <h2 class="header3">Profile management</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <label class="bb3" for="firstName">First Name<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="firstName" placeholder="John" value="<?php echo $learnerProfile['fname']; ?>">

                    <label class="bb3" for="lastName">Last Name<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="lastName" placeholder="Doe" value="<?php echo $learnerProfile['lname']; ?>">

                    <label class="bb3" for="email">Email Address<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="email" name="email" required placeholder="name@example.com" value="<?php echo $learnerProfile['email']; ?>" readonly>

                    <label class="bb3" for="password">Password<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="password" placeholder="**********" value="<?php echo $learnerProfile['password']; ?>">

                    <label class="bb3" for="city">City<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="city" placeholder="Riyadh" value="<?php echo $learnerProfile['city']; ?>">

                    <label class="bb3" for="location">Location<span class="mandatory">*</span>:</label>
                    <input class="bb3" type="text" name="location" placeholder="Saudi Arabia" value="<?php echo $learnerProfile['location']; ?>">

                    <div class="bb3">
                        <button id="saveChangesButton" class="accept" name="saveChanges">Save Changes</button>
                        <button id="deleteAccountButton" class="reject" name="deleteAccount">Delete Account</button>
                    </div>
                </form>
            </div>
            <div class="right-column">
                <label class="label" for="photo">Upload Photo<br>(JPG/PNG, max 5 MB):</label>
                <input type="file" id="photo" name="photo" accept=".jpg, .png">
                <img id="photoPreview" src="../Web-Phase2/learnerImages/<?php echo $learnerProfile['photo']; ?>" alt="Photo Preview" class="default-preview">
            </div>  
        </section>

        <footer>
            <a href="contact.php">Contact us</a>
            <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
        </footer>
    </div>
</body>
</html>

