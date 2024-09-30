<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $swaminame = $con->real_escape_string($_POST['swaminame']);
    $date = $con->real_escape_string($_POST['date']);
    $the_groom = $con->real_escape_string($_POST['the_groom']);
    $the_bride = $con->real_escape_string($_POST['the_bride']);
    $mahal = $con->real_escape_string($_POST['mahal']);
    $place = $con->real_escape_string($_POST['place']);
    $timing = $con->real_escape_string($_POST['timing']);
    
    $sql = "INSERT INTO wedding (swaminame,date, the_groom, the_bride, mahal, place, timing)
            VALUES ( '$swaminame','$date', '$the_groom', '$the_bride', '$mahal', '$place', '$timing')";

    if ($con->query($sql) === TRUE) {
        header("Location:addmoi.php ");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>

