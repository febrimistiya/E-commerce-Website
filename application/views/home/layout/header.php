<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Rebelwoven</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo base_url('assets/home/lib/owlcarousel/assets/owl.carousel.min.css'); ?>" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo base_url('assets/home/css/style.css'); ?>" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="<?php echo site_url(); ?>" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold px-3 mr-1">Rebelwoven</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group rounded">
                        <input type="text" class="form-control no-border" placeholder="Cari Produk">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary no-border rounded">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="#" class="btn border rounded-3">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="#" class="btn border rounded-3">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row px-xl-5">
            <?php $this->load->view('home/layout/kategori'); ?>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold px-3 mr-1">Rebelwoven</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php if (empty($this->session->userdata('Member'))) { ?>
                        <div class="collapse navbar-collapse justify-content-between" style="background-color: #DDDDDD;"
                            id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="<?php echo site_url(); ?>" class="nav-item nav-link active">Beranda</a>
                                <a href="#" class="nav-item nav-link">Belanja</a>
                                <a href="#" class="nav-item nav-link">Riwayat Belanja</a>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Halaman</a>
                                    <div class="dropdown-menu rounded-0 m-0">
                                        <a href="#" class="dropdown-item">Keranjang</a>
                                        <a href="#" class="dropdown-item">Checkout</a>
                                    </div>
                                </div>
                                <a href="#" class="nav-item nav-link">Kontak</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0">
                                <a href="<?php echo site_url('main/login'); ?>" class="nav-item nav-link">Masuk</a>
                                <a href="<?php echo site_url('main/register'); ?>" class="nav-item nav-link">Daftar</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="collapse navbar-collapse justify-content-between" style="background-color: #DDDDDD;"
                            id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <?php $current_page = $this->uri->segment(1); ?>

                                <a href="<?php echo site_url(''); ?>"
                                    class="nav-item nav-link <?php echo ($current_page == '' ? 'active' : ''); ?>">Beranda</a>
                                <a href="<?php echo site_url('toko'); ?>"
                                    class="nav-item nav-link <?php echo ($current_page == 'toko' ? 'active' : ''); ?>">Toko</a>
                                <a href="#"
                                    class="nav-item nav-link <?php echo ($current_page == 'transaksi' ? 'active' : ''); ?>">Transaksi</a>
                                <a href="<?php echo site_url('main/order_history'); ?>"
                                    class="nav-item nav-link <?php echo ($current_page == 'order_history' ? 'active' : ''); ?>">Riwayat
                                    Pembelian</a>
                            </div>
                            <div class="navbar-nav ml-auto py-0">
                                <a href="<?php echo site_url('main/logout'); ?>" class="nav-item nav-link">Keluar</a>

                            </div>
                        </div>
                    <?php } ?>
                </nav>
                <?php
                $loc = $this->uri->segment('1');
                if ($loc == "") {
                    $this->load->view('home/slider');
                }
                ?>

            </div>
        </div>
    </div>