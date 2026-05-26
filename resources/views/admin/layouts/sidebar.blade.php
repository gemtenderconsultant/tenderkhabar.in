@php 
$currentPage = $currentPage ?? 'dashboard';
@endphp

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-layers-fill text-primary me-2"></i> AdminPanel
        </div>
        <i class="bi bi-x text-light closeIcon d-lg-none" style="cursor:pointer;"></i>
    </div>

    <!-- Admin Info -->
    <div class="p-3 border-bottom border-secondary d-flex align-items-center">
        @if(Auth::guard('admin')->check())
            <img src="https://ui-avatars.com/api/?name={{ ucwords(Auth::guard('admin')->user()->name) }}&background=3b82f6&color=fff"
                class="rounded-circle me-2" width="40" alt="Admin Avatar">
            <div> 
                <h6 class="mb-0 text-white" style="font-size: 0.9rem;">
                    {{ ucwords(Auth::guard('admin')->user()->name) }}
                </h6>
                <small class="text-secondary" style="font-size: 0.75rem;">Administrator</small>
            </div>
        @endif
    </div>

    <!-- Menu -->
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item-link {{ $currentPage == 'dashboard' ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>

        <a href="{{ route('user-list') }}" class="nav-item-link {{ $currentPage == 'users' ? 'active' : '' }}">
            <i class="bi bi-people"></i> Users
        </a>

        <a href="{{ route('adminlist') }}" class="nav-item-link {{ $currentPage == 'admins' ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Admins
        </a>

        <a href="{{ route('userserviceinquiry') }}" class="nav-item-link {{ $currentPage == 'services' ? 'active' : '' }}">
            <i class="bi bi-headset"></i> Service Inquiry
        </a>

        <a href="{{ route('adminemails') }}" class="nav-item-link {{ $currentPage == 'emails' ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Emails
        </a>

        <a href="{{ route('changepwd') }}" class="nav-item-link {{ $currentPage == 'change-password' ? 'active' : '' }}">
            <i class="bi bi-key"></i> Change Password
        </a>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
        <a href="{{ route('admin.logout') }}" class="nav-item-link logout-link">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</aside>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>