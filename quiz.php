<!-- quiz.php (Only enrolled course quizzes) -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:index2.php");
exit();
}

require_once("includes/config.php");
include("includes/student-layout.php");

$student_id=$_SESSION['student_id'];
?>

<div class="card shadow rounded-4 border-0 p-4">

<h2 class="text-success mb-4">
My Course Quizzes
</h2>

<table class="table table-bordered">

<tr>
<th>Course</th>
<th>Total Questions</th>
<th>Action</th>
</tr>

<?php
$q=mysqli_query($conn,"
SELECT categories.category_id,categories.category_name
FROM enrollments
JOIN categories
ON categories.category_id=enrollments.category_id
WHERE enrollments.student_id='$student_id'
");

while($row=mysqli_fetch_assoc($q)){

$cid=$row['category_id'];

$total=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM quizzes
WHERE category_id='$cid'"))['total'];
?>

<tr>
<td><?php echo $row['category_name']; ?></td>
<td><?php echo $total; ?></td>

<td>
<a href="start-quiz.php?id=<?php echo $cid; ?>"
class="btn btn-success btn-sm">
Start Quiz
</a>
</td>

</tr>

<?php } ?>

</table>

</div>

</div>
</div>