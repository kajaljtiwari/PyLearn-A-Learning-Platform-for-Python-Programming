<?php
session_start();

/* destroy admin session */
session_unset();
session_destroy();

/* redirect login page */
header("Location: admin.php");
exit();
?>