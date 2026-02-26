<style type="text/css">
    :root {
        --primary: #E0B223;
        --secondary: #1e3a8a;
        --text: #333;
        --bg: #f8f9fc;
        --card-bg: #fff;
        --card-shadow: rgba(0, 0, 0, 0.1);
        --highlight: #fff9b3;
        --highlight-shadow: rgba(245, 197, 24, 0.4);
        --error-color: #d93025;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        background: var(--bg);
        color: var(--text);
        cursor: default !important; /* This should now work for the default body cursor */
        /* Add padding-top to body to prevent content from being hidden behind fixed navbar */
        padding-top: 64px; /* Adjust this value based on your navbar's actual height */
    }

    /* Sets the hand pointer for links, buttons, and other clickable items */
    a, button, input[type="submit"], label, select, .dropdown-toggle, .hamburger {
        cursor: pointer !important;
    }
    /* Explicitly set cursor for elements that should have default behavior but might be overridden */
    input[type="text"], input[type="password"], textarea {
        cursor: text !important;
    }
    /* Ensure cursor is default for plain body content or footer */
    footer, p, div:not(a):not(button):not(.dropdown-toggle):not(.hamburger) {
        cursor: default !important;
    }


    /* Navbar from new design */
    .navbar {
        background-color: #fff !important;
        box-shadow: 0 4px 10px var(--card-shadow);
        padding: 12px 24px;
        width: 100%;
        position: fixed; /* Make the navbar fixed at the top */
        top: 0;
        left: 0;
        z-index: 1000; /* Ensure it stays on top of other content */
    }

    .navbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        max-width: 1200px; /* Optional: Constrain width for larger screens */
        margin: 0 auto; /* Center the navbar content */
        width: 100%;
    }

    .logo-container {
        display: flex;
        align-items: center;
    }

    .logo-img {
        height: 40px;
        object-fit: contain;
        margin-right: 20px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--secondary);
        font-weight: 600;
        transition: color 0.3s ease;
        white-space: nowrap; /* Prevent links from wrapping */
    }

    .nav-links a:hover,
    .nav-links .dropdown-item:hover {
        color: var(--primary) !important;
    }

    .login-btn {
        padding: 6px 12px;
        background-color: var(--primary);
        color: #000;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        white-space: nowrap;
    }

    .hamburger {
        display: none;
        font-size: 28px;
        cursor: pointer;
        color: var(--secondary);
    }

    /* Dropdown specific styles */
    .nav-item.dropdown {
        position: relative; /* Essential for dropdown positioning */
        margin-left: 0;
    }

    .nav-item.dropdown .dropdown-toggle {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--secondary);
        font-weight: 600;
        cursor: pointer;
        padding: 0; /* Remove default padding */
        /* Ensure dropdown toggle is always block-level for consistent styling */
        display: block;
    }

    .nav-item.dropdown .dropdown-menu {
        position: absolute; /* Ensures dropdown is positioned relative to its parent */
        top: 100%; /* Positions dropdown below the toggle */
        left: auto; /* Override default left positioning */
        right: 0; /* Align dropdown with the right edge of its parent */
        background-color: var(--card-bg);
        box-shadow: 0 4px 10px var(--card-shadow);
        border-radius: 6px;
        padding: 8px 0;
        min-width: 160px;
        z-index: 1001; /* Higher than navbar but lower than modal */
        display: none; /* Hidden by default */
    }

    .nav-item.dropdown:hover .dropdown-menu,
    .nav-item.dropdown.show .dropdown-menu {
        display: block; /* Show on hover or when toggled */
    }

    .dropdown-item {
        padding: 8px 16px;
        color: var(--secondary);
        text-decoration: none;
        display: block;
        white-space: nowrap;
        font-weight: 500;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: var(--highlight);
        color: var(--primary) !important;
    }

    /* Mobile-specific styles */
    @media (max-width: 768px) {
        .navbar {
            padding: 10px 15px;
        }

        .hamburger {
            display: block;
        }

        .nav-links {
            display: none;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            margin-top: 10px;
            gap: 12px;
            background-color: var(--card-bg); /* Add background for mobile menu */
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 4px 10px var(--card-shadow);
        }

        .nav-links.show {
            display: flex;
        }

        .navbar-container {
            flex-direction: row; /* Keep logo and hamburger on same line */
            justify-content: space-between;
            align-items: center;
        }

        /* Adjust dropdown behavior for mobile */
        .nav-item.dropdown {
            width: 100%; /* Make dropdown occupy full width in mobile menu */
            position: static; /* Remove absolute positioning for mobile dropdown */
        }

        .nav-item.dropdown .dropdown-toggle {
            width: 100%; /* Ensure the toggle itself takes full width */
            padding: 8px 0; /* Add some padding back for clarity */
            justify-content: space-between; /* To push the arrow to the right if you have one */
        }

        .nav-item.dropdown .dropdown-menu {
            position: static; /* Allows it to flow naturally in the column */
            box-shadow: none; /* Remove shadow for nested menu */
            padding-left: 20px; /* Indent mobile dropdown items */
            margin-top: 0;
            border-radius: 0;
            background-color: var(--bg); /* Slightly different background for sub-items */
            width: 100%; /* Occupy full width */
            display: none; /* Keep hidden by default */
            left: 0; /* Reset left/right for mobile dropdown */
            right: auto; /* Reset left/right for mobile dropdown */
        }

        /* When mobile menu is active and dropdown is "shown" (clicked) */
        .nav-links.show .nav-item.dropdown.show .dropdown-menu {
            display: flex; /* Display as a column */
            flex-direction: column;
        }

        .dropdown-item {
            width: 100%;
        }

        .hamburger {
            margin-top: 0;
        }
    }
