<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $swaminame = $con->real_escape_string($_POST['swaminame']);
    $date = $con->real_escape_string($_POST['date']);
    $the_groom = $con->real_escape_string($_POST['the_groom']);
    $the_bride = $con->real_escape_string($_POST['the_bride']);
    $mahal= $con->real_escape_string($_POST['mahal']);
    $marriage_type= $con->real_escape_string($_POST['marriage_type']);
    $name= $con->real_escape_string($_POST['name']);
    $address= $con->real_escape_string($_POST['address']);
    $mobile= $con->real_escape_string($_POST['mobile']);
    $sequence = $con->real_escape_string($_POST['sequence']);
    $extra_input= $con->real_escape_string($_POST['extra_input']);
    $amount= $con->real_escape_string($_POST['amount']);
    
    $sql = "INSERT INTO uncle (swaminame,date,the_groom,the_bride,mahal, marriage_type, name, address, mobile,sequence,extra_input,amount)
            VALUES ('$swaminame','$date','$the_groom','$the_bride','$mahal', '$marriage_type', '$name', '$address', '$mobile','$sequence','$extra_input', '$amount')";

    if ($con->query($sql) === TRUE) {
        header("Location: maternaluncle.php");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>