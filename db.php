<?php
$host = "localhost"; 
$user = "root";       // change if your hosting has different user
$pass = "";           // change if your hosting has password
$dbname = "url_shortener"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
<?php