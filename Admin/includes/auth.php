<?php
session_start();
include('db.php');

if(!isset($_SESSION['admin']))
{
    header("Location: admin.php");
    exit();
}

$admin = $_SESSION['admin'];
?>