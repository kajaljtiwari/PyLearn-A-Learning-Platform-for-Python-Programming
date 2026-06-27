<!-- contact.php -->
<?php
session_start();
include('includes/config.php');

$msg="";

if(isset($_POST['submit']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$subject=$_POST['subject'];
$message=$_POST['message'];

/* DEBUG: check connection */

if(!$conn)
{
die("Connection failed");
}

/* INSERT QUERY */

$sql="INSERT INTO contact_us
(name,email,subject,message)
VALUES
('$name','$email','$subject','$message')";

$result=mysqli_query($conn,$sql);

if($result)
{
$msg="Your message has been sent successfully.";
}
else
{
$msg="Error: ".mysqli_error($conn);
}
}
?>




<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - PyLearn</title>

<style>

body{
margin:0;
font-family:Arial;
background:#eef2f7; /* light professional color */
}
.contact-box{
width:900px;
max-width:95%;
margin:50px auto;
background:white;
padding:50px;
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




.contact-box h2{
text-align:center;
margin-bottom:25px;
color:#2c3e50;
}

input,textarea{
width:100%;
padding:14px;
margin-bottom:20px;
border:1px solid #ccc;
border-radius:6px;
font-size:15px;
}

textarea{
height:200px;
resize:none;
}

button{
width:100%;
padding:14px;
border:none;

background:#1abc9c;
color:white;
font-size:16px;
border-radius:6px;
cursor:pointer;
}

button:hover{
background:#16a085;
}

.msg{
text-align:center;
color:green;
margin-bottom:15px;
font-size:14px;
}

.info{
margin-top:25px;
font-size:14px;
color:#555;
line-height:24px;
text-align:center;
}

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

</head>
<body>
<?php include('includes/header.php'); ?>

<!-- Sidebar -->
<div class="contact-box">

<h2>Contact Us</h2>

<div class="msg"><?php echo $msg; ?></div>

<form method="post">

<input type="text" name="name" placeholder="Enter Your Name" required>

<input type="email" name="email" placeholder="Enter Your Email" required>

<input type="text" name="subject" placeholder="Enter Subject" required>

<textarea name="message" placeholder="Write Your Message" required></textarea>

<button type="submit" name="submit">Send Message</button>

</form>



</div>

<!-- FOOTER -->
<div class="footer">

<div class="footer-container">

<div class="footer-box">
<h3>PyLearn</h3>
<p>Learn Python Programming from Basic to Advanced.</p>
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

</div>

<div class="footer-bottom">
© 2026 PyLearn | All Rights Reserved
</div>

</div>


</body>
</html>