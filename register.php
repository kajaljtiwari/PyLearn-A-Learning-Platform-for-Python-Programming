<?php
session_start();
include('includes/db.php');

if(isset($_POST['register']))
{
    $name     = mysqli_real_escape_string($conn,$_POST['full_name']);
    $email    = mysqli_real_escape_string($conn,$_POST['email']);
    $mobile   = mysqli_real_escape_string($conn,$_POST['mobile']);
    $password = $_POST['password'];

    $check = mysqli_query($conn,"SELECT * FROM students WHERE email='$email'");

    if(mysqli_num_rows($check)>0)
    {
        echo "exists";
        exit();
    }

    $hash = password_hash($password,PASSWORD_DEFAULT);

    mysqli_query($conn,"
    INSERT INTO students(full_name,email,mobile,password)
    VALUES('$name','$email','$mobile','$hash')
    ");

    echo "success";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
background:linear-gradient(135deg,#0d6efd,#198754);
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}
.card{
width:430px;
border:none;
border-radius:18px;
}
</style>
</head>

<body>

<div class="card shadow p-4">

<h3 class="text-center mb-4">Student Registration</h3>

<form id="regForm">

<input type="text" id="full_name" class="form-control mb-3" placeholder="Full Name" required>

<input type="email" id="email" class="form-control mb-3" placeholder="Email" required>

<input type="text" id="mobile" class="form-control mb-3" placeholder="Mobile" required>

<input type="password" id="password" class="form-control mb-3" placeholder="Password" required>

<button type="submit" class="btn btn-success w-100">
Register
</button>

<div class="text-center mt-3">
<a href="student-login.php">Already have account? Login</a>
</div>

</form>

</div>

<script>
document.getElementById("regForm").addEventListener("submit",function(e){

e.preventDefault();

let fd = new FormData();

fd.append("register",1);
fd.append("full_name",full_name.value);
fd.append("email",email.value);
fd.append("mobile",mobile.value);
fd.append("password",password.value);

fetch("student-register.php",{
method:"POST",
body:fd
})
.then(res=>res.text())
.then(data=>{

if(data.trim()=="exists")
{
Swal.fire("Error","Email already registered","error");
}
else if(data.trim()=="success")
{
Swal.fire("Success","Registration Complete","success")
.then(()=>{
window.location="student-login.php";
});
}

});

});
</script>

</body>
</html>