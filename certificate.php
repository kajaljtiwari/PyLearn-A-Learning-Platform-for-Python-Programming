<?php
session_start();
require_once("includes/config.php");

if(!isset($_SESSION['student_id'])){
    header("Location:index2.php");
    exit();
}

$student_id = $_SESSION['student_id'];

/* STUDENT INFO */
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$student_id'"
));

/* CERTIFICATES */
$certs = mysqli_query($conn,"
SELECT 
c.*,
cat.category_name
FROM certificates c
JOIN categories cat
ON c.category_id = cat.category_id
WHERE c.student_id='$student_id'
ORDER BY c.certificate_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>My Certificates</title>

<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">

<style>

body{
    background:#eef3f8;
    font-family:'Poppins',sans-serif;
    overflow-x:hidden;
    margin:0;
    padding:0;
}

/* MAIN WRAPPER */

.main-wrapper{
    width:100%;
    display:flex;
    flex-direction:column;
    align-items:center;
}

/* TOP BAR */

.top-bar{
    width:1200px;
    max-width:95%;
    display:flex;
    justify-content:flex-end;
    margin-top:25px;
    margin-bottom:20px;
}

/* DASHBOARD BUTTON */

.dashboard-btn{
    background:linear-gradient(135deg,#0d6efd,#4f8cff);
    color:white;
    text-decoration:none;
    padding:12px 24px;
    border-radius:40px;
    font-weight:600;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    transition:0.3s;
}

.dashboard-btn:hover{
    color:white;
    transform:translateY(-2px);
    background:linear-gradient(135deg,#0b5ed7,#2563eb);
}

/* CONTAINER */

.container{
    width:1200px !important;
    max-width:95% !important;
    margin:0 auto !important;
    padding:0 !important;
}

/* PAGE TITLE */

.page-title{
    text-align:center;
    font-size:38px;
    font-weight:700;
    color:#0d6efd;
    margin-bottom:40px;
}

/* SMALL CARD */

.cert-small-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    transition:0.3s;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    background:white;
    height:100%;
}

.cert-small-card:hover{
    transform:translateY(-5px);
}

.card-top{
    background:linear-gradient(135deg,#0d6efd,#4f8cff);
    padding:25px;
    color:white;
}

.card-icon{
    font-size:55px;
}

.course-name{
    font-size:24px;
    font-weight:700;
}

.card-body-custom{
    padding:25px;
}

.info-text{
    font-size:15px;
    margin-bottom:8px;
}

/* BUTTONS */

.btn-custom{
    border-radius:30px;
    padding:10px 18px;
    font-weight:600;
}

/* MODAL */

.modal-content{
    border:none;
    border-radius:20px;
}

/* CERTIFICATE */

.certificate{
    position:relative;
    background:white;
    border:12px solid #0d6efd;
    border-radius:20px;
    padding:60px;
    overflow:hidden;
}

.certificate::before{
    content:'';
    position:absolute;
    top:15px;
    left:15px;
    right:15px;
    bottom:15px;
    border:2px dashed #0d6efd;
    border-radius:10px;
}

/* TOP ICON */

.top-icon{
    text-align:center;
    font-size:60px;
}

/* TITLE */

.cert-title{
    text-align:center;
    font-size:42px;
    font-weight:700;
    color:#0d6efd;
    margin-top:10px;
}

.sub-title{
    text-align:center;
    color:#666;
    font-size:18px;
    margin-top:15px;
}

/* NAME */

.student-name{
    text-align:center;
    font-family:'Great Vibes',cursive;
    font-size:64px;
    margin:30px 0;
    color:#111;
}

/* COURSE */

.course{
    text-align:center;
    font-size:34px;
    font-weight:700;
    color:#198754;
    margin:20px 0;
}

/* SCORE */

.score{
    text-align:center;
    font-size:24px;
    color:#444;
    margin-top:15px;
}

.score span{
    color:#dc3545;
    font-size:34px;
    font-weight:700;
}

/* FOOTER */

.bottom-section{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:60px;
    flex-wrap:wrap;
}

.left-details{
    font-size:15px;
    color:#555;
    line-height:28px;
}

/* SIGNATURE */

.signature{
    text-align:center;
}

.signature-line{
    width:180px;
    border-top:2px solid #000;
    margin-bottom:8px;
}

.signature p{
    margin:0;
    color:#555;
}

/* VERIFIED SEAL */

.seal{
    position:absolute;
    right:40px;
    bottom:40px;
    width:110px;
    height:110px;
    border-radius:50%;
    background:radial-gradient(circle,#ffd700,#d4a017);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:13px;
    font-weight:700;
    text-align:center;
    transform:rotate(-15deg);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* PRINT */

@media print{

    body *{
        visibility:hidden;
    }

    .print-area,
    .print-area *{
        visibility:visible;
    }

    .print-area{
        position:absolute;
        left:0;
        top:0;
        width:100%;
    }

    .no-print{
        display:none;
    }

    .top-bar{
        display:none;
    }
}

/* MOBILE */

@media(max-width:768px){

    .container{
        width:95% !important;
    }

    .certificate{
        padding:30px 20px;
    }

    .cert-title{
        font-size:28px;
    }

    .student-name{
        font-size:42px;
    }

    .course{
        font-size:24px;
    }

    .bottom-section{
        flex-direction:column;
        align-items:flex-start;
        gap:25px;
    }

    .seal{
        width:80px;
        height:80px;
        font-size:10px;
    }

    .top-bar{
        width:95%;
        justify-content:center;
    }

    .dashboard-btn{
        width:100%;
        text-align:center;
    }
}

</style>

</head>

<body>

<div class="main-wrapper">

<!-- TOP BAR -->

<div class="top-bar">

    <a href="student-dashboard.php" class="dashboard-btn">
        🏠 Go To Dashboard
    </a>

</div>

<div class="container">

<div class="page-title">
    🎓 My Certificates
</div>

<?php if(mysqli_num_rows($certs) > 0){ ?>

<div class="row">

<?php while($row = mysqli_fetch_assoc($certs)){ ?>

<div class="col-md-6 mb-4">

<div class="cert-small-card">

<div class="card-top d-flex justify-content-between align-items-center">

    <div>

        <div class="course-name">
            <?php echo $row['category_name']; ?>
        </div>

        <div class="mt-2">
            Certificate of Achievement
        </div>

    </div>

    <div class="card-icon">
        🏆
    </div>

</div>

<div class="card-body-custom">

    <div class="info-text">
        <strong>Student:</strong>
        <?php echo $user['full_name']; ?>
    </div>

    <div class="info-text">
        <strong>Score:</strong>
        <?php echo $row['percentage']; ?>%
    </div>

    <div class="info-text">
        <strong>Date:</strong>
        <?php echo date("d M Y", strtotime($row['issue_date'])); ?>
    </div>

    <div class="mt-4 d-flex gap-2 flex-wrap">

        <button class="btn btn-primary btn-custom"
        data-bs-toggle="modal"
        data-bs-target="#certModal<?php echo $row['certificate_id']; ?>">

            View Certificate

        </button>

        <button onclick="printCertificate('print<?php echo $row['certificate_id']; ?>')"
        class="btn btn-success btn-custom">

            Download PDF

        </button>

    </div>

</div>

</div>

</div>

<!-- MODAL -->

<div class="modal fade"
id="certModal<?php echo $row['certificate_id']; ?>"
tabindex="-1">

<div class="modal-dialog modal-xl">

<div class="modal-content">

<div class="modal-body p-4">

<div id="print<?php echo $row['certificate_id']; ?>" class="print-area">

<div class="certificate">

    <div class="top-icon">
        🏆
    </div>

    <div class="cert-title">
        Certificate of Achievement
    </div>

    <div class="sub-title">
        This certificate is proudly presented to
    </div>

    <div class="student-name">
        <?php echo $user['full_name']; ?>
    </div>

    <div class="sub-title">
        for successfully completing the online quiz/course in
    </div>

    <div class="course">
        <?php echo $row['category_name']; ?>
    </div>

    <div class="score">
        Achieved Score :
        <span><?php echo $row['percentage']; ?>%</span>
    </div>

    <div class="bottom-section">

        <div class="left-details">

            <strong>Certificate ID :</strong>
            <?php echo $row['certificate_code']; ?>

            <br>

            <strong>Date Issued :</strong>
            <?php echo date("d M Y", strtotime($row['issue_date'])); ?>

        </div>

        <div class="signature">

            <div class="signature-line"></div>

            <p>Authorized Signature</p>

        </div>

    </div>

    <div class="seal">
        VERIFIED CERTIFICATE
    </div>

</div>

</div>

<div class="text-center mt-4 no-print">

    <button onclick="printCertificate('print<?php echo $row['certificate_id']; ?>')"
    class="btn btn-success btn-custom">

        🖨 Print / Download PDF

    </button>

</div>

</div>

</div>

</div>

</div>

<?php } ?>

</div>

<?php } else { ?>

<div class="alert alert-warning text-center p-4 rounded-4">

    <h4>No Certificates Found</h4>

    <p class="mb-0">
        Complete quizzes with 50%+ score to earn certificates.
    </p>

</div>

<?php } ?>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

function printCertificate(id){

    var content = document.getElementById(id).innerHTML;

    var myWindow = window.open('', '', 'width=1200,height=800');

    myWindow.document.write(`
    <html>
    <head>

        <title>Certificate</title>

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">

        <style>

        body{
            font-family:'Poppins',sans-serif;
            background:white;
            padding:20px;
        }

        </style>

    </head>

    <body>

        ${content}

    </body>

    </html>
    `);

    myWindow.document.close();

    myWindow.print();
}

</script>

</body>
</html>