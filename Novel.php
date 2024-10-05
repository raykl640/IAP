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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popular Novels - Novel Enthusiasts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <h3 class="text-center mb-4">Most Popular Novels</h3>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year Published</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($novels as $novel): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($novel['title']); ?></td>
                                <td><?php echo htmlspecialchars($novel['author']); ?></td>
                                <td><?php echo htmlspecialchars($novel['year_published']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>