<?php include_once('header.php'); ?>
<?php session_start(); ?>

<link rel="stylesheet" href="style2.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="text-center">SIGN UP</h2>
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
                    <form action="register_db.php" method="POST">
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
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="register" class="btn btn-success">Sign up</button>
                        </div>
                    </form>

                    <p class="mt-3 text-center">Already a member? <a href="login.php">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>