</style>

<nav id="navbar" class="navbar">
    <div class="navbar-container">
        <!-- Logo container -->
        <div class="logo-container">
            <img src="{{ asset('assets/img/Logo Image 1 - Copy.jpg') }}" alt="Dashboard Logo" class="logo-img">
        </div>

        <div class="hamburger" onclick="toggleMenu()">&#9776;</div>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('tender-listing') }}">Tender Listing</a>
            <a href="{{ route('logintenderresults') }}">Tender Result</a>

            @if(!Auth::check())
                <a class="login-btn" href="{{ route('login') }}">Login</a>
            @else
                <!-- My Profile Dropdown for logged-in users -->
                <div class="nav-item dropdown"> 
                    @php
                        $small_str = substr(Auth::user()->name,0,30);
                        $user_name = (trim($small_str) != "") ? $small_str."..." : "Guest";
                    @endphp
                    <a class="nav-link dropdown-toggle" href="#" id="myProfileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        My Profile
                    </a>
                    <ul class="dropdown-menu pt-0 pb-0" aria-labelledby="myProfileDropdown">
                        {{-- Added direct link to My Profile --}}
                        <li><a class="dropdown-item" href="{{ route('changepassword2') }}">Change Password</a></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        const nav = document.getElementById('navLinks');
        nav.classList.toggle('show');
    }

    document.addEventListener('click', function (e) {
        const nav = document.getElementById('navLinks');
        const hamburger = document.querySelector('.hamburger');
        const navbar = document.querySelector('.navbar'); 
        
        // Check if the click is outside the navbar and the nav links are currently open
        if (!navbar.contains(e.target) && nav.classList.contains('show')) {
            nav.classList.remove('show');
        }
    });

    // Close the mobile menu when a link is clicked
    document.querySelectorAll('#navLinks a').forEach(a => {
        a.addEventListener('click', () => {
            const nav = document.getElementById('navLinks');
            if (nav.classList.contains('show')) { 
                nav.classList.remove('show');
            }
        });
    });

    // Custom dropdown logic for desktop (if not relying solely on Bootstrap JS)
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggle = document.getElementById('myProfileDropdown');
        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation(); // Prevent document click from closing immediately
                this.parentNode.classList.toggle('show'); // Toggle 'show' class on parent nav-item
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', function (event) {
                if (!dropdownToggle.parentNode.contains(event.target)) {
                    dropdownToggle.parentNode.classList.remove('show');
                }
            });
        }
    });
</script>