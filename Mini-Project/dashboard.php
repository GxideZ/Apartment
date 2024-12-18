<?php
include_once('nav.php');
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

// ดึงข้อมูลหมายเลขห้องที่มีผู้เช่า
try {
  $stmtRooms = $pdo->prepare("SELECT room_number FROM tenants");
  $stmtRooms->execute();
  $occupiedRooms = $stmtRooms->fetchAll(PDO::FETCH_COLUMN);
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
    .room-btn {
      padding: 1.5rem;
      width: 100%;
      text-align: center;
      transition: transform 0.2s, background-color 0.2s;
    }

    .room-btn:hover {
      background-color: #101db5;
      color: #fff;
    }



    .logo img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 0 auto;
      border-radius: 10px;
    }

    .occupied-room {
      background-color: red;
      cursor: not-allowed;
      color: white;
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
        <br>
        <p><strong>ชื่อผู้ใช้ :</strong> <?php echo htmlspecialchars($userData['username']); ?></p>
        <p><strong>อีเมล์ :</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
      </div>
      <hr>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a href="#" class="back-to-top nav-link text-white active">รายการห้องพัก</a>
        </li>
        <li class="nav-item">
          <a href="users.php" class="nav-link text-white">รายชื่อผู้เช่า</a>
        </li>
        <li class="nav-item">
          <a href="rent.php" class="nav-link text-white">ฟอร์มคิดค่าเช่า</a>
        </li>
        <li class="nav-item">
          <a href="pay.php" class="nav-link text-white">รายการรอชำระเงิน</a>
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

    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h1 class="fw-light mt-4 ms-3">รายการห้องพัก</h1>
          <div class="offset-md-4 mt-5">
            <div class="row">
              <?php
              $rooms = [101, 102, 103, 104, 105, 201, 202, 203, 204, 205];
              foreach ($rooms as $room) {
                $btnClass = in_array($room, $occupiedRooms) ? 'occupied-room' : 'btn-secondary';
                echo "<div class='col-6 col-md-4 mb-4'>
                        <a href='tenant.php?room={$room}' class='btn $btnClass room-btn'>ห้อง {$room}</a>
                      </div>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>