<?php
// Database connection (ensure $conn is properly initialized before this block)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_ids'])) {
    $idsToDelete = $_POST['selected_ids'];

    // Prepare your delete statement
    $ids = implode(',', array_map('intval', $idsToDelete)); // Ensure IDs are safe for SQL
    $sql = "DELETE FROM addmoi WHERE id IN ($ids)";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Records deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting records: " . $conn->error . "</div>";
    }
}
?>