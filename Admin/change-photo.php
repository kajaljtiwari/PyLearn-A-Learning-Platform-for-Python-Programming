<?php
include('includes/auth.php');

$admin = $_SESSION['admin'];

/* SAVE PHOTO */
if(isset($_POST['save']))
{
    $photo = $_POST['photo'];

    mysqli_query($conn,"
    UPDATE admins
    SET photo='$photo'
    WHERE username='$admin'
    ");

    $msg = "Profile photo updated successfully.";
}

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM admins
WHERE username='$admin'
"));

$current = !empty($data['photo']) ? $data['photo'] : 'default.png';

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">

<div class="section">

<h2 class="mb-4">Change Profile Photo</h2>

<?php if(isset($msg)){ ?>
<div class="alert alert-success">
<?php echo $msg; ?>
</div>
<?php } ?>

<form method="POST">

<input type="hidden" name="photo" id="selectedPhoto"
value="<?php echo $current; ?>">

<div class="row g-4">

<?php
$photos = [
'sujal.jpg',
'admin2.png',
'admin3.png',
'admin4.png',
'default.png'
];

foreach($photos as $img)
{
?>

<div class="col-md-3 col-6">

<div class="avatar-box
<?php if($current==$img){ echo 'active'; } ?>"
onclick="selectAvatar(this,'<?php echo $img; ?>')">

<img src="img/<?php echo $img; ?>"
class="img-fluid rounded-circle">

<p class="mt-2 mb-0 text-center">
<?php echo $img; ?>
</p>

</div>

</div>

<?php } ?>

</div>

<button type="submit"
name="save"
class="btn btn-primary mt-4">
Save Photo
</button>

</form>

</div>

</div>

<style>
.avatar-box{
padding:15px;
border:2px solid #ddd;
border-radius:15px;
cursor:pointer;
transition:.3s;
text-align:center;
background:#fff;
}

.avatar-box:hover{
transform:translateY(-5px);
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.avatar-box.active{
border:3px solid #0d6efd;
background:#eaf2ff;
}

.avatar-box img{
width:110px;
height:110px;
object-fit:cover;
}
</style>

<script>
function selectAvatar(box,file)
{
document
.querySelectorAll('.avatar-box')
.forEach(el=>el.classList.remove('active'));

box.classList.add('active');

document
.getElementById('selectedPhoto')
.value = file;
}
</script>

<?php include('includes/footer.php'); ?>