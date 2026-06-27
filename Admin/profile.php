<?php
include('includes/auth.php');

$admin = $_SESSION['admin'];
$msg = "";

/* ---------- UPDATE PROFILE ---------- */
if(isset($_POST['update_profile']))
{
    $full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
    $email     = mysqli_real_escape_string($conn,$_POST['email']);
    $mobile    = mysqli_real_escape_string($conn,$_POST['mobile']);

    mysqli_query($conn,"
    UPDATE admins SET
    full_name='$full_name',
    email='$email',
    mobile='$mobile'
    WHERE username='$admin'
    ");

    $msg = "Profile Updated Successfully.";
}

/* ---------- FETCH DATA ---------- */
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM admins
WHERE username='$admin'
"));

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">

<div class="section">

<h2 class="mb-4">My Profile</h2>

<?php if($msg!=""){ ?>
<div class="alert alert-success">
<?php echo $msg; ?>
</div>
<?php } ?>

<div class="text-center mb-4">

<?php if(!empty($data['photo'])){ ?>

<img
src="uploads/<?php echo $data['photo']; ?>"
width="140"
height="140"
style="border-radius:50%;object-fit:cover;border:4px solid #0d6efd;">

<?php } else { ?>

<img
src="img/adminimg.jpeg"
width="140"
height="140"
style="border-radius:50%;border:4px solid #0d6efd;">

<?php } ?>

</div>

<form method="POST">

<table class="table table-bordered table-striped">

<tr>
<th width="250">Username</th>
<td><?php echo $data['username']; ?></td>
</tr>

<tr>
<th>Password</th>
<td><?php echo $data['password']; ?></td>
</tr>

<tr>
<th>Full Name</th>
<td>
<input
type="text"
name="full_name"
class="form-control"
value="<?php echo $data['full_name']; ?>">
</td>
</tr>

<tr>
<th>Email ID</th>
<td>
<input
type="email"
name="email"
class="form-control"
value="<?php echo $data['email']; ?>">
</td>
</tr>

<tr>
<th>Contact Number</th>
<td>
<input
type="text"
name="mobile"
class="form-control"
value="<?php echo $data['mobile']; ?>">
</td>
</tr>

<tr>
<th>Role</th>
<td>Administrator</td>
</tr>

<tr>
<th>Status</th>
<td>
<span class="badge bg-success">
Active
</span>
</td>
</tr>

</table>

<button
type="submit"
name="update_profile"
class="btn btn-success">
Save Changes
</button>

<a href="change-password.php"
class="btn btn-primary">
Change Password
</a>



</form>

</div>

</div>

<?php include('includes/footer.php'); ?>