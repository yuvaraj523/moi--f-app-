<?php
include('db.php');
if (isset($_GET['id'])) {
    $id = $con->real_escape_string($_GET['id']);

    $delete_sql = "DELETE FROM wedding WHERE id='$id'";

    if ($con->query($delete_sql) === TRUE) {
        header("Location: marriagedisplay.php?message=delete_success");
        exit();
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();
} else {
    echo "No ID provided!";
    exit();
}
?>
