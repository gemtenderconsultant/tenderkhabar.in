<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->
    {{-- <link href="{{ asset('assets/css/style1.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
        <div class="index-texture-overlay"></div>
        <div class="index-bg-shapes">
            <div class="index-shape index-shape-1"></div>
            <div class="index-shape index-shape-2"></div>
            <div class="index-shape index-shape-3"></div>
        </div>

        <div class="index-top-bar">
            <div class="index-container">
                <div class="index-top-info">
                    <span><i data-lucide="mail" size="14"></i> <a href="mailto:sales@gemtenderconsultant.com">sales@gemtenderconsultant.com</a></span>
                    <span><i data-lucide="phone" size="14"></i> <a href="tel:+919274686490">+91 9274686490</a></span>
                </div>
                <div>India's #1 Tender & GeM Intelligence Platform</div>
            </div>
        </div>
            <!-- Page Heading -->
                    @include('layouts.navbar')
                <!-- MOBILE MENU -->
                    <div class="index-mobile-overlay" id="index-mobileOverlay"></div>
                    <div class="index-mobile-menu" id="index-mobileMenu">
                        <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 20px;">
                            <span style="font-weight:800; color:var(--primary-blue)">MENU</span>
                            <i data-lucide="x" id="index-closeMenu" style="cursor:pointer"></i>
                        </div>
                        <a href="{{ url('/') }}">Home</a>
                        <a href="{{ route('gem') }}">GeM Services</a>
                        <a href="{{ route('otherportal') }}">Other Portals</a>
                        <a href="{{ route('pricing-plans') }}">Pricing Plan</a>
                        <a href="{{ route('certification') }}">Certificates</a>
                         @if(!Auth::check())
                        <div style="margin-top: auto; display:flex; flex-direction:column; gap:10px;">
                            <a href="{{ url('/login') }}" class="index-btn index-btn-login">
                                <i data-lucide="log-in" size="16"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="index-btn index-btn-reg">Register Now <i data-lucide="arrow-right" size="16"></i></a>
                        </div>    
                        @else
                        <div style="margin-top: auto; display:flex; flex-direction:column; gap:10px;">
                                <a href="{{ route('dashboards') }}" class="index-btn index-btn-login">Dashboard</a>
                                <a href="{{ route('logout') }}" class="index-btn index-btn-reg">Logout</a>
                            </div>
                        @endif
                    </div>

            @yield('content')
            
        @includeWhen(View::exists('layouts.footer'), 'layouts.footer')
        <!-- </div> -->
        @yield('scripts') 
        <script type="text/javascript">
             // Mobile Menu
            const menuBtn = document.getElementById('index-menuBtn');
            const closeMenu = document.getElementById('index-closeMenu');
            const mobileMenu = document.getElementById('index-mobileMenu');
            const overlay = document.getElementById('index-mobileOverlay');

            menuBtn.onclick = () => { mobileMenu.classList.add('active'); overlay.classList.add('active'); };
            closeMenu.onclick = overlay.onclick = () => { mobileMenu.classList.remove('active'); overlay.classList.remove('active'); };
        </script>
    </body>
</html>
