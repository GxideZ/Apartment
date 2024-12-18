<?php
$servername = "localhost"; // ชื่อโฮสต์ฐานข้อมูล
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = ""; // รหัสผ่านฐานข้อมูล
$dbname = "Manage_Apartment"; // ชื่อฐานข้อมูลที่ต้องการใช้

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับข้อมูลจากฟอร์ม
$name = $_POST['name'];
$address = $_POST['address'];
$iden_id = $_POST['iden_id'];
$roomnum = $_POST['roomnum'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// สร้างคำสั่ง SQL สำหรับบันทึกข้อมูล
$sql = "INSERT INTO tenants (name, address,room_number, email, phone, start_date, end_date)
VALUES ('$name', '$address',$roomnum', '$email', '$phone', '$startDate', '$endDate')";
$sql = "INSERT INTO rentor (room_number, name,iden_id,phone,address,email)
VALUES ('$roomnum', '$name',$iden_id','$phone', '$address', '$email')";

// ตรวจสอบการบันทึกข้อมูล
if ($conn->query($sql) === TRUE) {
    echo "บันทึกข้อมูลผู้เช่าเรียบร้อยแล้ว!";
// Redirect ไปยังหน้าหลักหลังจากบันทึกสำเร็จ
header("Location: dashboard.php"); // แทนที่ "index.php" ด้วย URL ของหน้าหลักของคุณ
exit(); // หยุดการทำงานของ PHP หลังจาก redirect
} else {
echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

// ปิดการเชื่อมต่อ
$stmt->close();
$conn->close();
?>