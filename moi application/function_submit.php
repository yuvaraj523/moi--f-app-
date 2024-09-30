<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $swaminame= $con->real_escape_string($_POST['swaminame']);
    $date = $con->real_escape_string($_POST['date']);
    $ceremony = $con->real_escape_string($_POST['ceremony']);
    $ceremonyowner = $con->real_escape_string($_POST['ceremonyowner']);
    $mahal = $con->real_escape_string($_POST['mahal']);
    $place = $con->real_escape_string($_POST['place']);
    $timing = $con->real_escape_string($_POST['timing']);
    
    $sql = "INSERT INTO ceremony(swaminame,date, ceremony, ceremonyowner, mahal, place, timing)
            VALUES ('$swaminame','$date', '$ceremony', '$ceremonyowner', '$mahal', '$place', '$timing')";

    if ($con->query($sql) === TRUE) {
        header("Location:ceremonymoi.php ");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
