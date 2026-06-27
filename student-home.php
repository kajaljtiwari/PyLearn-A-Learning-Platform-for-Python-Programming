<!-- student-home.php -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");
include("includes/header.php");

$student_id = $_SESSION['student_id'];

$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$student_id'"));

$courses = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM enrollments WHERE student_id='$student_id'"))['total'];

$quiz = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM results WHERE student_id='$student_id'"))['total'];

$certificates = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM certificates WHERE student_id='$student_id'"))['total'];
?>

<!-- Bootstrap -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fa;
}

.hero-box{
background:linear-gradient(135deg,#198754,#28a745);
color:white;
border-radius:22px;
padding:35px;
box-shadow:0 10px 30px rgba(0,0,0,.12);
}

.stat-card{
border:none;
border-radius:20px;
transition:.3s;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.stat-card:hover{
transform:translateY(-5px);
}

.course-card{
border:none;
border-radius:22px;
transition:.3s;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.course-card:hover{
transform:translateY(-6px);
}

.course-icon{
width:65px;
height:65px;
border-radius:50%;
background:#e9f8ef;
display:flex;
align-items:center;
justify-content:center;
font-size:28px;
margin:auto;
color:#198754;
font-weight:bold;
}

.section-title{
font-weight:700;
color:#198754;
}

.btn-custom{
border-radius:30px;
padding:10px 22px;
font-weight:600;
}

</style>

<div class="container py-5">

<!-- Hero Section -->

<div class="hero-box mb-5">

<div class="row align-items-center">

<div class="col-md-8">
<h2 class="fw-bold mb-2">
Welcome, <?php echo $user['full_name']; ?>
</h2>

<p class="mb-0 fs-5">
Continue your learning journey with PyLearn 🚀
</p>
</div>

<div class="col-md-4 text-md-end mt-4 mt-md-0">

<a href="student-dashboard.php"
class="btn btn-light btn-custom me-2">
Dashboard
</a>

<a href="profile.php"
class="btn btn-outline-light btn-custom">
My Profile
</a>

</div>

</div>

</div>

<!-- Stats -->

<div class="row g-4 mb-5">

<div class="col-md-4">
<div class="card stat-card p-4 text-center">
<h6 class="text-muted">My Courses</h6>
<h2 class="text-success fw-bold"><?php echo $courses; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card stat-card p-4 text-center">
<h6 class="text-muted">Quiz Attempts</h6>
<h2 class="text-success fw-bold"><?php echo $quiz; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card stat-card p-4 text-center">
<h6 class="text-muted">Certificates</h6>
<h2 class="text-success fw-bold"><?php echo $certificates; ?></h2>
</div>
</div>

</div>

<!-- Courses -->

<div class="d-flex justify-content-between align-items-center mb-4">
<h3 class="section-title">Available Courses</h3>
</div>

<div class="row g-4">

<?php
$q=mysqli_query($conn,"SELECT * FROM categories ORDER BY category_id DESC");

while($row=mysqli_fetch_assoc($q)){

$first = strtoupper(substr($row['category_name'],0,1));
?>

<div class="col-md-4">

<div class="card course-card p-4 text-center h-100">

<div class="course-icon mb-3">
<?php echo $first; ?>
</div>

<h4 class="text-success fw-bold">
<?php echo $row['category_name']; ?>
</h4>

<p class="text-muted">
Learn complete <?php echo $row['category_name']; ?>
course step by step.
</p>

<a href="course-details.php?id=<?php echo $row['category_id']; ?>"
class="btn btn-success btn-custom mt-2">
Open Course
</a>

</div>

</div>

<?php } ?>

</div>

<!-- Footer Buttons -->

<div class="text-center mt-5">

<a href="quiz.php"
class="btn btn-success btn-custom me-2">
Take Quiz
</a>

<a href="certificate.php"
class="btn btn-outline-success btn-custom">
My Certificates
</a>

</div>

</div>