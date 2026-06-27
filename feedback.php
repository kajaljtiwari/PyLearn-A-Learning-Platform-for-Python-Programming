<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

$thankYou = "";

/* GET USER ID FROM SESSION */
$user_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : 0;

/* SUBMIT FEEDBACK */
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($user_id == 0)
    {
        $thankYou = "<div class='error-msg'>Please login first</div>";
    }
    else
    {
        $message = $conn->real_escape_string($_POST['message']);

        if(isset($_POST['rating']))
        {
            $rating = (int)$_POST['rating'];

            $stmt = $conn->prepare("
            INSERT INTO feedback (user_id, rating, message)
            VALUES (?, ?, ?)");

            if(!$stmt){
                die("Prepare failed: ".$conn->error);
            }

            $stmt->bind_param("iis",$user_id,$rating,$message);

            if($stmt->execute()){
                header("Location: feedback.php?thanks=1");
                exit();
            } else {
                $thankYou = "<div class='error-msg'>Failed to submit feedback</div>";
            }
        }
        else
        {
            $thankYou = "<div class='error-msg'>Please select rating</div>";
        }
    }
}

/* THANK YOU MESSAGE */
if (isset($_GET['thanks'])){
    $thankYou = "<div class='thank-you'>Thank you for your feedback!</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>PyLearn Feedback</title>

<style>

/* LAYOUT */
.main-container{
    display:flex;
    margin-top:100px;
    justify-content:center;
}

/* SIDEBAR FIX SPACE */
.content{
    flex:1;
    padding:40px;
    margin-left:0;
}

/* CARD */
.feedback-card{
    width:750px;         
    max-width:95%;
    margin:40px auto;     
    background:#fff;
    padding:45px;         
    border-radius:16px;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
}

.feedback-card h2{
    text-align:center;
    margin-bottom:25px;
    color:#2c3e50;
}

/* INPUT */
.feedback-card textarea{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
    height:160px;
    font-size: 16px;;
}

/* STAR */
.star-rating{
    display:flex;
    flex-direction:row-reverse;
    justify-content:center;
    gap:5px;
    margin:15px 0;
}

.star-rating input{
    display:none;
}

.star-rating label{
    font-size:40px;
    color:#ccc;
    cursor:pointer;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label{
    color:gold;
}

/* BUTTON */
.feedback-card button{
    width:100%;
    padding:14px;
    border:none;
    background:#1abc9c;
    color:white;
    font-size:17px;
    border-radius:10px;
    cursor:pointer;

}

.feedback-card button:hover{
    background:#16a085;
}

/* MESSAGE */
.thank-you{
    text-align:center;
    padding:15px;
    margin-bottom:15px;
    color:green;
    background:#eafaf7;
    border-radius:8px;
    font-weight:bold;
}

.error-msg{
    text-align:center;
    padding:15px;
    margin-bottom:15px;
    color:red;
    background:#fdecea;
    border-radius:8px;
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

<div class="main-container">

<div class="content">

<div class="feedback-card">

<?= $thankYou ?>

<h2>Student Feedback</h2>

<form method="post">

<textarea name="message" placeholder="Your Feedback" required></textarea>

<label><b>Rate Your Experience:</b></label>

<div class="star-rating">

<input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
<input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
<input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
<input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
<input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>

</div>

<button type="submit">Submit Feedback</button>

</form>

</div>

</div>

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

<div class="footer-bottom">
© 2026 PyLearn | All Rights Reserved
</div>

</div>

</body>
</html>