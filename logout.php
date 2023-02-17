<?php
session_start();
session_destroy();
echo "<script>window.location.href='login.php?user_logged_out';</script>";

?>