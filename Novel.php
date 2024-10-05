<?php
session_start();
require_once 'UserManagement.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userManagement = new UserManagement('localhost', 'user_management', 'root', '');
$novels = $userManagement->getPopularNovels();
?>