<!-- edit-profile.php -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");

$student_id = $_SESSION['student_id'];

if(isset($_POST['update'])){

$name   = $_POST['full_name'];
$email  = $_POST['email'];
$mobile = $_POST['mobile'];

mysqli_query($conn,
"UPDATE students SET
full_name='$name',
email='$email',
mobile='$mobile'
WHERE student_id='$student_id'");

$_SESSION['name'] = $name;

header("Location:profile.php");
exit();
}

$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$student_id'"));

include("includes/student-layout.php");
?>

<div class="card shadow p-4 rounded-4">
<h2 class="text-success mb-4">Edit Profile</h2>

<form method="post">

<div class="mb-3">
<label>Full Name</label>
<input type="text"
name="full_name"
class="form-control"
value="<?php echo $user['full_name']; ?>"
required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
name="email"
class="form-control"
value="<?php echo $user['email']; ?>"
required>
</div>

<div class="mb-3">
<label>Mobile</label>
<input type="text"
name="mobile"
class="form-control"
value="<?php echo $user['mobile']; ?>">
</div>

<button type="submit"
name="update"
class="btn btn-success">
Update Profile
</button>

<a href="profile.php"
class="btn btn-secondary">
Cancel
</a>

</form>
</div>

</div>
</div>