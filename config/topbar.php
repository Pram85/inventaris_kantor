<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow-lg" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-white">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Title with Logo - HANYA MUNCUL DI BERANDA -->
    <?php if(isset($home)): ?>
    <div class="d-flex align-items-center justify-content-center flex-grow-1">
        <div class="d-flex align-items-center py-2">
            <img src="<?=base_url();?>assets/img/dispenduk.png" alt="Logo" style="width: 70px; height: 70px; margin-right: 20px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5)); animation: pulse 2s infinite;">
            <div class="text-left">
                <h3 class="mb-1 text-white font-weight-bold" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.5); letter-spacing: 1px;">
                    <i class="fas fa-boxes mr-2"></i>Sistem Inventaris Barang
                </h3>
                <h5 class="mb-0 text-white font-weight-normal" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
                    <i class="fas fa-building mr-2"></i>DISDUKCAPIL Kabupaten Ngawi
                </h5>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center" style="background: rgba(255,255,255,0.2); padding: 5px 15px; border-radius: 25px; backdrop-filter: blur(10px);">
                    <i class="fas fa-user-circle fa-2x text-white mr-2"></i>
                    <div class="d-none d-lg-block text-left">
                        <span class="text-white font-weight-bold" style="font-size: 13px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
                            <?= strtoupper($_SESSION['fullname']); ?>
                        </span>
                        <br>
                        <span class="badge badge-light" style="font-size: 10px; text-transform: uppercase;">
                            <?= $_SESSION['level']; ?>
                        </span>
                    </div>
                    <i class="fas fa-chevron-down text-white ml-2" style="font-size: 10px;"></i>
                </div>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a> -->
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#gantiPasswordModal">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ganti Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->