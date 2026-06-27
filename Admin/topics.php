<?php

include('includes/auth.php');
include('includes/config.php');
include('includes/header.php');
include('includes/sidebar.php');

/* ADD TOPIC */

if(isset($_POST['add']))
{
    $category_id = $_POST['category_id'];

    $title = mysqli_real_escape_string(
    $conn,
    $_POST['title']
    );

    $content = mysqli_real_escape_string(
    $conn,
    $_POST['content']
    );

    $example_code = mysqli_real_escape_string(
    $conn,
    $_POST['example_code']
    );

    mysqli_query($conn,"
    INSERT INTO topics
    (category_id,title,content,example_code)
    VALUES
    ('$category_id','$title','$content','$example_code')
    ");

    echo "<script>
    alert('Topic Added');
    window.location='topics.php';
    </script>";
}

/* DELETE */

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,"
    DELETE FROM topics
    WHERE topic_id='$id'
    ");

    echo "<script>
    alert('Topic Deleted');
    window.location='topics.php';
    </script>";
}

/* UPDATE */

if(isset($_POST['update']))
{
    $id = $_POST['topic_id'];

    $category_id = $_POST['category_id'];

    $title = mysqli_real_escape_string(
    $conn,
    $_POST['title']
    );

    $content = mysqli_real_escape_string(
    $conn,
    $_POST['content']
    );

    $example_code = mysqli_real_escape_string(
    $conn,
    $_POST['example_code']
    );

    mysqli_query($conn,"
    UPDATE topics
    SET
    category_id='$category_id',
    title='$title',
    content='$content',
    example_code='$example_code'
    WHERE topic_id='$id'
    ");

    echo "<script>
    alert('Topic Updated');
    window.location='topics.php';
    </script>";
}

?>

<div class="main">

<h2 class="mb-4">
Manage Topics
</h2>

<!-- ADD TOPIC -->

<div class="card p-3 mb-4">

<form method="POST">

<div class="row mb-3">

<div class="col-md-4">

<select
name="category_id"
class="form-control"
required>

<option value="">
Select Category
</option>

<?php

$cat =
mysqli_query(
$conn,
"SELECT * FROM categories"
);

while($c =
mysqli_fetch_assoc($cat))
{

?>

<option
value="<?php echo
$c['category_id']; ?>">

<?php echo
$c['category_name']; ?>

</option>

<?php

}

?>

</select>

</div>

<div class="col-md-4">

<input
type="text"
name="title"
class="form-control"
placeholder="Enter Topic Title"
required>

</div>

</div>

<div class="row mb-3">

<div class="col-md-6">

<textarea
name="content"
class="form-control"
rows="3"
placeholder="Enter Topic Content"
required></textarea>

</div>

<div class="col-md-6">

<textarea
name="example_code"
class="form-control"
rows="3"
placeholder="Enter Example Code"
required></textarea>

</div>

</div>

<button
name="add"
class="btn btn-primary">

Add Topic

</button>

</form>

</div>

<!-- TOPIC LIST -->

<div class="card p-3">

<table class="table table-bordered">

<tr>

<th>ID</th>
<th>Category</th>
<th>Title</th>
<th>Content</th>
<th>Example Code</th>
<th>Action</th>

</tr>

<?php

$query =
mysqli_query($conn,"
SELECT topics.*,
categories.category_name
FROM topics
JOIN categories
ON topics.category_id =
categories.category_id
ORDER BY topic_id DESC
");

while($row =
mysqli_fetch_assoc($query))
{

?>

<tr>

<form method="POST">

<td>

<?php
echo $row['topic_id'];
?>

<input
type="hidden"
name="topic_id"
value="<?php echo
$row['topic_id']; ?>">

</td>

<td>

<select
name="category_id"
class="form-control">

<?php

$cat2 =
mysqli_query(
$conn,
"SELECT * FROM categories"
);

while($c2 =
mysqli_fetch_assoc($cat2))
{

?>

<option

value="<?php echo
$c2['category_id']; ?>"

<?php

if(
$c2['category_id']
==
$row['category_id']
)
echo "selected";

?>

>

<?php echo
$c2['category_name']; ?>

</option>

<?php

}

?>

</select>

</td>

<td>

<input
type="text"
name="title"
value="<?php echo
$row['title']; ?>"
class="form-control">

</td>

<td>

<textarea
name="content"
class="form-control"
rows="2">

<?php
echo $row['content'];
?>

</textarea>

</td>

<td>

<textarea
name="example_code"
class="form-control"
rows="2">

<?php
echo $row['example_code'];
?>

</textarea>

</td>

<td>

<button
name="update"
class="btn btn-success btn-sm mb-1">

Edit

</button>

<a
href="topics.php?delete=<?php echo
$row['topic_id']; ?>"

class="btn btn-danger btn-sm"

onclick="
return confirm(
'Delete this topic?'
)">

Delete

</a>

</td>

</form>

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