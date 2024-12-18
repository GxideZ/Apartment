<?php 
session_start();
require 'config.php';
$minLength = 6; 

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($username)) {
        $_SESSION['error'] = "Please enter your username";
        header("Location: signup.php");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address";
        header("Location: signup.php");
        exit();
    } else if (strlen($password) < $minLength) {
        $_SESSION['error'] = "Password must be at least $minLength characters long";
        header("Location: signup.php");
        exit();
    } else if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Your password does not match";
        header("Location: signup.php");
        exit();
    } else {
        
        $checkUsername = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $checkUsername->execute([$username]);
        $userExists = $checkUsername->fetchColumn();

        $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        $emailExists = $checkEmail->fetchColumn();

        if ($userExists) {
            $_SESSION['error'] = "Username already exists";
            header("Location: signup.php");
            exit();
        } else if ($emailExists) {
            $_SESSION['error'] = "Email already exists";
            header("Location: signup.php");
            exit();
        } else {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $hashPassword]);

                $_SESSION['success'] = "Registration successfully! You can now log in.";
                header("Location: signup.php"); 
                exit();
            } catch (PDOException $e) {
                $_SESSION['error'] = "Something went wrong, please try again!";
                echo "Registration failed: " . $e->getMessage(); 
                header("Location: signup.php");
                exit();
            }
        }
    }
}
?>
