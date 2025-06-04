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
                    <button class="btn btn-account" id="account-menu-btn">
                        <i class="fas fa-user-circle"></i>
                        Account <i class="fas fa-caret-down"></i>
                    </button>
                    <ul class="account-menu" id="account-menu">
                        <li>
                            <a href="<?php echo $path ?>user/account.php#home">
                                <i class="fas fa-id-card"></i> I tuoi dati
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $path ?>user/logout.php#home">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (document.getElementById("account-menu-btn")) {
            const btn = document.getElementById("account-menu-btn");
            const menu = document.getElementById("account-menu");
            btn.addEventListener("click", function (e) {
                e.stopPropagation();
                menu.style.width = btn.offsetWidth + "px";
                menu.style.display = menu.style.display === "block" ? "none" : "block";
            });
            document.addEventListener("click", function () {
                menu.style.display = "none";
            });
        }
    });
</script>