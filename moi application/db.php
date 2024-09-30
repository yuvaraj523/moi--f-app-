
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moi_db";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
