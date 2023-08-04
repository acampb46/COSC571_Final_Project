<?php
// Connect to database 
$connection = mysqli_connect('localhost', 'root', 'root', 'library');

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the record ID from the URL parameter
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    // Query the database to delete the record with the specified ID
    $query = "DELETE FROM books WHERE id = $id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($connection);
?>
