<?php
session_start();
require "config.php";

$message = ''; // ตัวแปรสำหรับเก็บข้อความแจ้งเตือน

// ตรวจสอบว่ามีการส่งค่าหมายเลขห้องมาหรือไม่
if (isset($_GET['room'])) {
    $room_number = htmlspecialchars($_GET['room']); // ใช้ htmlspecialchars เพื่อป้องกัน XSS
    $tenant = null; // กำหนดค่าเริ่มต้นให้กับ $tenant

    // Query ข้อมูลผู้เช่าจากฐานข้อมูลโดยใช้หมายเลขห้อง
    try {
        $stmt = $pdo->prepare("SELECT * FROM tenants WHERE room_number = ?");
        $stmt->execute([$room_number]);
        $tenant = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับข้อมูลใหม่จากฟอร์ม
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $address = htmlspecialchars($_POST['address']);
        $phone = htmlspecialchars($_POST['phone']);
        $start_date = htmlspecialchars($_POST['start_date']);
        $end_date = htmlspecialchars($_POST['end_date']);
        $iden_id = htmlspecialchars($_POST['iden_id']); // รับข้อมูลเลขบัตรประชาชน

        // ตรวจสอบว่าห้องมีผู้เช่าหรือไม่
        if ($tenant) {
            // อัพเดทข้อมูลผู้เช่าเดิม
            try {
                $stmt = $pdo->prepare("UPDATE tenants SET name = ?, email = ?, address = ?, phone = ?, start_date = ?, end_date = ?, iden_id = ? WHERE room_number = ?");
                $stmt->execute([$name, $email, $address, $phone, $start_date, $end_date, $iden_id, $room_number]);

                $message = "ข้อมูลถูกแก้ไขเรียบร้อยแล้ว";
            } catch (PDOException $e) {
                $message = "Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } else {
            // เพิ่มข้อมูลผู้เช่าใหม่
            try {
                $stmt = $pdo->prepare("INSERT INTO tenants (name, email, address, phone, start_date, end_date, room_number, iden_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $address, $phone, $start_date, $end_date, $room_number, $iden_id]);

                $message = "เพิ่มข้อมูลผู้เช่าใหม่เรียบร้อยแล้ว";
            } catch (PDOException $e) {
                $message = "<div class='alert alert-danger text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        }

        try {
            $stmt = $pdo->prepare("SELECT room_number, name, iden_id, phone, address, email FROM tenants WHERE room_number = ?");
            $stmt->execute([$room_number]);
            $tenantData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($tenantData) {
                $stmt = $pdo->prepare("INSERT INTO rentor (room_number, name, iden_id, phone, address, email) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$tenantData['room_number'], $tenantData['name'], $tenantData['iden_id'], $tenantData['phone'], $tenantData['address'], $tenantData['email']]);
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger text-center'>Error while inserting into rentor: " . htmlspecialchars($e->getMessage()) . "</div>";
        }

        // เปลี่ยนเส้นทางไปยังหน้าเดิมเพื่อดึงข้อมูลที่อัปเดตแล้ว
        header("Location: " . $_SERVER['PHP_SELF'] . "?room=" . $room_number . "&message=" . urlencode($message));
        exit;
    }
} else {
    echo "<div class='alert alert-warning text-center'>กรุณาเลือกห้องพัก</div>";
    exit;
}

// เช็คและแสดงข้อความแจ้งเตือน
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้เช่า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="tanant.css">
</head>

<body>
    <h1 class='text-center mt-5'>ข้อมูลผู้เช่าห้อง <?php echo htmlspecialchars($room_number); ?></h1>
    <div class='container mt-5'>
        <div class='row justify-content-center'>
            <div class='col-md-8'>
                <div class='card'>
                    <div class='card-header bg-success text-white text-center'>
                        <h4><?php echo $tenant ? 'แก้ไข' : 'เพิ่ม'; ?>ข้อมูลผู้เช่าห้อง <?php echo htmlspecialchars($room_number); ?></h4>
                    </div>

                    <div class='card-body'>
                        <?php if ($message): ?>
                            <div class='alert alert-info text-center'><?php echo $message; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">ชื่อ</label>
                                <input type="text" class="form-control" id="name" name="name" value="  <?php echo $tenant ? htmlspecialchars($tenant['name']) : ''; ?>  " required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">อีเมล</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $tenant ? htmlspecialchars($tenant['email']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">ที่อยู่</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $tenant ? htmlspecialchars($tenant['address']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $tenant ? htmlspecialchars($tenant['phone']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="iden_id" class="form-label">เลขบัตรประชาชน</label>
                                <input type="text" class="form-control" id="iden_id" name="iden_id" value="<?php echo $tenant ? htmlspecialchars($tenant['iden_id']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">วันเริ่มเช่า</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $tenant ? htmlspecialchars($tenant['start_date']) : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">วันสิ้นสุดสัญญาเช่า</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $tenant ? htmlspecialchars($tenant['end_date']) : ''; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-danger"><?php echo $tenant ? 'บันทึกการแก้ไข' : 'เพิ่มข้อมูลผู้เช่า'; ?></button>
                        </form>
                    </div>
                    <div class='card-footer text-center'>
                        <a href='dashboard.php' class='btn'>กลับไปหน้าหลัก</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
