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

try {
    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        body {
            background-color: #f0f2f5;
            /* เปลี่ยนเป็นสีพื้นหลังที่ดูหรูหรา */
            font-family: 'Roboto', sans-serif;
            /* ใช้ฟอนต์ Roboto */
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            background-color: #212529;
            /* สีพื้นหลังเข้ม */
            color: white;
            padding-top: 30px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            /* เพิ่มเงาให้ sidebar */
        }

        .sidebar .user-info {
            background-color: #343a40;
            /* สีพื้นหลังของ user-info */
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* เพิ่มเงาให้ user-info */
        }

        .sidebar .nav-link {
            transition: background-color 0.3s ease, transform 0.3s ease;
            padding: 10px 15px;
            /* เพิ่ม padding */
        }

        .sidebar .nav-link:hover {
            background-color: #17a2b8;
            /* สีเมื่อ hover */
            transform: scale(1.05);
        }

        .sidebar .nav-link.active {
            background-color: #17a2b8;
            /* สีที่ใช้ในลิงก์ที่เลือก */
            font-weight: bold;
            border-left: 5px solid gold;
            /* ขอบซ้ายสีทอง */
        }

        .btn {
            background-color: #FFA500;
            color: white;

            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #FF8C00;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .table {
            margin-top: 30px;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background-color: green;
            color: white;
        }

        .table td {
            vertical-align: middle;
        }

        .status-icon {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
        }

        .table th {
            background-color: green;
            color: #ffffff;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .table th:hover {
            background-color: #006400;

        }

        th,
        td {
            white-space: nowrap;
            /* ป้องกันข้อความยาวเกินจนขึ้นบรรทัดใหม่ */
            text-align: center;
            /* จัดให้อยู่กึ่งกลาง */
            justify-content: center;
        }

        .status-icon {
            font-size: 1.2rem;
            /* ขนาดไอคอน */
        }

        th:nth-child(1),
        td:nth-child(1) {
            width: 10%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 15%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 30%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 15%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 100%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 50%;
        }

        .form-select {
            width: 90%;
            margin-right: 10px;

        }

        .confirm-btn {
            flex-shrink: 0;
        }

        td[style*="display: flex;"] {
            justify-content: space-between;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-danger:hover {
            background-color: darkred;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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
                    <a href="#" class="back-to-top nav-link text-white active">รายชื่อเจ้าของหอพัก</a>
                </li>
                <li class="nav-item">
                    <a href="signup.php" class="nav-link text-white ">เพิ่มข้อมูลเจ้าของหอพัก</a>
                </li>
                <li class="nav-item">
                    <a href="rate.php" class="nav-link text-white ">อัตราค่าน้ำค่าไฟ</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="container mt-4 ms-3">
            <h1 class="fw-light">รายชื่อเจ้าของหอพัก</h1>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">ชื่อผู้ใช้</th>
                            <th scope="col">email</th>
                            <th scope="col">password</th>
                            <th scope="col">แก้ไขข้อมูล</th>
                            <th scope="col">ลบข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['password']); ?></td>
                                <td>
                                    <a href="change_password.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">เปลี่ยนรหัสผ่าน</a>
                                </td>
                                <td>
                                    <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลนี้ใช่หรือไม่?');">ลบ</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>