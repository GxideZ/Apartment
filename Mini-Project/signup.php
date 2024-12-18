<?php include_once('nav.php'); ?>

<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 120%;
        justify-content: center;
        align-items: center;
        /* จัดกลางทั้งแนวตั้งและแนวนอน */
        height: 90vh;
        /* ใช้ความสูงเต็มของ viewport */
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9);
        /* โปร่งใส 80% */
        border: none;
        /* เอาเส้นขอบออกหากต้องการ */
        box-shadow: none;
        /* เอาเงาออกหากไม่ต้องการ */
    }

    .card-header {
        background-color: #28a745;
        /* สีเขียวเข้ม */
        color: white;
        text-align: center;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        /* มุมมนที่ด้านบน */
    }

    .card-body {
        padding: 20px;
    }

    .form-label {
        font-weight: bold;
        /* ตัวหนาเพื่อความชัดเจน */
    }


    p.text-center {
        color: gray;
        /* เปลี่ยนเป็นสีเทา */
    }

    p.text-center a {
        color: #007bff;
        /* สีลิงก์ */
    }

    p.text-center a:hover {
        color: #0056b3;
        /* สีลิงก์เมื่อ hover */
    }

    .card-header.custom-header {
        background-color: #218838;
        /* เปลี่ยนเป็นสีที่คุณต้องการ */
        color: white;
        /* สีของข้อความ */
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการห้องพัก - Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboradZ.css">
    <style>

    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
            <div class="user-info">
                
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
                    <a href="rent.php" class="nav-link text-white">ฟอร์มคิดค่าเช่า</a>
                </li>
                <li class="nav-item">
                    <a href="pay.php" class="nav-link text-white" aria-current="page">รายการรอชำระเงิน</a>
                </li>
                <li class="nav-item">
                    <a href="admin.php" class="nav-link text-white">รายชื่อเจ้าของหอพัก</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="back-to-top nav-link text-white active">เพิ่มข้อมูลเจ้าของหอพัก</a>
                </li>
                <li class="nav-item">
                    <a href="rate.php" class="nav-link text-white ">อัตราค่าน้ำค่าไฟ</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header custom-header">
                            <h2 class="text-center">เพิ่มข้อมูลเจ้าของหอพัก</h2>
                        </div>

                        <div class="card-body">

                            <!-- Success Message -->
                            <?php if (isset($_SESSION['success'])) { ?>
                                <div class="alert alert-success">
                                    <?php
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                    ?>
                                </div>
                            <?php } ?>

                            <!-- Error Message -->
                            <?php if (isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger">
                                    <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                    ?>
                                </div>
                            <?php } ?>

                            <!-- Registration Form -->
                            <form action="signup_db.php" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password_1" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password_2" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm your password" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" name="register" class="btn btn-success">Sign up</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>