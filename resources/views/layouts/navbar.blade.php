
 <style type="text/css">
:root {
     /* --primary: #f5c518; */
     /* --primary: #f6cb30; */
      --primary: #E0B223;
     --secondary: #1e3a8a;
     --text: #333;
     --bg: #f8f9fc;
     --card-bg: #fff;
     --card-shadow: rgba(0, 0, 0, 0.1);
     /* --highlight: #fffbcc; */
     --highlight: #fff9b3;
     --highlight-shadow: rgba(245, 197, 24, 0.4);
     --error-color: #d93025;
 }

 * {
     box-sizing: border-box;
 }
 
 body {
     margin: 0px;
     font-family: 'Poppins', sans-serif;
     background: var(--bg);
     color: var(--text);
     cursor: none !important;
 }

 /* Topbar */
 .topbar {
     background-color: var(--secondary);
     color: var(--bg);
     padding: 6px 0;
     overflow: hidden;
     font-weight: bold;
     font-size: 14px;
     white-space: nowrap;
     position: relative;
 }

 .marquee {
     width: 100%;
     overflow: hidden;
     position: relative;
 }

 .marquee-content {
     display: inline-block;
     white-space: nowrap;
     animation: scroll-left 20s linear infinite;
 }

 @keyframes scroll-left {
     0% {
         transform: translateX(0%);
     }

     100% {
         transform: translateX(-50%);
     }
 }

 @media (max-width: 768px) {
     .topbar {
         font-size: 13px;
         padding: 5px 0;
     }
 }

 @media (max-width: 480px) {
     .topbar {
         font-size: 12px;
         padding: 4px 0;
     }

     .marquee-content {
         animation: scroll-left 15s linear infinite;
     }
 }

 /* Navbar */
 .navbar {
     background-color: var(--card-bg) !important;
     box-shadow: 0 4px 10px var(--card-shadow);
     padding: 12px 24px;
     width: 100%;
 }

 

 .navbar-container {
     display: flex;
     justify-content: space-between;
     align-items: center;
     flex-wrap: wrap;
 }

 .logo-container {
     display: flex;
     align-items: center;
 }

 .logo-img {
     height: 40px;
     object-fit: contain;
     margin-right: 130px;
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
     
 }

 .nav-links a:hover {
     color: var(--primary);
 }

 .login-btn {
     padding: 6px 12px;
     background-color: var(--primary);
     color: #000;
     border-radius: 6px;
     font-weight: bold;
 }

 .hamburger {
     display: none;
     font-size: 28px;
     cursor: pointer;
     color: var(--secondary);
 }

 @media (max-width: 768px) {
    /* General Mobile Styles */
    body {
        cursor: default !important;
    }
    .cursor-dot,
    .cursor-ring {
        display: none !important;
    }
    .navbar {
        padding: 12px 24px; /* Default mobile padding */
    }

    /* Logo Specific */
    .logo-img {
        height: 40px; /* Smaller logo for tablets */
        margin-right: 0; /* Remove right margin */
    }
    .logo-container {
        margin-right: 0; /* Ensure no extra margin here */
    }


    /* Hamburger Specific */
    .hamburger {
        display: block; /* Show hamburger */
        font-size: 28px;
        padding: 5px;
        margin-right: 0; /* Ensure no extra right margin if any */
         margin-left: 200px;
    }

    /* Navbar Container Specific */
    .navbar-container {
        justify-content: space-between;
        flex-wrap: nowrap;
    }

    /* Navigation Links (Dropdown) Specific */
    .nav-links {
        display: none; /* Hide by default for mobile */
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        position: absolute;
        top: 65px; /* Adjust as needed */
        left: 0;
        background-color: var(--card-bg);
        box-shadow: 0 4px 10px var(--card-shadow);
        padding: 15px 24px;
        z-index: 1000;
        gap: 10px;
    }
    .nav-links.show {
        display: flex !important; /* Show when active */
    }

    /* Login Button Specific */
    .login-btn {
        font-size: 14px;
        padding: 5px 10px;
        width: auto;
        text-align: center;
    }

    /* Topbar Specific */
    .topbar {
        font-size: 13px;
        padding: 5px 0;
    }
}


/* Media Query for very Small Phones (e.g., 480px and below) */
@media (max-width: 480px) {
    /* Logo Specific */
    .logo-img {
        height: 30px; /* Even smaller logo */
    }

    /* Navbar Specific */
    .navbar {
        padding: 10px 15px; /* Adjust padding for smaller screens */
    }

    /* Hamburger Specific */
    .hamburger {
        font-size: 24px; /* Slightly smaller hamburger */
        margin-right: 30px;
         margin-left: 90px;
    }

    /* Navigation Links (Dropdown) Specific */
    .nav-links {
        top: 55px; /* Adjust dropdown position for smaller navbar height */
        padding: 10px 15px;
    }

    /* Topbar Specific */
    .topbar {
        font-size: 12px;
        padding: 4px 0;
    }

    .marquee-content {
        animation: scroll-left 15s linear infinite;
    }
}
 </style>

<nav class="navbar">

    <div class="navbar-container">
      
        <div class="logo-container">
            <img src="{{ asset('assets/img/Logo Image 1 - Copy.jpg')  }}" alt="Logo" class="logo-img" />
        </div>

        <div class="hamburger" onclick="toggleMenu()">&#9776;</div>

        <div class="nav-links" id="navLinks">
            <a href="{{ route('welcome') }}">Home</a>
            <a href="{{ route('gem') }}">GeM Services</a>
            <a href="{{ route('bidding') }}">Other Portal Services</a>
            <a href="{{ route('certification') }}">Certificates</a>
            <a href="{{ route('pricing-plans') }}">Pricing Plan</a>

            @if(!Auth::check())
                <a href="{{ route('login') }}" class="login-btn">Login</a>
                <a href="{{ route('register') }}" class="login-btn">Sign Up</a>
            @else
                <a href="{{ route('dashboard') }}" class="login-btn">Dashboard</a>
                <a href="{{ route('logout') }}" class="login-btn">Logout</a>
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
        if (!navbar.contains(e.target) && nav.classList.contains('show')) {
            nav.classList.remove('show');
        }
    });

    document.querySelectorAll('#navLinks a').forEach(a => {
        a.addEventListener('click', () => {
            const nav = document.getElementById('navLinks');
            nav.classList.remove('show');
        });
    });
</script>