<?php
if (isset($_GET['exit_user'])){
setcookie("hash", '', time() - 60 * 60 * 24, "/", null, null, true);
setcookie("user_name", '', time() - 60 * 60 * 24, "/", null, null, true);

header("Location: ../index.php");
}