<?php
$conn = new mysqli("localhost", "root", "", "bbdms");
$result = $conn->query("SELECT * FROM feedback ORDER BY submitted_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<body>
<style>
body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
            margin-top: 70px;
            margin-left: -30px; /* or whatever your sidebar width is */

}
.admin-feedback-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
    background: #fdfdfd;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-family: 'Segoe UI', sans-serif;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    margin-right: 40px; /* or whatever your sidebar width is */

}

.admin-feedback-container h2 {
    text-align: center;
    margin-bottom: 25px;
    color:rgba(0, 150, 230, 0.86);
}

.feedback-card {
    background: #fff;
    border-left: 5px solidrgba(35, 0, 230, 0.64);
    padding: 15px 20px;
    margin-bottom: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(11, 132, 244, 0.86);
}

.feedback-card h4 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.feedback-card small {
    color: #777;
    font-size: 13px;
}

.feedback-card .message {
    margin-top: 8px;
    font-size: 15px;
    line-height: 1.5;
    color: #444;
}

.feedback-card .stars {
    margin-top: 5px;
    color: gold;
    font-size: 18px;
}
</style>
</head>

<?php include('includes/header.php');?>

<?php include('includes/leftbar.php');?>

</head>
<div class="admin-feedback-container">
    <h2>User Feedback</h2>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="feedback-card">
            <h4><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['email']) ?>)</h4>
            <div class="stars"><?= str_repeat('⭐', $row['rating']) ?></div>
            <div class="message"><?= nl2br(htmlspecialchars($row['message'])) ?></div>
            <small>Submitted at: <?= $row['submitted_at'] ?></small>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

