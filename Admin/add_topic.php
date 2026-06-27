<?php
include('includes/auth.php');

/* ---------- ADD TOPIC AJAX ---------- */
if(isset($_POST['ajax_add']))
{
    $category_id  = (int)$_POST['category_id'];
    $title        = mysqli_real_escape_string($conn,$_POST['title']);
    $content      = mysqli_real_escape_string($conn,$_POST['content']);
    $example_code = mysqli_real_escape_string($conn,$_POST['example_code']);

    mysqli_query($conn,"
    INSERT INTO topics(category_id,title,content,example_code)
    VALUES('$category_id','$title','$content','$example_code')
    ");

    $id = mysqli_insert_id($conn);

    $cat = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT category_name
    FROM categories
    WHERE category_id='$category_id'
    "));

    // ✅ FIXED RESPONSE
    echo $id."|".$cat['category_name']."|".$title."|".$content."|".$example_code."|".$category_id;
    exit();
}

/* ---------- DELETE TOPIC AJAX ---------- */
if(isset($_POST['ajax_delete']))
{
    $id = (int)$_POST['ajax_delete'];

    mysqli_query($conn,"
    DELETE FROM topics
    WHERE topic_id='$id'
    ");

    echo "success";
    exit();
}

/* ---------- UPDATE TOPIC AJAX ---------- */
if(isset($_POST['ajax_update']))
{
    $topic_id     = (int)$_POST['topic_id'];
    $category_id  = (int)$_POST['category_id'];

    $title        = mysqli_real_escape_string($conn,$_POST['title']);
    $content      = mysqli_real_escape_string($conn,$_POST['content']);
    $example_code = mysqli_real_escape_string($conn,$_POST['example_code']);

    mysqli_query($conn,"
    UPDATE topics SET
    category_id='$category_id',
    title='$title',
    content='$content',
    example_code='$example_code'
    WHERE topic_id='$topic_id'
    ");

    $cat = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT category_name
    FROM categories
    WHERE category_id='$category_id'
    "));

    echo $cat['category_name']."|".$title;
    exit();
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="main">
<h2 class="mb-4">Manage Topics</h2>

<!-- Add Form -->
<div class="section">
<form id="topicForm">

<div class="row">

<div class="col-md-6 mb-3">
<label>Category</label>
<select id="category_id" class="form-control" required>
<option value="">Choose Category</option>

<?php
$cat = mysqli_query($conn,"SELECT * FROM categories ORDER BY category_name ASC");
while($c = mysqli_fetch_assoc($cat)){
?>
<option value="<?php echo $c['category_id']; ?>">
<?php echo $c['category_name']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-6 mb-3">
<label>Topic Title</label>
<input type="text" id="title" class="form-control" required>
</div>

</div>

<div class="mb-3">
<label>Content</label>
<textarea id="content" rows="6" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>Example Code</label>
<textarea id="example_code" rows="4" class="form-control"></textarea>
</div>

<button type="submit" class="btn btn-primary">Add Topic</button>

</form>
</div>

<!-- Table -->
<div class="section">
<table class="table table-bordered table-hover">
<thead>
<tr class="table-primary">
<th>ID</th>
<th>Category</th>
<th>Title</th>
<th width="250">Action</th>
</tr>
</thead>

<tbody id="topicTable">

<?php
$query = mysqli_query($conn,"
SELECT topics.*, categories.category_name
FROM topics
INNER JOIN categories
ON topics.category_id = categories.category_id
ORDER BY topics.topic_id DESC
");

while($row = mysqli_fetch_assoc($query)){
?>

<tr id="row<?php echo $row['topic_id']; ?>">

<td><?php echo $row['topic_id']; ?></td>

<td id="cat<?php echo $row['topic_id']; ?>">
<?php echo $row['category_name']; ?>
</td>

<td id="title<?php echo $row['topic_id']; ?>">
<?php echo $row['title']; ?>
</td>

<td>

<button class="btn btn-warning btn-sm"
onclick="editTopic(
<?php echo $row['topic_id']; ?>,
'<?php echo htmlspecialchars($row['title'],ENT_QUOTES); ?>',
'<?php echo htmlspecialchars($row['content'],ENT_QUOTES); ?>',
'<?php echo htmlspecialchars($row['example_code'],ENT_QUOTES); ?>',
<?php echo $row['category_id']; ?>
)">
Edit
</button>

<button class="btn btn-danger btn-sm"
onclick="deleteTopic(<?php echo $row['topic_id']; ?>)">
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
document.getElementById("topicForm").addEventListener("submit",function(e){
e.preventDefault();

let fd = new FormData();
fd.append("ajax_add",1);
fd.append("category_id",category_id.value);
fd.append("title",title.value);
fd.append("content",content.value);
fd.append("example_code",example_code.value);

fetch("add_topic.php",{method:"POST",body:fd})
.then(res=>res.text())
.then(data=>{

let arr = data.split("|");

let id = arr[0];
let cat = arr[1];
let titleTxt = arr[2];
let content = arr[3];
let code = arr[4];
let catid = arr[5];

let row = `
<tr id="row${id}">
<td>${id}</td>
<td id="cat${id}">${cat}</td>
<td id="title${id}">${titleTxt}</td>
<td>

<button class="btn btn-warning btn-sm"
onclick="editTopic(
${id},
'${titleTxt.replace(/'/g,"\\'")}',
'${content.replace(/'/g,"\\'")}',
'${code.replace(/'/g,"\\'")}',
${catid}
)">
Edit
</button>

<button class="btn btn-danger btn-sm"
onclick="deleteTopic(${id})">
Delete
</button>

</td>
</tr>
`;

document.getElementById("topicTable").insertAdjacentHTML("afterbegin",row);
document.getElementById("topicForm").reset();

Swal.fire("Success","Topic Added","success");

});
});

/* ---------- DELETE ---------- */
function deleteTopic(id){
Swal.fire({
title:"Delete Topic?",
icon:"warning",
showCancelButton:true,
confirmButtonText:"Delete"
}).then((result)=>{
if(result.isConfirmed){

let fd = new FormData();
fd.append("ajax_delete",id);

fetch("add_topic.php",{method:"POST",body:fd})
.then(res=>res.text())
.then(data=>{
if(data.trim()=="success"){
document.getElementById("row"+id).remove();
Swal.fire("Deleted","Topic Removed","success");
}
});
}
});
}

</script>

<?php include('includes/footer.php'); ?>