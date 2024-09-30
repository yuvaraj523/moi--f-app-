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
    $sequence = $con->real_escape_string($_POST['sequence']);
    $extra_input= $con->real_escape_string($_POST['extra_input']);
    $amount = $con->real_escape_string($_POST['amount']);
    
  
    $sql = "INSERT INTO uncle_ceremony (swaminame,date, ceremony, ceremonyowner,mahal, name, address, mobile, sequence,extra_input,amount) 
            VALUES ('$swaminame','$date', '$ceremony', '$ceremonyowner','$mahal', '$name', '$address', '$mobile', '$sequence','$extra_input','$amount')";
    
    if ($con->query($sql) === TRUE) {
        header("Location: uncle_ceremony.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
