<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status=1;
$sql = "UPDATE tblcontactusquery SET status=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Testimonial Successfully Inacrive";
}

if(isset($_REQUEST['del']))
	{
$did=intval($_GET['del']);
$sql = "delete from tblcontactusquery WHERE  id=:did";
$query = $dbh->prepare($sql);
$query-> bindParam(':did',$did, PDO::PARAM_STR);
$query -> execute();

$msg="Record deleted Successfully ";
}



 ?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	

  <style>
	body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin top: 300;
            padding: 20px;
            margin-left: -20px;        
           margin-top: 55px;


        }

/* --- Main Content Area --- */
.content-wrapper {
    padding: 20px;
    background: #f5f5f5;
}

/* --- Page Heading --- */
h2.page-title {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
	margin-top: 100px;

}

/* --- Panel Styling --- */
.panel {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.panel-heading {
    background: #007bff;
    color: #fff;
    padding: 12px;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
	margin-top: -10px;

}

/* --- Success & Error Message Styling --- */
.succWrap, .errorWrap {
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    font-size: 14px;
}

.succWrap {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.errorWrap {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* --- Table Styling --- */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 5px;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.table th {
    background: #007bff;
    color: #fff;
    padding: 12px;
    text-align: left;
    font-size: 15px;
}

.table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

/* --- Alternate row background for readability --- */
.table tbody tr:nth-child(even) {
    background: #f9f9f9;
}

/* --- Hover Effect on Rows --- */
.table tbody tr:hover {
    background: #e9f3ff;
}

/* --- Action Buttons --- */
td a {
    color: #dc3545;
    font-weight: bold;
    text-decoration: none;
    padding: 5px 8px;
    border-radius: 5px;
    transition: 0.3s ease;
}

td a:hover {
    color: #fff;
    background: #dc3545;
}

/* --- Status Styling --- */
td a[href*="eid"] {
    color: #28a745;
}

td a[href*="eid"]:hover {
    background: #28a745;
    color: #fff;
}

/* --- Responsive Table --- */
@media (max-width: 768px) {
    .table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}

		</style>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Manage Contact Us Queries</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">User queries</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Contact No</th>
											<th>Message</th>
											<th>Posting date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Contact No</th>
											<th>Message</th>
											<th>Posting date</th>
											<th>Action</th>
										</tr>
										</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT * from  tblcontactusquery ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->name);?></td>
											<td><?php echo htmlentities($result->EmailId);?></td>
											<td><?php echo htmlentities($result->ContactNumber);?></td>
											<td><?php echo htmlentities($result->Message);?></td>
											<td><?php echo htmlentities($result->PostingDate);?></td>
																<?php if($result->status==1)
{
	?><td>Read<br /> |
		<a href="manage-conactusquery.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Delete?')" >Delete</a></td>
<?php } else {?>

<td><a href="manage-conactusquery.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to read?')" >Pending</a><br /> | 
	<a href="manage-conactusquery.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Delete?')" >Delete</a>
</td>
<?php } ?>
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>

						

							</div>
						</div>

					

					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	
</body>
</html>
<?php } ?>
