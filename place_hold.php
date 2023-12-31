<!DOCTYPE html>
<html>
<head>
    <title>Place Hold</title>
</head>
<body>
    <?php
		//Start session
		session_start();
		
        // Connect to database 
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');

        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the book_id from the form
        $book_id = $_GET['id'];
        $book_id = $_GET['id'];
		
		//Set username with session variable
		$username = $_SESSION['username'];
		
		// Get borrower_id from borrower table based on username
		$query = "SELECT borrower_id FROM borrower WHERE username = '$username'";
		$result = mysqli_query($connection, $query);
		
		if($result) {
			$row = mysqli_fetch_assoc($result);
			$borrower_id = $row['borrower_id'];
			
			// Prepare and execute the SQL query to update the hold column
			$sql = "INSERT INTO borrower (borrower_id, book_id, username, hold) VALUES ('$borrower_id','$book_id', '$username', 1) ON DUPLICATE KEY UPDATE hold = VALUES(hold)";

			if (mysqli_query($connection, $sql)) {
				echo "Book with ID: $book_id has been placed on hold successfully!";
			} else {
				echo "Error placing the hold. Please try again later.";
			}
		}
		
        // Close the database connection
        mysqli_close($connection);
    if($_SESSION['is_admin']) {
    ?>
	<a href="admin_dashboard.php">Return to Admin Dashboard</a>
	<?php
	}
	else {
	?>
	<a href="borrower_dashboard.php">Return to Borrower Dashboard</a>
	<?php
	}
	?>
	<a href="logout.php">Logout</a>
</body>
</html>
