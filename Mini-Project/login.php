<?php include_once('header.php'); ?>
<?php session_start(); ?>
<!-- <link rel="stylesheet" href="style2.css"> -->

<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 120%;
        background: url('bg.jpg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
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

    .btn-success {
        background-color: #28a745;
        /* สีเขียว */
        border: none;
        /* เอาเส้นขอบออก */
    }

    .btn-success:hover {
        background-color: #218838;
        /* เปลี่ยนสีเมื่อ hover */
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

    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #1a1a1d;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 4px solid #1a1a1d;
        border-top: 4px solid #f4d03f;
        border-radius: 50%;
        animation: spin 1s linear infinite, glow 1.5s ease-in-out infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes glow {

        0%,
        100% {
            box-shadow: 0 0 10px #f4d03f, 0 0 20px #f4d03f, 0 0 30px #f4d03f;
        }

        50% {
            box-shadow: 0 0 20px #f4d03f, 0 0 30px #f4d03f, 0 0 50px #f4d03f;
        }
    }
</style>

<div id="loading-screen">
    <div class="loader"></div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-white">
                    <h2 class="text-center mt-2">SIGN IN</h2>
                </div>
                <div class="card-body">

                    <!-- Error Message -->
                    <?php if (isset($_SESSION['error'])) { ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php } ?>

                    <!-- Login Form -->
                    <form action="login_db.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="login" class="btn btn-success">Sign in</button>
                        </div>
                    </form>

                    <p class="mt-3 text-center">
                        <!-- Not yet a member? <a href="register.php">Sign up</a>  -->
                        Do your want to go <a href="home.php">Home</a> ?
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('load', function() {
        // Hide the loading screen when the page has fully loaded
        var loadingScreen = document.getElementById('loading-screen');
        loadingScreen.style.display = 'none';
    });
</script>

<?php include_once('footer.php'); ?>