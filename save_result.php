<!DOCTYPE html>
<html>
<head>
    <title>Save Result</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Save Result</h2>
    <?php
	//Start session
	session_start();
	
    // Check if the URL has the 'status' parameter set
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        
        // Display the appropriate message based on the 'status' parameter
        if ($status === 'success') {
            echo "<p>Update successful!</p>";
        } elseif ($status === 'error') {
            echo "<p>Update failed. Please try again.</p>";
        } else {
            echo "<p>Invalid status value.</p>";
        }
    } else {
        echo "<p>No status parameter found.</p>";
    }
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
