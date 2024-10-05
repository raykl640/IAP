?php
session_start();
require_once 'UserManagement.php';

$message = '';
$userManagement = new UserManagement('localhost', 'user_management', 'root', '');