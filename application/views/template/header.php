<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= toko()->name ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= base_url() ?>assets/img/favicon.png" rel="icon">
    <link href="<?= base_url() ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <!-- <link href="<?= base_url() ?>assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="<?= base_url() ?>assets/jquery.js"></script>

    <style>
        .section {
            min-height: 70vh;
        }

        .dt-length {
            margin-bottom: 10px;
            margin-top: 10px;
        }


        /* table.dataTable th {
            font-size: 12px;
        }

        table.dataTable td {
            font-size: 12px;
        } */
        div.dt-container div.dt-search input {
            padding: 12px 6px;
            margin-right: 5px;
            border-radius: 0px;
            border: 1px solid rgb(133, 133, 133);
        }

        div.dt-container div.dt-length select {
            padding: 10px 6px;
            width: 70px;
            margin-left: 5px;
            border-radius: 0px;
            border: 1px solid rgb(133, 133, 133);
        }

        table.dataTable thead>tr>th.dt-orderable-asc:hover,
        table.dataTable thead>tr>th.dt-orderable-desc:hover,
        table.dataTable thead>tr>td.dt-orderable-asc:hover,
        table.dataTable thead>tr>td.dt-orderable-desc:hover {
            outline: none;
            outline-offset: 0;
        }

        .page-link {
            margin-left: 2px !important;
            padding: 6px 12px !important;
        }

        table.table-detail td {
            font-size: 12px;
        }

        .sidebar-nav .nav-content a.active {
            color: #4154f1;
        }

        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="datetime-local"],
        input[type="time"],
        input[type="search"],
        select,
        .select2-container--bootstrap-5 .select2-selection--single,
        textarea {
            border-radius: 0px;
        }
    </style>
</head>

