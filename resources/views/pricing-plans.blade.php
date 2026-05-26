@extends('layouts.app')
@section('content')
<style>
        /* --- GLOBAL VARIABLES (From Index) --- */
        :root {
            --primary-blue: #0A2540;
            --primary-gradient: linear-gradient(135deg, #0A2540 0%, #1A4971 100%);
            --accent-yellow: #F9BF29;
            --accent-gradient: linear-gradient(135deg, #F9BF29 0%, #FF9F0A 100%);
            --text-dark: #0f172a;
            --text-muted: #475569;
            --white: #ffffff;
            --glass-bg: rgba(255, 255, 255, 0.65);
            --glass-border: rgba(255, 255, 255, 0.5);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Manrope', sans-serif; 
            color: var(--text-dark); 
            line-height: 1.5; 
            background-color: #f8fafc;
            overflow-x: hidden;
            position: relative;
        }

        /* --- GLOBAL TEXTURE & SHAPES (From Index) --- */
        .index-texture-overlay {
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 9999;
        }

        .index-bg-shapes { position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; }
        .index-shape { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.6; animation: index-float 20s infinite alternate; }
        .index-shape-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: rgba(59, 130, 246, 0.4); }
        .index-shape-2 { top: 40%; right: -10%; width: 40vw; height: 40vw; background: rgba(249, 191, 41, 0.3); animation-delay: -5s; }
        .index-shape-3 { bottom: -20%; left: 20%; width: 60vw; height: 60vw; background: rgba(147, 51, 234, 0.2); animation-delay: -10s; }

        @keyframes index-float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        .index-container { max-width: 1280px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 10; }
        .index-text-gradient { background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .index-text-gradient-yellow { background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* --- TOP BAR & HEADER (From Index) --- */
        .index-top-bar { background: rgba(10, 37, 64, 0.95); backdrop-filter: blur(10px); padding: 10px 0; font-size: 0.8rem; font-weight: 600; color: var(--white); }
        .index-top-bar .index-container { display: flex; justify-content: space-between; align-items: center; }
        .index-top-bar a { color: var(--accent-yellow); text-decoration: none; }
        .index-top-info { display: flex; gap: 20px; align-items: center; }

        .index-header { 
            background: var(--glass-bg); backdrop-filter: blur(16px); padding: 10px 0; border-bottom: 1px solid var(--glass-border); 
            position: sticky; top: 0; z-index: 1000; box-shadow: var(--glass-shadow);
        }
        .index-nav-wrap { display: flex; justify-content: space-between; align-items: center; }
        .index-logo { font-size: 1.6rem; font-weight: 800; text-decoration: none; color: var(--primary-blue); display: flex; align-items: center; gap: 5px; }
        .index-logo span { color: var(--accent-yellow); } 

        .index-nav-links { display: flex; gap: 25px; }
        .index-nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 700; font-size: 0.9rem; transition: var(--transition); position: relative; }
        .index-nav-links a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background: var(--accent-gradient); transition: var(--transition); }
        .index-nav-links a:hover::after { width: 100%; }
        .index-nav-links a:hover { color: var(--primary-blue); }

        .index-auth-btns { display: flex; gap: 10px; }
        .index-btn { padding: 10px 22px; border-radius: 8px; font-weight: 800; cursor: pointer; border: none; font-size: 0.85rem; transition: var(--transition); display: inline-flex; align-items: center; justify-content: center; gap: 6px; }
        .index-btn-login { background: rgba(255,255,255,0.7); border: 1px solid var(--primary-blue); color: var(--primary-blue); backdrop-filter: blur(5px); }
        .index-btn-login:hover { background: var(--primary-blue); color: white; }
        .index-btn-reg { background: var(--accent-gradient); color: #000; box-shadow: 0 8px 15px rgba(249, 191, 41, 0.3); }
        .index-btn-reg:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(249, 191, 41, 0.4); }

        /* HAMBURGER */
        .index-menu-toggle { display: none; background: none; border: none; cursor: pointer; color: var(--primary-blue); }
        .index-mobile-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1999; display: none; backdrop-filter: blur(4px); }
        .index-mobile-menu { 
            position: fixed; top: 0; right: -100%; width: 280px; height: 100vh; background: white; 
            z-index: 2000; padding: 40px 30px; transition: 0.4s ease; box-shadow: -10px 0 30px rgba(0,0,0,0.1);
            display: flex; flex-direction: column; gap: 20px;
        }
        .index-mobile-menu.active { right: 0; }
        .index-mobile-overlay.active { display: block; }
        .index-mobile-menu a { font-size: 1.1rem; font-weight: 700; text-decoration: none; color: var(--primary-blue); border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; }

        /* --- PRICING PLAN STYLES --- */
        .pricing-plan-section { padding: 60px 0 80px; }
        
        .index-section-header { text-align: center; margin-bottom: 50px; animation: pricing-plan-fadeDown 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards; }
        .index-section-header h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.1; margin-bottom: 16px; color: var(--primary-blue); }
        .index-section-header p { font-size: clamp(0.95rem, 1.5vw, 1.1rem); color: var(--text-muted); max-width: 700px; margin: 0 auto; font-weight: 500; }
        
        .pricing-plan-badge { 
            display: inline-flex; align-items: center; padding: 8px 20px; 
            background: var(--glass-bg); border: 1px solid var(--glass-border); border-radius: 100px; 
            font-size: 0.75rem; font-weight: 800; color: var(--primary-blue); text-transform: uppercase; 
            letter-spacing: 2px; margin-bottom: 20px; box-shadow: var(--glass-shadow); backdrop-filter: blur(10px);
        }

        .pricing-plan-grid { 
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; align-items: stretch;
        }

        /* Glassmorphism Uniform Cards */
        .pricing-plan-card {
            background: var(--glass-bg); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border); border-radius: 24px; padding: 40px 30px; 
            box-shadow: var(--glass-shadow); transition: var(--transition);
            position: relative; display: flex; flex-direction: column;
            opacity: 0; transform: translateY(20px); animation: pricing-plan-fadeUp 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        }

        .pricing-plan-card:hover {
            transform: translateY(-5px); background: rgba(255, 255, 255, 0.85);
            border-color: rgba(249, 191, 41, 0.4); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06), 0 0 20px rgba(249, 191, 41, 0.1);
        }

        .pricing-plan-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; 
            background: var(--accent-gradient); transform: scaleX(0); transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.19, 1, 0.22, 1); border-radius: 24px 24px 0 0;
        }
        
        .pricing-plan-card:hover::before { transform: scaleX(1); }

        .pricing-plan-card:nth-child(1) { animation-delay: 0.1s; }
        .pricing-plan-card:nth-child(2) { animation-delay: 0.2s; }
        .pricing-plan-card:nth-child(3) { animation-delay: 0.3s; }

        .pricing-plan-title { font-size: 1.6rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 8px; }
        .pricing-plan-desc { font-size: 0.95rem; color: var(--text-muted); margin-bottom: 30px; font-weight: 500; }

        .pricing-plan-features { list-style: none; margin-bottom: 40px; }
        .pricing-plan-features li { display: flex; align-items: flex-start; gap: 12px; font-weight: 600; font-size: 0.95rem; margin-bottom: 16px; color: var(--text-dark); }
        .pricing-plan-features li i { color: #10b981; flex-shrink: 0; margin-top: 2px; }

        /* Symmetrical Dual Panel inside Glass Card */
        .pricing-plan-dual-panel {
            display: flex; background: rgba(255,255,255,0.7); border: 1px solid var(--glass-border);
            border-radius: 16px; margin-top: auto; overflow: hidden;
        }

        .pricing-plan-price-col {
            flex: 1; display: flex; flex-direction: column; align-items: center; text-align: center;
            padding: 24px 16px; transition: var(--transition);
        }

        .pricing-plan-price-col:first-child { border-right: 1px solid var(--glass-border); }
        .pricing-plan-price-col:hover { background: rgba(255,255,255,0.95); }

        .pricing-plan-term { font-size: 0.8rem; font-weight: 800; color: var(--primary-blue); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
        .pricing-plan-cost { font-size: 1.75rem; font-weight: 800; color: var(--text-dark); line-height: 1; margin-bottom: 6px; letter-spacing: -0.5px; }
        .pricing-plan-tax { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); margin-bottom: 20px; }

        .pricing-plan-price-col .index-btn { width: 100%; font-size: 0.85rem; padding: 12px 10px; }

        /* Trust Banner adapted to Glassmorphism */
        .pricing-plan-creative-banner {
            margin-top: 60px; background: var(--glass-bg); backdrop-filter: blur(16px);
            border-radius: 20px; padding: 32px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;
            border: 1px solid var(--glass-border); box-shadow: var(--glass-shadow);
            opacity: 0; transform: translateY(20px); animation: pricing-plan-fadeUp 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards; animation-delay: 0.5s;
        }

        .pricing-plan-creative-item { display: flex; align-items: center; gap: 16px; }
        .pricing-plan-creative-icon {
            width: 52px; height: 52px; background: rgba(255,255,255,0.8); border: 1px solid var(--glass-border);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            color: var(--accent-yellow); flex-shrink: 0; transition: var(--transition);
        }
        .pricing-plan-creative-item:hover .pricing-plan-creative-icon { background: rgba(249, 191, 41, 0.1); border-color: rgba(249, 191, 41, 0.3); transform: scale(1.05); }

        .pricing-plan-creative-item div h4 { font-size: 0.95rem; font-weight: 800; color: var(--primary-blue); margin-bottom: 4px; }
        .pricing-plan-creative-item div p { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }

        /* --- FOOTER (From Index) --- */
        .index-footer { background: var(--primary-gradient); color: white; padding: 60px 0 20px; font-size: 0.9rem; }
        .index-footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1.5fr; gap: 30px; margin-bottom: 40px; }
        .index-footer-col h5 { font-size: 1.1rem; margin-bottom: 20px; color: var(--accent-yellow); font-weight: 800; display: inline-block; position: relative; }
        .index-footer-col h5::after { content:''; position:absolute; bottom:-8px; left:0; width:30px; height:2px; background:var(--accent-gradient); }
        .index-footer-col ul { list-style: none; }
        .index-footer-col ul li { margin-bottom: 12px; }
        .index-footer-col ul li a { color: #e2e8f0; text-decoration: none; transition: 0.3s; display: flex; align-items: center; gap: 8px; font-weight: 500; }
        .index-contact-block { margin-bottom: 15px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); }
        .index-contact-block h6 { color: var(--accent-yellow); font-size: 0.95rem; margin-bottom: 8px; font-weight: 700; }
        .index-contact-block p { color: #f8fafc; display: flex; align-items: flex-start; gap: 10px; margin-bottom: 6px; font-size: 0.85rem; }
        .index-social-links { display: flex; gap: 12px; }
        .index-social-links a { color: var(--primary-blue); background: var(--white); width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .index-footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; text-align: center; color: #cbd5e1; }

        /* Animations */
        @keyframes pricing-plan-fadeUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes pricing-plan-fadeDown { 0% { opacity: 0; transform: translateY(-20px); } 100% { opacity: 1; transform: translateY(0); } }

        /* --- RESPONSIVE MEDIA QUERIES --- */
        @media (max-width: 1200px) {
            .pricing-plan-grid { grid-template-columns: repeat(2, 1fr); }
            .pricing-plan-card:nth-child(3) { grid-column: span 2; max-width: 600px; margin: 0 auto; width: 100%; }
            .pricing-plan-creative-banner { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 992px) {
            .index-footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 850px) {
            .pricing-plan-card:nth-child(3) { max-width: 100%; }
        }

        @media (max-width: 768px) {
            /* Navbar Fix */
            .index-top-bar .index-container { flex-direction: column; gap: 10px; text-align: center; }
            .index-top-info { flex-direction: column; gap: 5px; }
            .index-nav-links, .index-auth-btns { display: none; }
            .index-menu-toggle { display: block; }
            
            /* Pricing Fix */
            .pricing-plan-section { padding: 40px 0; }
            .pricing-plan-grid { grid-template-columns: 1fr; gap: 24px; }
            .pricing-plan-card:nth-child(3) { grid-column: span 1; }
            .pricing-plan-card { padding: 32px 24px; }
            .pricing-plan-creative-banner { grid-template-columns: 1fr; gap: 24px; padding: 24px; }

            /* Footer Fix */
            .index-footer { text-align: center; }
            .index-footer-grid { grid-template-columns: 1fr; gap: 40px; }
            .index-footer-col { display: flex; flex-direction: column; align-items: center; }
            .index-footer-col h5::after { left: 50%; transform: translateX(-50%); }
            .index-footer-col ul li a { justify-content: center; }
            .index-social-links { justify-content: center; }
            .index-contact-block { width: 100%; }
            .index-contact-block p { justify-content: center; }
        }

        @media (max-width: 480px) {
            .pricing-plan-dual-panel { flex-direction: column; }
            .pricing-plan-price-col:first-child { border-right: none; border-bottom: 1px solid var(--glass-border); }
            .pricing-plan-price-col { padding: 20px 16px; }
            .pricing-plan-cost { font-size: 1.5rem; }
        }
    </style>
<section class="pricing-plan-section index-container">
    
    <div class="index-section-header">
        <span class="pricing-plan-badge"><i data-lucide="shield-check" size="16" style="margin-right: 8px; color: var(--accent-yellow);"></i> Simple & Transparent</span>
        <h1>Choose Your <span class="index-text-gradient">Coverage Area</span></h1>
        <p>Select the plan that matches your business reach. All features are consistently provided to ensure maximum bidding success.</p>
    </div>

    <div class="pricing-plan-grid">
        <!-- Plan 1: Single State -->
        <div class="pricing-plan-card">
            <h3 class="pricing-plan-title">Single State</h3>
            <p class="pricing-plan-desc">Perfect for localized businesses starting out.</p>
            <ul class="pricing-plan-features">
                <li><i data-lucide="check-circle" size="18"></i> 1 State Coverage</li>
                <li><i data-lucide="check-circle" size="18"></i> Basic Tender Alerts</li>
                <li><i data-lucide="check-circle" size="18"></i> Email Support</li>
                <li><i data-lucide="check-circle" size="18"></i> Document Upload Assistance</li>
                <li><i data-lucide="check-circle" size="18"></i> Mobile Application Access</li>
            </ul>

            <div class="pricing-plan-dual-panel">
                <div class="pricing-plan-price-col">
                    <span class="pricing-plan-term">1 Year</span>
                    <div class="pricing-plan-cost">₹5,900</div>
                    <span class="pricing-plan-tax">(Incl. GST)</span>
                    <a href="javascript:void(0)" onclick="payNow('Single State - 1 Yr', 1)" class="index-btn index-btn-login btn-pay">Pay Now</a>
                </div>
                <div class="pricing-plan-price-col">
                    <span class="pricing-plan-term">2 Years</span>
                    <div class="pricing-plan-cost">₹8,850</div>
                    <span class="pricing-plan-tax">(Incl. GST)</span>
                    <a href="javascript:void(0)" onclick="payNow('Single State - 2 Yr', 8850)" class="index-btn index-btn-reg btn-pay">Pay Now</a>
                </div>
            </div>
        </div>

        <!-- Plan 2: Five States -->
        <div class="pricing-plan-card">
            <h3 class="pricing-plan-title">Five States</h3>
            <p class="pricing-plan-desc">Ideal for growing companies expanding reach.</p>
            <ul class="pricing-plan-features">
                <li><i data-lucide="check-circle" size="18"></i> 5 States Coverage</li>
                <li><i data-lucide="check-circle" size="18"></i> Standard Tender Alerts</li>
                <li><i data-lucide="check-circle" size="18"></i> Phone & Email Support</li>
                <li><i data-lucide="check-circle" size="18"></i> Document Submission Help</li>
                <li><i data-lucide="check-circle" size="18"></i> Mobile Application Access</li>
            </ul>
            <div class="pricing-plan-dual-panel">
                <div class="pricing-plan-price-col">
                    <span class="pricing-plan-term">1 Year</span>
                    <div class="pricing-plan-cost">₹8,260</div>
                    <span class="pricing-plan-tax">(Incl. GST)</span>
                    <a href="javascript:void(0)" onclick="payNow('Five State - 1 Yr', 8260)" class="index-btn index-btn-login btn-pay">Pay Now</a>
                </div>
                <div class="pricing-plan-price-col">
                    <span class="pricing-plan-term">2 Years</span>
                    <div class="pricing-plan-cost">₹11,800</div>
                    <span class="pricing-plan-tax">(Incl. GST)</span>
                    <a href="javascript:void(0)" onclick="payNow('Five State - 2 Yr', 11800)" class="index-btn index-btn-reg btn-pay">Pay Now</a>
                </div>
            </div>
        </div>
 
        <!-- Plan 3: All India -->
        <div class="pricing-plan-card">
            <h3 class="pricing-plan-title">All India</h3>
            <p class="pricing-plan-desc">For enterprise leaders dominating the market.</p>
            <ul class="pricing-plan-features">
                <li><i data-lucide="check-circle" size="18"></i> All India Coverage</li>
                <li><i data-lucide="check-circle" size="18"></i> Premium Tender Alerts</li>
                <li><i data-lucide="check-circle" size="18"></i> Dedicated Account Manager</li>
                <li><i data-lucide="check-circle" size="18"></i> Complete Bidding Support</li>
                <li><i data-lucide="check-circle" size="18"></i> Mobile Application Access</li>
            </ul>
            <div class="pricing-plan-dual-panel">
                <div class="pricing-plan-price-col">
                    <span class="pricing-plan-term">1 Year</span>
                    <div class="pricing-plan-cost">₹11,800</div>
                    <span class="pricing-plan-tax">(Incl. GST)</span>
                    <a href="javascript:void(0)" onclick="payNow('All India - 1 Yr', 11800)" class="index-btn index-btn-login btn-pay">Pay Now</a>
                </div>
                <div class="pricing-plan-price-col">
                    <span class="pricing-plan-term">2 Years</span>
                    <div class="pricing-plan-cost">₹17,700</div>
                    <span class="pricing-plan-tax">(Incl. GST)</span>
                    <a href="javascript:void(0)" onclick="payNow('All India - 2 Yr', 17700)" class="index-btn index-btn-reg btn-pay">Pay Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- SaaS Trust Banner -->
    <div class="pricing-plan-creative-banner">
        <div class="pricing-plan-creative-item">
            <div class="pricing-plan-creative-icon"><i data-lucide="lock" size="24"></i></div>
            <div>
                <h4>Bank-Grade Security</h4>
                <p>256-bit encrypted transactions</p>
            </div>
        </div>
        <div class="pricing-plan-creative-item">
            <div class="pricing-plan-creative-icon"><i data-lucide="zap" size="24"></i></div>
            <div>
                <h4>Instant Setup</h4>
                <p>Get bidding within 24 hours</p>
            </div>
        </div>
        <div class="pricing-plan-creative-item">
            <div class="pricing-plan-creative-icon"><i data-lucide="file-check-2" size="24"></i></div>
            <div>
                <h4>Data Privacy</h4>
                <p>100% compliant & secure</p>
            </div>
        </div>
        <div class="pricing-plan-creative-item">
            <div class="pricing-plan-creative-icon"><i data-lucide="headphones" size="24"></i></div>
            <div>
                <h4>Expert Support</h4>
                <p>Guided by procurement pros</p>
            </div>
        </div>
    </div>
    <form id="payuRedirect" method="POST" action="{{ route('payment.payu') }}" style="display:none;">
        @csrf
        <input type="hidden" name="plan">
        <input type="hidden" name="amount">
    </form>
</section>
@endsection
@section('scripts')

<script>
    lucide.createIcons();
</script>
<script>
function payNow(plan, amount) {
    const form = document.getElementById('payuRedirect');
    form.plan.value = plan;
    form.amount.value = amount;
    form.submit();
}
</script>
@endsection