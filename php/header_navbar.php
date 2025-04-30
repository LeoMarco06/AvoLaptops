<?php
session_start();
$_SESSION["u_role"] = 0; // Temporary session variable for testing

// Get the current directory name
$currentDir = basename(dirname($_SERVER['SCRIPT_FILENAME']));

// Modify path based on the current directory and user role
$path = (isset($_SESSION["u_role"]) && $_SESSION["u_role"] === 0 && $currentDir != "php") 
    ? "../" 
    : "./";
?>

<!-- Header section with navbar inside -->
<header class="main-header">
    <div class="main-container">
        <div class="site-logo">
            <i class="fas fa-laptop-code"></i>
            <span>Avo Laptops</span>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="<?php echo $path?>homepage.php#home">Home</a></li>
                <li><a href="<?php echo $path?>prenota.php#home">Prenota</a></li>
                <li><a href="<?php echo $path?>prenotazioni.php#home">Prenotazioni</a></li>
                <li><a href="<?php echo $path?>statistics/statistics.php#home">Statistiche</a></li>
                <?php if (isset($_SESSION["u_role"]) && $_SESSION["u_role"] == 0): ?>
                    <li><a href="<?php echo $path?>admin_services.php#home">Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="user-actions">
            <!-- Use the user's name and last name if the user is logged -->
            <?php if (isset($_SESSION["id"]) && !empty($_SESSION["id"])): ?>
                <button class="btn btn-outline" onclick="window.location.replace('<?php echo $path?>logout.php')">Logout</button>
            <?php else: ?>
                <button class="btn btn-outline" onclick="window.location.replace('<?php echo $path?>login.php#login')">Accedi</button>
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