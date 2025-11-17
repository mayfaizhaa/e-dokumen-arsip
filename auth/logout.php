<?php
require '../config/init.php';
session_destroy();
header('Location: auth_login.php');
exit;