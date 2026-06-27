<?php
session_start();
include_once('includes/config.php');

/* ================= REGISTER ================= */
if(isset($_POST['action']) && $_POST['action']=="register")
{
$name=trim($_POST['name']);
$email=trim($_POST['email']);
$mobile=trim($_POST['mobile']);
$password=$_POST['password'];

if(empty($name)||empty($email)||empty($mobile)||empty($password)){
echo "All fields required"; exit();
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
echo "Invalid email"; exit();
}

if(!preg_match('/^[0-9]{10}$/',$mobile)){
echo "Invalid mobile number"; exit();
}

if(strlen($password)<6){
echo "Password must be at least 6 characters"; exit();
}

$email=mysqli_real_escape_string($con,$email);

$check=mysqli_query($con,"SELECT * FROM students WHERE email='$email'");
if(mysqli_num_rows($check)>0){
echo "exists"; exit();
}

$hash=password_hash($password,PASSWORD_DEFAULT);

mysqli_query($con,"INSERT INTO students(full_name,email,mobile,password)
VALUES('$name','$email','$mobile','$hash')");

echo "success"; exit();
}

/* ================= LOGIN ================= */
if(isset($_POST['action']) && $_POST['action']=="login")
{
$email=trim($_POST['email']);
$password=$_POST['password'];

if(empty($email)||empty($password)){
echo "invalid"; exit();
}

$email=mysqli_real_escape_string($con,$email);

$q=mysqli_query($con,"SELECT * FROM students WHERE email='$email'");
if(mysqli_num_rows($q)>0)
{
$row=mysqli_fetch_assoc($q);

if(password_verify($password,$row['password']))
{
$_SESSION['student_id']=$row['student_id'];
$_SESSION['student_name']=$row['full_name'];

echo "login_success"; exit();
}
}

echo "invalid"; exit();
}
?>