<body>
    <div id="loading" class="text-center" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <header id="header" class="header fixed-top d-flex align-items-center d-print-none">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="<?= base_url() ?>assets/toko/<?= toko()->file ?>" alt="<?= toko()->name ?>">
                <span class="d-none d-lg-block"><?= toko()->name ?></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>





                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?= base_url() ?>assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $this->session->userdata('name') ?></span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $this->session->userdata('name') ?></h6>
                            <!-- <span>Web Designer</span> -->
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('user/profil') ?>">
                                <i class="bi bi-person"></i>
                                <span>Profil</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="<?= base_url('user/logout') ?>">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>

    </header>

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('dashboard') ?>">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php
            if (($this->session->userdata('level') == 1) or ($this->session->userdata('level') == 2)) {
            ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="javascript:void()">
                        <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="master-nav" class="nav-content <?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?>" data-bs-parent="#master-nav">
                        <li>
                            <a href="<?= base_url('kategori') ?>">
                                <i class="bi bi-circle"></i><span>Kategori</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('brand') ?>">
                                <i class="bi bi-circle"></i><span>Brand</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('satuan') ?>">
                                <i class="bi bi-circle"></i><span>Satuan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('lokasi') ?>">
                                <i class="bi bi-circle"></i><span>Lokasi</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('supplier') ?>">
                                <i class="bi bi-circle"></i><span>Supplier</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('pelanggan') ?>">
                                <i class="bi bi-circle"></i><span>Pelanggan</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('barang') ?>" class="<?= ($this->uri->segment(1) == 'barang' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                                <i class="bi bi-circle"></i><span>Barang</span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'masuk' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#masuk-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-cart-plus"></i><span>Barang Masuk</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="masuk-nav" class="nav-content <?= ($this->uri->segment(1) == 'masuk' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?> " data-bs-parent="#masuk-nav">
                    <?php
                    if ($this->session->userdata('level') <> 1) {
                    ?>
                        <li>
                            <a href="<?= base_url('stock/masuk') ?>">
                                <i class="bi bi-circle"></i><span>Input Barang Masuk</span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li>
                        <a href="<?= base_url('stock/data_masuk') ?>" class="<?= ($this->uri->segment(1) == 'masuk' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                            <i class="bi bi-circle"></i><span>Data Barang Masuk</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'keluar' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#keluar-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-cart-dash"></i><span>Barang Keluar</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="keluar-nav" class="nav-content <?= ($this->uri->segment(1) == 'keluar' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?> " data-bs-parent="#keluar-nav">
                    <?php
                    if ($this->session->userdata('level') <> 1) {
                    ?>
                        <li>
                            <a href="<?= base_url('stock/keluar') ?>">
                                <i class="bi bi-circle"></i><span>Input Barang Keluar</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?= base_url('stock/data_keluar') ?>" class="<?= ($this->uri->segment(1) == 'keluar' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                            <i class="bi bi-circle"></i><span>Data Barang Keluar</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'BarangReturn' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#return-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-reply"></i><span>Barang Return</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="return-nav" class="nav-content <?= ($this->uri->segment(1) == 'BarangReturn' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?> " data-bs-parent="#return-nav">
                    <?php
                    if ($this->session->userdata('level') <> 1) {
                    ?>
                        <li>
                            <a href="<?= base_url('stock/return') ?>">
                                <i class="bi bi-circle"></i><span>Input Barang Return</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?= base_url('stock/data_return') ?>" class="<?= ($this->uri->segment(1) == 'BarangReturn' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                            <i class="bi bi-circle"></i><span>Data Barang Return</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#stock-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-table"></i><span>Data Stock</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="stock-nav" class="nav-content collapse " data-bs-parent="#stock-nav">
                    <li>
                        <a href="<?= base_url('stock') ?>">
                            <i class="bi bi-circle"></i><span>Stock</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('stock/histori') ?>">
                            <i class="bi bi-circle"></i><span>Histori</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'transfer' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#transfer-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-cart-x"></i><span>Transfer Stock</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="transfer-nav" class="nav-content <?= ($this->uri->segment(1) == 'transfer' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?> " data-bs-parent="#transfer-nav">
                    <?php
                    if ($this->session->userdata('level') <> 1) {
                    ?>
                        <li>
                            <a href="<?= base_url('stock/transfer') ?>">
                                <i class="bi bi-circle"></i><span>Input Transfer</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?= base_url('stock/data_transfer') ?>" class="<?= ($this->uri->segment(1) == 'transfer' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                            <i class="bi bi-circle"></i><span>Data Transfer</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'pengurangan' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#pengurangan-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-cart-x"></i><span>Pengurangan Stock</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pengurangan-nav" class="nav-content <?= ($this->uri->segment(1) == 'pengurangan' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?> " data-bs-parent="#pengurangan-nav">
                    <?php
                    if ($this->session->userdata('level') <> 1) {
                    ?>
                        <li>
                            <a href="<?= base_url('pengurangan/input_pengurangan') ?>">
                                <i class="bi bi-circle"></i><span>Input Pengurangan</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?= base_url('pengurangan') ?>" class="<?= ($this->uri->segment(1) == 'pengurangan' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                            <i class="bi bi-circle"></i><span>Data Pengurangan</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($this->uri->segment(1) == 'opname' && $this->uri->segment(2) == 'detail') ? "" : "collapsed"; ?>" data-bs-target="#opname-nav" data-bs-toggle="collapse" href="javascript:void()">
                    <i class="bi bi-card-checklist"></i><span>Opname Stock</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="opname-nav" class="nav-content <?= ($this->uri->segment(1) == 'opname' && $this->uri->segment(2) == 'detail') ? "" : "collapse"; ?> " data-bs-parent="#opname-nav">
                    <?php
                    if ($this->session->userdata('level') <> 1) {
                    ?>
                        <li>
                            <a href="<?= base_url('opname/input_opname') ?>">
                                <i class="bi bi-circle"></i><span>Input Opname</span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?= base_url('opname') ?>" class="<?= ($this->uri->segment(1) == 'opname' && $this->uri->segment(2) == 'detail') ? "active" : ""; ?>">
                            <i class="bi bi-circle"></i><span>Data Opname</span>
                        </a>
                    </li>

                </ul>
            </li>

            <?php
            if ($this->session->userdata('level') == 1) {
            ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?= base_url('pengaturan') ?>">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan Toko</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?= base_url('user') ?>">
                        <i class="bi bi-people"></i>
                        <span>Data User</span>
                    </a>
                </li>


            <?php } ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('user/profil') ?>">
                    <i class="bi bi-person"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="<?= base_url('user/logout') ?>">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Logout</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="forms-elements.html">
                            <i class="bi bi-circle"></i><span>Form Elements</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-layouts.html">
                            <i class="bi bi-circle"></i><span>Form Layouts</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-editors.html">
                            <i class="bi bi-circle"></i><span>Form Editors</span>
                        </a>
                    </li>
                    <li>
                        <a href="forms-validation.html">
                            <i class="bi bi-circle"></i><span>Form Validation</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="tables-general.html">
                            <i class="bi bi-circle"></i><span>General Tables</span>
                        </a>
                    </li>
                    <li>
                        <a href="tables-data.html">
                            <i class="bi bi-circle"></i><span>Data Tables</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="charts-chartjs.html">
                            <i class="bi bi-circle"></i><span>Chart.js</span>
                        </a>
                    </li>
                    <li>
                        <a href="charts-apexcharts.html">
                            <i class="bi bi-circle"></i><span>ApexCharts</span>
                        </a>
                    </li>
                    <li>
                        <a href="charts-echarts.html">
                            <i class="bi bi-circle"></i><span>ECharts</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="icons-bootstrap.html">
                            <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="icons-remix.html">
                            <i class="bi bi-circle"></i><span>Remix Icons</span>
                        </a>
                    </li>
                    <li>
                        <a href="icons-boxicons.html">
                            <i class="bi bi-circle"></i><span>Boxicons</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.html">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-faq.html">
                    <i class="bi bi-question-circle"></i>
                    <span>F.A.Q</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-contact.html">
                    <i class="bi bi-envelope"></i>
                    <span>Contact</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-register.html">
                    <i class="bi bi-card-list"></i>
                    <span>Register</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.html">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-error-404.html">
                    <i class="bi bi-dash-circle"></i>
                    <span>Error 404</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="pages-blank.html">
                    <i class="bi bi-file-earmark"></i>
                    <span>Blank</span>
                </a>
            </li> -->

        </ul>

    </aside>

    <main id="main" class="main">

        <script>
            var currentUrl = window.location.href;
            var links = document.querySelectorAll('#sidebar-nav a');

            links.forEach(function(link) {
                var parentNavItem = link.closest('.nav-item');
                var hasDropdown = parentNavItem.querySelector('.nav-content');

                if (link.getAttribute('href') === currentUrl) {
                    link.classList.add('active');

                    if (!hasDropdown) {
                        link.classList.remove('collapsed');
                    } else {
                        link.classList.remove('collapsed');
                        parentNavItem.querySelector('.nav-content').classList.add('show');

                        // Set parent menu to active
                        var parentMenuLink = parentNavItem.querySelector('.nav-link');
                        parentMenuLink.classList.add('active');

                        // Hapus kelas "collapsed" dari dropdown
                        parentMenuLink.classList.remove('collapsed');
                    }
                }
            });
        </script>