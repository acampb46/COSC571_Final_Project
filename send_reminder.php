<?php
    // Replace the following with appropriate email details
    $to_email = $_GET['email']; // Student's email address
    $subject = "Reminder: Your Library Books";
    $message = "Dear Student,\n\nThis is a reminder that your library book is due soon. Please return your book promptly.\n\nBest regards,\nYour School";

    // Set additional headers (optional)
    $headers = "From: school@example.com"; // Replace with your school's email address or a valid sender address

    // Send the email
    if (mail($to_email, $subject, $message, $headers)) {
        echo "Reminder email sent successfully!";
    } else {
        echo "Error sending the reminder email. Please try again later.";
    }
?>
