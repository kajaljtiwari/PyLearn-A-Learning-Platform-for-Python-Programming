<?php

include('includes/auth.php');
include('includes/config.php');
include('includes/header.php');
include('includes/sidebar.php');
?>

<style>
body{
margin:0;
font-family:Arial, sans-serif;
background:#f4f6f9;
}

.main{
margin-left:240px;
padding:20px;
}

.card{
background:#fff;
padding:20px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

h2{
margin-bottom:15px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:15px;
background:white;
}

table th{
background:#0d6efd;
color:white;
padding:12px;
text-align:left;
}

table td{
padding:10px;
border-bottom:1px solid #ddd;
}

table tr:hover{
background:#f1f1f1;
}

.btn{
background:#dc3545;
color:white;
padding:6px 10px;
text-decoration:none;
border-radius:5px;
font-size:14px;
}

.btn:hover{
background:#bb2d3b;
}

.pass{
color:green;
font-weight:bold;
}

.fail{
color:red;
font-weight:bold;
}
</style>

<div class="main">
<div class="card">

<h2>Quiz Results</h2>

<?php
// DELETE RESULT
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM results WHERE result_id='$id'");
    echo "<script>alert('Result Deleted'); window.location='results.php';</script>";
}
?>

<table>
<tr>
<th>ID</th>
<th>Student Name</th>
<th>Email</th>
<th>Category</th>
<th>Score</th>
<th>Total</th>
<th>Percentage</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php
$query = mysqli_query($conn, "

SELECT 
r.result_id,
s.full_name,
s.email,
c.category_name,
r.score,
r.total_questions,
r.percentage,
r.result_date

FROM results r

LEFT JOIN students s 
ON r.student_id = s.student_id

LEFT JOIN categories c 
ON r.category_id = c.category_id

ORDER BY r.result_id DESC

");

while($row = mysqli_fetch_assoc($query)){
?>

<tr>

<td><?php echo $row['result_id']; ?></td>

<td><?php echo !empty($row['full_name']) ? $row['full_name'] : "N/A"; ?></td>

<td><?php echo !empty($row['email']) ? $row['email'] : "N/A"; ?></td>

<td><?php echo !empty($row['category_name']) ? $row['category_name'] : "N/A"; ?></td>

<td><?php echo $row['score']; ?></td>

<td><?php echo $row['total_questions']; ?></td>

<td><?php echo $row['percentage']; ?>%</td>

<td>
<?php 
if($row['percentage'] >= 50){
    echo "<span class='pass'>Pass</span>";
}else{
    echo "<span class='fail'>Fail</span>";
}
?>
</td>

<td><?php echo $row['result_date']; ?></td>

<td>
<a href="results.php?delete=<?php echo $row['result_id']; ?>"
class="btn"
onclick="return confirm('Delete this result?')">
Delete
</a>
</td>

</tr>

<?php } ?>

</table>

</div>
</div>

<?php include('includes/footer.php'); ?>