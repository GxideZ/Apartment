    <?php include_once('nav.php'); ?>

    <?php
    session_start();
    require "config.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // สร้างอาร์เรย์สำหรับเดือนในภาษาไทย
    $months = [
        1 => 'มกราคม',
        2 => 'กุมภาพันธ์',
        3 => 'มีนาคม',
        4 => 'เมษายน',
        5 => 'พฤษภาคม',
        6 => 'มิถุนายน',
        7 => 'กรกฎาคม',
        8 => 'สิงหาคม',
        9 => 'กันยายน',
        10 => 'ตุลาคม',
        11 => 'พฤศจิกายน',
        12 => 'ธันวาคม',
    ];

    // การเลือกเดือน
    $selected_month = isset($_POST['month']) ? $_POST['month'] : '';

    $bills = []; // ตัวแปรเพื่อเก็บข้อมูลบิล

    try {
        // ตรวจสอบว่ามีการเลือกเดือนหรือไม่
        if ($selected_month) {
            // แปลงเลขเดือนเป็นชื่อเดือนในภาษาไทย
            $selected_month_name = $months[$selected_month];

            // SQL ที่ใช้ในการดึงข้อมูลเฉพาะ billing_cycle ที่ตรงกับเดือนที่เลือก
            $stmt = $pdo->prepare("
                SELECT room_number, 
                    room_price, 
                    water_price, 
                    electricity_price, 
                    total_price, 
                    billing_cycle,  
                    date
                FROM check_bill 
                WHERE billing_cycle LIKE ? 
                ORDER BY room_number ASC
            ");

            $stmt->execute(['%' . $selected_month_name . '%']); // เปรียบเทียบเฉพาะส่วนของเดือน
            $bills = $stmt->fetchAll(PDO::FETCH_ASSOC); // เก็บผลลัพธ์จากการดึงข้อมูล
        }

        $stmt = $pdo->query("
            SELECT room_number, 
                room_price, 
                water_price, 
                electricity_price, 
                total_price, 
                billing_cycle,  
                date 
            FROM check_bill 
            ORDER BY room_number ASC
        ");


        // ถ้าไม่มีการเลือกเดือน ให้ดึงข้อมูลทั้งหมด
        if (empty($bills) && !$selected_month) {
            $stmt = $pdo->query("
                SELECT room_number, 
                    room_price, 
                    water_price, 
                    electricity_price, 
                    total_price, 
                    billing_cycle,  /* ดึงข้อมูลรอบบิล */
                    date 
                FROM check_bill 
                ORDER BY room_number ASC");
            $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }

    // สร้างอาร์เรย์สำหรับรายได้ของแต่ละเดือน เริ่มต้นด้วย 0
    $monthlyRevenue = array_fill(1, 12, 0);

    try {
        // ใช้ billing_cycle เพื่อดึงข้อมูลรายได้รวมรายเดือนจากรอบบิลที่มีชื่อเดือน
        $stmt = $pdo->query("
        SELECT 
            billing_cycle,
            SUM(total_price) AS revenue
        FROM check_bill
        GROUP BY billing_cycle
        ORDER BY FIELD(billing_cycle, 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม')
    ");

        $revenues = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // กรอกข้อมูลรายได้ลงในอาร์เรย์เดือน
        foreach ($revenues as $row) {
            // หา key ที่ตรงกับชื่อเดือนจาก billing_cycle
            $monthIndex = array_search($row['billing_cycle'], $months);
            if ($monthIndex !== false) {
                $monthlyRevenue[$monthIndex] = (float)$row['revenue'];
            }
        }

        // เตรียมข้อมูลสำหรับกราฟ
        $labels = array_values($months); // ใช้ชื่อเดือนที่สร้างไว้
        $data = array_values($monthlyRevenue); // ยอดรายได้ที่ปรับแล้ว

    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage());
    }



    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>รายงานบิล - Apartment</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="view_bills.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </head>

    <body>

        <div class="container2 mt-5">
            <h2 class="text-center text-primary">รายการบิล</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="month" class="form-label">เดือน :</label>
                    <select class="form-select" id="month" name="month" required>
                        <option value="" selected disabled>เลือกเดือน</option>
                        <?php foreach ($months as $key => $month): ?>
                            <option value="<?php echo $key; ?>" <?php echo ($selected_month == $key) ? 'selected' : ''; ?>>
                                <?php echo $month; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-danger">แสดงบิล</button>
                    <a href="rent.php" class="btn btn-secondary">กลับไปหน้าหลัก</a>
                </div>
            </form>

            <!-- แสดงรายการบิล -->
            <div class="table-responsive mt-4">
                <table class="table table-hover table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>หมายเลขห้อง</th>
                            <th>รอบบิล</th>
                            <th>ราคาห้อง (บาท)</th>
                            <th>ค่าน้ำ (บาท)</th>
                            <th>ค่าไฟ (บาท)</th>
                            <th>ราคารวม (บาท)</th>
                            <th>วันที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($bills): ?>
                            <?php foreach ($bills as $bill): ?>
                                <tr class='text-center'>
                                    <td><?php echo htmlspecialchars($bill['room_number']); ?></td>
                                    <td><?php echo htmlspecialchars($bill['billing_cycle']); ?></td>
                                    <td><?php echo number_format($bill['room_price'], 2); ?></td>
                                    <td><?php echo number_format($bill['water_price'], 2); ?></td>
                                    <td><?php echo number_format($bill['electricity_price'], 2); ?></td>
                                    <td class='fw-bold text-success'><?php echo number_format($bill['total_price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($bill['date']))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan='7' class='text-center'>ยังไม่มีข้อมูลบิล</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="container mt-5">
                <h2 class="text-center text-primary">กราฟรายได้รวมรายเดือน</h2>
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>

        </div>

        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_values($months)); ?>, // ชื่อเดือน
                    datasets: [{
                        label: 'รายได้รวม (บาท)',
                        data: <?php echo json_encode($data); ?>, // ยอดรายได้
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>





        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>