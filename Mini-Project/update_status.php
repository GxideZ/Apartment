<?php
session_start();
require "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $bill_id = $_POST['id'] ?? null;
  $status = $_POST['status'] ?? null;

  if ($bill_id && $status) {
    try {
      // อัปเดตสถานะการชำระเงินในฐานข้อมูล
      $stmt = $pdo->prepare("UPDATE check_bill SET payment_status = ? WHERE bill_id = ?");
      $stmt->execute([$status, $bill_id]);

      if ($stmt->rowCount() > 0) {
        echo "Success";
      } else {
        echo "No changes made";
      }
    } catch (PDOException $e) {
      echo "Error: " . htmlspecialchars($e->getMessage());
    }
  } else {
    echo "Invalid input";
  }
} else {
  echo "Invalid request";
}
