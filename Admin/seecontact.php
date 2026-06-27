<?php
include("../includes/config.php");
include("sidebar.php");
?>

<div class="main">
<div class="card">

<h2>All Users</h2>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
</tr>

<?php
$query = mysqli_query($conn, "SELECT * FROM users");

while($row = mysqli_fetch_assoc($query))
{
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
</tr>

<?php } ?>

</table>

</div>
</div>