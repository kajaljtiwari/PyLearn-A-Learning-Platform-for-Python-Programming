<?php

include('includes/auth.php');
include('includes/config.php');
include('includes/header.php');
include('includes/sidebar.php');

/* ADD CATEGORY */

if(isset($_POST['add']))
{
    $name = mysqli_real_escape_string(
    $conn,
    $_POST['category_name']
    );

    mysqli_query($conn,
    "INSERT INTO categories
    (category_name)
    VALUES('$name')"
    );

    echo "<script>
    alert('Category Added');
    window.location='categories.php';
    </script>";
}

/* DELETE CATEGORY */

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM categories
     WHERE category_id='$id'"
    );

    echo "<script>
    alert('Category Deleted');
    window.location='categories.php';
    </script>";
}

/* UPDATE CATEGORY */

if(isset($_POST['update']))
{
    $id = $_POST['category_id'];

    $name = mysqli_real_escape_string(
    $conn,
    $_POST['category_name']
    );

    mysqli_query($conn,
    "UPDATE categories
     SET category_name='$name'
     WHERE category_id='$id'"
    );

    echo "<script>
    alert('Category Updated');
    window.location='categories.php';
    </script>";
}

?>

<div class="main">

<h2 class="mb-4">
Manage Categories
</h2>

<!-- ADD CATEGORY -->

<div class="card p-3 mb-4">

<form method="POST">

<div class="row">

<div class="col-md-6">

<input
type="text"
name="category_name"
class="form-control"
placeholder="Enter Category Name"
required>

</div>

<div class="col-md-3">

<button
name="add"
class="btn btn-primary">

Add Category

</button>

</div>

</div>

</form>

</div>

<!-- CATEGORY LIST -->

<div class="card p-3">

<table
class="table table-bordered table-striped">

<tr>

<th>ID</th>
<th>Category Name</th>
<th>Action</th>

</tr>

<?php

$query = mysqli_query(
$conn,
"SELECT * FROM categories
ORDER BY category_id DESC"
);

while($row =
mysqli_fetch_assoc($query))
{

?>

<tr>

<td>
<?php echo
$row['category_id'];
?>
</td>

<td>

<form method="POST"
style="display:flex;">

<input
type="hidden"
name="category_id"
value="<?php echo
$row['category_id']; ?>">

<input
type="text"
name="category_name"
value="<?php echo
$row['category_name']; ?>"
class="form-control me-2">

<button
name="update"
class="btn btn-success btn-sm me-2">

Edit

</button>

<a
href="categories.php?delete=<?php echo
$row['category_id']; ?>"

class="btn btn-danger btn-sm"

onclick="
return confirm(
'Delete this category?'
)">

Delete

</a>

</form>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

<?php
include('includes/footer.php');
?>