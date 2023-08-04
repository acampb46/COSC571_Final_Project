<?php
//Start the session
session_start();

// Connect to database 
$connection = mysqli_connect('localhost', 'root', 'root', 'library');

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
	$id = mysqli_real_escape_string($connection, $_POST['id']);
    $isbn = mysqli_real_escape_string($connection, $_POST["isbn"]);
    $title = mysqli_real_escape_string($connection, $_POST["title"]);
    $author = mysqli_real_escape_string($connection, $_POST["author"]);
    $publisher = mysqli_real_escape_string($connection, $_POST["publisher"]);
    $genre = mysqli_real_escape_string($connection, $_POST["genre"]);
    $copies_available = (int)$_POST["number_copies_available"];
    $copies_total = (int)$_POST["number_copies_total"];

    // Perform the update query
    $query = "UPDATE books 
              SET isbn = '$isbn', 
                  title = '$title', 
                  author = '$author', 
                  publisher = '$publisher', 
                  genre = '$genre', 
                  number_copies_available = $copies_available, 
                  number_copies_total = $copies_total
              WHERE book_id = $id";

    $result = mysqli_query($connection, $query);

    if ($result) {
        // If the update is successful, redirect the user to save_result.php page with a success message
        header("Location: save_result.php?id=$id&status=success");
    } else {
        // If there is an error, redirect the user to save_result.php page with an error message
        header("Location: save_result.php?id=$id&status=error");
    }
} else {
    // If the form is not submitted directly to this page, redirect the user to their dashboard page
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
	<?php
}

// Close the database connection
mysqli_close($connection);
?>
