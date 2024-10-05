<?php
require_once 'UserManagement.php';

$message = '';
$userManagement = new UserManagement('localhost', 'user_management', 'root', '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($username) || empty($email) || empty($password)) {
        $message = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format.';
    } elseif (strlen($password) < 8) {
        $message = 'Password must be at least 8 characters long.';
    } else {
        try {
            $userId = $userManagement->registerUser($username, $email, $password);
            $message = "User registered successfully. You can now <a href='login.php'>log in</a>.";
        } catch (PDOException $e) {
            $message = 'Registration failed: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Novel Enthusiasts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>