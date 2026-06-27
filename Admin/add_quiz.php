<?php
include('includes/auth.php');

/* ---------- ADD ---------- */
if(isset($_POST['ajax_add']))
{
    $category_id = (int)$_POST['category_id'];

    $question = mysqli_real_escape_string($conn,$_POST['question']);
    $a = mysqli_real_escape_string($conn,$_POST['option_a']);
    $b = mysqli_real_escape_string($conn,$_POST['option_b']);
    $c = mysqli_real_escape_string($conn,$_POST['option_c']);
    $d = mysqli_real_escape_string($conn,$_POST['option_d']);
    $correct = mysqli_real_escape_string($conn,$_POST['correct_answer']);

    mysqli_query($conn,"
    INSERT INTO quizzes
    (
        category_id,
        question,
        option_a,
        option_b,
        option_c,
        option_d,
        correct_answer
    )
    VALUES
    (
        '$category_id',
        '$question',
        '$a',
        '$b',
        '$c',
        '$d',
        '$correct'
    )
    ");

    $id = mysqli_insert_id($conn);

    $cat = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT category_name
    FROM categories
    WHERE category_id='$category_id'
    "));

    echo $id."|".$cat['category_name']."|".$question."|".$correct;
    exit();
}

/* ---------- DELETE ---------- */
if(isset($_POST['ajax_delete']))
{
    $id = (int)$_POST['ajax_delete'];

    mysqli_query($conn,"
    DELETE FROM quizzes
    WHERE id='$id'
    ");

    echo "success";
    exit();
}

/* ---------- UPDATE ---------- */
if(isset($_POST['ajax_update']))
{
    $id = (int)$_POST['quiz_id'];
    $category_id = (int)$_POST['category_id'];

    $question = mysqli_real_escape_string($conn,$_POST['question']);
    $a = mysqli_real_escape_string($conn,$_POST['option_a']);
    $b = mysqli_real_escape_string($conn,$_POST['option_b']);
    $c = mysqli_real_escape_string($conn,$_POST['option_c']);
    $d = mysqli_real_escape_string($conn,$_POST['option_d']);
    $correct = mysqli_real_escape_string($conn,$_POST['correct_answer']);

    mysqli_query($conn,"
    UPDATE quizzes SET

    category_id='$category_id',
    question='$question',
    option_a='$a',
    option_b='$b',
    option_c='$c',
    option_d='$d',
    correct_answer='$correct'

    WHERE id='$id'
    ");

    $cat = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT category_name
    FROM categories
    WHERE category_id='$category_id'
    "));

    echo $cat['category_name']."|".$question."|".$correct;
    exit();
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">

<h2 class="mb-4">Manage MCQ Quiz</h2>

<!-- Form -->
<div class="section">

<form id="quizForm">

<div class="row">

<div class="col-md-6 mb-3">
<label>Category</label>

<select
id="category_id"
class="form-control"
required>

<option value="">Choose Category</option>

<?php
$cat = mysqli_query($conn,"
SELECT * FROM categories
ORDER BY category_name ASC
");

while($c = mysqli_fetch_assoc($cat))
{
?>
<option value="<?php echo $c['category_id']; ?>">
<?php echo $c['category_name']; ?>
</option>
<?php } ?>

</select>
</div>

<div class="col-md-6 mb-3">
<label>Correct Answer</label>

<select
id="correct_answer"
class="form-control"
required>

<option value="">Choose</option>
<option>A</option>
<option>B</option>
<option>C</option>
<option>D</option>

</select>
</div>

</div>

<div class="mb-3">
<label>Question</label>

<textarea
id="question"
class="form-control"
rows="3"
required></textarea>
</div>

<div class="row">

<div class="col-md-6 mb-3">
<input
type="text"
id="option_a"
class="form-control"
placeholder="Option A"
required>
</div>

<div class="col-md-6 mb-3">
<input
type="text"
id="option_b"
class="form-control"
placeholder="Option B"
required>
</div>

<div class="col-md-6 mb-3">
<input
type="text"
id="option_c"
class="form-control"
placeholder="Option C"
required>
</div>

<div class="col-md-6 mb-3">
<input
type="text"
id="option_d"
class="form-control"
placeholder="Option D"
required>
</div>

</div>

<button
type="submit"
class="btn btn-primary">
Add Question
</button>

</form>

</div>

<!-- Table -->
<div class="section">

<table class="table table-bordered table-hover">

<thead>
<tr class="table-primary">
<th>ID</th>
<th>Category</th>
<th>Question</th>
<th>Answer</th>
<th width="220">Action</th>
</tr>
</thead>

<tbody id="quizTable">

<?php
$q = mysqli_query($conn,"
SELECT quizzes.*, categories.category_name
FROM quizzes
INNER JOIN categories
ON quizzes.category_id = categories.category_id
ORDER BY quizzes.id DESC
");

while($row = mysqli_fetch_assoc($q))
{
?>

<tr id="row<?php echo $row['id']; ?>">

<td><?php echo $row['id']; ?></td>

<td id="cat<?php echo $row['id']; ?>">
<?php echo $row['category_name']; ?>
</td>

<td id="ques<?php echo $row['id']; ?>">
<?php echo $row['question']; ?>
</td>

<td id="ans<?php echo $row['id']; ?>">
<?php echo $row['correct_answer']; ?>
</td>

<td>

<button
class="btn btn-warning btn-sm"
onclick="location.reload()">
Edit
</button>

<button
class="btn btn-danger btn-sm"
onclick="deleteQuiz(
<?php echo $row['id']; ?>
)">
Delete
</button>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

/* ---------- ADD ---------- */
document.getElementById("quizForm")
.addEventListener("submit",function(e){

e.preventDefault();

let fd = new FormData();

fd.append("ajax_add",1);
fd.append("category_id",category_id.value);
fd.append("question",question.value);
fd.append("option_a",option_a.value);
fd.append("option_b",option_b.value);
fd.append("option_c",option_c.value);
fd.append("option_d",option_d.value);
fd.append("correct_answer",correct_answer.value);

fetch("add_quiz.php",{
method:"POST",
body:fd
})
.then(res=>res.text())
.then(data=>{

let arr = data.split("|");

let row = `
<tr id="row${arr[0]}">

<td>${arr[0]}</td>

<td id="cat${arr[0]}">
${arr[1]}
</td>

<td id="ques${arr[0]}">
${arr[2]}
</td>

<td id="ans${arr[0]}">
${arr[3]}
</td>

<td>

<button class="btn btn-warning btn-sm"
onclick="location.reload()">
Edit
</button>

<button class="btn btn-danger btn-sm"
onclick="deleteQuiz(${arr[0]})">
Delete
</button>

</td>
</tr>
`;

document
.getElementById("quizTable")
.insertAdjacentHTML("afterbegin",row);

document
.getElementById("quizForm")
.reset();

Swal.fire(
"Success",
"Question Added",
"success"
);

});

});


/* ---------- DELETE ---------- */
function deleteQuiz(id)
{
Swal.fire({
title:"Delete Question?",
icon:"warning",
showCancelButton:true
})
.then((r)=>{

if(r.isConfirmed)
{
let fd = new FormData();

fd.append("ajax_delete",id);

fetch("add_quiz.php",{
method:"POST",
body:fd
})
.then(res=>res.text())
.then(data=>{

if(data.trim()=="success")
{
document
.getElementById("row"+id)
.remove();

Swal.fire(
"Deleted",
"Removed",
"success"
);
}

});

}

});
}

</script>

<?php include('includes/footer.php'); ?>