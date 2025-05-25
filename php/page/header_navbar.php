<?php
include_once $path . "include/session_check.php";
?>

<header class="main-header">
    <div class="main-container">
        <div class="site-logo">
            <i class="fas fa-laptop-code"></i>
            <span>Avo Laptops</span>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="<?php echo $path ?>homepage.php#home">Home</a></li>
                <li><a href="<?php echo $path ?>reservation/prenota.php#home">Prenota</a></li>
                <li><a href="<?php echo $path ?>reservation/prenotazioni.php#home">Prenotazioni</a></li>
                <li><a href="<?php echo $path ?>statistics/statistics.php#home">Statistiche</a></li>
                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == 1): ?>
                    <li><a href="<?php echo $path ?>admin_services.php#home">Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="user-actions">
            <!-- Use the user's name and last name if the user is logged -->
            <?php if (isset($_SESSION["id"]) && !empty($_SESSION["id"])): ?>
                <div class="profile-actions" id="profile-actions">
                    <select class="btn btn-outline" onchange="profileActionChanged(this.value); this.selectedIndex = 0;">
                        <option value="" style="display: none;" selected>Account</option>
                        <option value="account">I tuoi dati</option>
                        <option value="logout">Logout</option>
                    </select>
                    <script>
                        function profileActionChanged(val) {
                            if (val === "account") {
                                window.location.assign('<?php echo $path ?>user/account.php#home');
                            } else if (val === "logout") {
                                window.location.assign('<?php echo $path ?>user/logout.php#home');
                            }
                        }
                    </script>
                </div>
            <?php else: ?>
                <button class="btn btn-outline"
                    onclick="window.location.replace('<?php echo $path ?>user/login.php')">Accedi</button>
            <?php endif; ?>
            <button id="theme-toggle" class="btn-icon">
                <i class="fas fa-moon"></i>
            </button>
        </div>
        <button class="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Loading object -->
    <div class="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Button to go back to the top -->
    <button id="back-to-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
</header>