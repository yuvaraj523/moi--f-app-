<?php
include('db.php');
if (isset($_GET['id'])) {
    $id = $con->real_escape_string($_GET['id']);

    $delete_sql = "DELETE FROM uncle_ceremony WHERE id='$id'";

    if ($con->query($delete_sql) === TRUE) {
        header("Location: uncle_ceremony_display.php?message=delete_success");
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