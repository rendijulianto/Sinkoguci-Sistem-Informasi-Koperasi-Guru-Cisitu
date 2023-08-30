
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

    <!--=========================*
                Met Data
    *===========================-->
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Falr - Bootstrap 4 Admin Dashboard Template">

    <!--=========================*
              Page Title
    *===========================-->
    <title>{{ config('app.name', 'Laravel') }} | {{ $title }}</title>

    <!--=========================*
                Favicon
    *===========================-->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}">

    <!--=========================*
            Bootstrap Css
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <!--=========================*
              Custom CSS
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!--=========================*
            Font Awesome
    *===========================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--=========================*
               Ionicons
    *===========================-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!--=========================*
               Toastr Css
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/vendors/toastr/css/toastr.min.css')}}">


    <!--=========================*
               Metis Menu
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/css/metisMenu.css')}}">

    <!--=========================*
               Slick Menu
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/css/slicknav.min.css')}}">
    
    <!--=========================*
              Flag Icons
    *===========================-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.1/feather.min.js" integrity="sha512-4lykFR6C2W55I60sYddEGjieC2fU79R7GUtaqr3DzmNbo0vSaO1MfUjMoTFYYuedjfEix6uV9jVTtRCSBU/Xiw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--=========================*
            Google Fonts
    *===========================-->

    <!-- Font USE: 'Roboto', sans-serif;-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
   @yield('css')

</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!--=========================*
         Page Container
