<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            Reset password
        </title>
        <link rel = "stylesheet" href = "styles.css">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    </head>
    <body>
        <div class="wrapper">
            <header>
                <nav>
                    <a href ="index.php"><img src="images/webLogo1.png" alt="logo"></a>
                    <div class ="nav-links">
                        <ul>
                            <li><a href = "index.php">Home</a></li>
                            <li><a href = "about.php">About</a></li>
                            <li><a href = "contact.php">Contact us</a></li>
                        </ul>
                    </div>
                </nav>
                <h2 class="header1">Lanturn</h2>
            </header>
            <section>
                <div class="wrapper-login"> 
                    <form action="#" method="post">
                        <h1 class="header2">Forgot Password</h1>
                        <div class="input-box-login">
                            <label> Enter your Email</label>
                            <input type="email" name="email" placeholder="email" required>
                        </div>
                        <button type="submit" class="submit-continer" onclick="window.location.href= 'login.php';">Reset my Password</button>
            
                    </form>
                </div>
            </section>
            <footer>
                <a href = "contact.php">Contact us</a>
                <p class="copyright">Created by KSU Students!<br>&copy; 2024 Lanturn</p>
            </footer>
        </div>
    </body>
</html>





