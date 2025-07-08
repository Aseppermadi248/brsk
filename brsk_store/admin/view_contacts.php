<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    // If not logged in, redirect to the login page
    header('Location: index.php');
    exit();
}

// Include necessary files
require_once 'includes/header_admin.php';
?>

<div class="container mt-4">
    <h2>Contact Messages</h2>

    <?php
    if (isset($_GET['delete_success'])) {
        echo '<div class="alert alert-success">Message deleted successfully.</div>';
    }
    if (isset($_GET['delete_error'])) {
        echo '<div class="alert alert-danger">Error deleting message.</div>';
    }
    ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Submitted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM contacts ORDER BY submitted_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                    echo "<td>" . $row['submitted_at'] . "</td>";
                    echo '<td>
                            <form action="delete_contact.php" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this message?\');">
                                <input type="hidden" name="contact_id" value="' . $row['id'] . '">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                          </td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No contact messages found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php
require_once 'includes/footer_admin.php';
?>
