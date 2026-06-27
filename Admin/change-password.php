<?php
include('includes/auth.php');

$msg = "";
$admin = $_SESSION['admin'];

if(isset($_POST['save']))
{
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    $check = mysqli_query($conn,"
    SELECT * FROM admins
    WHERE username='$admin'
    AND password='$old'
    ");

    if(mysqli_num_rows($check)>0)
    {
        mysqli_query($conn,"
        UPDATE admins
        SET password='$new'
        WHERE username='$admin'
        ");

        $msg = "Password changed successfully.";
    }
    else
    {
        $msg = "Old password incorrect.";
    }
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">

<div class="section">

<h2 class="mb-4">Change Password</h2>

<?php if($msg!=""){ ?>
<div class="alert alert-info">
<?php echo $msg; ?>
</div>
<?php } ?>

<form method="POST">

<label>Old Password</label>
<input
type="password"
name="old_password"
class="form-control mb-3"
required>

<label>New Password</label>
<input
type="password"
name="new_password"
class="form-control mb-4"
required>

<button
type="submit"
name="save"
class="btn btn-primary">
Update Password
</button>

</form>

</div>

</div>

<?php include('includes/footer.php'); ?>