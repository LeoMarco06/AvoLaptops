<!-- Header section with navbar inside -->
<header class="main-header">
    <div class="main-container">
        <div class="site-logo">
            <i class="fas fa-laptop-code"></i>
            <span>Noleggio Portatili</span>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="homepage.php#home">Home</a></li>
                <li><a href="prenota.php">Prenota</a></li>
                <li><a href="prenotazioni.php">Le mie prenotazioni</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <button class="btn btn-outline" onclick="window.location.replace('login.php#login')">Accedi</button>
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