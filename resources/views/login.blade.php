
<!doctype html>
<html lang="zxx">
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
    <title>{{ config('app.name', 'Laravel') }} - {{$title}}</title>

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
               Owl CSS
    *===========================-->
    <link href="{{asset('assets/css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/owl.theme.default.min.css')}}" rel="stylesheet" type="text/css">

    <!--=========================*
            Font Awesome
    *===========================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--=========================*
             Themify Icons
    *===========================-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@icon/themify-icons@1.0.1-alpha.3/themify-icons.min.css">

    <!--=========================*
               Ionicons
    *===========================-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

    <!--=========================*
              EtLine Icons
    *===========================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.css" integrity="sha512-9Tu/Gu0+bXW+oGrTGJOeNz2RG4MaF52FznXCciXFrXehFTLF6phJnJFNVOU2mmj9FWIXk9ap0H1ocygu1ZTRqg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!--=========================*
              Feather Icons
    *===========================-->
    <link href="{{asset('assets/css/feather.css')}}" rel="stylesheet"/>

    <!--=========================*
              Modernizer
    *===========================-->
    <script src="{{asset('assets/js/modernizr-2.8.3.min.js')}}"></script>

    <!--=========================*
               Metis Menu
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/css/metisMenu.css')}}">

    <!--=========================*
               Slick Menu
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/css/slicknav.min.css')}}">
    <!--=========================*
               Toastr Css
    *===========================-->
    <link rel="stylesheet" href="{{asset('assets/vendors/toastr/css/toastr.min.css')}}">

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

    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
</head>
<body>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="login-bg">
                    <div class="login-overlay"></div>
                    <div class="login-left">
                        <img src="{{asset('assets/images/logo.jpeg')}}" alt="Logo" width="100px">
                        <p>
                          Jln. Darmaraja KM. 18 Kec. Cisitu, Sumedang, Jawa Barat.
                        </p>
                        <a href="javascript:void(0);" class="btn btn-primary">Learn More</a>
                    </div><!--login-left-->
                </div><!--login-bg-->

                <div class="login-form">
                    <form>
                        <div class="login-form-body">
                            <h4 class="text-center">Selamat datang di KPRI KANCAWINAYA GURU CISITU (KPRI-KGC)</h4>
                            <div class="login-logo text-center mb-3">
                                <img src="{{asset('assets/images/logo.jpeg')}}" alt="Logo" width="100px">
                            </div><!--login-logo-->
                            <div class="form-gp">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" id="exampleInputEmail1">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="form-gp">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" id="exampleInputPassword1">
                                <i class="fa fa-lock"></i>
                            </div>
                            <div class="row mb-4 rmber-area">

                                <div class="col-12 text-right">
                                    <a href="{{route('lupaPassword')}}" class="text-primary">Lupa Password?</a>
                                </div>
                            </div>
                            <div class="submit-btn-area">
                                <button id="form_submit" type="submit" class="btn btn-primary">Masuk <i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div><!--login-form-->

            </div><!--row-->
        </div><!--container-fluid-->
    </div><!--wrapper-->


<!--=========================*
            Scripts
*===========================-->

<!-- Jquery Js -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- bootstrap 4 js -->
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Owl Carousel Js -->
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<!-- Metis Menu Js -->
<script src="{{asset('assets/js/metisMenu.min.js')}}"></script>
<!-- SlimScroll Js -->
<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>
<!-- Slick Nav -->
<script src="{{asset('assets/js/jquery.slicknav.min.js')}}"></script>
<!-- Fancy Box Js -->
<script src="{{asset('assets/js/jquery.fancybox.pack.js')}}"></script>
<!-- Toastr Js -->
<script src="{{asset('assets/vendors/toastr/js/toastr.min.js')}}"></script>
<!-- ========== This Page js ========== -->

<!-- Main Js -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script>
      $('#form_submit').on('click', function(e) {
        e.preventDefault();
        var email = $('#exampleInputEmail1').val();
        var password = $('#exampleInputPassword1').val();

        $.ajax({
            url: "{{route('isLogin')}}",
            type: "POST",
            data: {
                email: email,
                password: password,
                _token: "{{ csrf_token() }}",
            },
            beforeSend: function() {
                $('#form_submit').html('<i class="fa fa-spinner fa-spin"></i> Tunggu Sebentar');
            },
            success: function(data) {
                if(data.status === "success") {
                    toastr.success(data.message, 'Sukses!')
                    setTimeout(function() {
                        window.location.href = data.redirect;
                    }, 1000);
                } else {
                    toastr.error(data.message, 'Kesalahan!')
                }
            },
            error: function(data) {
                // jika statusnya 422
                if(data.status === 422) {

                    let errors = '';
                    $.each(data.responseJSON.errors, function (i, error) {
                        errors += '<li>'+error[0]+'</li>';
                    });
                    toastr.error(errors, 'Kesalahan Input!')
                } else {
                    toastr.error('Terjadi Kesalahan', 'Error!')
                }
            },
            complete: function() {
                $('#form_submit').html('Masuk <i class="fa fa-arrow-right"></i>');
            }
        });
      });
</script>
</body>
</html>
