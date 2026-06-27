<!-- includes/sidebar.php (FINAL FULL CSS + WORKING VERSION) -->

<?php
include_once('includes/config.php');
?>

<style>

/* Sidebar Main */
.sidebar{
width:250px;
height:100vh;
background:#2c3e50;
position:fixed;
top:80px;
left:0;
overflow-y:auto;
z-index:999;
box-shadow:2px 0 10px rgba(0,0,0,0.2);
}

/* Heading */
.sidebar h3{
margin:0;
padding:18px;
font-size:22px;
text-align:center;
color:#fff;
background:#1abc9c;
}

/* Category Button */
.menu-btn{
width:100%;
border:none;
outline:none;
padding:14px 18px;
text-align:left;
font-size:16px;
cursor:pointer;
background:#34495e;
color:#fff;
border-bottom:1px solid rgba(255,255,255,0.08);
transition:0.3s;
}

.menu-btn:hover{
background:#1abc9c;
}

/* Submenu */
.submenu{
display:none;
background:#22313f;
}

/* Topic Links */
.submenu a{
display:block;
padding:12px 22px;
font-size:14px;
text-decoration:none;
color:#ecf0f1;
border-bottom:1px solid rgba(255,255,255,0.05);
transition:0.3s;
}

.submenu a:hover{
background:#16a085;
padding-left:28px;
}

/* Scrollbar */
.sidebar::-webkit-scrollbar{
width:6px;
}

.sidebar::-webkit-scrollbar-thumb{
background:#1abc9c;
border-radius:10px;
}

/* Mobile Responsive */
@media(max-width:768px){

.sidebar{
position:relative;
top:0;
width:100%;
height:auto;
}

}

</style>

<script>
function toggleMenu(id)
{
var menu = document.getElementById(id);

if(menu.style.display=="block")
{
menu.style.display="none";
}
else
{
menu.style.display="block";
}
}
</script>

<div class="sidebar">

<h3>Python Topics</h3>

<?php

$cat = mysqli_query($con,"SELECT * FROM categories ORDER BY category_id ASC");

while($row = mysqli_fetch_assoc($cat))
{
$cid = $row['category_id'];
?>

<button class="menu-btn" onclick="toggleMenu('menu<?php echo $cid; ?>')">
<?php echo $row['category_name']; ?>
</button>

<div class="submenu" id="menu<?php echo $cid; ?>">

<?php

$topic = mysqli_query($con,"SELECT * FROM topics WHERE category_id='$cid' ORDER BY topic_id ASC");

while($data = mysqli_fetch_assoc($topic))
{
?>

<a href="index2.php?id=<?php echo $data['topic_id']; ?>">
<?php echo $data['title']; ?>
</a>

<?php } ?>

</div>

<?php } ?>

</div>