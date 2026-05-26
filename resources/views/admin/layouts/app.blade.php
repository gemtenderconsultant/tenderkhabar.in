<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    
    <style>
        /* ===== GLOBAL STYLES (colors unchanged) ===== */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
            color: #334155;
        }

        /* Wrapper layout */
        .wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== SIDEBAR (exact colors from original) ===== */
        .sidebar {
            width: 260px;
            background-color: #1e293b;
            color: #fff;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
            z-index: 1000;
        }
        .sidebar-header {
            padding: 20px;
            background-color: #0f172a;
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }
        .sidebar-nav {
            flex-grow: 1;
            padding-top: 15px;
            overflow-y: auto;
        }
        .nav-item-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
            transition: 0.2s;
            border-left: 3px solid transparent;
        }
        .nav-item-link:hover,
        .nav-item-link.active {
            background-color: #334155;
            color: #fff;
            border-left-color: #3b82f6;
        }
        .nav-item-link i {
            font-size: 1.1rem;
            width: 30px;
        }

        .sidebar-footer {
            padding: 10px 0;
            border-top: 1px solid #334155;
            margin-top: auto;
        }
        .nav-item-link.logout-link {
            color: #f87171;
        }
        .nav-item-link.logout-link:hover {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-left-color: #ef4444;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        /* Top navbar */
        /* .top-navbar {
            background: #fff;
            padding: 15px 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        } */

        /* Content area padding */
        .content-area {
            padding: 25px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        /* Icon box (stat cards) */
        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Table styling */
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }
        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tr:last-child td {
            border-bottom: none;
        }

        /* Custom badges */
        .badge-soft-primary {
            background-color: #e0f2fe;
            color: #0369a1;
        }
        .badge-soft-success {
            background-color: #dcfce7;
            color: #166534;
        }

        /* Progress bar */
        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e2e8f0;
        }

        /* Close Icon */
        .closeIcon {
            font-size: 2rem;
            margin-left: 40px;
            display: none;
        }
        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                height: 100vh;
                width: 260px;
                z-index: 1000;
            }

            .sidebar.show {
                left: 0;
            }

            .closeIcon {
                display: block;
            }
            .top-navbar {
            background: #fff;
            padding: 15px 25px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        }
        .badge-paid {
            background-color: #dcfce7;
            color: #166534;
            padding: 6px 10px;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Action Buttons */
        .btn-action {
            padding: 4px 10px;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 4px;
        }

        /* Form label and input focus (consistent across all pages) */
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }
        .form-control {
            border-color: #cbd5e1;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        /* Modal header background (already present but ensure it's defined) */
        .modal-header {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        /* Custom Badges for Service Inquiry Flags */
        .badge-contact { 
            background-color: #e0f2fe; 
            color: #0369a1; 
            padding: 6px 10px; 
            border-radius: 6px; 
            font-weight: 500; 
            font-size: 0.8rem; 
        }
        .badge-admin { 
            background-color: #f3e8ff; 
            color: #7e22ce; 
            padding: 6px 10px; 
            border-radius: 6px; 
            font-weight: 500; 
            font-size: 0.8rem; 
        }

        /* Date & Time styling */
        .text-date { 
            font-size: 0.85rem; 
            font-weight: 500; 
            color: #64748b; 
        }
        .text-time { 
            font-size: 0.8rem; 
            color: #94a3b8; 
            display: block; 
        }

        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap; /* <-- add this */
        }
    </style>
</head>
<body>
<div class="wrapper">
    @include('admin.layouts.sidebar')
    <main class="main-content">
        <div class="top-navbar">
            <button class="btn btn-primary d-md-none" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>
        </div>
        @yield('stylesheet')
        @yield('content')
       @yield('scripts') 
    @includeWhen(View::exists('admin.layouts.footer'), 'admin.layouts.footer')
        <!-- </div> -->
        <script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("menuToggle");
    const overlay = document.getElementById("sidebarOverlay");
    const closeBtn = document.querySelector(".closeIcon");

    // Open sidebar
    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            sidebar.classList.add("show");
            overlay.classList.add("active");
        });
    }

    // Close sidebar (overlay click)
    if (overlay) {
        overlay.addEventListener("click", function () {
            sidebar.classList.remove("show");
            overlay.classList.remove("active");
        });
    }

    // Close sidebar (X button)
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            sidebar.classList.remove("show");
            overlay.classList.remove("active");
        });
    }

});
</script>
    </body>
</html>
