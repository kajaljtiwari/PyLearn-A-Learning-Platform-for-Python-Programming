<!-- includes/student-layout.php -->

<?php
if(session_status()==PHP_SESSION_NONE){
session_start();
}

require_once("config.php");

$student_id=$_SESSION['student_id'];

$user=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$student_id'"));

$name=$user['full_name'];

$parts=explode(" ",$name);

$avatar=strtoupper(substr($parts[0],0,1));

if(isset($parts[1])){
$avatar.=strtoupper(substr($parts[1],0,1));
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f8f9fa;
}

.sidebar{
width:240px;
height:100vh;
position:fixed;
left:0;
top:0;
background:#198754;
padding:20px;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:10px;
margin-bottom:8px;
border-radius:8px;
}

.sidebar a:hover{
background:white;
color:#198754;
}

.main{
margin-left:240px;
}

.topbar{
background:white;
padding:15px 25px;
box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.avatar{
width:42px;
height:42px;
border-radius:50%;
background:#198754;
color:white;
display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
}

</style>

<div class="sidebar">

<h3 class="text-white mb-4">PyLearn</h3>

<a href="student-dashboard.php">Dashboard</a>
<a href="profile.php">My Profile</a>
<a href="courses.php">Courses</a>
<a href="quiz.php">Quiz</a>
<a href="student-logout.php">Logout</a>

</div>

<div class="main">

<div class="topbar d-flex justify-content-between align-items-center">

<h4 class="text-success m-0">Student Panel</h4>

<div class="d-flex align-items-center gap-2">

<div class="avatar"><?php echo $avatar; ?></div>

<div>
<b><?php echo $user['full_name']; ?></b><br>
<small><?php echo $user['email']; ?></small>
</div>

</div>

</div>

<div class="p-4">