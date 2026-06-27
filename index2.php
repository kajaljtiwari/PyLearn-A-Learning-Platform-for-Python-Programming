<?php
session_start();
include_once('includes/config.php');

/* ================= REGISTER ================= */
if(isset($_POST['action']) && $_POST['action']=="register")
{
$name=trim($_POST['name']);
$email=trim($_POST['email']);
$mobile=trim($_POST['mobile']);
$password=$_POST['password'];

if(empty($name)||empty($email)||empty($mobile)||empty($password)){
echo "All fields required"; exit();
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
echo "Invalid email"; exit();
}

if(!preg_match('/^[0-9]{10}$/',$mobile)){
echo "Invalid mobile number"; exit();
}

if(strlen($password)<6){
echo "Password must be at least 6 characters"; exit();
}

$email=mysqli_real_escape_string($con,$email);

$check=mysqli_query($con,"SELECT * FROM students WHERE email='$email'");
if(mysqli_num_rows($check)>0){
echo "exists"; exit();
}

$hash=password_hash($password,PASSWORD_DEFAULT);

mysqli_query($con,"INSERT INTO students(full_name,email,mobile,password)
VALUES('$name','$email','$mobile','$hash')");

echo "success"; exit();
}

/* ================= LOGIN ================= */
if(isset($_POST['action']) && $_POST['action']=="login")
{
$email=trim($_POST['email']);
$password=$_POST['password'];

if(empty($email)||empty($password)){
echo "invalid"; exit();
}

$email=mysqli_real_escape_string($con,$email);

$q=mysqli_query($con,"SELECT * FROM students WHERE email='$email'");
if(mysqli_num_rows($q)>0)
{
$row=mysqli_fetch_assoc($q);

if(password_verify($password,$row['password']))
{
$_SESSION['student_id']=$row['student_id'];
$_SESSION['student_name']=$row['full_name'];

echo "login_success"; exit();
}
}

echo "invalid"; exit();
}

/* ================= TOPIC ================= */
$topicid = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = mysqli_query($con,"SELECT * FROM topics WHERE topic_id='$topicid'");

if(mysqli_num_rows($sql)>0){
    $row = mysqli_fetch_assoc($sql);
}else{
    $sql2 = mysqli_query($con,"SELECT * FROM topics LIMIT 1");
    $row = mysqli_fetch_assoc($sql2);
}

/* SAFE VARIABLES */
$title   = $row['title'] ?? "No Title";
$content = $row['content'] ?? "No Content Available";
$code    = $row['example_code'] ?? "No Code";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PyLearn</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{margin:0;font-family:Arial;background:#f4f6f9;}
.content{margin-left:250px;padding:30px;margin-top:100px;}
.topic-box{background:white;padding:30px;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,.08);}
pre{background:#eee;padding:15px;border-radius:8px;}

.swal2-container{z-index:20000 !important;}

/* POPUP */
.popup-overlay{
position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,.60);display:none;
justify-content:center;align-items:center;z-index:9999;
}

.popup-card{
width:520px;background:#fff;padding:35px;border-radius:18px;
position:relative;box-shadow:0 15px 40px rgba(0,0,0,.25);
}

.close-btn{position:absolute;top:10px;right:18px;font-size:32px;cursor:pointer;}

.tabs{display:flex;gap:10px;margin-bottom:25px;}
.tabs button{flex:1;padding:12px;border:none;border-radius:10px;font-weight:bold;background:#eee;}
.tabs .active{background:linear-gradient(90deg,#0d6efd,#d633ff);color:white;}

/* INPUT */
.input-group{position:relative;margin:20px 0;}
.input-group input{
width:100%;padding:10px;border:none;
border-bottom:2px solid #999;background:transparent;outline:none;
}
.input-group label{
position:absolute;top:10px;left:0;color:#777;transition:.3s;
}
.input-group input:focus ~ label,
.input-group input:valid ~ label{
top:-10px;font-size:12px;color:#000;
}

.eye{position:absolute;right:0;top:10px;cursor:pointer;}

.submit-btn{
width:100%;padding:12px;border:none;border-radius:10px;
background:linear-gradient(90deg,#0d6efd,#d633ff);color:white;
}

.error{color:red;font-size:13px;}
</style>
</head>

<body>

<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>

<div class="content">
<div class="topic-box">
<h2><?php echo $title; ?></h2>
<p><?php echo nl2br($content); ?></p>
<pre><?php echo $code; ?></pre>
</div>
</div>

<?php include('includes/footer.php'); ?>

<!-- POPUP -->
<div class="popup-overlay" id="popupBox">
<div class="popup-card">

<div class="close-btn" onclick="closePopup()">×</div>

<div class="tabs">
<button id="btnReg" class="active" onclick="showRegister()">Sign Up</button>
<button id="btnLog" onclick="showLogin()">Login</button>
</div>

<!-- REGISTER -->
<div id="registerArea">

<div class="input-group">
<input type="text" id="reg_name" required>
<label>Full Name</label>
</div>

<div class="input-group">
<input type="email" id="reg_email" required>
<label>Email</label>
</div>

<div class="input-group">
<input type="text" id="reg_mobile" required>
<label>Mobile</label>
</div>

<div class="input-group">
<input type="password" id="reg_pass" required>
<label>Password</label>
<span class="eye" onclick="togglePass('reg_pass')">👁️</span>
</div>

<small id="reg_error" class="error"></small>

<button class="submit-btn" onclick="registerUser()">Create Account</button>

</div>

<!-- LOGIN -->
<div id="loginArea" style="display:none;">
<input type="email" id="log_email" class="form-control mb-3" placeholder="Email">
<input type="password" id="log_pass" class="form-control mb-3" placeholder="Password">
<button class="submit-btn" onclick="loginUser()">Login</button>
</div>

</div>
</div>

<script>

function openPopup(type){
popupBox.style.display="flex";
(type=="login")?showLogin():showRegister();
}
function closePopup(){ popupBox.style.display="none"; }

function showRegister(){
registerArea.style.display="block";
loginArea.style.display="none";
btnReg.classList.add("active");
btnLog.classList.remove("active");
}
function showLogin(){
registerArea.style.display="none";
loginArea.style.display="block";
btnLog.classList.add("active");
btnReg.classList.remove("active");
}

function togglePass(id){
let i=document.getElementById(id);
i.type=(i.type==="password")?"text":"password";
}

/* REGISTER */
function registerUser(){
reg_error.innerText="";

let name=reg_name.value.trim();
let email=reg_email.value.trim();
let mobile=reg_mobile.value.trim();
let pass=reg_pass.value.trim();

if(name=="") return reg_error.innerText="Enter name";
if(!email.includes("@")) return reg_error.innerText="Invalid email";
if(mobile.length!=10) return reg_error.innerText="Invalid mobile";
if(pass.length<6) return reg_error.innerText="Password too short";

let fd=new FormData();
fd.append("action","register");
fd.append("name",name);
fd.append("email",email);
fd.append("mobile",mobile);
fd.append("password",pass);

fetch("",{method:"POST",body:fd})
.then(r=>r.text())
.then(d=>{
d=d.trim();

if(d=="exists") reg_error.innerText="Email already exists";
else if(d=="success"){
Swal.fire("Success","Registered Successfully","success");
showLogin();
}
else reg_error.innerText=d;
});
}

/* LOGIN */
function loginUser(){
let email=log_email.value.trim();
let pass=log_pass.value.trim();

if(email==""||pass=="")
return Swal.fire("Error","All fields required","error");

let fd=new FormData();
fd.append("action","login");
fd.append("email",email);
fd.append("password",pass);

fetch("",{method:"POST",body:fd})
.then(r=>r.text())
.then(d=>{
d=d.trim();

if(d=="login_success"){
Swal.fire("Success","Login Success","success")
.then(()=>location="student-home.php");
}
else{
Swal.fire("Error","Invalid login","error");
}
});
}

</script>

</body>
</html>