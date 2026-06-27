<?php
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>Python Compiler</title>

<style>

.main-container{
display:flex;
min-height:100vh;
}

.sidebar{
width:250px;
background:#2c3e50;
padding-top:20px;
color:white;
}

.content{
flex:1;
padding:30px;
background:white;
}

textarea{
width:100%;
height:200px;
}

button{
background:#1abc9c;
color:white;
padding:10px 20px;
border:none;
cursor:pointer;
}

.output{
margin-top:20px;
padding:10px;
border:1px solid #ccc;
}

</style>

</head>

<body>

<?php include('includes/header.php'); ?>

<div class="main-container">

<div class="sidebar">

<h3>Tools</h3>

<a href="compiler.php">Python Compiler</a>

</div>

<div class="content">

<h2>Python Code Compiler</h2>

<form method="post">

<textarea name="code"
placeholder="Write Python code here..."></textarea>

<br><br>

<button type="submit">

Run Code

</button>

</form>

<div class="output">

<?php

if(isset($_POST['code']))
{
echo "Output will display here";
}

?>

</div>

</div>

</div>

<?php include('includes/footer.php'); ?>

</body>

</html>