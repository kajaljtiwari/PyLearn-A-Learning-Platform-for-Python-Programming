<!-- view-topic.php -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");
include("includes/header.php");

if(!isset($_GET['id'])){
header("Location:student-home.php");
exit();
}

$topic_id = $_GET['id'];

/* Topic + Category */

$q = mysqli_query($conn,"
SELECT topics.*, categories.category_name
FROM topics
JOIN categories ON categories.category_id = topics.category_id
WHERE topics.topic_id='$topic_id'
");

if(mysqli_num_rows($q)==0){
header("Location:student-home.php");
exit();
}

$row = mysqli_fetch_assoc($q);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f5f7fa;
}

.topic-box{
background:white;
border-radius:24px;
padding:35px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.code-box{
background:#1e1e1e;
color:#00ff99;
padding:20px;
border-radius:16px;
overflow:auto;
font-family:monospace;
font-size:15px;
white-space:pre-wrap;
}

.badge-course{
background:#198754;
padding:8px 16px;
border-radius:30px;
font-size:14px;
}

.btn-custom{
padding:10px 22px;
border-radius:30px;
font-weight:600;
}

.topic-content{
line-height:1.8;
font-size:17px;
color:#333;
}

</style>

<div class="container py-5">

<div class="topic-box">

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

<div>
<span class="badge-course text-white">
<?php echo $row['category_name']; ?>
</span>

<h2 class="text-success fw-bold mt-3 mb-1">
<?php echo $row['title']; ?>
</h2>

<p class="text-muted mb-0">
Learn step by step with explanation & example
</p>
</div>

<div class="mt-3 mt-md-0">

<a href="course-details.php?id=<?php echo $row['category_id']; ?>"
class="btn btn-outline-success btn-custom me-2">
Back Course
</a>

<a href="quiz.php"
class="btn btn-success btn-custom">
Take Quiz
</a>

</div>

</div>

<hr>

<!-- Topic Content -->

<h4 class="text-success mb-3">📘 Explanation</h4>

<div class="topic-content mb-4">
<?php echo nl2br($row['content']); ?>
</div>

<!-- Example Code -->

<?php if(!empty($row['example_code'])){ ?>

<h4 class="text-success mb-3">💻 Example Code</h4>

<div class="code-box">
<?php echo htmlspecialchars($row['example_code']); ?>
</div>

<?php } ?>

<!-- Bottom Buttons -->

<div class="mt-5 text-center">

<a href="course-details.php?id=<?php echo $row['category_id']; ?>"
class="btn btn-outline-success btn-custom me-2">
Previous Page
</a>

<a href="student-home.php"
class="btn btn-success btn-custom">
Home
</a>

</div>

</div>

</div>