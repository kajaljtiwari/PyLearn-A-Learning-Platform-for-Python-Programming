<?php
session_start();
include('includes/db.php');

$message = "";
$error   = "";

/* ---------- RESET PASSWORD ---------- */
if(isset($_POST['reset']))
{
    $username     = mysqli_real_escape_string($conn,$_POST['username']);
    $new_password = mysqli_real_escape_string($conn,$_POST['new_password']);

    $check = mysqli_query($conn,"
    SELECT * FROM admins
    WHERE username='$username'
    ");

    if(mysqli_num_rows($check)>0)
    {
        mysqli_query($conn,"
        UPDATE admins
        SET password='$new_password'
        WHERE username='$username'
        ");

        $message = "Password changed successfully.";
    }
    else
    {
        $error = "Username not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
background:url('img/bg.jpg');
background-size:cover;
background-position:center;
height:100vh;
margin:0;
}

.overlay{
background:rgba(0,0,0,.60);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.card{
width:420px;
border:none;
border-radius:18px;
overflow:hidden;
}

.card-header{
background:#0d6efd;
color:#fff;
text-align:center;
padding:18px;
font-size:24px;
font-weight:bold;
}

.card-body{
padding:30px;
}
</style>
</head>

<body>

<div class="overlay">

<div class="card shadow-lg">

<div class="card-header">
Forgot Password
</div>

<div class="card-body">

<?php if($message!=""){ ?>
<div class="alert alert-success">
<?php echo $message; ?>
</div>
<?php } ?>

<?php if($error!=""){ ?>
<div class="alert alert-danger">
<?php echo $error; ?>
</div>
<?php } ?>

<form method="POST">

<label class="mb-2">Username</label>
<input
type="text"
name="username"
class="form-control mb-3"
required>

<label class="mb-2">New Password</label>
<input
type="password"
name="new_password"
class="form-control mb-4"
required>

<button
type="submit"
name="reset"
class="btn btn-primary w-100 mb-3">
Reset Password
</button>

<a href="admin.php" class="btn btn-dark w-100">
Back to Login
</a>

</form>

</div>
</div>

</div>

</body>
</html>