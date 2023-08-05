<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// If the user is logged in, welcome them on the dashboard
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, Administrator <?php echo $_SESSION['username']; ?>!</h2>
    <h3>Search Library Database</h3>
    <form method="post" action="search_results.php">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" required>
        <input type="submit" value="Search">
    </form>
	
	<h3> Send Reminders </h3>
	<?php
    // Connect to the database
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');

    // Check connection
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];

    // Fetch books that are due in the next 3 days
    $query = "SELECT b.book_id, b.title,  bor.date_due, student.student_name, student.email
              FROM books AS b
              JOIN borrower AS bor ON bor.book_id = b.book_id
			  JOIN student ON bor.borrower_id = student.borrower_id
			  WHERE bor.date_due <= DATE_ADD(CURRENT_DATE(), INTERVAL 3 DAY)";

    $result = mysqli_query($connection, $query);

    if ($result) {
        // Display the table header
        echo "<table>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
					<th>Date Due</th>
					<th>Student Name</th>
					<th>Student Email</th>
					<th>Send Reminder</th>
                </tr>";

        // Display each row of data in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
			echo "<td>" . $row['date_due'] . "</td>";
			echo "<td>" . $row['student_name'] . "</td>";
			echo "<td>" . $row['email'] . "</td>";
			echo "<td><a href='send_reminder.php?email=" . $row['email'] . "'>Send Reminder</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No reminders need to be sent.";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
	
    <a href="logout.php">Logout</a>
</body>
</html>
