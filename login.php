<?php
// Start the session
session_start();

// Include database connection
include 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim input
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("SELECT password FROM login WHERE username = ?");
    if ($stmt === false) {
        die(json_encode(['error' => 'Error preparing statement: ' . $conn->error]));
    }

    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $stmt->store_result();

    // Check if username exists
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($storedPassword);
        $stmt->fetch();

        // Verify password
        if ($inputPassword === $storedPassword) {
            // Password is correct, start session and store username
            $_SESSION['username'] = $inputUsername;
            echo json_encode(['success' => true]);
        } else {
            // Invalid password
            echo json_encode(['error' => 'Invalid username or password.']);
        }
    } else {
        // Username does not exist
        echo json_encode(['error' => 'Invalid username or password.']);
    }

    $stmt->close();
}

$conn->close();
?>
