{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('includes.schema')

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WVNV8KCZ');</script>
<!-- End Google Tag Manager -->

<meta name="google-site-verification" content="6hZa9OlkJhAhAYORdw9kq1n4EcfiQZXQDzP_PURf_Yc" />

    <meta charset="utf-8">
    <title>@yield('title', 'Default Website Title')</title>
    <meta name="description" content="@yield('meta_description', 'Default website description here.')">

    <!-- CRITICAL: Stronger declaration to lock the light theme -->
    <meta name="color-scheme" content="light only">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'TenderKhabar') }}</title> --}}
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('title', 'Default Website Title')" />
    <meta property="og:description" content="@yield('meta_description', 'Default website description here.')" />
    <meta property="og:url" content="@yield('meta_url', url()->current())" />
    <meta property="og:site_name" content="@yield('meta_site_name', 'Your Website Name')" />
    <meta property="og:image" content="@yield('meta_image', asset('assets/img/Logo Image 1 - Copy.jpg'))" />
    <meta property="article:publisher" content="https://www.facebook.com/gemtenderconsultant.in" />
    
    {{-- Links and other head content --}}
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

     <!-- IMPORTANT: Switched to Laravel Mix for cache busting -->
    {{-- <link href="{{ mix('css/main.css') }}" rel="stylesheet">  --}}

    @yield('stylesheet')
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    
    <style>
        /* CSS Reset */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100%;

             color-scheme: light !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fc;
            padding-top: 98px; 
        }

        /* Header Container */
        .header.fixed-top {
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            position: fixed; 
        }
        
        /* Topbar Styles */
        .topbar {
            background-color: #1e3a8a;
            color: #f8f9fc;
            padding: 8px 0;
            overflow: hidden;
            font-weight: bold;
            font-size: 14px;
            white-space: nowrap;
            width: 100%;
        }

        .marquee {
            width: 100%;
            overflow: hidden;
        }

        .marquee-content {
            display: inline-block;
            white-space: nowrap;
            animation: scroll-left 40s linear infinite;
        }
        
        .marquee-content span {
            padding-right: 50px;
        }

        @keyframes scroll-left {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }

        main#main {
            flex: 1 0 auto; 
        }

         html, body {
            /* Sets the default arrow cursor for the whole page */
            cursor: default !important;
        }

        /* Sets the hand pointer for links, buttons, and other clickable items */
        a, button, input[type="submit"], label, select {
            cursor: pointer !important;
        }


         /* ======================================================= */
        /* === POPUP CSS == */
        /* ======================================================= */
        /* .popup-overlay {
            position: fixed;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            z-index: 9999;
        }

        .popup-overlay.hidden {
            display: none;
        }

        .popup-card {
            position: relative;
            background: #ffffff; 
            border-radius: 16px;
            padding: 3rem 2rem 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 400px;
            color: #333;
            animation: fadeSlide 0.4s ease;
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        .close-btn svg {
            width: 16px;
            height: 16px;
            stroke: #555;
            transition: stroke 0.2s;
        }
        .close-btn:hover svg {
            stroke: #000;
        }

        .popup-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .popup-form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .popup-form input {
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        .popup-form input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(246, 203, 48, 0.4);
        }

        .popup-form button {
            padding: 12px;
            background-color: var(--primary);
            color: var(--secondary); 
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600; 
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .popup-form button:hover {
            background-color: #e0b81a; 
        }

        @keyframes fadeSlide {
            0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .popup-form .checkbox-group {
            display: flex; 
            align-items: center; 
            margin: 8px 0;
            gap: 8px; 
        }

        .popup-form .checkbox-group input[type="checkbox"] {
            margin: 0;
            flex-shrink: 0;
            width: 16px; 
            height: 16px; 
            border: 1px solid #ccc;
            border-radius: 4px;
            accent-color: var(--primary);
        }

        .popup-form .checkbox-group label {
            font-size: 14px;
            color: var(--secondary);
            line-height: 1.4;
            cursor: pointer;
            margin: 0;
            flex-grow: 1;
        }

        @media (max-width: 768px) {
            .popup-form .checkbox-group {
                flex-direction: column; 
                align-items: flex-start; 
                gap: 4px;
                margin: 6px 0;
            }

            .popup-form .checkbox-group input[type="checkbox"] {
                margin: 0 0 4px 0; 
            }

            .popup-form .checkbox-group label {
                font-size: 13px; 
                line-height: 1.3;
            }
        } 

        @media (max-width: 480px) {
            .popup-card {
                width: 95%;
                padding: 2rem 1.25rem 1.5rem;
                border-radius: 12px;
            }

            .popup-title {
                font-size: 1.1rem;
            }

            .popup-form input {
                font-size: 13px;
                padding: 9px 10px;
            }

            .popup-form button {
                font-size: 14px;
                padding: 9px;
            }

            .close-btn {
                top: 8px;
                right: 8px;
                width: 24px;
                height: 24px;
            }

            .close-btn svg {
                width: 14px;
                height: 14px;
            }
        } */

        .popup-overlay {
    position: fixed;
    inset: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(4px);
    z-index: 9999;
}

