<!-- includes/header.php -->

<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
}

.header{
width:100%;
background:#2c3e50;
color:white;
padding:12px 25px;
position:fixed;
top:0;
left:0;
z-index:1000;
box-shadow:0 2px 10px rgba(0,0,0,0.25);
}

.header-container{
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
}

.logo-section{
display:flex;
align-items:center;
gap:12px;
}

.logo{
width:58px;
height:58px;
border-radius:50%;
object-fit:cover;
}

.brand h1{
font-size:24px;
margin-bottom:3px;
}

.brand p{
font-size:14px;
color:#dcdcdc;
}

.navbar{
display:flex;
align-items:center;
gap:10px;
flex-wrap:wrap;
}

.navbar a{
color:white;
text-decoration:none;
padding:8px 14px;
border-radius:6px;
transition:0.3s;
font-size:15px;
}

.navbar a:hover{
background:#1abc9c;
}

.user-name{
color:#1abc9c;
font-weight:bold;
margin-right:10px;
}

body{
padding-top:95px;
}

@media(max-width:768px){
.header-container{
flex-direction:column;
align-items:flex-start;
gap:12px;
}

.navbar{
width:100%;
justify-content:flex-start;
}

body{
padding-top:150px;
}
}
</style>

<div class="header">

<div class="header-container">

<!-- LOGO -->
<div class="logo-section">

<img src="images/logo.jpg" class="logo">

<div class="brand">
<h1>PyLearn</h1>
<p>Learn Python Step by Step</p>
</div>

</div>

<!-- NAVBAR -->
<div class="navbar">

<a href="index2.php">Home</a>
<a href="about.php">About</a>
<a href="contact.php">Contact</a>

<?php if(isset($_SESSION['student_id'])) { ?>

    <!-- USER LOGGED IN -->

    <span class="user-name">
        Hi, <?php echo $_SESSION['student_name']; ?>
    </span>

    <a href="student-dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>

    <a href="student-logout.php">Logout</a>

<?php } else { ?>

    <!-- USER NOT LOGGED IN -->

    <a href="javascript:void(0)" onclick="openPopup('login')">
        Login
    </a>

    <a href="javascript:void(0)" onclick="openPopup('register')">
        Register
    </a>





    
<?php } ?>

</div>

</div>

</div>









<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<div class="header">

<div class="header-container">

<div class="logo-section">

<img src="images/logo.jpg" class="logo">

<div class="brand">
<h1>PyLearn</h1>
<p>Learn Python Step by Step</p>
</div>

</div>

<div class="navbar">

<a href="index2.php">Home</a>


<?php if(isset($_SESSION['student_id'])) { ?>

    <span class="user-name">
        Hi, <?php echo $_SESSION['student_name']; ?>
    </span>

    <a href="student-dashboard.php">Dashboard</a>
    <a href="profile.php">Profile</a>
    <a href="student-logout.php">Logout</a>

<?php } else { ?>

    <a href="javascript:void(0)" onclick="openPopup('login')">
        Login
    </a>

    <a href="javascript:void(0)" onclick="openPopup('register')">
        Register
    </a>

<?php } ?>

</div>

</div>

</div>