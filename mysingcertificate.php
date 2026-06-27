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
}

.container{
    margin-top:40px;
    margin-bottom:40px;
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
    position:relative;
    z-index:2;
}

/* TITLE */

.cert-title{
    text-align:center;
    font-size:42px;
    font-weight:700;
    color:#0d6efd;
    margin-top:10px;
    position:relative;
    z-index:2;
}

.sub-title{
    text-align:center;
    color:#666;
    font-size:18px;
    margin-top:15px;
    position:relative;
    z-index:2;
}

/* NAME */

.student-name{
    text-align:center;
    font-family:'Great Vibes',cursive;
    font-size:64px;
    margin:30px 0;
    color:#111;
    position:relative;
    z-index:2;
}

/* COURSE */

.course{
    text-align:center;
    font-size:34px;
    font-weight:700;
    color:#198754;
    margin:20px 0;
    position:relative;
    z-index:2;
}

/* SCORE */

.score{
    text-align:center;
    font-size:24px;
    color:#444;
    margin-top:15px;
    position:relative;
    z-index:2;
}

.score span{
    color:#dc3545;
    font-size:34px;
    font-weight:700;
}

/* BOTTOM SECTION */

.bottom-section{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    margin-top:70px;
    flex-wrap:wrap;
    gap:20px;
    position:relative;
    z-index:2;
}

/* VERIFY */

.verify-box{
    text-align:left;
}

.verify-title{
    font-size:14px;
    color:#777;
    margin-bottom:10px;
    font-weight:500;
}

.verify-code{
    background:#eef4ff;
    border:1px solid #cfe0ff;
    padding:10px 18px;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
    color:#0d6efd;
    display:inline-block;
}

.issue-date{
    font-size:14px;
    color:#555;
}

/* SIGNATURE */

.signature-box{
    text-align:center;
}

.digital-sign{
    font-family:'Great Vibes',cursive;
    font-size:52px;
    color:#1d4ed8;
    transform:rotate(-7deg);
    margin-bottom:-10px;
    text-shadow:1px 1px 4px rgba(0,0,0,0.15);
}

.signature-line{
    width:190px;
    border-top:2px solid #000;
    margin:0 auto 8px;
}

.sign-role{
    font-size:14px;
    color:#555;
    font-weight:500;
}

/* GOLDEN SEAL */

.official-seal{
    width:130px;
    height:130px;
    border-radius:50%;
    background:radial-gradient(circle,#ffd700,#d4a017);
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 5px 18px rgba(0,0,0,0.2);
    animation:sealFloat 3s ease-in-out infinite;
}

.seal-inner{
    width:100px;
    height:100px;
    border:3px dashed rgba(255,255,255,0.7);
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:white;
    font-size:13px;
    font-weight:700;
    line-height:20px;
}

/* FLOAT EFFECT */

@keyframes sealFloat{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-6px);
    }

    100%{
        transform:translateY(0px);
    }

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
}

/* MOBILE */

@media(max-width:768px){

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

    .official-seal{
        width:90px;
        height:90px;
    }

    .seal-inner{
        width:70px;
        height:70px;
        font-size:10px;
    }
}

</style>

</head>

<body>

<div class="container">

<div class="page-title">
    🎓 My Certificates
</div>

<?php if(mysqli_num_rows($certs) > 0){ ?>

<div class="row">

<?php while($row = mysqli_fetch_assoc($certs)){ ?>

<div class="col-md-6 mb-4">

<div class="cert-small-card">

    <!-- TOP -->

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

    <!-- BODY -->

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

            <!-- VIEW -->

            <button class="btn btn-primary btn-custom"
            data-bs-toggle="modal"
            data-bs-target="#certModal<?php echo $row['certificate_id']; ?>">

                View Certificate

            </button>

            <!-- PRINT -->

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

    <!-- NEW PROFESSIONAL FOOTER -->

    <div class="bottom-section">

        <!-- VERIFY -->

        <div class="verify-box">

            <div class="verify-title">
                Certificate Verification
            </div>

            <div class="verify-code">
                <?php echo $row['certificate_code']; ?>
            </div>

            <div class="issue-date mt-2">
                Issued :
                <?php echo date("d M Y", strtotime($row['issue_date'])); ?>
            </div>

        </div>

        <!-- GOLDEN SEAL -->

        <div class="official-seal">

            <div class="seal-inner">

                VERIFIED<br>
                CERTIFICATE

            </div>

        </div>

        <!-- DIGITAL SIGNATURE -->

        <div class="signature-box">

            <div class="digital-sign">
                Kajal Tiwari
            </div>

            <div class="signature-line"></div>

            <div class="sign-role">
                Certification Authority
            </div>

        </div>

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

<!-- BOOTSTRAP -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- PRINT FUNCTION -->

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