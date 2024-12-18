<?php
session_start();
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปลี่ยนรหัสผ่าน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        h2 {
            color: #333333;
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.9rem;
            color: #666666;
            margin: 10px 0 5px;
            text-align: left;
        }

        input[type="password"] {
            width: 90%;
            padding: 0.8rem;
            margin: 8px 0 16px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: green;
            border: none;
            color: white;
            font-size: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #006633;
        }

        .btn-back {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: red;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #e53e3e;
        }

        .notification {
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 4px;
            font-weight: bold;
        }

        .success {
            color: #38a169;
            background-color: #e6fffa;
            border: 1px solid #38a169;
        }

        .error {
            color: #e53e3e;
            background-color: #ffe5e5;
            border: 1px solid #e53e3e;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>เปลี่ยนรหัสผ่าน</h2>
        <form action="change_password.php" method="POST">
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user_id = $_SESSION['user_id'];
                $currentPassword = $_POST['current_password'];
                $newPassword = $_POST['new_password'];

                try {
                    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
                    $stmt->execute([$user_id]);
                    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($userData && password_verify($currentPassword, $userData['password'])) {
                        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $updateStmt->execute([$newPasswordHash, $user_id]);

                        echo "<p class='notification success'>เปลี่ยนรหัสผ่านสำเร็จ!</p>";
                    } else {
                        echo "<p class='notification error'>รหัสผ่านปัจจุบันไม่ถูกต้อง</p>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . htmlspecialchars($e->getMessage());
                }
            } ?>
            <label for="current_password">รหัสผ่านปัจจุบัน:</label>
            <input type="password" name="current_password" required>
            <label for="new_password">รหัสผ่านใหม่:</label>
            <input type="password" name="new_password" required>
            <button type="submit">อัปเดตรหัสผ่าน</button>
            <a href="admin.php" class="btn-back">X</a>
        </form>
    </div>
</body>

</html>
