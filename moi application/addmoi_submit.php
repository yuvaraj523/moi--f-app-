<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
$swaminame = $con->real_escape_string($_POST['swaminame']);
    
    $date = $con->real_escape_string($_POST['date']);
    $the_groom = $con->real_escape_string($_POST['the_groom']);
    $the_bride = $con->real_escape_string($_POST['the_bride']);
    $mahal= $con->real_escape_string($_POST['mahal']);
    $marriage_type = isset($_POST['marriage_type']) ? implode(',', $_POST['marriage_type']) : '';
    $name= $con->real_escape_string($_POST['name']);
    $address= $con->real_escape_string($_POST['address']);
    $mobile= $con->real_escape_string($_POST['mobile']);
    $amount= $con->real_escape_string($_POST['amount']);
    
    $sql = "INSERT INTO addmoi (swaminame,date,the_groom,the_bride,mahal, marriage_type, name, address, mobile,amount)
            VALUES ('$swaminame','$date','$the_groom','$the_bride',' $mahal','$marriage_type', '$name', '$address', '$mobile', '$amount')";

    if ($con->query($sql) === TRUE) {
        header("Location: addmoi.php");
        exit(); 
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
