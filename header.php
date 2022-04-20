<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo"/></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a> -->
                    <a class="navbar-brand">SPK AHP-VIKOR</a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                    <span class="nav-profile-name"><?= get_user_login($_COOKIE['user_dashboard'])["nama"] ?></span>
                    <span class="online-status"></span>
                    <img src="images/dashboard/cat.jpg" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a href="?page=logout" class="dropdown-item">
                        <i class="mdi mdi-logout text-primary"></i>
                        Logout
                    </a>
                </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="mdi mdi-menu"></span>
            </button>
        </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-account menu-icon"></i>
                    <span class="menu-title">Dosen</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul>
                        <li class="nav-item"><a class="nav-link" href="pages/ui-features/buttons.html">Input Dosen</a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/ui-features/typography.html">Daftar Dosen</a></li>
                    </ul>
                </div>
            </li>
                    <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-view-list menu-icon"></i>
                    <span class="menu-title">Kriteria</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul>
                        <li class="nav-item"><a class="nav-link" href="pages/ui-features/buttons.html">Input Kriteria</a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/ui-features/typography.html">Daftar Kriteria</a></li>
                    </ul>
                </div>
            </li>
                    <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="mdi mdi-cube-outline menu-icon"></i>
                    <span class="menu-title">Alternatif</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="submenu">
                    <ul>
                        <li class="nav-item"><a class="nav-link" href="pages/ui-features/buttons.html">Daftar Alternatif</a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/ui-features/typography.html">Daftar Kriteria</a></li>
                    </ul>
                </div>
            </li>
            </ul>
        </div>
    </nav>
</div>