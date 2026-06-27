<!-- start-quiz.php (FINAL CORRECTED) -->

<?php
session_start();

if(!isset($_SESSION['student_id'])){
header("Location:student-home.php");
exit();
}

require_once("includes/config.php");

$student_id = $_SESSION['student_id'];

if(!isset($_GET['id'])){
header("Location:quiz.php");
exit();
}

$category_id = $_GET['id'];

/* Category */
$cat = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM categories WHERE category_id='$category_id'"));

if(!$cat){
header("Location:quiz.php");
exit();
}

/* Quiz Submit */
if(isset($_POST['submit_quiz'])){

$score = 0;
$total = 0;

$q = mysqli_query($conn,
"SELECT * FROM quizzes WHERE category_id='$category_id'");

while($row=mysqli_fetch_assoc($q)){

$total++;

$qid = $row['id'];
$correct = trim($row['correct_answer']);

$ans = isset($_POST['answer'][$qid])
? trim($_POST['answer'][$qid])
: '';

if($ans == $correct){
$score++;
}

}

/* Prevent divide by zero */
$percentage = ($total > 0) ? ($score/$total)*100 : 0;
$percentage = round($percentage,2);

/* Save Result */
mysqli_query($conn,"
INSERT INTO results
(student_id,category_id,score,total_questions,percentage)
VALUES
('$student_id','$category_id','$score','$total','$percentage')
");

/* AUTO CERTIFICATE */
$earned = false;

if($percentage >= 70){

$check = mysqli_query($conn,"
SELECT * FROM certificates
WHERE student_id='$student_id'
AND category_id='$category_id'
");

if(mysqli_num_rows($check) == 0){

$code = "CERT-" . strtoupper(uniqid());

mysqli_query($conn,"
INSERT INTO certificates
(student_id, category_id, certificate_code, percentage)
VALUES
('$student_id','$category_id','$code','$percentage')
");

}

$earned = true;
}

/* Session Result */
$_SESSION['quiz_score']   = $score;
$_SESSION['quiz_total']   = $total;
$_SESSION['quiz_percent'] = $percentage;
$_SESSION['quiz_earned']  = $earned;

header("Location:start-quiz.php?id=$category_id&result=1");
exit();
}

include("includes/student-layout.php");
?>

<div class="card shadow border-0 rounded-4 p-4">

<h2 class="text-success mb-4">
<?php echo $cat['category_name']; ?> Quiz
</h2>

<?php if(isset($_GET['result'])){ ?>

<div class="alert alert-light border rounded-4 p-4">

<h4 class="text-success mb-3">Quiz Result</h4>

<p>
<strong>Score:</strong>
<?php echo $_SESSION['quiz_score']; ?>
/
<?php echo $_SESSION['quiz_total']; ?>
</p>

<p>
<strong>Percentage:</strong>
<?php echo $_SESSION['quiz_percent']; ?>%
</p>

<?php if($_SESSION['quiz_earned']){ ?>

<div class="alert alert-success mt-3">
🎉 Congratulations! Certificate Earned
</div>

<a href="certificate.php"
class="btn btn-success">
View Certificate
</a>

<?php } else { ?>

<div class="alert alert-danger mt-3">
You need 70%+ score to earn certificate.
</div>

<?php } ?>

<a href="quiz.php"
class="btn btn-secondary mt-2">
Back to Quiz Page
</a>

</div>

<?php } else { ?>

<form method="post">

<?php
$i = 1;

$q = mysqli_query($conn,
"SELECT * FROM quizzes WHERE category_id='$category_id'");

if(mysqli_num_rows($q) > 0){

while($row=mysqli_fetch_assoc($q)){
?>

<div class="border rounded-4 p-4 mb-4">

<h5 class="mb-3">
Q<?php echo $i; ?>.
<?php echo $row['question']; ?>
</h5>

<div class="form-check mb-2">
<input class="form-check-input"
type="radio"
name="answer[<?php echo $row['id']; ?>]"
value="A"
required>

<label class="form-check-label">
<?php echo $row['option_a']; ?>
</label>
</div>

<div class="form-check mb-2">
<input class="form-check-input"
type="radio"
name="answer[<?php echo $row['id']; ?>]"
value="B">

<label class="form-check-label">
<?php echo $row['option_b']; ?>
</label>
</div>

<div class="form-check mb-2">
<input class="form-check-input"
type="radio"
name="answer[<?php echo $row['id']; ?>]"
value="C">

<label class="form-check-label">
<?php echo $row['option_c']; ?>
</label>
</div>

<div class="form-check">
<input class="form-check-input"
type="radio"
name="answer[<?php echo $row['id']; ?>]"
value="D">

<label class="form-check-label">
<?php echo $row['option_d']; ?>
</label>
</div>

</div>

<?php
$i++;
}

?>

<button type="submit"
name="submit_quiz"
class="btn btn-success">
Submit Quiz
</button>

<a href="quiz.php"
class="btn btn-secondary">
Back
</a>

<?php } else { ?>

<div class="alert alert-warning">
No quiz available for this course.
</div>

<a href="quiz.php"
class="btn btn-secondary">
Back
</a>

<?php } ?>

</form>

<?php } ?>

</div>

</div>
</div>