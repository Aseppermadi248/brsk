<?php
session_start();
include '../includes/connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query to fetch the admin user
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Password is correct, start a new session
            $_SESSION['admin_logged_in'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            header("Location: index.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Invalid username
        header("Location: index.php?error=invalid_credentials");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
<?php
session_start();
include '../includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query to fetch the admin user
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Password is correct, start a new session
            $_SESSION['admin_logged_in'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            header("Location: index.php?error=invalid_credentials");
            exit();
        }
    } else {
        // Invalid username
        header("Location: index.php?error=invalid_credentials");
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: index.php");
    exit();
}
?>
