<!-- about.php -->

<?php
session_start();
include('includes/config.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us - PyLearn</title>

<style>

body{
margin:0;
font-family:Arial;
background:#eef2f7; /* light professional color */
}
.about-container{
width:900px;
max-width:95%;
margin:50px auto;
background:white;
padding:40px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.about-container h1{
text-align:center;
color:#2c3e50;
margin-bottom:25px;
}

.about-container h2{
color:#1abc9c;
margin-top:30px;
}

.about-container p{
font-size:16px;
line-height:28px;
color:#444;
text-align:justify;
}

.features{
margin-top:20px;
padding-left:20px;
}

.features li{
margin-bottom:10px;
font-size:15px;
color:#333;
}

.footer-note{
margin-top:30px;
text-align:center;
font-size:15px;
color:#777;
}

</style>

</head>
<body>
<?php include('includes/header.php'); ?>
<!-- Sidebar -->
<div class="about-container">

<h1>About PyLearn</h1>

<p>
PyLearn is a web-based Python learning platform designed to help students learn Python programming from basic to advanced level in a simple and interactive way.
Our aim is to make Python easy for beginners and useful for future developers, data scientists, and AI learners.
</p>

<h2>What We Provide</h2>

<ul class="features">

<li>Python Basics (Variables, Loops, Functions, OOP)</li>

<li>Python for Data Science (NumPy, Pandas, Matplotlib)</li>

<li>Python in Artificial Intelligence</li>

<li>Web Development using Django and Flask</li>

<li>Quiz System with Results</li>

<li>Certificate after Completion</li>

<li>User Login and Progress Tracking</li>

</ul>

<h2>Our Mission</h2>

<p>
To provide quality programming education through a smart online platform where students can learn anytime and anywhere.
</p>

<h2>Why Choose PyLearn?</h2>

<p>
PyLearn offers structured content, simple examples, quizzes, and certificates that help students build practical Python skills.
</p>

<div class="footer-note">

© 2026 PyLearn | Learn Python Step by Step

</div>

</div><style>

/* DEFAULT FOOTER (FULL WIDTH) */
.footer{
margin-left:0;
width:100%;
background:#2c3e50;
color:white;
box-sizing:border-box;
margin-top:30px;
transition:0.3s;
}

/* WHEN SIDEBAR EXISTS */
.with-sidebar .footer{
margin-left:250px;
width:calc(100% - 250px);
}

/* Grid */

.footer-container{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:25px;
padding:30px;
}

.footer-box h3{
margin:0 0 15px;
color:#1abc9c;
font-size:22px;
}

.footer-box p{
margin:0 0 10px;
font-size:14px;
line-height:24px;
color:#ddd;
}

.footer-box a{
display:block;
color:#ddd;
text-decoration:none;
margin-bottom:10px;
font-size:14px;
transition:0.3s;
}

.footer-box a:hover{
color:#1abc9c;
padding-left:5px;
}

/* Bottom */

.footer-bottom{
background:#17232e;
text-align:center;
padding:15px;
font-size:14px;
}

/* Mobile */

@media(max-width:768px){

.footer,
.with-sidebar .footer{
margin-left:0;
width:100%;
}

.footer-container{
grid-template-columns:1fr;
}

}

</style>

<div class="footer">

<div class="footer-container">

<div class="footer-box">
<h3>PyLearn</h3>
<p>Learn Python Programming from Basic to Advanced with quizzes and certificates.</p>
</div>

<div class="footer-box">
<h3>Quick Links</h3>
<a href="index2.php">Home</a>
<a href="contact.php">Contact</a>
<a href="feedback.php">Feedback</a>
<a href="about.php">About Us</a>
</div>



<div class="footer-box">
<h3>Contact</h3>
<p>Email: support@pylearn.com</p>
<p>Phone: +91 XXXXX XXXXX</p>
<p>India</p>
</div>

</div>

<div class="footer-bottom">
© 2026 PyLearn | All Rights Reserved
</div>

</div>