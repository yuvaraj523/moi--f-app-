<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $swaminame = $con->real_escape_string($_POST['swaminame']);
    $date = $con->real_escape_string($_POST['date']);
    $ceremony = $con->real_escape_string($_POST['ceremony']);
    $ceremonyowner = $con->real_escape_string($_POST['ceremonyowner']);
    $mahal = $con->real_escape_string($_POST['mahal']);
    $name = $con->real_escape_string($_POST['name']);
    $address = $con->real_escape_string($_POST['address']);
    $mobile = $con->real_escape_string($_POST['mobile']);
    $amount = $con->real_escape_string($_POST['amount']);
    
  
    $sql = "INSERT INTO ceremony_moi (swaminame,date, ceremony, ceremonyowner,mahal, name, address, mobile, amount) 
            VALUES ('$swaminame','$date', '$ceremony', '$ceremonyowner','$mahal', '$name', '$address', '$mobile', '$amount')";
    
    if ($con->query($sql) === TRUE) {
        header("Location: ceremonymoi.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
