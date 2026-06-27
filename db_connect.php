<?php 
$servername = "localhost"; // XAMPP runs MySQL on localhost
$username = "root"; // Default XAMPP username
$password = ""; // Default password is empty
$dbname = "bbdms"; // Your database name

try {
    // Create connection using PDO
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
