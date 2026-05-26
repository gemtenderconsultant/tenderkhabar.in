@extends('layouts.app')
@section('content')
    <style>
        :root {
            --view-category-primary: #0A2540;
            --view-category-primary-light: #16385d;
            --view-category-accent: #F9BF29;
            --view-category-accent-hover: #e5ad1e;
            --view-category-bg: #F8FAFC;
            --view-category-surface: #FFFFFF;
            --view-category-text-main: #1E293B;
            --view-category-text-muted: #64748B;
            --view-category-border: #E2E8F0;

            --view-category-shadow-sm: 0 2px 8px rgba(10, 37, 64, 0.04);
            --view-category-shadow-md: 0 10px 30px rgba(10, 37, 64, 0.06);
            --view-category-shadow-hover: 0 20px 40px rgba(10, 37, 64, 0.1);
            
            --view-category-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Manrope', sans-serif; 
            background-color: var(--view-category-bg);
            color: var(--view-category-text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .view-category-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .view-category-top-bar { 
            background: var(--view-category-primary); 
            padding: 10px 0; 
            font-size: 0.85rem; 
            color: #E2E8F0; 
            font-weight: 500;
        }
        .view-category-top-bar .view-category-container { 
            display: flex; justify-content: space-between; align-items: center; 
        }
        .view-category-top-info { display: flex; gap: 24px; align-items: center; }
        .view-category-top-info i { color: var(--view-category-accent); margin-right: 6px; }

        .view-category-header { 
            background: var(--view-category-surface); 
            padding: 18px 0; 
            border-bottom: 1px solid var(--view-category-border);
            position: sticky; top: 0; z-index: 1000;
        }
        .view-category-nav { display: flex; justify-content: space-between; align-items: center; }
        .view-category-logo { 
            font-size: 1.5rem; font-weight: 800; color: var(--view-category-primary); 
            text-decoration: none; letter-spacing: -0.5px;
        }
        .view-category-logo span { color: var(--view-category-accent); }
        
        .view-category-links { display: flex; gap: 32px; }
        .view-category-links a { 
            text-decoration: none; color: var(--view-category-text-main); 
            font-weight: 600; font-size: 0.95rem; transition: var(--view-category-transition); 
        }
        .view-category-links a:hover { color: var(--view-category-primary); }
        
        .view-category-actions { display: flex; gap: 12px; }
        .view-category-btn { 
            padding: 10px 24px; border-radius: 8px; font-weight: 700; border: none; 
            cursor: pointer; transition: var(--view-category-transition); font-family: inherit; font-size: 0.95rem; 
        }
        .view-category-btn-login { 
            background: var(--view-category-surface); color: var(--view-category-primary); 
            border: 1px solid var(--view-category-border); 
        }
        .view-category-btn-login:hover { border-color: var(--view-category-primary); background: #f8fafc; }
        .view-category-btn-reg { 
            background: var(--view-category-primary); color: var(--view-category-surface); 
        }
        .view-category-btn-reg:hover { background: var(--view-category-primary-light); }

        .view-category-menu-toggle { display: none; background: none; border: none; color: var(--view-category-primary); cursor: pointer; }

        .view-category-hero {
            padding: 70px 0 100px;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230a2540' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            text-align: center;
        }
        
        .view-category-hero-tag {
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

        .view-category-hero-title { 
            font-size: 3rem; font-weight: 800; color: var(--view-category-primary);
            margin-bottom: 16px; line-height: 1.2; letter-spacing: -1px;
        }
        
        .view-category-hero-subtitle { 
            font-size: 1.15rem; color: var(--view-category-text-muted); 
            max-width: 650px; margin: 0 auto; line-height: 1.6;
        }

        .view-category-search-wrapper {
            max-width: 750px;
            margin: -40px auto 60px;
            position: relative;
            z-index: 10;
        }
        
        .view-category-search-box {
            background: var(--view-category-surface);
            border-radius: 16px;
            padding: 10px;
            display: flex;
            align-items: center;
            box-shadow: var(--view-category-shadow-md);
            border: 1px solid rgba(0,0,0,0.03);
            transition: var(--view-category-transition);
        }
        
        .view-category-search-box:focus-within {
            box-shadow: var(--view-category-shadow-hover);
            border-color: rgba(10, 37, 64, 0.1);
            transform: translateY(-2px);
        }

        .view-category-search-icon {
            padding: 0 20px;
            color: var(--view-category-text-muted);
        }

        .view-category-search-input {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            font-family: inherit;
            color: var(--view-category-text-main);
            outline: none;
            font-weight: 500;
        }
        
        .view-category-search-input::placeholder { color: #94A3B8; }

        .view-category-search-btn {
            background: var(--view-category-accent);
            color: var(--view-category-primary);
            border: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--view-category-transition);
        }
        
        .view-category-search-btn:hover {
            background: var(--view-category-accent-hover);
        }

        .view-category-grid-section { padding-bottom: 80px; }
        
        .view-category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .view-category-card {
            background: var(--view-category-surface);
            border-radius: 16px;
            padding: 24px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid var(--view-category-border);
            box-shadow: var(--view-category-shadow-sm);
            transition: var(--view-category-transition);
            position: relative;
            overflow: hidden;
        }

        .view-category-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 0;
            width: 4px;
            background: var(--view-category-accent);
            border-radius: 0 4px 4px 0;
            transition: var(--view-category-transition);
        }

        .view-category-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--view-category-shadow-md);
            border-color: rgba(10, 37, 64, 0.1);
        }

        .view-category-card:hover::before {
            height: 60%;
        }

        .view-category-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            background: #F1F5F9;
            color: var(--view-category-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--view-category-transition);
            flex-shrink: 0;
        }

        .view-category-card:hover .view-category-icon-box {
            background: var(--view-category-primary);
            color: var(--view-category-surface);
        }

        .view-category-card-content {
            flex: 1;
        }

        .view-category-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--view-category-primary);
            margin-bottom: 4px;
        }

        .view-category-card-link {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--view-category-text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: var(--view-category-transition);
        }

        .view-category-card:hover .view-category-card-link {
            color: var(--view-category-accent-hover);
        }

        .view-category-card-arrow {
            transition: transform 0.3s ease;
        }

        .view-category-card:hover .view-category-card-arrow {
            transform: translateX(4px);
        }

        .view-category-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: var(--view-category-surface);
            border-radius: 16px;
            border: 1px solid var(--view-category-border);
            display: none;
        }
        .view-category-empty-icon { color: var(--view-category-border); margin-bottom: 16px; }
        .view-category-empty h3 { font-size: 1.4rem; color: var(--view-category-primary); font-weight: 700; margin-bottom: 8px; }
        .view-category-empty p { color: var(--view-category-text-muted); }

        .view-category-footer { background: var(--view-category-primary); color: #F8FAFC; padding: 70px 0 30px; font-size: 0.95rem; }
        .view-category-footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; margin-bottom: 40px; }
        
        .view-category-footer-brand { margin-bottom: 20px; }
        .view-category-footer-brand span { color: var(--view-category-accent); }
        
        .view-category-footer h5 { color: var(--view-category-surface); font-size: 1.1rem; margin-bottom: 24px; font-weight: 700; }
        .view-category-footer ul { list-style: none; }
        .view-category-footer ul li { margin-bottom: 14px; }
        .view-category-footer ul li a { color: #94A3B8; text-decoration: none; transition: var(--view-category-transition); font-weight: 500; }
        .view-category-footer ul li a:hover { color: var(--view-category-accent); }
        
        .view-category-contact-item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; color: #94A3B8; }
        .view-category-contact-item i { color: var(--view-category-accent); margin-top: 3px; }
        
        .view-category-social { display: flex; gap: 16px; margin-top: 24px; }
        .view-category-social a { 
            width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.05); 
            display: flex; align-items: center; justify-content: center; color: var(--view-category-surface); 
            transition: var(--view-category-transition); 
        }
        .view-category-social a:hover { background: var(--view-category-accent); color: var(--view-category-primary); }
        
        .view-category-copyright { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 24px; text-align: center; color: #64748B; font-size: 0.85rem; }

        .view-category-scroll-top {
            position: fixed; bottom: 30px; right: 30px;
            background: var(--view-category-surface); color: var(--view-category-primary);
            width: 50px; height: 50px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid var(--view-category-border); cursor: pointer; z-index: 1000;
            box-shadow: var(--view-category-shadow-md);
            opacity: 0; visibility: hidden; transform: translateY(20px);
            transition: var(--view-category-transition);
        }
        .view-category-scroll-top.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .view-category-scroll-top:hover { background: var(--view-category-primary); color: var(--view-category-surface); transform: translateY(-5px); }

        .view-category-mobile-overlay { position: fixed; inset: 0; background: rgba(10,37,64,0.5); z-index: 1999; display: none; backdrop-filter: blur(3px); }
        .view-category-mobile-menu { position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: var(--view-category-surface); z-index: 2000; padding: 30px; transition: right 0.3s ease; display: flex; flex-direction: column; }
        .view-category-mobile-menu.active { right: 0; }
        .view-category-mobile-overlay.active { display: block; }

        @media (max-width: 992px) {
            .view-category-footer-grid { grid-template-columns: 1fr 1fr; }
            .view-category-hero-title { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            .view-category-top-bar { display: none; }
            .view-category-links, .view-category-actions { display: none; }
            .view-category-menu-toggle { display: block; }
            
            .view-category-hero { padding: 50px 0 80px; }
            .view-category-hero-title { font-size: 2rem; }
            
            .view-category-search-box { padding: 6px; }
            .view-category-search-icon { padding: 0 12px; }
            .view-category-search-btn { padding: 12px 20px; font-size: 0.9rem; }

            .view-category-footer-grid { grid-template-columns: 1fr; gap: 40px; }
        }
    </style>

<section class="view-category-hero">
    <div class="view-category-container">
        <h1 class="view-category-hero-title">Browse by Category</h1>
        <p class="view-category-hero-subtitle">Explore active tenders organized by industry and sector. Select a category below to narrow down your search and find relevant procurement opportunities.</p>
    </div>
</section>

<main class="view-category-container view-category-grid-section">
    <div class="view-category-search-wrapper">
        <div class="view-category-search-box">
            <i data-lucide="search" size="22" class="view-category-search-icon"></i>
            <input type="text" id="view-category-searchInput" class="view-category-search-input" placeholder="Search...">
            <button class="view-category-search-btn" onclick="filterCategories()">Search</button>
        </div>
    </div>

    <div class="view-category-grid" id="view-category-grid">
          @if($category_data->count() > 0)
            @foreach($category_data as $key => $value)
                <a href="#" class="view-category-card" data-category="{{ $value->name }}">
                    <div class="view-category-card-content">
                        <div class="view-category-card-title">{{ $value->name }}</div>
                        <div class="view-category-card-link" onclick="window.location.href='{{ route('stateresult', ['id' => $value->name]) }}'">View Tenders <i data-lucide="arrow-right" size="14" class="view-category-card-arrow"></i></div>
                    </div>    
                </a>
        @endforeach
        @else
            <div class="view-category-empty" id="view-category-empty">
                <i data-lucide="search-x" size="48" class="view-category-empty-icon"></i>
                <h3>No Categories Found</h3>
                <p>We couldn't find an industry or sector matching your search.</p>
            </div>
        @endif
    </div>
</main>

<button class="view-category-scroll-top" id="view-category-scrollBtn">
    <i data-lucide="arrow-up" size="20"></i>
</button>
@endsection
@section('scripts')
<script>

    lucide.createIcons();

    // Search Functionality
    const categorySearchInput = document.getElementById('view-category-searchInput');
    const categoryCards = document.querySelectorAll('.view-category-card');
    const categoryEmptyState = document.getElementById('view-category-empty');

    function filterCategories() {

        const query = categorySearchInput.value.toLowerCase().trim();

        let visibleCount = 0;

        categoryCards.forEach(card => {

            const categoryName = card.dataset.category.toLowerCase();

            if (categoryName.includes(query)) {

                card.style.display = 'flex';
                visibleCount++;

            } else {

                card.style.display = 'none';

            }

        });

        if (visibleCount === 0) {

            categoryEmptyState.style.display = 'block';

        } else {

            categoryEmptyState.style.display = 'none';

        }

    }

    // Live Search
    categorySearchInput.addEventListener('keyup', filterCategories);

    // Scroll Top Button
    const scrollBtn = document.getElementById('view-category-scrollBtn');

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