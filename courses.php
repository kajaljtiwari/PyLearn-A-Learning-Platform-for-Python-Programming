<!-- courses.php -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");

$student_id = $_SESSION['student_id'];

include("includes/student-layout.php");
?>

<div class="card shadow border-0 rounded-4 p-4">

<h2 class="text-success mb-4">My Learning Courses</h2>

<?php
$q = mysqli_query($conn,"
SELECT categories.category_id,categories.category_name
FROM enrollments
JOIN categories
ON categories.category_id=enrollments.category_id
WHERE enrollments.student_id='$student_id'
ORDER BY enroll_id DESC
");

if(mysqli_num_rows($q)>0){

while($cat=mysqli_fetch_assoc($q)){

$cid = $cat['category_id'];
?>

<div class="card shadow-sm border-0 rounded-4 mb-4">

<div class="card-header bg-success text-white rounded-top-4">
<h4 class="mb-0">
<?php echo $cat['category_name']; ?>
</h4>
</div>

<div class="card-body">

<div class="row g-3">

<?php
$t = mysqli_query($conn,"
SELECT * FROM topics
WHERE category_id='$cid'
ORDER BY topic_id ASC
");

if(mysqli_num_rows($t)>0){

while($topic=mysqli_fetch_assoc($t)){
?>

<div class="col-md-6">

<div class="border rounded-4 p-3 h-100">

<h5 class="text-success">
<?php echo $topic['title']; ?>
</h5>

<p class="text-muted">
<?php echo substr(strip_tags($topic['content']),0,120); ?>...
</p>

<a href="view-topic.php?id=<?php echo $topic['topic_id']; ?>"
class="btn btn-success btn-sm">
Read Topic
</a>

</div>

</div>

<?php } } else { ?>

<div class="col-12">
<p class="text-muted">
No topics available in this course.
</p>
</div>

<?php } ?>

</div>

</div>

</div>

<?php } } else { ?>

<div class="alert alert-warning">
You are not enrolled in any course yet.
</div>

<?php } ?>

</div>

</div>
</div>