<?php
include 'includes/connection.php'; // Include your database connection file
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        // Handle error - perhaps redirect back to contact form with an error message 
        header("Location: contact.php?error=empty_fields");
        exit();
    }

    // Insert into database (assuming you have a 'contacts' table)
    $sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Success - perhaps redirect to a thank you page 
        header("Location: contact.php?success=message_sent");
    } else {
        // Handle error - perhaps redirect back to contact form with an error message 
        header("Location: contact.php?error=database_error");
    }
    $stmt->close();
    $conn->close();
} else {
    // If accessed directly without POST method
    header("Location: contact.php");
    exit();
}
?>
