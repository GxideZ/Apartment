<?php include_once('nav.php'); ?>

<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

try {
  // ดึงข้อมูลบิลทั้งหมด
  $stmt = $pdo->prepare("
    SELECT room_number, payment_status 
    FROM check_bill 
    ORDER BY 
      room_number ASC
  ");
  $stmt->execute();
  $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // สร้างอาร์เรย์สำหรับสถานะห้องพัก
  $roomStatuses = [];
  foreach ($bills as $bill) {
    $roomStatuses[$bill['room_number']] = $bill['payment_status'];
  }
} catch (PDOException $e) {
  echo "Error: " . htmlspecialchars($e->getMessage());
}

try {
  $stmt = $pdo->prepare("
    SELECT *, DATE_FORMAT(date, '%d-%m-%Y') AS formatted_date 
    FROM check_bill 
    ORDER BY 
      CASE
        WHEN billing_cycle = 'มกราคม' THEN 1
        WHEN billing_cycle = 'กุมภาพันธ์' THEN 2
        WHEN billing_cycle = 'มีนาคม' THEN 3
        WHEN billing_cycle = 'เมษายน' THEN 4
        WHEN billing_cycle = 'พฤษภาคม' THEN 5
        WHEN billing_cycle = 'มิถุนายน' THEN 6
        WHEN billing_cycle = 'กรกฎาคม' THEN 7
        WHEN billing_cycle = 'สิงหาคม' THEN 8
        WHEN billing_cycle = 'กันยายน' THEN 9
        WHEN billing_cycle = 'ตุลาคม' THEN 10
        WHEN billing_cycle = 'พฤศจิกายน' THEN 11
        WHEN billing_cycle = 'ธันวาคม' THEN 12
        ELSE 13
      END ASC, room_number ASC
");

  $stmt->execute();
  $bills = $stmt->fetchAll(PDO::FETCH_ASSOC); // ดึงข้อมูลทั้งหมด
} catch (PDOException $e) {
  echo "Error: " . htmlspecialchars($e->getMessage());
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
  <title>รายการรอชำระเงิน - Apartment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="pay1.css">
  <style>
    .room-btn {
      padding: 15px;
      display: block;
      text-align: center;
      color: white;
    }

    .room-unpaid {
      background-color: red;
    }

    .room-paid {
      background-color: green;
    }

    .room-no-data {
      background-color: grey;
    }

    .logo img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 0 auto;
      border-radius: 10px;
    }

    .room-btn {
      width: 100%;
      padding: 1.5rem;
    }

    .occupied-room {
      background-color: red;
      color: white;
    }

    .btn1:hover {
      background-color: #434eb1;
      color: white;
    }

    .room-btn {
      padding: 15px;
      display: block;
      text-align: center;
      color: white;
      font-weight: bold;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .room-unpaid {
      background-color: #dc3545;
    }

    .room-paid {
      background-color: #28a745;
    }

    .room-no-data {
      background-color: #6c757d;
    }

    .btn1 {
    outline: none !important; 
    text-decoration: none !important; 
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
          <a href="#" class="back-to-top nav-link active" aria-current="page">รายการรอชำระเงิน</a>
        </li>
        <li class="nav-item">
          <a href="admin.php" class="nav-link text-white ">รายชื่อเจ้าของหอพัก</a>
        </li>
        <li class="nav-item">
          <a href="signup.php" class="nav-link text-white">เพิ่มข้อมูลเจ้าของหอพัก</a>
        </li>
        <li class="nav-item">
          <a href="rate.php" class="nav-link text-white">อัตราค่าน้ำค่าไฟ</a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="container mt-4 ms-3">
      <h1 class="fw-light">รายการรอชำระเงิน</h1>

      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">หมายเลขห้อง</th>
              <th scope="col">รอบบิล</th>
              <th scope="col">ค่าใช้จ่ายรวม</th>
              <th scope="col">วันที่บันทึกข้อมูล</th>
              <th scope="col">สถานะชำระเงิน</th>
              <th scope="col">ลบข้อมูล</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($bills)): ?>
              <?php foreach ($bills as $bill): ?>
                <tr>
                  <td><?php echo htmlspecialchars($bill['room_number']); ?></td>
                  <td><?php echo htmlspecialchars($bill['billing_cycle']); ?></td>
                  <td><?php echo number_format($bill['total_price'], 2); ?> บาท</td>
                  <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($bill['date']))); ?></td>
                  <td style="display: flex; align-items: center; gap: 20px;">
                    <?php if ($bill['payment_status'] == 'ชำระแล้ว'): ?>
                      <span class="status-icon text-success ms-3">&#10004;</span>
                    <?php else: ?>
                      <span class="status-icon text-danger ms-3">&#10008;</span>
                    <?php endif; ?>
                    <select class="form-select" onchange="showConfirmButton(<?php echo $bill['bill_id']; ?>, this)" data-original-status="<?php echo htmlspecialchars($bill['payment_status']); ?>">
                      <option value="ยังไม่ชำระ" <?php echo $bill['payment_status'] == 'ยังไม่ชำระ' ? 'selected' : ''; ?>>ยังไม่ชำระ</option>
                      <option value="ชำระแล้ว" <?php echo $bill['payment_status'] == 'ชำระแล้ว' ? 'selected' : ''; ?>>ชำระแล้ว</option>
                    </select>
                    <button class="btn btn-primary confirm-btn me-3" onclick="updatePaymentStatus(<?php echo $bill['bill_id']; ?>, this)">ยืนยัน</button>
                  </td>
                  <td>
                    <button class="btn btn-danger " onclick="deleteBill(<?php echo $bill['bill_id']; ?>)">ลบ</button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">ไม่มีข้อมูลบิลที่ต้องการแสดง</td>
              </tr>
            <?php endif; ?>
          </tbody>

        </table>
      </div>

      <br>
      <div class="row">
        
        <?php
        $rooms = [101, 102, 103, 104, 105, 201, 202, 203, 204, 205];
        foreach ($rooms as $room) {
          if (isset($roomStatuses[$room])) {
            $status = $roomStatuses[$room];
            if ($status == 'ชำระแล้ว') {
              $btnClass = 'room-paid';
            } elseif ($status == 'ยังไม่ชำระ') {
              $btnClass = 'room-unpaid';
            }
          } else {
            $btnClass = 'room-no-data';
          }

          echo "<div class='col-6 col-md-4 mb-4'>
            <a href='#.' class='btn1 $btnClass room-btn'>ห้อง {$room}</a>
          </div>";
        }
        ?>
      </div>

    </div>
  </div>



  </div>

  <?php include_once('footer.php'); ?>

  <script>
    function updatePaymentStatus(bill_id, buttonElement) {
      const selectElement = buttonElement.previousElementSibling; // ค้นหา select element
      const newStatus = selectElement.value;

      // ส่งคำขอ AJAX เพื่ออัปเดตสถานะในฐานข้อมูล
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "update_status.php", true); // ตรวจสอบว่าไฟล์นี้อยู่ใน path ที่ถูกต้อง
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          window.location.href = "pay.php"; // ย้ายไปยังหน้า pay.php หลังจากอัปเดตสำเร็จ
          selectElement.value = newStatus;
        } else if (xhr.readyState === 4) {
          alert("เกิดข้อผิดพลาดในการอัปเดตสถานะ: " + xhr.status);
        }
      };
      xhr.send("id=" + bill_id + "&status=" + encodeURIComponent(newStatus));
    }


    function deleteBill(bill_id) {
      if (confirm("คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_bill.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            alert("ลบรายการสำเร็จ!");
            window.location.reload();
          } else if (xhr.readyState === 4) {
            alert("เกิดข้อผิดพลาดในการลบ: " + xhr.status);
          }
        };
        xhr.send("id=" + bill_id);
      }
    }
  </script>

</body>

</html>