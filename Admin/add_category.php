<?php
include('includes/auth.php');

/* ---------- ADD CATEGORY AJAX ---------- */
if(isset($_POST['ajax_add']))
{
    $name = mysqli_real_escape_string($conn,$_POST['category_name']);

    mysqli_query($conn,"
    INSERT INTO categories(category_name)
    VALUES('$name')
    ");

    $id = mysqli_insert_id($conn);

    echo $id."|".$name;
    exit();
}

/* ---------- DELETE AJAX ---------- */
if(isset($_POST['ajax_delete']))
{
    $id = (int)$_POST['ajax_delete'];

    mysqli_query($conn,"
    DELETE FROM categories
    WHERE category_id='$id'
    ");

    echo "success";
    exit();
}

/* ---------- UPDATE AJAX ---------- */
if(isset($_POST['ajax_update']))
{
    $id   = (int)$_POST['category_id'];
    $name = mysqli_real_escape_string($conn,$_POST['category_name']);

    mysqli_query($conn,"
    UPDATE categories
    SET category_name='$name'
    WHERE category_id='$id'
    ");

    echo "success";
    exit();
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">

<h2 class="mb-4">Manage Categories</h2>

<!-- Add Form -->
<div class="section">

<form id="addForm">

<label class="mb-2">Category Name</label>

<input
type="text"
id="category_name"
class="form-control mb-3"
required>

<button
type="submit"
class="btn btn-primary">
Add Category
</button>

</form>

</div>

<!-- Table -->
<div class="section">

<table class="table table-bordered table-hover">

<thead>
<tr class="table-primary">
<th>ID</th>
<th>Category Name</th>
<th width="250">Action</th>
</tr>
</thead>

<tbody id="categoryTable">

<?php
$query = mysqli_query($conn,"
SELECT * FROM categories
ORDER BY category_id DESC
");

while($row = mysqli_fetch_assoc($query))
{
?>

<tr id="row<?php echo $row['category_id']; ?>">

<td><?php echo $row['category_id']; ?></td>

<td id="name<?php echo $row['category_id']; ?>">
<?php echo $row['category_name']; ?>
</td>

<td>

<button
class="btn btn-warning btn-sm"
onclick="editCategory(
<?php echo $row['category_id']; ?>,
'<?php echo addslashes($row['category_name']); ?>'
)">
Edit
</button>

<button
class="btn btn-danger btn-sm"
onclick="deleteCategory(
<?php echo $row['category_id']; ?>
)">
Delete
</button>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

/* ---------- ADD ---------- */
document.getElementById("addForm")
.addEventListener("submit",function(e){

e.preventDefault();

let name =
document.getElementById("category_name").value;

let fd = new FormData();

fd.append("ajax_add",1);
fd.append("category_name",name);

fetch("add_category.php",{
method:"POST",
body:fd
})
.then(res=>res.text())
.then(data=>{

let arr = data.split("|");

let id = arr[0];
let cname = arr[1];

let row = `
<tr id="row${id}">
<td>${id}</td>

<td id="name${id}">
${cname}
</td>

<td>

<button
class="btn btn-warning btn-sm"
onclick="editCategory(${id},'${cname}')">
Edit
</button>

<button
class="btn btn-danger btn-sm"
onclick="deleteCategory(${id})">
Delete
</button>

</td>
</tr>
`;

document
.getElementById("categoryTable")
.insertAdjacentHTML("afterbegin",row);

document
.getElementById("category_name")
.value="";

Swal.fire(
"Success",
"Category Added",
"success"
);

});

});


/* ---------- DELETE ---------- */
function deleteCategory(id)
{
Swal.fire({
title:"Delete Category?",
icon:"warning",
showCancelButton:true,
confirmButtonText:"Delete"
})
.then((result)=>{

if(result.isConfirmed)
{
let fd = new FormData();

fd.append("ajax_delete",id);


fetch("add_category.php",{
method:"POST",
body:fd
})



.then(res=>res.text())
.then(data=>{

if(data.trim()=="success")
{
document
.getElementById("row"+id)
.remove();

Swal.fire(
"Deleted",
"Category Removed",
"success"
);
}

});

}

});
}


/* ---------- EDIT ---------- */
function editCategory(id,name)
{
Swal.fire({
title:"Edit Category",
input:"text",
inputValue:name,
showCancelButton:true,
confirmButtonText:"Update"
})
.then((result)=>{

if(result.isConfirmed)
{
let newName = result.value;

let fd = new FormData();

fd.append("ajax_update",1);
fd.append("category_id",id);
fd.append("category_name",newName);

fetch("add_category.php",{
method:"POST",
body:fd
})
.then(res=>res.text())
.then(data=>{

if(data.trim()=="success")
{
document
.getElementById("name"+id)
.innerText = newName;

Swal.fire(
"Updated",
"Category Updated",
"success"
);
}

});

}

});
}

</script>

<?php include('includes/footer.php'); ?>