<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $tenant_id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM tenants WHERE id = ?");
        $stmt->execute([$tenant_id]);

        if ($stmt->rowCount() > 0) {
            echo "ลบผู้เช่าสำเร็จ";
        } else {
            echo "ไม่พบผู้เช่าที่ต้องการลบ";
        }
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
} else {
    echo "คำขอไม่ถูกต้อง";
}
?>
