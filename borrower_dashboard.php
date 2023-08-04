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
    <title>Dashboard</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <h3>Search Library Database</h3>
    <form method="post" action="search_results.php">
        <label for="search">Search:</label>
        <input type="text" id="search" name="search" required>
        <input type="submit" value="Search">
    </form>
	
	<h3> Your Currently Checked Out Books </h3>
	<?php
    // Connect to the database
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');

    // Check connection
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];

    // Fetch checked out books data based on the borrower_id
    $query = "SELECT b.book_id, b.isbn, b.title, b.author, b.publisher, b.genre, bor.date_borrowed, bor.date_due
              FROM books AS b
              JOIN borrower AS bor ON bor.book_id = b.book_id
              WHERE bor.username = '$username'
			  AND date_borrowed IS NOT NULL";

    $result = mysqli_query($connection, $query);

    if ($result) {
        // Display the table header
        echo "<table border='1'>
                <tr>
                    <th>Book ID</th>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Genre</th>
					<th>Date Borrowed</th>
					<th>Date Due</th>
                </tr>";

        // Display each row of data in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . $row['isbn'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['publisher'] . "</td>";
            echo "<td>" . $row['genre'] . "</td>";
			echo "<td>" . $row['date_borrowed'] . "</td>";
			echo "<td>" . $row['date_due'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No books checked out by this borrower.";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
	
	<h3> Your Books Currently On Hold </h3>
	<?php
    // Connect to the database
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');

    // Check connection
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];

    // Fetch checked out books data based on the borrower_id
    $query = "SELECT b.book_id, b.isbn, b.title, b.author, b.publisher, b.genre
              FROM books AS b
              JOIN borrower AS bor ON bor.book_id = b.book_id
              WHERE bor.username = '$username'  AND bor.hold = 1";

    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Display the table header
        echo "<table border='1'>
                <tr>
                    <th>Book ID</th>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Genre</th>
                </tr>";

        // Display each row of data in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['book_id'] . "</td>";
            echo "<td>" . $row['isbn'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . $row['publisher'] . "</td>";
            echo "<td>" . $row['genre'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No books on hold for this borrower.";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
    <a href="logout.php">Logout</a>
</body>
</html>
