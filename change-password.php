<!-- change-password.php -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");

$student_id = $_SESSION['student_id'];
$msg = "";

if(isset($_POST['change'])){

$current = $_POST['current_password'];
$new     = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT password FROM students
WHERE student_id='$student_id'"));

if(password_verify($current,$user['password'])){

if($new == $confirm){

$hash = password_hash($new,PASSWORD_DEFAULT);

mysqli_query($conn,
"UPDATE students SET
password='$hash'
WHERE student_id='$student_id'");

$msg = "<div class='alert alert-success'>
Password Changed Successfully
</div>";

}else{

$msg = "<div class='alert alert-danger'>
Passwords do not match
</div>";

}

}else{

$msg = "<div class='alert alert-danger'>
Current password incorrect
</div>";

}

}

include("includes/student-layout.php");
?>

<div class="card shadow p-4 rounded-4">
<h2 class="text-success mb-4">Change Password</h2>

<?php echo $msg; ?>

<form method="post">

<div class="mb-3">
<label>Current Password</label>
<input type="password"
name="current_password"
class="form-control"
required>
</div>

<div class="mb-3">
<label>New Password</label>
<input type="password"
name="new_password"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Confirm Password</label>
<input type="password"
name="confirm_password"
class="form-control"
required>
</div>

<button type="submit"
name="change"
class="btn btn-success">
Change Password
</button>

<a href="profile.php"
class="btn btn-secondary">
Back
</a>

</form>
</div>

</div>
</div>