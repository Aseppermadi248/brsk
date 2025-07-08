<?php
session_start();
// Check if the admin is logged in, otherwise redirect to the login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

include_once '../includes/connection.php';

$message = "";

// Handle message deletion
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        $message = "Message deleted successfully.";
    } else {
        $message = "Error deleting message.";
    }
    $stmt->close();
}

// Fetch all contact messages
$contacts = [];
$sql = "SELECT * FROM contacts ORDER BY created_at DESC"; // Corrected column name
if ($result = $conn->query($sql)) {
    $contacts = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
}

?>
<?php include_once 'includes/header_admin.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Contact Messages</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            All Messages
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Received At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contacts)): ?>
                            <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['id']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['name']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['message']); ?></td>
                                    <td><?php echo htmlspecialchars($contact['created_at']); ?></td>
                                    <td>
                                        <a href="view_contacts.php?delete=<?php echo $contact['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No contact messages found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$conn->close();
include_once 'includes/footer_admin.php';
?>