.popup-overlay.hidden {
    display: none;
}

.popup-card {
    position: relative;
    background: #ffffff;
    border-radius: 16px;
    padding: 1.5rem 1rem 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    width: 90%;
    max-width: 400px;
    color: #333;
    animation: fadeSlide 0.4s ease;
}

.close-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 2px;
}

.close-btn svg {
    width: 14px;
    height: 14px;
    stroke: #555;
    transition: stroke 0.2s;
}

.close-btn:hover svg {
    stroke: #000;
}

.popup-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--secondary);
    margin-bottom: 0.75rem;
    text-align: center;
}

.popup-form {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.popup-form input {
    padding: 8px 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.popup-form input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(246, 203, 48, 0.4);
}

.popup-form button {
    padding: 8px;
    background-color: var(--primary);
    color: var(--secondary);
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.popup-form button:hover {
    background-color: #e0b81a;
}

@keyframes fadeSlide {
    0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
    100% { opacity: 1; transform: translateY(0) scale(1); }
}

.popup-form .checkbox-group {
    display: flex;
    align-items: center;
    margin: 4px 0;
    gap: 6px;
}

.popup-form .checkbox-group input[type="checkbox"] {
    margin: 0;
    flex-shrink: 0;
    width: 14px;
    height: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    accent-color: var(--primary);
}

.popup-form .checkbox-group label {
    font-size: 13px;
    color: var(--secondary);
    line-height: 1.3;
    cursor: pointer;
    margin: 0;
    flex-grow: 1;
}

@media (max-width: 768px) {
    .popup-form .checkbox-group {
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
        margin: 4px 0;
    }

    .popup-form .checkbox-group input[type="checkbox"] {
        margin: 0 0 3px 0;
    }

    .popup-form .checkbox-group label {
        font-size: 12px;
        line-height: 1.2;
    }
}

@media (max-width: 480px) {
    .popup-card {
        width: 95%;
        padding: 1.25rem 0.75rem 0.75rem;
        border-radius: 12px;
    }

    .popup-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .popup-form {
        gap: 6px;
    }

    .popup-form input {
        font-size: 13px;
        padding: 6px 8px;
    }

    .popup-form button {
        font-size: 14px;
        padding: 6px;
    }

    .close-btn {
        top: 6px;
        right: 6px;
    }

    .close-btn svg {
        width: 12px;
        height: 12px;
    }
}

    </style>
</head>

<body>
    
    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex flex-column fixed-top">

        <!-- Top bar -->
        <div class="topbar">
            <div class="marquee">
                <div class="marquee-content">
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                    <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                     <span>📞 Inquiry: +91-9824895546  |  ✉️ sales@gemtenderconsultant.com</span>
                </div>
            </div>
        </div>

        <!-- Navbar -->
        @include('layouts.navbar')

    </header>
    <!-- End Header -->

    <!-- ======= Page Content ======= -->
    <main id="main">
        @yield('content')
    </main>
    <!-- End Content -->

    <!-- ======= Footer ======= -->
    @includeWhen(View::exists('layouts.footer'), 'layouts.footer')
    <!-- End Footer -->

     <!-- Popup Form -->
    <div id="popup-form" class="popup-overlay hidden">
        <div class="popup-card">
            <button id="closePopup" class="close-btn" aria-label="Close popup">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
            <h3 class="popup-title">Get Tender Alerts!</h3>
                <div class="errors"></div>
                <form id="leadForm" method="post" name="leadForm" class="popup-form" action="{{ route('sortinquiry') }}">
                 @csrf
                <input type="hidden" class="form-control" name="flag" value="contact-us" id="blog_popup_flag" autocomplete="off">
                <input type="text" id="name" name="name" placeholder="Enter your name" required />
                <input type="tel" name="user_primary_phone" placeholder="Enter mobile number" required />
                <input type="text" id="company_name" name="company_name" placeholder="Enter your company name" required />
                <input type="email" name="email" placeholder="Enter email address" required />
                <div>
                    <textarea id="looking_for" name="looking_for" required placeholder="Write your inquiry here..." rows="4"></textarea>
                    <div class="error-message" aria-live="polite"></div>
                </div>
                <div class="checkbox-group" >
                    <input type="checkbox" id="agreePopupTerms" name="agree"  required>
                    <label for="agreePopupTerms" >
                    I authorize ATCPL and its representatives to contact me.
                    </label>
                </div>
                <div class="g-recaptcha" data-sitekey="6LeyH3YsAAAAAK5FxKO0bASRuC2nB1KDsABsjUwF"></div>
 
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    
    <!-- Scripts -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script> -->
 <script type="text/javascript" src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
          (function() {
            function forceCursorVisibility() {
                document.documentElement.style.setProperty('cursor', 'auto', 'important');
                document.body.style.setProperty('cursor', 'auto', 'important');

                const clickableElements = document.querySelectorAll('a, button, input[type="submit"], label, select');
                clickableElements.forEach(el => {
                    el.style.setProperty('cursor', 'pointer', 'important');
                });
            }
            forceCursorVisibility();
            document.addEventListener('DOMContentLoaded', forceCursorVisibility);
            setInterval(forceCursorVisibility, 300);
        })();
    </script>
    @if (!Route::is('login') && !Route::is('register'))
    @if(!Auth::check())
        <script>
        const popup = document.getElementById('popup-form');
        const closeBtn = document.getElementById('closePopup');

        let popupDisabled = false; // flag to prevent showing again
        if (popup) {
            function showPopup() {
                if (!popupDisabled) {
                    popup.classList.remove('hidden');
                }
            }
            function hidePopup() {
                popup.classList.add('hidden');
            }
            closeBtn.addEventListener('click', hidePopup);

setTimeout(() => {
    showPopup();
}, 181000); 
    
            // Lead form in popup
            var formSubmitted;
            $('#leadForm').on('submit', function(e) {
                e.preventDefault(); 
                if (formSubmitted) return; 
                    formSubmitted = true;
                //  for popup check
                if(!$('#agreePopupTerms').is(':checked')){
                            $("#form-message").html("<span style='color:red;'>Please agree to the terms before submitting.</span>");
                            return;
                        }
                    var valid = true;
                var captchaResponse = grecaptcha.getResponse();
                if(captchaResponse.length === 0) {
                    alert("Please verify that you are not a robot.");
                    valid = false;
                }
                if (!valid) return;
       
                var name = $('#name').val();
                $('.errors').empty().fadeIn();
                $.ajax({
                    type: "POST",
                    url: "{{ route('sortinquiry') }}",
                    data: $('#leadForm').serialize(),
                    success: function(response) {
                        if(response.success == true){
                            var msg ='<div class="alert alert-success success_inquiry_pop_msg">';    
                                msg+=response.msg;
                                msg+='</div>';    
                                $('.errors').empty().append(msg).delay(5000).fadeOut();          

                            $('#leadForm')[0].reset();

                            // ✅ Disable popup after successful submit
                            popupDisabled = true;
                            hidePopup();
                            localStorage.setItem("popupSubmitted", "yes"); // persist
                            formSubmitted = false;
                        }
                    },
                    error: function(xhr, status, error) {
                        var msg = '<div class="alert alert-danger">';
                        $.each(xhr.responseJSON.errors, function(key, item) {
                            msg += item + '<br>';
                        });
                        msg += '</div>';
                        $('.errors').append(msg).delay(5000).fadeOut();
                    }
                });
            });

            // ✅ Check if already submitted before showing popup
            if (localStorage.getItem("popupSubmitted") === "yes") {
                popupDisabled = true;
            }
        }
    </script> 
@endif
@endif
  @yield('scripts')
</body>
</html>