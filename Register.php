<?php
require_once 'UserManagement.php';

$message = '';
$userManagement = new UserManagement('localhost', 'user_management', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';