*===========================-->
<div id="page-container">

    <!--==================================*
               Header Section
    *====================================-->
    <div class="header-area">

        <!--======================*
                   Logo
        *=========================-->
        <div class="header-area-left">
            <a href="index.html" class="logo">
                <span>
                    <img src="{{asset('assets/images/logo.png')}}"  alt="" height="18">

                </span>
                <i>
                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="22">
                </i>
            </a>
        </div>
        <!--======================*
                  End Logo
        *=========================-->

        <div class="row align-items-center header_right">
            <!--==================================*
                     Navigation and Search
            *====================================-->
            <div class="col-md-6 d_none_sm d-flex align-items-center">
                <div class="nav-btn button-menu-mobile pull-left">
                    <button class="open-left waves-effect">
                        <i class="ion-android-menu"></i>
                    </button>
                </div>
                <div class="search-box pull-left">
                    <form action="#">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" placeholder="Search..." required="">
                    </form>
                </div>
            </div>
            <!--==================================*
                     End Navigation and Search
            *====================================-->
            <!--==================================*
                     Notification Section
            *====================================-->
            <div class="col-md-6 col-sm-12">
                <ul class="notification-area pull-right" style="float: right;">
                    <li class="mobile_menu_btn">
                        <span class="nav-btn pull-left d_none_lg">
                            <button class="open-left waves-effect">
                                <i class="ion-android-menu"></i>
                            </button>
                        </span>
                    </li>
                    
                    <li class="user-dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('assets/images/user.jpg')}}" alt="" class="img-fluid">
                            </button>
                            <div class="dropdown-menu dropdown_user" aria-labelledby="dropdownMenuButton" >
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="user_img mb-3">
                                        <img src="{{asset('assets/images/user.jpg')}}" alt="User Image">
                                    </div>
                                    <div class="user_bio text-center">
                                        <p class="name font-weight-bold mb-0">Monica Jhonson</p>
                                        <p class="email text-muted mb-3"><a class="pl-3 pr-3" href="monica@jhon.co.uk">monica@jhon.co.uk</a></p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="profile.html"><i class="fas fa-user"></i>My Profile</a>
                                <span role="separator" class="divider"></span>
                                <a class="dropdown-item" href="login.html"><i class="fas fa-sign-out-alt"></i>Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!--==================================*
                     End Notification Section
            *====================================-->
        </div>

    </div>
    <!--==================================*
               End Header Section
    *====================================-->

    <!--=========================*
             Side Bar Menu
    *===========================-->
    <div class="sidebar_menu pt-4">
        <div class="menu-inner">
            <div id="sidebar-menu">
                <!--=========================*
                           Main Menu
                *===========================-->
                <ul class="metismenu" id="sidebar_menu">
                    <li class="menu-title">Main</li>
                    <li class="active">
                        <a href="index.html" class="active">
                            <i class="fa fa-dashboard"></i>
                            <span>Halaman Utama</span>
                        </a>
                    </li>
                    <li class="menu-title">Apps</li>
                    <!--=========================*
                              Kelola Simpanan
                    *===========================-->
                    <li>
                        <a href="full-calendar.html">
                            <i class="fa fa-dollar-sign"></i>
                            <span>Kelola Simpanan</span>
                        </a>
                    </li>
                    <!--=========================*
                              Kelola Pinjaman
                    *===========================-->
                    <li>
                        <a href="gallery.html">
                            <i class="fa fa-credit-card"></i>
                            <span>Kelola Pinjaman</span>
                        </a>
                    </li>
                     <!--=========================*
                              Bayar Cicilan
                    *===========================-->
                    <li>
                     <a href="gallery.html">
                         <i class="fa fa-file-invoice-dollar"></i>
                         <span>Bayar Cicilan</span>
                     </a>
                    </li>
                    <!--=========================*
                              Kelola Penarikan
                    *===========================-->
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true">
                            <i class="fa fa-money-bill"></i>
                            <span>Kelola Penarikan</span>
                            <span class="float-right arrow"><i class="ion ion-chevron-down"></i></span>
                        </a>
                        <ul class="submenu">
                            <li><a href="inbox.html"><i class="ion-ios-folder-outline"></i><span>Penarikan Simpanan</span></a></li>
                            <li><a href="compose.html"><i class="ti-pencil-alt"></i><span>Penarikan Dana Sosial </span></a></li>
                        </ul>
                    </li>
                     <!--=========================*
                           Kelola Anggota
                    *===========================-->
                    <li>
                     <a href="{{route('petugas.anggota.index')}}">
                  
                         <i class="fa fa-users"></i>
                         <span>Kelola Anggota</span>
                     </a>
                 </li>
                    <li class="menu-title">Laporan</li>
                    <!--=========================*
                        Laporan Tagihan
                    *===========================-->
                    <li>
                     <a href="gallery.html">
                         <i class="fa fa-receipt"></i>
                         <span>Laporan Tagihan</span>
                     </a>
                    </li>
                </ul>
                <!--=========================*
                          End Main Menu
                *===========================-->
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!--=========================*
           End Side Bar Menu
    *===========================-->

    <!--==================================*
               Main Content Section
    *====================================-->
    <div class="main-content page-content">

        <!--==================================*
                   Main Section
        *====================================-->
        {{-- <div class="main-content-inner d-flex  atas bawah"> --}}
         <div class="main-content-inner">
            @yield('content')
        </div>
        <!--==================================*
                   End Main Section
        *====================================-->
    </div>
    <!--=================================*
           End Main Content Section
    *===================================-->

    <!--=================================*
                  Footer Section
    *===================================-->
    <footer>
        <div class="footer-area">
            <p>&copy; Copyright {{
                date('Y') }} KPRI KGC. Design by <a href="https://www.kebutuhansosmed.com/" target="_blank">HAR</a>  with <i class="fa fa-heart text-danger" aria-hidden="true"></i>.</p>
        </div>
    </footer>
    <!--=================================*
                End Footer Section
    *===================================-->

</div>
<!--=========================*
        End Page Container
*===========================-->


<!--=========================*
            Scripts
*===========================-->

<!-- Jquery Js -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- bootstrap 4 js -->
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Js -->
<script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
<!-- SlimScroll Js -->
<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>
<!-- Slick Nav -->
<script src="{{asset('assets/js/jquery.slicknav.min.js')}}"></script>
<!-- Toastr Js -->
<script src="{{asset('assets/vendors/toastr/js/toastr.min.js')}}"></script>
<!-- ========== This Page js ========== -->


@yield('js')
@if($errors->any())
    <script>
        toastr.error("{{$errors->first()}}", "Error");
    </script>
@endif
@if(Session::has('error'))
    <script>
        toastr.error("{{Session::get('error')}}", "Error");
    </script>
@endif
@if(Session::has('success'))
    <script>
        toastr.success("{{Session::get('success')}}", "Success");
    </script>
@endif
<!-- ========== This Page js ========== -->

<!-- Main Js -->
<script src="{{asset('assets/js/main.js')}}"></script>


</body>
</html>
