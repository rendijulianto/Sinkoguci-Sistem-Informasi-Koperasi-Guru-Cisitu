<?php
$menu = [];
if (Auth::guard('petugas')->user()->level == "petugas") {
    //
    $menu = [
        [
            'text' => 'Main',
            'type' => 'label',
        ],
        [
            'text' => 'Halaman Utama',
            'type'=> 'link',
            'url' => route('petugas.dashboard'),
            'icon' => 'fa fa-dashboard'
        ],
        [
            'text' => 'App',
            'type' => 'label',
        ],
        [
            'text' => 'Kelola Simpanan',
            'type'=> 'link',
            'url' => route('petugas.simpanan.index'),
            'icon' => 'fa fa-dollar-sign'
        ],
        [
            'text' => 'Kelola Pinjaman',
            'type'=> 'link',
            'url' => route('petugas.pinjaman.index'),
            'icon' => 'fa fa-credit-card'
        ],
        [
            'text' => 'Bayar Cicilan',
            'type'=> 'link',
            'url' => route('petugas.cicilan.index'),
            'icon' => 'fa fa-file-invoice-dollar'
        ],
        [
            'text' => 'Kelola Penarikan',
            'type'=> 'parent',
            'icon' => 'fa fa-money-bill',
            'child' => [
                [
                    'text' => 'Penarikan Simpanan',
                    'type'=> 'link',
                    'url' => route('petugas.penarikan.simpanan'),
                    'icon' => 'fa fa-dollar-sign'
                ],
                [
                    'text' => 'Penarikan Dana Sosial',
                    'type'=> 'link',
                    'url' => route('petugas.penarikan.dana-sosial'),
                    'icon' => 'fa fa-dollar-sign'
                ]
            ]
        ],
        [
            'text' => 'Kelola Anggota',
            'type'=> 'link',
            'url' => route('petugas.anggota.index'),
            'icon' => 'fa fa-users'
        ],
        [
            'text' => 'Laporan',
            'type' => 'label',
        ],
        [
            'text' => 'Laporan Tagihan',
            'type'=> 'link',
            'url' => route('petugas.laporan.tagihan'),
            'icon' => 'fa fa-receipt'
        ],
        [
            'text' => 'Laporan Pembayaran',
            'type'=> 'link',
            'url' => route('petugas.laporan.pembayaran'),
            'icon' => 'fa fa-receipt'
        ],
    ];
} else {
    $menu =  [
        [
            'text' => 'Main',
            'type' => 'label',
        ],
        [
            'text' => 'Halaman Utama',
            'type'=> 'link',
            'url' => route('admin.dashboard'),
            'icon' => 'fa fa-dashboard'
        ],
        [
            'text' => 'App',
            'type' => 'label',
        ],
        [
            'text' => 'Kelola Petugas',
            'type'=> 'link',
            'url' => route('admin.petugas.index'),
            'icon' => 'fa fa-user'
        ],
        [
            'text' => 'Kelola Sekolah',
            'type'=> 'link',
            'url' => route('admin.sekolah.index'),
            'icon' => 'fa fa-school'
        ],
        [
            'text' => 'Kelola Kategori Simpanan',
            'type'=> 'link',
            'url' => route('admin.kategori-simpanan.index'),
            'icon' => 'fa fa-dollar-sign'
        ],
        [
            'text' => 'Laporan',
            'type' => 'label',
        ],
        [
            'text' => 'Laporan Peminjaman',
            'type'=> 'link',
            'url' => route('admin.laporan.pinjaman'),
            'icon' => 'fa fa-credit-card'
        ],
        [
            'text' => 'Laporan Simpanan',
            'type'=> 'parent',
            'icon' => 'fa fa-receipt text-success',
            'child' => [
                [
                    'text' => 'Simpanan Bulanan',
                    'type'=> 'link',
                    'url' => route('admin.laporan.simpanan-bulanan'),
                    'icon' => 'fa fa-receipt'
                ],
                [
                    'text' => 'Simpanan Tahunan',
                    'type'=> 'link',
                    'url' => route('admin.laporan.simpanan-tahunan'),
                    'icon' => 'fa fa-receipt'
                ]
            ]
        ],
        [
            'text' => 'Laporan Pembayaran',
            'type'=> 'parent',
            'icon' => 'fa fa-receipt text-success',
            'child' => [
                [
                    'text' => 'Pembayaran Bulanan',
                    'type'=> 'link',
                    'url' => route('admin.laporan.pembayaran-bulanan'),
                    'icon' => 'fa fa-receipt'
                ],
                [
                    'text' => 'Pembayaran Tahunan',
                    'type'=> 'link',
                    'url' => route('admin.laporan.pembayaran-tahunan'),
                    'icon' => 'fa fa-receipt'
                ]
            ]
        ],
    ];
}

