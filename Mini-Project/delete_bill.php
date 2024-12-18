<?php
require "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $bill_id = $_POST['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM check_bill WHERE bill_id = ?");
        $stmt->execute([$bill_id]);

        if ($stmt->rowCount()) {
            echo "ลบรายการสำเร็จ!";
        } else {
            echo "ไม่พบรายการที่ต้องการลบ!";
        }
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
