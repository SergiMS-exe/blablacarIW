<?php 
session_start();

unset($_SESSION['login']);
unset($_SESSION['google_email']);

header('Location: /index.php');