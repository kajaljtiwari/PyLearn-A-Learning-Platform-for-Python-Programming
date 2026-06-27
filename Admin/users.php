<?php
      include('includes/auth.php');

include("includes/db.php");

/* DELETE STUDENT */

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM students WHERE student_id='$id'");

    echo "<script>
    alert('Student Deleted');
    window.location='users.php';
    </script>";
}

/* SEARCH */

$search = "";

if(isset($_GET['search']))
{
    $search = $_GET['search'];
}

/* PAGINATION */

$limit = 5;

$page = isset($_GET['page'])
? $_GET['page']
: 1;

$start = ($page - 1) * $limit;

/* QUERY */

if($search != "")
{
    $query = mysqli_query($conn,

    "SELECT * FROM students
     WHERE full_name LIKE '%$search%'
     OR email LIKE '%$search%'
     LIMIT $start,$limit"

    );
}
else
{
    $query = mysqli_query($conn,

    "SELECT * FROM students
     LIMIT $start,$limit"

    );
}

/* TOTAL RECORDS */

$total = mysqli_query($conn,
"SELECT COUNT(*) FROM students");

$total_rows =
mysqli_fetch_array($total)[0];

$total_pages =
ceil($total_rows / $limit);

include('includes/header.php');
include('includes/sidebar.php');
?>

<!DOCTYPE html>
<html>
<head>

<title>All Students</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

.main{
margin-left:250px;
padding:30px;
}

.card{
padding:25px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
}

</style>

</head>

<body>

<div class="main">

<div class="card">

<h2 class="mb-3">
All Students
</h2>

<!-- SEARCH -->

<form method="GET" class="mb-3">

<div class="row">

<div class="col-md-4">

<input
type="text"
name="search"
value="<?php echo $search; ?>"
class="form-control"
placeholder="Search name or email">

</div>

<div class="col-md-2">

<button class="btn btn-primary">
Search
</button>

</div>

</div>

</form>

<table class="table table-bordered table-striped">

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Mobile</th>
<th>Action</th>

</tr>

<?php

if(mysqli_num_rows($query) > 0)
{
    while($row =
    mysqli_fetch_assoc($query))
    {
?>

<tr>

<td>
<?php echo $row['student_id']; ?>
</td>

<td>
<?php echo $row['full_name']; ?>
</td>

<td>
<?php echo $row['email']; ?>
</td>

<td>
<?php echo $row['mobile']; ?>
</td>

<td>

<a
href="users.php?delete=<?php echo $row['student_id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete student?')">

Delete

</a>

</td>

</tr>

<?php
    }
}
else
{
?>

<tr>
<td colspan="5">
No Students Found
</td>
</tr>

<?php
}

?>

</table>

<!-- PAGINATION -->

<nav>

<ul class="pagination">

<?php

for($i=1; $i <= $total_pages; $i++)
{

?>

<li class="page-item">

<a
class="page-link"
href="users.php?page=<?php echo $i; ?>">

<?php echo $i; ?>

</a>

</li>

<?php

}

?>

</ul>

</nav>

</div>

</div>

</body>
</html>