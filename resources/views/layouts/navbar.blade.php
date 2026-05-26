<header class="index-header">
    <div class="index-container index-nav-wrap">
        <a href="#" class="index-logo">
            <!-- <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=100&q=80" alt="Logo Icon"> -->
            TENDER<span class="index-text-gradient-yellow">KHABAR</span>
        </a>
        <nav class="index-nav-links">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('gem') }}">GeM Services</a>
            <a href="{{ route('otherportal') }}">Other Portals</a>
            <a href="{{ route('pricing-plans') }}">Pricing Plan</a>
            <a href="{{ route('certification') }}">Certificates</a>
        </nav>
         @if(!Auth::check())
         <div class="index-auth-btns">
            <a href="{{ url('/login') }}" class="index-btn index-btn-login">
                <i data-lucide="log-in" size="16"></i> Login
            </a>
            <a href="{{ route('register') }}" class="index-btn index-btn-reg">Register Now <i data-lucide="arrow-right" size="16"></i></a>
        </div>
                
        @else
        <div class="index-auth-btns">
                <a href="{{ route('dashboards') }}" class="index-btn index-btn-login">Dashboard</a>
                <a href="{{ route('logout') }}" class="index-btn index-btn-reg">Logout</a>
            </div>
        @endif
        
        <button class="index-menu-toggle" id="index-menuBtn">
            <i data-lucide="menu" size="28"></i>
        </button>
    </div>
      </header>