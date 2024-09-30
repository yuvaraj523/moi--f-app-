<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_ids']) && is_array($_POST['selected_ids'])) {
        $idsToDelete = $_POST['selected_ids'];

 
        $idsToDelete = array_map('intval', $idsToDelete); 
        $idsString = implode(',', $idsToDelete);

        $sql = "DELETE FROM ceremony WHERE id IN ($idsString)";
        
        if ($con->query($sql) === TRUE) {

            header("Location: functiondisplay.php?message=Records deleted successfully");
            exit();
        } else {
      
            header("Location:functiondisplay.php?message=Error deleting records: " . urlencode($con->error));
            exit();
        }
    } else {

        header("Location:functiondisplay.php?message=No records selected for deletion.");
        exit();
    }
}
?>