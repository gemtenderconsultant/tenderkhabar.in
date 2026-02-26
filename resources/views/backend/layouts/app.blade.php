<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', config('app.company_name')) }}</title>
  <meta property="og:title" content="@yield('title',config('app.company_name').' - Tender Bidding Service Provider')" />  
  <meta property="og:description" content="@yield('meta_description',config('app.company_name').' - Tender Bidding Service Provider')"/> 
  <meta property="og:url" content="{{ URL::current() }}" />   
  <meta property="og:image" content="{{ asset('logo.png') }}">
  <meta property="og:image:secure_url" content="{{ asset('logo.png') }}" />
  <meta property="og:lang" content="en US" />
  <meta property="og:type" content="website" />
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:creator" content="{{ '@'.config('app.company_name') }}" />
  <meta name="twitter:site" content="{{ '@'.config('app.company_name') }}" />
  <meta name="twitter:app:name:googleplay" content="{{ config('app.company_name') }}" />
  <meta name="twitter:image" content="{{ asset('logo.png') }}" />  
  <meta name="twitter:title" content="@yield('title',config('app.company_name').' - Tender Bidding Service Provider')" />  
  <meta name="twitter:description" content="@yield('meta_description',config('app.company_name').' - Tender Bidding Service Provider')" /> 
  <meta name="keywords" content="@yield('meta_keywords',config('app.company_name').' - Tender Bidding Service Provider')" />   
  <meta name="category" content="@yield('meta_category',config('app.company_name').' - Tender Bidding Service Provider')" />
  <meta name="description" content="@yield('meta_description',config('app.company_name').' - Tender Bidding Service Provider')" />
  <meta name="robots" content="index, follow">  
  <meta property="og:site_name" content="{{ config('app.company_name') }}"/>
  <meta name="author" content="{{ config('app.company_name').' - '.config('app.website_name') }}">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  
  @yield('stylesheet')
</head>
<body>
  <!-- ======= Header ======= -->

        @include('backend.layouts.navbar')
     
  <!-- End Header -->
  <!-- ======= Hero Section ======= -->
  @yield('content')
  <!-- End Hero -->
  <!-- ======= Footer ======= -->
  @include('layouts.footer')
  <script type="text/javascript" src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script type="text/javascript">
  $('body').on('click','.mobile-nav-toggle',function(){
    if($(this).hasClass('mobile-nav-hide')){
      $('.header').attr('style', 'z-index: 10 !important');
      $('body').removeClass('mobile-nav-active');    
      $('.mobile-nav-show').removeClass('d-none');
      $('.mobile-nav-hide').addClass('d-none');
    }else{
      $('.header').attr('style', 'z-index: 17 !important');
      $('body').addClass('mobile-nav-active');
      $('.main_div').css('z-index',);
      $('.mobile-nav-show').addClass('d-none');
      $('.mobile-nav-hide').removeClass('d-none');  
    }
  });
  </script>
  <!-- End Footer -->
  @yield('scripts')
</body>
</html>