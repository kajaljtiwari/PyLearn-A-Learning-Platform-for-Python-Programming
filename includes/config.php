<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "pylearn_db";

/* Create Connection */
$con = mysqli_connect($host, $user, $password, $database);

/* Check Connection */
if (!$con)
{
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* Optional Charset */
mysqli_set_charset($con, "utf8");

/* Extra alias for new pages */
$conn = $con;

?>