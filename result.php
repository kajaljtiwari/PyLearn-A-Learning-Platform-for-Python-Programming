<?php

session_start();

include('includes/config.php');
include('includes/header.php');
include('includes/sidebar.php');

/* CHECK LOGIN */

if(!isset($_SESSION['student_id']))
{
    echo "<script>
    alert('Please login first');
    window.location='login.php';
    </script>";
    exit();
}

$student_id = $_SESSION['student_id'];

?>

<div class="main">

<h2 class="mb-4">
My Quiz Results
</h2>

<div class="card p-3">

<table class="table table-bordered table-striped">

<tr>

<th>ID</th>
<th>Category</th>
<th>Score</th>
<th>Total Questions</th>
<th>Percentage</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php

$query = mysqli_query($conn, "

SELECT

results.result_id,
results.score,
results.total_questions,
results.percentage,
results.result_date,
categories.category_name

FROM results

LEFT JOIN categories
ON results.category_id = categories.category_id

WHERE results.student_id = '$student_id'

ORDER BY results.result_id DESC

");

/* NO RESULTS MESSAGE */

if(mysqli_num_rows($query) == 0)
{
    echo "
    <tr>
    <td colspan='7'
    style='text-align:center;
    font-weight:bold;'>

    No results found

    </td>
    </tr>
    ";
}

while($row = mysqli_fetch_assoc($query))
{

$percentage = $row['percentage'];

/* PASS / FAIL */

if($percentage >= 40)
{
    $status = "
    <span style='color:green;
    font-weight:bold;'>
    Pass
    </span>";
}
else
{
    $status = "
    <span style='color:red;
    font-weight:bold;'>
    Fail
    </span>";
}

?>

<tr>

<td>
<?php echo $row['result_id']; ?>
</td>

<td>
<?php
echo $row['category_name']
? $row['category_name']
: "Category Deleted";
?>
</td>

<td>
<?php echo $row['score']; ?>
</td>

<td>
<?php echo $row['total_questions']; ?>
</td>

<td>
<?php echo number_format($percentage,2); ?>%
</td>

<td>
<?php echo $status; ?>
</td>

<td>
<?php echo $row['result_date']; ?>
</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

<?php include('includes/footer.php'); ?>