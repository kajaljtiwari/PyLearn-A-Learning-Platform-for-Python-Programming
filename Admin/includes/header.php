<!DOCTYPE html>
<html>
<head>
<title>PyLearn Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
margin:0;
background:#f4f6f9;
font-family:Arial;
}

/* Sidebar */
.sidebar{
width:250px;
height:100vh;
position:fixed;
left:0;
top:0;
background:#0d6efd;
padding-top:20px;
overflow-y:auto;
}

.sidebar h2{
color:#fff;
text-align:center;
margin-bottom:25px;
font-size:34px;
}

.sidebar a{
display:block;
padding:14px 22px;
color:#fff;
text-decoration:none;
font-size:17px;
}

.sidebar a:hover{
background:#084298;
}

/* Main */
.main{
margin-left:250px;
padding:25px;
}

/* Topbar */
.topbar{
background:#fff;
padding:15px 20px;
border-radius:12px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 4px 10px rgba(0,0,0,.08);
margin-bottom:25px;
}

.avatar{
width:45px;
height:45px;
border-radius:50%;
background:#0d6efd;
color:#fff;
display:flex;
justify-content:center;
align-items:center;
font-weight:bold;
cursor:pointer;
}

/* Cards */
.stat-card{
background:#fff;
padding:25px;
border-radius:15px;
text-align:center;
box-shadow:0 8px 20px rgba(0,0,0,.08);
height:100%;
}

.stat-card h5{
font-size:18px;
margin-bottom:10px;
}

.stat-card h2{
font-size:42px;
margin:0;
color:#0d6efd;
}

.section{
background:#fff;
padding:25px;
border-radius:15px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
margin-top:25px;
}

.quick-btn{
margin-bottom:12px;
}
</style>

</head>
<body>