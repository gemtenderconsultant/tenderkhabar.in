<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
       
    </head>
    <body>
        @include('backend.layouts.navbar')
        @yield('content')
        @include('layouts.footer')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script> lucide.createIcons(); </script>
        @yield('scripts') 
        <script>
        // Dropdown Logic
        const dropdownBtn = document.getElementById('dropdownBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownBtn.addEventListener('click', (e) => {
            // Prevent event from bubbling up to the window listener
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
            dropdownBtn.classList.toggle('active');
        });

        // Close dropdown when clicking anywhere else on the screen
        window.addEventListener('click', (e) => {
            if (dropdownMenu.classList.contains('show')) {
                // If the click is outside the dropdown and outside the button, close it
                if (!dropdownMenu.contains(e.target) && !dropdownBtn.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                    dropdownBtn.classList.remove('active');
                }
            }
        });
    </script>
    </body>
    
</html>
