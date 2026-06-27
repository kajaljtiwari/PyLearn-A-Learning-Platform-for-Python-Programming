<?php
session_start();
require_once("includes/config.php");

if(!isset($_SESSION['student_id'])){
    header("Location:index2.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* Student Data */
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$student_id'"));

/* Enrolled Courses */
$enrolled = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total 
FROM enrollments 
WHERE student_id='$student_id'"
))['total'];

/* 🔥 FIXED: Topics only for enrolled courses */
$topics = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(t.topic_id) as total
FROM topics t
JOIN enrollments e 
ON t.category_id = e.category_id
WHERE e.student_id='$student_id'
"))['total'];

/* Quiz Attempts */
$results = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total 
FROM results 
WHERE student_id='$student_id'"
))['total'];

/* Certificates */
$certificates = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total 
FROM certificates 
WHERE student_id='$student_id'"
))['total'];

/* Safe Average */
$avgData = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT AVG(percentage) as avgp 
FROM results 
WHERE student_id='$student_id'"
));

$avg = $avgData['avgp'] ? round($avgData['avgp']) : 0;

/* Avatar */
$fullName = trim($user['full_name']);
$nameParts = explode(" ", $fullName);

$first = strtoupper(substr($nameParts[0],0,1));
$second = isset($nameParts[1]) ? strtoupper(substr($nameParts[1],0,1)) : "";

$initials = $first.$second;?>

<!DOCTYPE html>
<html>
<head>
<title>PyLearn Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fa;
}

.sidebar{
min-height:100vh;
background:#198754;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:12px;
margin-bottom:8px;
border-radius:8px;
transition:.3s;
}

.sidebar a:hover{
background:white;
color:#198754;
}

.card-box{
border:none;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.avatar-circle{
width:45px;
height:45px;
border-radius:50%;
background:#198754;
color:white;
display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
font-size:16px;
}

.progress{
height:12px;
}

.table thead{
background:#198754;
color:white;
}

@media(max-width:768px){
.sidebar{
min-height:auto;
}
}

</style>

</head>
<body>
    

<div class="container-fluid">
<div class="row">

<!-- Sidebar -->

<div class="col-md-2 p-3 sidebar">

<h3 class="text-white mb-4">PyLearn</h3>

<a href="#">Dashboard</a>
<a href="student-home.php">Home</a>
<a href="courses.php">Courses</a>
<a href="quiz.php">Quiz</a>
<a href="certificate.php">Certificates</a>
<a href="profile.php">Profile</a>
<a href="student-logout.php">Logout</a>

</div>

<!-- Main Content -->

<div class="col-md-10 p-4">

<!-- Topbar -->

<div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm mb-4">

<div>
<h4 class="text-success mb-0">Student Dashboard</h4>
<small class="text-muted">Welcome back to PyLearn</small>
</div>

<div class="dropdown">

<a href="#"
class="d-flex align-items-center text-decoration-none dropdown-toggle"
data-bs-toggle="dropdown">

<div class="avatar-circle me-2">
<?php echo $initials; ?>
</div>

<div>
<b class="text-dark"><?php echo $user['full_name']; ?></b><br>
<small class="text-muted"><?php echo $user['email']; ?></small>
</div>

</a>

<ul class="dropdown-menu dropdown-menu-end shadow">

<li>
<a class="dropdown-item" href="profile.php">👤 My Profile</a>
</li>

<li>
<a class="dropdown-item" href="edit-profile.php">✏ Edit Profile</a>
</li>

<li>
<a class="dropdown-item" href="change-password.php">🔒 Change Password</a>
</li>

<li><hr class="dropdown-divider"></li>

<li>
<a class="dropdown-item text-danger" href="student-logout.php">🚪 Logout</a>
</li>

</ul>

</div>

</div>

<!-- Cards -->

<div class="row g-4">

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Enrolled Courses</h6>
<h2 class="text-success"><?php echo $enrolled; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Total Topics</h6>
<h2 class="text-success"><?php echo $topics; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Quiz Attempts</h6>
<h2 class="text-success"><?php echo $results; ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card card-box p-3">
<h6>Certificates</h6>
<h2 class="text-success"><?php echo $certificates; ?></h2>
</div>
</div>

</div>

<!-- Performance -->

<div class="card card-box mt-4 p-4">

<h5>Overall Performance</h5>
<p><?php echo $avg; ?>%</p>

<div class="progress">
<div class="progress-bar bg-success" style="width:<?php echo $avg; ?>%"></div>
</div>

</div>

<!-- Recent Results -->

<div class="card card-box mt-4 p-4">

<h5 class="mb-3">Recent Quiz Results</h5>

<table class="table table-bordered">

<thead>
<tr>
<th>Course</th>
<th>Score</th>
<th>Percentage</th>
</tr>
</thead>

<tbody>

<?php
$q=mysqli_query($conn,"
SELECT categories.category_name,results.score,results.percentage
FROM results
JOIN categories ON categories.category_id=results.category_id
WHERE results.student_id='$student_id'
ORDER BY result_id DESC LIMIT 5
");

while($row=mysqli_fetch_assoc($q)){
?>

<tr>
<td><?php echo $row['category_name']; ?></td>
<td><?php echo $row['score']; ?></td>
<td><?php echo $row['percentage']; ?>%</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>