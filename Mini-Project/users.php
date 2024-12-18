    <?php include_once('nav.php'); ?>

    <?php
    session_start();
    require "config.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM tenants ORDER BY room_number ASC");
        $stmt->execute();
        $tenants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger text-center mt-5'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        exit;
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
        <title>รายการผู้เช่า - Apartment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="users_.css">
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
                        <a href="#" class="back-to-top nav-link text-white active">รายชื่อผู้เช่า</a>
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
                        <a href="rate.php" class="nav-link text-white">อัตราค่าน้ำค่าไฟ</a>
                    </li>
                </ul>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-11 ms-3">
                        <h1 class="fw-light mt-4 ms-3">รายการผู้เช่า</h1>
                        <div class="container mt-5 d-flex justify-content-center">
                            <table class="table table-striped">
                                <thead class="table">
                                    <tr>
                                        <th scope="col">เลขห้อง</th>
                                        <th scope="col">ชื่อผู้เช่า</th>
                                        <th scope="col">หมายเลขบัตรประชาชน</th>
                                        <th scope="col">เบอร์โทร</th>
                                        <th scope="col">ที่อยู่</th>
                                        <th scope="col">อีเมล</th>
                                        <th scope="col">ลบข้อมูล</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($tenants): ?>
                                        <?php foreach ($tenants as $tenant): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($tenant['room_number']); ?></td>
                                                <td><?php echo htmlspecialchars($tenant['name']); ?></td>
                                                <td><?php echo htmlspecialchars($tenant['iden_id']); ?></td>
                                                <td><?php echo htmlspecialchars($tenant['phone']); ?></td>
                                                <td><?php echo htmlspecialchars($tenant['address']); ?></td>
                                                <td><?php echo htmlspecialchars($tenant['email']); ?></td>
                                                <td>
                                                    <button class="btn btn-danger" onclick="deleteTenant(<?php echo $tenant['id']; ?>)">ลบ</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">ไม่มีข้อมูลผู้เช่า</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function deleteTenant(tenant_id) {
                if (confirm("คุณแน่ใจหรือไม่ว่าต้องการลบผู้เช่ารายนี้?")) {
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "delete_tenant.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert("ลบผู้เช่าสำเร็จ!");
                            window.location.reload();
                        } else if (xhr.readyState === 4) {
                            alert("เกิดข้อผิดพลาดในการลบ: " + xhr.status);
                        }
                    };
                    xhr.send("id=" + tenant_id);
                }
            }
        </script>

        <?php include_once('footer.php'); ?>
    </body>

    </html>