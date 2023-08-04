<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Search Results</h2>
    <?php
	// Start the session
		session_start();
		
    // Connect to the database
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');
    // Check connection
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Get the search term from the form submission
    if (isset($_POST['search'])) {
        $search = mysqli_real_escape_string($connection, $_POST['search']);

        // Query the database to search for records matching the search term (you'll need to replace 'your_table_name' with the actual name of your database table)
        $query = "SELECT books.book_id, isbn, title, author, publisher, genre, number_copies_available, number_copies_total, shelf.shelf_number, shelf.floor_number FROM books 
				  JOIN shelf WHERE (title LIKE '%$search%' OR author LIKE '%$search%' OR publisher LIKE '%$search%' OR genre LIKE '%$search%') AND books.book_id = shelf.book_id";
        $result = mysqli_query($connection, $query);

		if ($_SESSION['is_admin']) {
			if ($result) {
				echo "<table border='1'>
						<tr>
							<th>Book ID</th>
							<th>ISBN</th>
							<th>Title</th>
							<th>Author</th>
							<th>Publisher</th>
							<th>Genre</th>
							<th>Copies Available</th>
							<th>Total Copies</th>
							<th>Shelf Number</th>
							<th>Floor Number</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>";

				// Loop through the query results and display them in the table
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>
							<td>" . $row['book_id'] . "</td>
							<td>" . $row['isbn'] . "</td>
							<td>" . $row['title'] . "</td>
							<td>" . $row['author'] . "</td>
							<td>" . $row['publisher'] . "</td>
							<td>" . $row['genre'] . "</td>
							<td>" . $row['number_copies_available'] . "</td>
							<td>" . $row['number_copies_total'] . "</td>
							<td>" . $row['shelf_number'] . " </td>
							<td>" . $row['floor_number'] . "</td>
							<td><a href='edit.php?id=" . $row['book_id'] . "'>Edit</a></td>
							<td><a href='delete.php?id=" . $row['book_id'] . "'>Delete</a></td>
						</tr>";
				}
				echo "</table>";
			} else {
				echo "No results found.";
			}
		} else {
			if ($result) {
				echo "<table border='1'>
						<tr>
							<th>Book ID</th>
							<th>ISBN</th>
							<th>Title</th>
							<th>Author</th>
							<th>Publisher</th>
							<th>Genre</th>
							<th>Copies Available</th>
							<th>Total Copies</th>
							<th>Shelf Number</th>
							<th>Floor Number</th>
							<th>Hold</th>
						</tr>";

				// Loop through the query results and display them in the table
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>
							<td>" . $row['book_id'] . "</td>
							<td>" . $row['isbn'] . "</td>
							<td>" . $row['title'] . "</td>
							<td>" . $row['author'] . "</td>
							<td>" . $row['publisher'] . "</td>
							<td>" . $row['genre'] . "</td>
							<td>" . $row['number_copies_available'] . "</td>
							<td>" . $row['number_copies_total'] . "</td>
							<td>" . $row['shelf_number'] . " </td>
							<td>" . $row['floor_number'] . "</td>
							<td><a href='place_hold.php?id=" . $row['book_id'] . "'>Place Hold</a></td>
						</tr>";
				}
				echo "</table>";
			} else {
				echo "No results found.";
			}
		}
	} else {
		echo "Please enter a search term.";
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
