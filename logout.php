<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: index.php"); // перенаправление на главную страницу после выхода
?>
