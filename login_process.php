<?php
//Start the session
	session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST["username"];
    $password = $_POST["password"];

	
    // Perform validation
    if (empty($username) || empty($password)) {
        print("Please fill in both username and password.");
    } else {
	// Connect to the database
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');

        // Check connection
        if (!$connection) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        // Sanitize the inputs to prevent SQL injection
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        // Query the database to check if the user exists with the given username and password
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($connection, $query);

        // Check if any rows are returned
        if (mysqli_num_rows($result) == 1) {
			
			//Fetch result as an associative array
			$row = mysqli_fetch_assoc($result);
			
			//Get "is_admin" value from the row
			$is_admin = $row['is_admin'];
			
			//Store username and is_admin in session variables
			$_SESSION['username'] = $username;
			$_SESSION['is_admin'] = $is_admin;
			
            // Successful admin login, redirect to admin dashboard
			if($is_admin) {
				header("Location: admin_dashboard.php");
				exit();
			}
			// Successful borrower login, redirect to borrower dashboard
			else {
				header("Location: borrower_dashboard.php");
				exit();
			}
        } else {
            // Invalid credentials, show error message
            print("Invalid username or password.");
        }

        // Close the database connection
        mysqli_close($connection);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="login.php">Try Again</a>
</body>
</html>
