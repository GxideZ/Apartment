<?php include_once('nav.php'); ?>

<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success_message = ""; // ตัวแปรสำหรับเก็บข้อความสำเร็จ

try {
    $stmt = $pdo->prepare("SELECT water_rate, electricity_rate FROM utilities_rates WHERE id = 1");
    $stmt->execute();
    $rates = $stmt->fetch(PDO::FETCH_ASSOC);
    $water_rate = $rates['water_rate'];
    $electricity_rate = $rates['electricity_rate'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $room_number = $_POST['room_number'];
    $billing_cycle = $_POST['billing_cycle'];
    $room_price = $_POST['room_price'];
    $water_units = $_POST['water_units'];
    $electricity_units = $_POST['electricity_units'];

    // คำนวณค่าน้ำและค่าไฟโดยคูณกับอัตราต่อหน่วย
    $water_price = $water_units * $water_rate;
    $electricity_price = $electricity_units * $electricity_rate;
    $total_price = $room_price + $water_price + $electricity_price;

    // บันทึกข้อมูลลงในตาราง check_bill
    try {
        $stmt = $pdo->prepare("INSERT INTO check_bill (room_number, billing_cycle, room_price, water_price, electricity_price, total_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$room_number, $billing_cycle, $room_price, $water_price, $electricity_price, $total_price]);

        // ถ้าบันทึกสำเร็จ, ตั้งค่าข้อความสำเร็จ
        $success_message = "บันทึกข้อมูลสำเร็จแล้ว";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มคิดค่าเช่า - Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="rent_.css">
    <style>
        .logo img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 10px;
        }


    </style>

<body>

    <div class="d-flex ">
        <!-- Sidebar -->
        <div class="sidebar p-3 ">
            <div class="user-info">
                <!-- <div class="logo mb-3 mt-3">
                    <img src="pr.jpg" alt="Logo" class="img-fluid">
                </div> -->
                <br>
                <p><strong>ชื่อผู้ใช้ :</strong> <?php echo htmlspecialchars($userData['username']); ?></p>
                <p><strong>อีเมล์ :</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link text-white">รายการห้องพัก</a>
                </li>
                <li class="nav-item">
                    <a href="users.php" class="nav-link text-white">รายชื่อผู้เช่า</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="back-to-top nav-link text-white active">ฟอร์มคิดค่าเช่า</a>
                </li>
                <li class="nav-item">
                    <a href="pay.php" class="nav-link text-white" aria-current="page">รายการรอชำระเงิน</a>
                </li>
                <li class="nav-item">
                    <a href="admin.php" class="nav-link text-white">รายชื่อเจ้าของหอพัก</a>
                </li>
                <li class="nav-item">
                    <a href="signup.php" class="nav-link text-white">เพิ่มข้อมูลเจ้าของหอพัก</a>
                </li>
                <li class="nav-item">
                    <a href="rate.php" class="nav-link text-white">อัตราค่าน้ำค่าไฟ</a>
                </li>
            </ul>
        </div>

        <!-- เนื้อหาด้านขวา -->
        <div class="container mt-2 ms-3">
            <h1 class="fw-light mt-2 ms-3">ฟอร์มคิดค่าเช่า</h1>
            <br>
            <!-- ส่วนแสดงข้อความบันทึกข้อมูลสำเร็จ -->
            <?php if ($success_message): ?>
                <div id="success-message" class="success-message alert alert-success">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="bg-light p-4 rounded shadow-sm">
                <div class="mb-3">
                    <label for="room_number" class="form-label">หมายเลขห้อง :</label>
                    <select class="form-select" id="room_number" name="room_number" required>
                        <option value="" selected disabled>เลือกหมายเลขห้อง</option>
                        <option value="101">101</option>
                        <option value="102">102</option>
                        <option value="103">103</option>
                        <option value="104">104</option>
                        <option value="105">105</option>
                        <option value="201">201</option>
                        <option value="202">202</option>
                        <option value="203">203</option>
                        <option value="204">204</option>
                        <option value="205">205</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="billing_cycle" class="form-label">รอบบิล :</label>
                    <select class="form-select" id="billing_cycle" name="billing_cycle" required>
                        <option value="" selected disabled>เลือกรอบบิล</option>
                        <option value="มกราคม">มกราคม</option>
                        <option value="กุมภาพันธ์">กุมภาพันธ์</option>
                        <option value="มีนาคม">มีนาคม</option>
                        <option value="เมษายน">เมษายน</option>
                        <option value="พฤษภาคม">พฤษภาคม</option>
                        <option value="มิถุนายน">มิถุนายน</option>
                        <option value="กรกฎาคม">กรกฎาคม</option>
                        <option value="สิงหาคม">สิงหาคม</option>
                        <option value="กันยายน">กันยายน</option>
                        <option value="ตุลาคม">ตุลาคม</option>
                        <option value="พฤศจิกายน">พฤศจิกายน</option>
                        <option value="ธันวาคม">ธันวาคม</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="room_price" class="form-label">ราคาห้อง :</label>
                    <input type="number" class="form-control" id="room_price" name="room_price" required>
                </div>


                <div class="mb-3">
                    <label for="water_units" class="form-label">หน่วยค่าน้ำ : <small>อัตราค่าน้ำ: <?php echo $water_rate; ?> บาท/หน่วย</small></label>
                    <input type="number" class="form-control" id="water_units" name="water_units" required>

                </div>


                <div class="mb-3">
                    <label for="electricity_units" class="form-label">หน่วยค่าไฟ : <small>อัตราค่าไฟ: <?php echo $electricity_rate; ?> บาท/หน่วย</small></label>
                    <input type="number" class="form-control" id="electricity_units" name="electricity_units" required>
                </div>


                <div class="mb-3">
                    <label for="total_price" class="form-label">รวมทั้งหมด :</label>
                    <input type="text" class="form-control" id="total_price" readonly>
                </div>
            
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                    <a href="view_bills.php" class="btn btn-danger">ดูรายการบิล</a>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var roomPriceInput = document.getElementById('room_price');
                var waterUnitsInput = document.getElementById('water_units');
                var electricityUnitsInput = document.getElementById('electricity_units');
                var totalPriceInput = document.getElementById('total_price');
                var waterRate = <?php echo $water_rate; ?>;
                var electricityRate = <?php echo $electricity_rate; ?>;

                function calculateTotal() {
                    var roomPrice = parseFloat(roomPriceInput.value) || 0;
                    var waterUnits = parseFloat(waterUnitsInput.value) || 0;
                    var electricityUnits = parseFloat(electricityUnitsInput.value) || 0;
                    var waterPrice = waterUnits * waterRate;
                    var electricityPrice = electricityUnits * electricityRate;
                    var totalPrice = roomPrice + waterPrice + electricityPrice;
                    totalPriceInput.value = totalPrice.toFixed(2);
                }

                roomPriceInput.addEventListener('input', calculateTotal);
                waterUnitsInput.addEventListener('input', calculateTotal);
                electricityUnitsInput.addEventListener('input', calculateTotal);

                // ซ่อนข้อความสำเร็จ
                var successMessage = document.getElementById('success-message');
                if (successMessage) {
                    setTimeout(function() {
                        successMessage.classList.add('hidden');
                    }, 1800); // ซ่อนหลัง 1.8 วินาที
                }
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>