<!-- includes/footer.php -->

<style>

.footer{
margin-left:250px;
width:calc(100% - 250px);
background:#2c3e50;
color:white;
box-sizing:border-box;
margin-top:30px;
}

/* Grid */

.footer-container{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:250px;
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

.footer{
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