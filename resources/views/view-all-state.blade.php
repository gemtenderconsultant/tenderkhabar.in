@extends('layouts.app')
@section('content')
    <style>
        :root {

            --view-state-primary: #0A2540;
            --view-state-primary-light: #16385d;
            --view-state-accent: #F9BF29;
            --view-state-accent-hover: #e5ad1e;
            --view-state-bg: #F8FAFC;
            --view-state-surface: #FFFFFF;
            --view-state-text-main: #1E293B;
            --view-state-text-muted: #64748B;
            --view-state-border: #E2E8F0;

            --view-state-shadow-sm: 0 2px 8px rgba(10, 37, 64, 0.04);
            --view-state-shadow-md: 0 10px 30px rgba(10, 37, 64, 0.06);
            --view-state-shadow-hover: 0 20px 40px rgba(10, 37, 64, 0.1);
            
            --view-state-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Manrope', sans-serif; 
            background-color: var(--view-state-bg);
            color: var(--view-state-text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .view-state-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .view-state-top-bar { 
            background: var(--view-state-primary); 
            padding: 10px 0; 
            font-size: 0.85rem; 
            color: #E2E8F0; 
            font-weight: 500;
        }
        .view-state-top-bar .view-state-container { 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .view-state-top-info { display: flex; gap: 24px; align-items: center; }
        .view-state-top-info i { color: var(--view-state-accent); margin-right: 6px; }

        .view-state-header { 
            background: var(--view-state-surface); 
            padding: 18px 0; 
            border-bottom: 1px solid var(--view-state-border);
            position: sticky; top: 0; z-index: 1000;
        }
        .view-state-nav { display: flex; justify-content: space-between; align-items: center; }
        .view-state-logo { 
            font-size: 1.5rem; font-weight: 800; color: var(--view-state-primary); 
            text-decoration: none; letter-spacing: -0.5px;
        }
        .view-state-logo span { color: var(--view-state-accent); }
        
        .view-state-links { display: flex; gap: 32px; }
        .view-state-links a { 
            text-decoration: none; color: var(--view-state-text-main); 
            font-weight: 600; font-size: 0.95rem; transition: var(--view-state-transition); 
        }
        .view-state-links a:hover { color: var(--view-state-primary); }
        
        .view-state-actions { display: flex; gap: 12px; }
        .view-state-btn { 
            padding: 10px 24px; border-radius: 8px; font-weight: 700; border: none; 
            cursor: pointer; transition: var(--view-state-transition); font-family: inherit; font-size: 0.95rem; 
        }
        .view-state-btn-login { 
            background: var(--view-state-surface); color: var(--view-state-primary); 
            border: 1px solid var(--view-state-border); 
        }
        .view-state-btn-login:hover { border-color: var(--view-state-primary); background: #f8fafc; }
        .view-state-btn-reg { 
            background: var(--view-state-primary); color: var(--view-state-surface); 
        }
        .view-state-btn-reg:hover { background: var(--view-state-primary-light); }

        .view-state-menu-toggle { display: none; background: none; border: none; color: var(--view-state-primary); cursor: pointer; }

        .view-state-hero {
            padding: 70px 0 100px;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230a2540' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            text-align: center;
        }
        
        .view-state-hero-tag {
            display: inline-block;
            background: rgba(249, 191, 41, 0.15);
            color: #d97706;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .view-state-hero-title { 
            font-size: 3rem; font-weight: 800; color: var(--view-state-primary);
            margin-bottom: 16px; line-height: 1.2; letter-spacing: -1px;
        }
        
        .view-state-hero-subtitle { 
            font-size: 1.15rem; color: var(--view-state-text-muted); 
            max-width: 650px; margin: 0 auto; line-height: 1.6;
        }

        .view-state-search-wrapper {
            max-width: 750px;
            margin: -40px auto 60px;
            position: relative;
            z-index: 10;
        }
        
        .view-state-search-box {
            background: var(--view-state-surface);
            border-radius: 16px;
            padding: 10px;
            display: flex;
            align-items: center;
            box-shadow: var(--view-state-shadow-md);
            border: 1px solid rgba(0,0,0,0.03);
            transition: var(--view-state-transition);
        }
        
        .view-state-search-box:focus-within {
            box-shadow: var(--view-state-shadow-hover);
            border-color: rgba(10, 37, 64, 0.1);
            transform: translateY(-2px);
        }

        .view-state-search-icon {
            padding: 0 20px;
            color: var(--view-state-text-muted);
        }

        .view-state-search-input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            font-family: inherit;
            color: var(--view-state-text-main);
            outline: none;
            font-weight: 500;
        }
        
        .view-state-search-input::placeholder { color: #94A3B8; }

        .view-state-search-btn {
            background: var(--view-state-accent);
            color: var(--view-state-primary);
            border: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--view-state-transition);
        }
        
        .view-state-search-btn:hover {
            background: var(--view-state-accent-hover);
        }

        .view-state-grid-section { padding-bottom: 80px; }
        
        .view-state-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .view-state-card {
            background: var(--view-state-surface);
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid var(--view-state-border);
            box-shadow: var(--view-state-shadow-sm);
            transition: var(--view-state-transition);
            position: relative;
            overflow: hidden;
        }

        .view-state-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 0;
            width: 4px;
            background: var(--view-state-accent);
            border-radius: 0 4px 4px 0;
            transition: var(--view-state-transition);
        }

        .view-state-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--view-state-shadow-md);
            border-color: rgba(10, 37, 64, 0.1);
        }

        .view-state-card:hover::before {
            height: 60%;
        }

        .view-state-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            background: #F1F5F9;
            color: var(--view-state-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--view-state-transition);
            flex-shrink: 0;
        }

        .view-state-card:hover .view-state-icon-box {
            background: var(--view-state-primary);
            color: var(--view-state-surface);
        }

        .view-state-card-content {
            flex: 1;
        }

        .view-state-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--view-state-primary);
            margin-bottom: 4px;
        }

        .view-state-card-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--view-state-text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--view-state-transition);
        }

        .view-state-card:hover .view-state-card-link {
            color: var(--view-state-accent-hover);
        }

        .view-state-card-arrow {
            transition: transform 0.3s ease;
        }

        .view-state-card:hover .view-state-card-arrow {
            transform: translateX(4px);
        }

        .view-state-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: var(--view-state-surface);
            border-radius: 16px;
            border: 1px solid var(--view-state-border);
            display: none;
        }
        .view-state-empty-icon { color: var(--view-state-border); margin-bottom: 16px; }
        .view-state-empty h3 { font-size: 1.4rem; color: var(--view-state-primary); font-weight: 700; margin-bottom: 8px; }
        .view-state-empty p { color: var(--view-state-text-muted); }

        .view-state-footer { background: var(--view-state-primary); color: #F8FAFC; padding: 70px 0 30px; font-size: 0.95rem; }
        .view-state-footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; margin-bottom: 40px; }
        
        .view-state-footer-brand { margin-bottom: 20px; }
        .view-state-footer-brand span { color: var(--view-state-accent); }
        
        .view-state-footer h5 { color: var(--view-state-surface); font-size: 1.1rem; margin-bottom: 24px; font-weight: 700; }
        .view-state-footer ul { list-style: none; }
        .view-state-footer ul li { margin-bottom: 14px; }
        .view-state-footer ul li a { color: #94A3B8; text-decoration: none; transition: var(--view-state-transition); font-weight: 500; }
        .view-state-footer ul li a:hover { color: var(--view-state-accent); }
        
        .view-state-contact-item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; color: #94A3B8; }
        .view-state-contact-item i { color: var(--view-state-accent); margin-top: 3px; }
        
        .view-state-social { display: flex; gap: 16px; margin-top: 24px; }
        .view-state-social a { 
            width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.05); 
            display: flex; align-items: center; justify-content: center; color: var(--view-state-surface); 
            transition: var(--view-state-transition); 
        }
        .view-state-social a:hover { background: var(--view-state-accent); color: var(--view-state-primary); }
        
        .view-state-copyright { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px; text-align: center; color: #64748B; font-size: 0.85rem; }

        .view-state-scroll-top {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--view-state-surface); color: var(--view-state-primary);
            width: 50px; height: 50px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid var(--view-state-border); cursor: pointer; z-index: 1000;
            box-shadow: var(--view-state-shadow-md);
            opacity: 0; visibility: hidden; transform: translateY(20px);
            transition: var(--view-state-transition);
        }
        .view-state-scroll-top.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .view-state-scroll-top:hover { background: var(--view-state-primary); color: var(--view-state-surface); transform: translateY(-5px); }

        .view-state-mobile-overlay { position: fixed; inset: 0; background: rgba(10,37,64,0.5); z-index: 1999; display: none; backdrop-filter: blur(3px); }
        .view-state-mobile-menu { position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: var(--view-state-surface); z-index: 2000; padding: 30px; transition: right 0.3s ease; display: flex; flex-direction: column; }
        .view-state-mobile-menu.active { right: 0; }
        .view-state-mobile-overlay.active { display: block; }

        @media (max-width: 992px) {
            .view-state-footer-grid { grid-template-columns: 1fr 1fr; }
            .view-state-hero-title { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            .view-state-top-bar { display: none; }
            .view-state-links, .view-state-actions { display: none; }
            .view-state-menu-toggle { display: block; }
            
            .view-state-hero { padding: 50px 0 80px; }
            .view-state-hero-title { font-size: 2rem; }
            
            .view-state-search-box { padding: 6px; }
            .view-state-search-icon { padding: 0 12px; }
            .view-state-search-btn { padding: 12px 20px; font-size: 0.9rem; }

            .view-state-footer-grid { grid-template-columns: 1fr; gap: 40px; }
        }
    </style>

<section class="view-state-hero">
    <div class="view-state-container">
        
        <h1 class="view-state-hero-title">Browse All States & UTs</h1>
        <p class="view-state-hero-subtitle">Navigate through India's comprehensive procurement landscape. Select any state below to view dedicated tenders, analytics, and active authorities.</p>
    </div>
</section>

<main class="view-state-container view-state-grid-section">
    <div class="view-state-search-wrapper">
        <div class="view-state-search-box">
            <i data-lucide="search" size="22" class="view-state-search-icon"></i>
            <input type="text" id="view-state-searchInput" class="view-state-search-input" placeholder="Search...">
            <button class="view-state-search-btn" onclick="filterStates()">Search</button>
        </div>
    </div>
    <div class="view-state-grid" id="view-state-grid">
            @if($state_data->count() > 0)
              @foreach($state_data as $key => $value)
        <a href="#" class="view-state-card" data-state="{{ $value->name }}">
            <div class="view-state-card-content">
                <div class="view-state-card-title"> {{ $value->name }} Tenders</div>
                <div class="view-state-card-link" onclick="window.location.href='{{ route('stateresult', ['id' => $value->name]) }}'">View Tenders <i data-lucide="arrow-right" size="14" class="view-state-card-arrow"></i></div>
            </div>
        </a>
        @endforeach
        @else
            <p>No states found.</p>
        @endif
    </div>
</main>
<button class="view-state-scroll-top" id="view-state-scrollBtn">
    <i data-lucide="arrow-up" size="20"></i>
</button>
@endsection
@section('scripts')
<script>
    lucide.createIcons();
    // Search Functionality
    const stateSearchInput = document.getElementById('view-state-searchInput');
    const stateCards = document.querySelectorAll('.view-state-card');
    const stateEmptyState = document.getElementById('view-state-empty');

    function filterStates() {

        const query = stateSearchInput.value.toLowerCase().trim();

        let visibleCount = 0;

        stateCards.forEach(card => {

            const stateName = card.dataset.state.toLowerCase();

            if (stateName.includes(query)) {

                card.style.display = 'flex';
                visibleCount++;

            } else {
                card.style.display = 'none';
            }
        });
        if (visibleCount === 0) {
            stateEmptyState.style.display = 'block';
        } else {
            stateEmptyState.style.display = 'none';
        }
    }
    // Live Search
    stateSearchInput.addEventListener('keyup', filterStates);

    // Scroll Top Button
    const scrollBtn = document.getElementById('view-state-scrollBtn');

    window.addEventListener('scroll', () => {

        if (window.scrollY > 300) {
            scrollBtn.classList.add('show');
        } else {
            scrollBtn.classList.remove('show');
        }

    });

    scrollBtn.addEventListener('click', () => {

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    });

</script>
@endsection