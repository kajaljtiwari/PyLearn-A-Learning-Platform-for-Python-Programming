<?php

include('includes/auth.php');
include('includes/config.php');
include('includes/header.php');
include('includes/sidebar.php');

/* DELETE MESSAGE */

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    mysqli_query($conn,"
    DELETE FROM contact
    WHERE id='$id'
    ");

    echo "<script>
    alert('Message Deleted');
    window.location='contact.php';
    </script>";
}

?>

<div class="main">

<h2 class="mb-4">
Contact Messages
</h2>

<div class="card p-3">

<table class="table table-bordered table-striped">

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Message</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

$query = mysqli_query($conn,"
SELECT * FROM contact
ORDER BY id DESC
");

while($row = mysqli_fetch_assoc($query))
{

?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['email']; ?>
</td>

<td>
<?php echo $row['subject']; ?>
</td>

<td>
<?php echo $row['message']; ?>
</td>

<td>
<?php echo $row['created_at']; ?>
</td>

<td>

<a
href="contact.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this message?')">

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