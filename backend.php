<?php
// Anslut till databasen
include "db_connect.php";
$interval = 1;


try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Om ett nytt meddelande skickas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO chat (ip, message, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$ip, $message]);
    }
    exit;
}

// Radera gamla meddelanden (äldre än 30 min)
$pdo->exec("DELETE FROM chat WHERE created_at < NOW() - INTERVAL $interval MINUTE");

// Hämta meddelanden
$messages = $pdo->query("SELECT ip, message, created_at FROM chat ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$json_data = json_encode($messages, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
echo $json_data;
?>