<?php
session_start();
include('includes/db.php');
if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM admins WHERE username='$username' AND password='$password'");

    if(mysqli_num_rows($query)>0)
    {
        $_SESSION['admin'] = $username;
header("Location: dashboard.php");        exit();
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:url('img/bg.jpg');
    background-size:cover;
    background-position:center;
    height:100vh;
}

.overlay{
    background:rgba(0,0,0,0.55);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    border:none;
    border-radius:15px;
}
</style>

</head>

<body>

<div class="overlay">

<div class="col-md-4">

<div class="card shadow-lg">
<div class="card-header bg-primary text-white text-center">
<h3>Pylearn Admin Login</h3>
</div>

<div class="card-body">

<?php if(isset($error)){ ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>


<form method="POST">

<label>Username</label>
<input type="text" name="username" class="form-control mb-3" required>

<label>Password</label>
<input type="password" name="password" class="form-control mb-2" required>

<div class="d-flex justify-content-between mb-3">
<a href="forgot-password.php">Forgot Password?</a>
<a href="../index2.php">Go Home</a>
</div>

<button type="submit" name="login" class="btn btn-primary w-100">
Login
</button>

</form>

</div>
</div>

</div>

</div>

</body>
</html>