<?php
session_start();

unset($_SESSION['is_admin']);
unset($_SESSION['admin_email']);

session_destroy();

header('Location: index.php?page=admin&action=login');
exit;
