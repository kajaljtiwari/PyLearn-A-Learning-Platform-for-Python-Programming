<?php
include('includes/auth.php');

/* Logged Admin Data */
$admin = $_SESSION['admin'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM admins
WHERE username='$admin'
"));

/* COUNTS */

$total_categories =
mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM categories")
)['total'];

$total_topics =
mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) total FROM topics")
)['total'];

$total_quizzes =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(DISTINCT category_id) total
FROM quizzes
"))['total'];

$total_questions =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM quizzes
"))['total'];

/* USERS */
$total_users = 0;

$check = mysqli_query($conn,"
SHOW TABLES LIKE 'users'
");

if(mysqli_num_rows($check)>0)
{
$total_users =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total FROM users
"))['total'];
}

/* FEEDBACK */
$total_feedback = 0;

$check2 = mysqli_query($conn,"
SHOW TABLES LIKE 'feedback'
");

if(mysqli_num_rows($check2)>0)
{
$total_feedback =
mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total FROM feedback
"))['total'];
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">

<!-- Topbar -->
<div class="topbar">

<div>
<h3 class="mb-0">
Welcome, <?php echo $admin; ?> 👋
</h3>

<small class="text-muted">
Admin Control Panel
</small>
</div>

<?php
$photo = !empty($data['photo'])
? $data['photo']
: 'adminimg.jpeg';
?>

<div class="dropdown">

<div class="profile-img dropdown-toggle"
data-bs-toggle="dropdown">

<img
src="img/<?php echo $photo; ?>"
width="45"
height="45"
style="
border-radius:50%;
object-fit:cover;
cursor:pointer;
border:2px solid #0d6efd;
">

</div>

<ul class="dropdown-menu dropdown-menu-end">

<li>
<a class="dropdown-item"
href="profile.php">
My Profile
</a>
</li>

<li>
<a class="dropdown-item"
href="change-password.php">
Change Password
</a>
</li>



<li><hr class="dropdown-divider"></li>

<li>
<a class="dropdown-item text-danger"
href="logout.php">
Logout
</a>
</li>

</ul>

</div>

</div>
<!-- End Topbar -->


<!-- Stats -->
<div class="row g-4">

<div class="col-md-4">
<div class="stat-card">
<h5>Total Users</h5>
<h2><?php echo $total_users; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h5>Total Categories</h5>
<h2><?php echo $total_categories; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h5>Total Topics</h5>
<h2><?php echo $total_topics; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h5>Total Quiz Categories</h5>
<h2><?php echo $total_quizzes; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h5>Total Questions</h5>
<h2><?php echo $total_questions; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<h5>Total Feedback</h5>
<h2><?php echo $total_feedback; ?></h2>
</div>
</div>

</div>


<!-- Quick Actions -->
<div class="section mt-4">

<h4 class="mb-4">
Quick Actions
</h4>

<a href="add_category.php"
class="btn btn-primary w-100 mb-2">
Add Category
</a>

<a href="add_topic.php"
class="btn btn-success w-100 mb-2">
Add Topic
</a>

<a href="add_quiz.php"
class="btn btn-warning w-100 mb-2">
Add Quiz
</a>

<a href="results.php"
class="btn btn-dark w-100">
View Results
</a>

</div>

</div>

<?php include('includes/footer.php'); ?>