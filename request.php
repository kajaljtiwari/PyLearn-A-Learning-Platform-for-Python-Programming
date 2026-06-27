<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['send']))
  {
    $cid=$_GET['cid'];
$name=$_POST['fullname'];
$email=$_POST['email'];
$contactno=$_POST['contactno'];
$brf=$_POST['brf'];
$message=$_POST['message'];
$sql="INSERT INTO  tblbloodrequirer(BloodDonarID,name,EmailId,ContactNumber,BloodRequirefor,Message) VALUES(:cid,:name,:email,:contactno,:brf,:message)";
$query = $dbh->prepare($sql);
$query->bindParam(':cid',$cid,PDO::PARAM_STR);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':contactno',$contactno,PDO::PARAM_STR);
$query->bindParam(':brf',$brf,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

echo '<script>alert("Request has been sent. We will contact you shortly.")</script>';
}
else 
{
echo "<script>alert('Something went wrong. Please try again.');</script>";  
}

}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>


</head>

<body>
    <?php include('includes/header.php');?>
<style>
.contact-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    padding: 40px;
}

.contact-image {
    width: 50%;
}

.contact-image img {
    width: 100%;
    border-radius: 8px;
}

/* Right section - Form */
.contact-form {
    flex: 1;
    max-width: 50%;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

/* Input and textarea styles */
.contact-form input, 
.contact-form textarea, 
.contact-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Submit button */
.contact-form input[type="submit"] {
    background: #d9534f;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.contact-form input[type="submit"]:hover {
    background: #c9302c;
}
</style>
    <!-- contact -->
<!-- Contact Section -->
<div class="contact-container">

    <!-- Left Side - Image -->
    <div class="contact-image">
        <img src="images/b2.png" alt="Blood Donation">
    </div>

    <!-- Right Side - Form -->
    <div class="contact-form">
        <h3>Contact For Blood</h3>
        <h5 class="title-w3 text-center mb-4">Fill the form for blood request</h5>

        <form action="#" method="post">
            <input type="text" name="fullname" placeholder="Enter your name" required>
            <input type="tel" name="contactno" placeholder="Enter your phone number" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <select name="brf">
                <option value="">Blood Require For</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Brother">Brother</option>
                <option value="Sister">Sister</option>
                <option value="Others">Others</option>
            </select>
            <textarea name="message" placeholder="Enter your message"></textarea>
            <input type="submit" value="Send Message" name="send">
        </form>
    </div>

</div>

<!-- Footer -->
<?php include('includes/footer.php');?>
