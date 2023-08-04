<!DOCTYPE html>
<html>
<head>
    <title>Place Hold</title>
</head>
<body>
    <?php
        // Connect to database 
		$connection = mysqli_connect('localhost', 'root', 'root', 'library');

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the book_id from the form
        $book_id = $_POST['book_id'];

        // Prepare and execute the SQL query to update the hold column
        $sql = "UPDATE borrower SET hold = 1 WHERE book_id = '$book_id'";

        if (mysqli_query($conn, $sql)) {
            echo "Book with ID: $book_id has been placed on hold successfully!";
        } else {
            echo "Error placing the hold. Please try again later.";
        }

        // Close the database connection
        mysqli_close($conn);
    }
    ?>
</body>
</html>
