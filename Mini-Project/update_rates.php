<?php
require "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $water_rate = $_POST['water'];
    $electricity_rate = $_POST['electricity'];

    // ตรวจสอบข้อมูลและป้องกันการใส่ข้อมูลผิด
    if (is_numeric($water_rate) && is_numeric($electricity_rate)) {
        try {
            $stmt = $pdo->prepare("UPDATE utilities_rates SET water_rate = ?, electricity_rate = ? WHERE id = 1");
            $stmt->execute([$water_rate, $electricity_rate]);

            header("Location: rate.php");
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        echo "กรุณากรอกค่าน้ำและค่าไฟเป็นตัวเลขเท่านั้น!";
    }
}
?>
