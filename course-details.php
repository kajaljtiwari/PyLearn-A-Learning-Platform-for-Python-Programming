<!-- course-details.php -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");
include("includes/student-layout.php");

$student_id=$_SESSION['student_id'];

if(!isset($_GET['id'])){
header("Location:index2.php");
exit();
}

$category_id=$_GET['id'];

$cat=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM categories WHERE category_id='$category_id'"));

/* Auto Enroll if not exists */

$check=mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM enrollments
WHERE student_id='$student_id'
AND category_id='$category_id'"));

if($check==0){

mysqli_query($conn,"
INSERT INTO enrollments(student_id,category_id)
VALUES('$student_id','$category_id')
");

}
?>

<div class="card shadow rounded-4 border-0 p-4">

<h2 class="text-success mb-4">
<?php echo $cat['category_name']; ?> Course
</h2>

<div class="row g-4">

<?php
$t=mysqli_query($conn,"
SELECT * FROM topics
WHERE category_id='$category_id'
ORDER BY topic_id ASC
");

if(mysqli_num_rows($t)>0){

while($topic=mysqli_fetch_assoc($t)){
?>

<div class="col-md-6">

<div class="card shadow-sm border-0 rounded-4 h-100 p-3">

<h5 class="text-success">
<?php echo $topic['title']; ?>
</h5>

<p class="text-muted">
<?php echo substr(strip_tags($topic['content']),0,120); ?>...
</p>

<a href="view-topic.php?id=<?php echo $topic['topic_id']; ?>"
class="btn btn-outline-success btn-sm">
Read Topic
</a>

</div>

</div>

<?php } } else { ?>

<p>No topics available.</p>

<?php } ?>

</div>

<hr class="my-4">

<a href="start-quiz.php?id=<?php echo $category_id; ?>"
class="btn btn-success">
Start <?php echo $cat['category_name']; ?> Quiz
</a>

<a href="quiz.php" class="btn btn-secondary">
All Quizzes
</a>

</div>

</div>
</div>