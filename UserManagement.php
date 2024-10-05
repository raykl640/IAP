<?php

class UserManagement {
    private $pdo;

    public function __construct($host, $db, $user, $pass) {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException("Database connection failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public function registerUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $twoFactorSecret = $this->generateTwoFactorSecret();

        $sql = "INSERT INTO users (username, email, password, two_factor_secret) VALUES (?, ?, ?, ?)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $email, $hashedPassword, $twoFactorSecret]);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw new \PDOException("User registration failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public function loginUser($username, $password) {
        try {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
        } catch (\PDOException $e) {
            throw new \PDOException("Login failed: " . $e->getMessage(), (int)$e->getCode());
        }

        return false;
    }

    public function getPopularNovels() {
        try {
            $sql = "SELECT * FROM popular_novels ORDER BY year_published DESC";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \PDOException("Fetching popular novels failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    private function generateTwoFactorSecret() {
        return strval(random_int(100000, 999999));
    }
}
?>