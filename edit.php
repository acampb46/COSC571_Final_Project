<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Edit Record</h2>
    <?php
	// Start the session
		session_start();
		
    // Connect to your database
	$connection = mysqli_connect('localhost', 'root', 'root', 'library');

    // Check connection
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Get the record ID from the URL parameter
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($connection, $_GET['id']);

        // Query the database to fetch the record with the specified ID 
        $query = "SELECT books.book_id, isbn, title, author, publisher, genre, number_copies_available, number_copies_total, shelf_number, floor_number FROM books JOIN shelf WHERE books.book_id = $id AND books.book_id = shelf.book_id";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 1) {
            // Fetch the record data as an associative array
            $row = mysqli_fetch_assoc($result);

            // Display the record data in a form for editing
            echo "<form method='post' action='update.php'>
                    <input type='hidden' name='id' value='" . $row['book_id'] . "'>
                    <label for='isbn'>ISBN:</label>
                    <input type='text' id='isbn' name='isbn' value='" . $row['isbn'] . "'><br>
					<label for='title'>Title:</label>
                    <input type='text' id='title' name='title' value='" . $row['title'] . "'><br>
					<label for='author'>Author:</label>
                    <input type='text' id='author' name='author' value='" . $row['author'] . "'><br>
					<label for='publisher'>Publisher:</label>
                    <input type='text' id='publisher' name='publisher' value='" . $row['publisher'] . "'><br>
					<label for='genre'>Genre:</label>
                    <input type='text' id='genre' name='genre' value='" . $row['genre'] . "'><br>
					<label for='number_copies_available'>Copies Available:</label>
                    <input type='text' id='number_copies_available' name='number_copies_available' value='" . $row['number_copies_available'] . "'><br>
					<label for='number_copies_total'>Total Copies:</label>
                    <input type='text' id='number_copies_total' name='number_copies_total' value='" . $row['number_copies_total'] . "'><br>
					<label for='shelf_number'>Shelf Number:</label>
                    <input type='text' id='shelf_number' name='shelf_number' value='" . $row['shelf_number'] . "'><br>
					<label for='floor_number'>Floor Number:</label>
                    <input type='text' id='floor_number' name='floor_number' value='" . $row['floor_number'] . "'><br>
                    <input type='submit' value='Save'>
                </form>";
        } else {
            echo "Record not found.";
        }
    } else {
        echo "Invalid request.";
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
