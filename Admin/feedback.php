<?php

include('includes/auth.php');
include('includes/config.php');
include('includes/header.php');
include('includes/sidebar.php');

/* DELETE FEEDBACK */

if(isset($_GET['delete']))
{
    $id = intval($_GET['delete']);

    mysqli_query($conn,"
    DELETE FROM feedback
    WHERE id = $id
    ");

    echo "<script>
    alert('Feedback Deleted Successfully');
    window.location='feedback.php';
    </script>";
}

?>

<div class="main">

<h2 class="mb-4">
User Feedback & Ratings
</h2>

<div class="card p-3">

<table class="table table-bordered table-striped">

<tr>

<th>ID</th>
<th>User Name</th>
<th>Email</th>
<th>Rating</th>
<th>Message</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

$query = mysqli_query($conn, "

SELECT

feedback.id,
feedback.user_id,
feedback.rating,
feedback.message,
feedback.created_at,
users.name,
users.email

FROM feedback

LEFT JOIN users
ON feedback.user_id = users.id

ORDER BY feedback.id DESC

");

/* CHECK IF NO DATA */

if(mysqli_num_rows($query) == 0)
{
    echo "
    <tr>
    <td colspan='7'
    style='text-align:center;
    font-weight:bold;'>

    No feedback found

    </td>
    </tr>
    ";
}

while($row = mysqli_fetch_assoc($query))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php

if($row['name'])
{
    echo $row['name'];
}
else
{
    echo "Unknown User";
}

?>

</td>

<td>

<?php

if($row['email'])
{
    echo $row['email'];
}
else
{
    echo "-";
}

?>

</td>

<td>

<?php

$rating = $row['rating'];

for($i=1; $i<=5; $i++)
{
    if($i <= $rating)
    {
        echo "<span style='color:gold;
        font-size:18px;'>★</span>";
    }
    else
    {
        echo "<span style='color:#ccc;
        font-size:18px;'>★</span>";
    }
}

?>

</td>

<td>

<?php echo $row['message']; ?>

</td>

<td>

<?php echo $row['created_at']; ?>

</td>

<td>

<a

href="feedback.php?delete=
<?php echo $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm(
'Delete this feedback?')">

Delete

</a>

</td>

</tr>

<?php
}
?>

</table>

</div>

</div>

<?php include('includes/footer.php'); ?>