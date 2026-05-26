<div class="tender-listing-bg-layer"></div>
<header class="login-dashboard-header">
    <a href="#" class="login-dashboard-logo">
        <i data-lucide="shield-check" style="color:var(--gold)"></i>
        Tender <span>Khabar</span>
    </a>
    <nav class="login-dashboard-nav">
        <a href="{{ route('dashboards') }}">Dashboard</a>
        <a href="{{ route('tendersearch') }}">Tender Listing</a>
        <a href="{{ route('logintenderresults') }}">Tender Result</a>
        <div class="login-dashboard-dropdown-container">
            <button class="login-dashboard-dropdown-trigger" id="dropdownBtn">
                Profile <i data-lucide="chevron-down" size="14"></i>
            </button>
            <div class="login-dashboard-dropdown-menu" id="dropdownMenu">
                <a href="{{ route('profile') }}"><i data-lucide="user" size="16"></i> My Profile</a>
                <a href="{{ route('changepassword2') }}"><i data-lucide="key-round" size="16"></i> Change Password</a>
                <a href="{{ route('logout') }}"><i data-lucide="log-out" size="16"></i> Logout</a>
            </div>
        </div>
    </nav>
</header>