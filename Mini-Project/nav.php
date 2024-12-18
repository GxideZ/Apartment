<header data-bs-theme="dark" style="padding: 0; height: 80px;">
    <div class="navbar navbar-dark bg-dark shadow-sm" style="height: 80px;">
        <div class="container d-flex justify-content-between align-items-center" style="width: 100%;">
            
            <a href="" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                    <path d="M3 9.5L12 2l9 7.5V20a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9.5z"></path>
                </svg>
                <strong style="color: white; font-size: 1.5rem;" >Apartment</strong>
            </a>
            <div class="col-md-3 text-end">
                <?php if (!isset($_SESSION['user_id'])) { ?>
                    <button type="button" class="btn btn-danger" onclick="showLogoutWarning()">ออกจากระบบ</button>
                <?php } ?>

            </div>
        </div>
    </div>
    
    <script>
        function showLogoutWarning() {
            if (confirm("คุณต้องการออกจากระบบหรือไม่?")) {
                window.location.href = 'logout.php';
            }
        }
    </script>

</header>