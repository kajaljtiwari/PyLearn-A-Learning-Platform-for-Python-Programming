<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");

$student_id = $_SESSION['student_id'];

/* Student Info */
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$student_id'"));

/* Stats */
$categories = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM enrollments WHERE student_id='$student_id'"))['total'];

$topics = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM topics"))['total'];

$certificates = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM certificates WHERE student_id='$student_id'"))['total'];

$quiz = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM results WHERE student_id='$student_id'"))['total'];

$avg = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT AVG(percentage) avgp FROM results WHERE student_id='$student_id'"))['avgp'];

$avg = round($avg);

/* Best Score */
$best = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT MAX(percentage) bestp FROM results WHERE student_id='$student_id'"))['bestp'];

$best = round($best);

/* Last Quiz */
$lastquiz = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT result_date FROM results WHERE student_id='$student_id'
ORDER BY result_id DESC LIMIT 1"));

/* Avatar */
$name = trim($user['full_name']);
$parts = explode(" ", $name);
$avatar = strtoupper(substr($parts[0],0,1));
if(isset($parts[1])){
$avatar .= strtoupper(substr($parts[1],0,1));
}

include("includes/student-layout.php");
?>

<div class="row g-4">

<!-- Left Profile Card -->

<div class="col-md-4">
<div class="card shadow border-0 rounded-4 p-4 text-center">

<div style="width:90px;height:90px;background:#198754;color:white;
border-radius:50%;display:flex;align-items:center;
justify-content:center;font-size:30px;font-weight:bold;margin:auto;">
<?php echo $avatar; ?>
</div>

<h3 class="mt-3 text-success">
<?php echo $user['full_name']; ?>
</h3>

<p class="text-muted mb-1">
<?php echo $user['email']; ?>
</p>

<p class="text-muted">
<?php echo $user['mobile']; ?>
</p>

<hr>

<p><strong>Joined:</strong><br>
<?php echo date("d M Y", strtotime($user['created_at'])); ?>
</p>

<a href="edit-profile.php" class="btn btn-success w-100 mb-2">
Edit Profile
</a>

<a href="change-password.php" class="btn btn-outline-success w-100">
Change Password
</a>

</div>
</div>

<!-- Right Content -->

<div class="col-md-8">

<!-- Stats -->

<div class="row g-3">

<div class="col-md-3">
<div class="card shadow border-0 rounded-4 p-3 text-center">
<h6>Courses</h6>
<h3 class="text-success"><?php echo $categories; ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 rounded-4 p-3 text-center">
<h6>Topics</h6>
<h3 class="text-success"><?php echo $topics; ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 rounded-4 p-3 text-center">
<h6>Quizzes</h6>
<h3 class="text-success"><?php echo $quiz; ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 rounded-4 p-3 text-center">
<h6>Certificates</h6>
<h3 class="text-success"><?php echo $certificates; ?></h3>
</div>
</div>

</div>

<!-- Performance -->

<div class="card shadow border-0 rounded-4 p-4 mt-4">

<h4 class="text-success mb-3">Performance</h4>

<p class="mb-2">
Average Score: <strong><?php echo $avg; ?>%</strong>
</p>

<div class="progress mb-3" style="height:12px;">
<div class="progress-bar bg-success"
style="width:<?php echo $avg; ?>%">
</div>
</div>

<p class="mb-2">
Best Score: <strong><?php echo $best; ?>%</strong>
</p>

<p class="mb-0">
Last Quiz:
<strong>
<?php
if($lastquiz){
echo date("d M Y", strtotime($lastquiz['result_date']));
}else{
echo "No Attempt";
}
?>
</strong>
</p>

</div>

<!-- Recent Certificates -->

<div class="card shadow border-0 rounded-4 p-4 mt-4">

<h4 class="text-success mb-3">Recent Certificates</h4>

<?php
$q = mysqli_query($conn,"
SELECT categories.category_name, certificates.issued_date
FROM certificates
JOIN categories ON categories.category_id=certificates.category_id
WHERE certificates.student_id='$student_id'
ORDER BY certificate_id DESC
LIMIT 5
");

if(mysqli_num_rows($q)>0){

while($row=mysqli_fetch_assoc($q)){
?>

<div class="d-flex justify-content-between border-bottom py-2">
<span><?php echo $row['category_name']; ?></span>
<small class="text-muted">
<?php echo date("d M Y", strtotime($row['issued_date'])); ?>
</small>
</div>

<?php } } else { ?>

<p class="text-muted">No certificates yet.</p>

<?php } ?>

</div>

</div>

</div>

</div>
</div>