?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
               Sweet Alert Css
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/vendors/sweetalert2/css/sweetalert2.min.css')}}">

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
    <!-- Jquery Js -->
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>

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
                                <img src="https://ui-avatars.com/api/?name={{Auth::guard('petugas')->user()->nama}}" alt="User Image">
                            </button>
                            <div class="dropdown-menu dropdown_user" aria-labelledby="dropdownMenuButton" >
                                <div class="dropdown-header d-flex flex-column align-items-center">

                                    <div class="user_bio text-center">
                                        <p class="name font-weight-bold mb-0">{{Auth::guard('petugas')->user()->nama}}</p>
                                        <p class="email text-muted mb-3"><a class="pl-3 pr-3" href="monica@jhon.co.uk">{{Auth::guard('petugas')->user()->email}}</a></p>
                                    </div>
                                </div>

                                <span role="separator" class="divider"></span>
                                <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>Keluar</a>
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

                    @foreach ($menu as $item)
                        @if($item['type'] =="label")
                            <li class="menu-title">{{$item['text']}}</li>
                        @elseif($item['type'] =="link")
                            <li>
                                <a href="{{$item['url']}}">
                                    <i class="{{$item['icon']}}"></i>
                                    <span>{{$item['text']}}</span>
                                </a>
                            </li>
                        @elseif($item['type'] =="parent")
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true">
                                    <i class="{{$item['icon']}}"></i>
                                    <span>{{$item['text']}}</span>
                                    <span class="float-right arrow"><i class="ion ion-chevron-down"></i></span>
                                </a>
                                <ul class="submenu">
                                    @foreach ($item['child'] as $child)
                                        <li><a href="{{$child['url']}}"><i class="{{$child['icon']}}"></i><span>{{$child['text']}}</span></a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
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
<!-- Sweet Alert Js -->
<script src="{{asset('assets/vendors/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<!-- ========== This Page js ========== -->


@yield('js')
@if($errors->any())
    <script>
        toastr.error("{{$errors->first()}}", "Gagal!");
    </script>
@endif
@if(Session::has('error'))
    <script>
        toastr.error("{{Session::get('error')}}", "Gagal!");
    </script>
@endif
@if(Session::has('success'))
    <script>
        toastr.success("{{Session::get('success')}}", "Berhasil!");
    </script>
@endif
<!-- ========== This Page js ========== -->
<script>
    $("form.tambah").submit(function(event) {
        event.preventDefault();
        swal({
            title: "Apakah anda yakin?",
            text: "Anda akan menambahkan data baru!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonClass: "btn btn-success mr-5",
            cancelButtonClass: "btn btn-danger",
            buttonsStyling: !1
        }).then((result) => {
            if (result.value) {
                $(this).unbind('submit').submit();
            } else {
                swal("Dibatalkan", "Data batal ditambahkan", "error");
            }
        });
    });
    $("form.ubah").submit(function(event) {
        event.preventDefault();
        swal({
            title: "Apakah anda yakin?",
            text: "Anda akan mengubah data baru!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonClass: "btn btn-success mr-5",
            cancelButtonClass: "btn btn-danger",
            buttonsStyling: !1
        }).then((result) => {
            if (result.value) {
                $(this).unbind('submit').submit();
            } else {
                swal("Dibatalkan", "Data batal diubah", "error");
            }
        });
    });
    $("form.hapus").submit(function(event) {
        event.preventDefault();
        swal({
            title: "Apakah anda yakin?",
            text: "Anda tidak akan dapat mengembalikan data yang telah dihapus! ",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonClass: "btn btn-success mr-5",
            cancelButtonClass: "btn btn-danger",
            buttonsStyling: !1
        }).then((result) => {
            if (result.value) {
                $(this).unbind('submit').submit();
            } else {
                swal("Dibatalkan", "Data batal dihapus", "error");
            }
        });
    });
    </script>
<!-- Main Js -->
<script src="{{asset('assets/js/main.js')}}"></script>


</body>
</html>
