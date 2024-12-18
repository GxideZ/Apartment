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

// ดึงค่าน้ำและค่าไฟจากฐานข้อมูล
try {
    $stmt = $pdo->prepare("SELECT water_rate, electricity_rate FROM utilities_rates WHERE id = 1");
    $stmt->execute();
    $rates = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการห้องพัก - Apartment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboradZ.css">
    <style>
        .logo img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 10px;
        }

        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .form-container h1 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #343a40;
        }

        .form-container .form-label {
            font-weight: bold;
            color: #495057;
        }

        .form-container input[type="text"] {
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-container input[type="text"]:focus {
            border-color: #80bdff;
            outline: none;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3">
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
                    <a href="rent.php" class="nav-link text-white">ฟอร์มคิดค่าเช่า</a>
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
                    <a href="#" class="back-to-top nav-link text-white active">อัตราค่าน้ำค่าไฟ</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container mt-4">
            <div class="form-container mt-4">
                <h1>อัตราการเปลี่ยนแปลงค่าน้ำ-ค่าไฟ</h1>
                <form action="update_rates.php" method="POST">
                    <div class="mb-3">
                        <label for="water" class="form-label">ค่าน้ำ / หน่วย</label>
                        <input type="text" class="form-control" name="water" value="<?php echo htmlspecialchars($rates['water_rate']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="electricity" class="form-label">ค่าไฟ / หน่วย</label>
                        <input type="text" class="form-control" name="electricity" value="<?php echo htmlspecialchars($rates['electricity_rate']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>