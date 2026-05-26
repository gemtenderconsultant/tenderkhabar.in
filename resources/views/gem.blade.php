@extends('layouts.app')
@section('content')

<style>
        :root {
            --primary: #0A2540;
            --accent: #F9BF29;
            --accent-grad: linear-gradient(135deg, #F9BF29 0%, #FF9F0A 100%);
            --royal-grad: linear-gradient(135deg, #0A2540 0%, #1A4971 100%);
            --glass: rgba(255, 255, 255, 0.75);
            --border: rgba(255, 255, 255, 0.8);
            --text-main: #0f172a;
            --text-muted: #475569;
            --shadow: 0 10px 30px rgba(10, 37, 64, 0.06);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
       
        .gem-service-container { 
            max-width: 1400px; 
            margin: 0 auto; 
            padding: 0 24px;
        }

        .gem-service-header { 
            text-align: center; 
                margin: 40px 0px;
            animation: fadeDown 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        }
        
        .gem-service-header .gem-service-badge { 
            display: inline-flex; 
            align-items: center;
            padding: 6px 16px; 
            background: rgba(255, 255, 255, 0.9); 
            border: 1px solid rgba(249, 191, 41, 0.4);
            border-radius: 100px; 
            font-size: 0.75rem; 
            font-weight: 800; 
            color: var(--primary);
            text-transform: uppercase; 
            letter-spacing: 2px; 
            margin-bottom: 16px; 
            box-shadow: 0 4px 12px rgba(249, 191, 41, 0.15);
            backdrop-filter: blur(10px);
        }

        .gem-service-header h1 { 
            font-size: clamp(2rem, 4vw, 3rem); 
            font-weight: 800; 
            color: var(--primary); 
            line-height: 1.1; 
            margin-bottom: 16px; 
            letter-spacing: -0.5px;
        }

        .gem-service-header h1 span { 
            background: var(--accent-grad); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            position: relative;
        }

        .gem-service-header p { 
            font-size: clamp(0.95rem, 1.5vw, 1.1rem); 
            color: var(--text-muted); 
            max-width: 700px; 
            margin: 0 auto; 
            font-weight: 500;
        }

        .gem-service-bento-grid { 
            display: grid; 
            grid-template-columns: repeat(12, 1fr); 
            gap: 20px; 
            grid-auto-rows: minmax(min-content, max-content);
        }

        .gem-service-card {
            background: var(--glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            border-radius: 20px; 
            padding: 24px; 
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.8s cubic-bezier(0.19, 1, 0.22, 1) forwards;
        }

        .gem-service-card:hover {
            transform: translateY(-4px) scale(1.005);
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(249, 191, 41, 0.5);
            box-shadow: 0 15px 30px rgba(10, 37, 64, 0.1), 
                        0 0 20px rgba(249, 191, 41, 0.08);
            z-index: 2;
        }

        .gem-service-card::before {
            content: ''; 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 4px; 
            background: var(--accent-grad); 
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        .gem-service-card:hover::before { 
            transform: scaleX(1); 
        }

        .gem-service-span-8 { grid-column: span 8; }
        .gem-service-span-6 { grid-column: span 6; }
        .gem-service-span-4 { grid-column: span 4; }
        .gem-service-span-12 { grid-column: span 12; }

        .gem-service-card:nth-child(1) { animation-delay: 0.1s; }
        .gem-service-card:nth-child(2) { animation-delay: 0.2s; }
        .gem-service-card:nth-child(3) { animation-delay: 0.3s; }
        .gem-service-card:nth-child(4) { animation-delay: 0.4s; }
        .gem-service-card:nth-child(5) { animation-delay: 0.5s; }
        .gem-service-card:nth-child(6) { animation-delay: 0.6s; }
        .gem-service-card:nth-child(7) { animation-delay: 0.7s; }

        .gem-service-icon-wrap {
            width: 48px; 
            height: 48px; 
            background: #ffffff; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.05), inset 0 0 0 1px rgba(0,0,0,0.05);
            color: var(--primary); 
            transition: all 0.4s cubic-bezier(0.19, 1, 0.22, 1);
        }
        
        .gem-service-card:hover .gem-service-icon-wrap { 
            background: var(--accent-grad); 
            color: white; 
            box-shadow: 0 8px 16px rgba(249, 191, 41, 0.25);
        }

        .gem-service-card h3 { 
            font-size: 0.75rem; 
            font-weight: 800; 
            color: var(--accent); 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            margin-bottom: 6px; 
        }

        .gem-service-card h2 { 
            font-size: clamp(1.2rem, 2vw, 1.5rem); 
            font-weight: 800; 
            color: var(--primary); 
            margin-bottom: 12px; 
            line-height: 1.2; 
            letter-spacing: -0.5px;
        }

        .gem-service-card p { 
            font-size: 0.9rem; 
            color: var(--text-muted); 
            margin-bottom: 20px; 
            font-weight: 500;
        }

        .gem-service-feature-list { 
            list-style: none; 
            margin-bottom: 20px; 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); 
            gap: 10px; 
        }
        
        .gem-service-feature-list li { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-weight: 700; 
            font-size: 0.85rem; 
            color: var(--primary); 
            background: rgba(255,255,255,0.5);
            padding: 8px 12px;
            border-radius: 8px; 
            border: 1px solid rgba(0,0,0,0.03);
            transition: 0.3s;
        }

        .gem-service-card:hover .gem-service-feature-list li {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        
        .gem-service-feature-list li i { color: #10b981; flex-shrink: 0; }

        /* --- CREATIVE FILLER BOXES FOR BLANK SPACE --- */
        .gem-service-creative-box {
            margin-top: auto; /* Pushes itself and the note box below to the bottom */
            margin-bottom: 20px;
            padding: 16px;
            background: linear-gradient(135deg, rgba(249, 191, 41, 0.05) 0%, rgba(249, 191, 41, 0.02) 100%);
            border-radius: 12px;
            border: 1px dashed rgba(249, 191, 41, 0.4);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .gem-service-creative-box h4 {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--primary);
            letter-spacing: 1px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .gem-service-creative-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 10px;
        }

        .gem-service-creative-item {
            background: white;
            padding: 10px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            border: 1px solid rgba(0,0,0,0.02);
        }

        .gem-service-creative-item i {
            color: var(--accent);
        }
        /* ------------------------------------------- */

        .gem-service-note-box {
            background: #f1f5f9; 
            padding: 16px; 
            border-radius: 12px; 
            border-left: 4px solid var(--accent); 
            font-size: 0.85rem; 
            font-weight: 600; 
            color: var(--text-muted);
            transition: 0.3s;
        }

        /* For cards without the creative box, note-box handles the push to bottom */
        .gem-service-card > .gem-service-note-box:first-of-type:not(:nth-child(2)) {
            margin-top: auto; 
        }
        
        .gem-service-note-box b { 
            display: inline-block; 
            color: #e11d48; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 1px; 
            margin-bottom: 0px;
            margin-right: 8px;
            background: rgba(225, 29, 72, 0.1);
            padding: 3px 8px;
            border-radius: 4px; 
            vertical-align: baseline;
        }

        .gem-service-card-dark { 
            background: var(--royal-grad); 
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: inset 0 0 60px rgba(0,0,0,0.15), var(--shadow);
        }
        
        .gem-service-card-dark:hover {
            background: linear-gradient(135deg, #0d2e4f 0%, #1e5482 100%);
            border-color: rgba(249, 191, 41, 0.3);
        }

        .gem-service-card-dark h2, .gem-service-card-dark p { color: white; }
        
        .gem-service-card-dark .gem-service-icon-wrap { 
            background: rgba(255,255,255,0.1); 
            color: white; 
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .gem-service-card-dark .gem-service-note-box { 
            background: rgba(0,0,0,0.2); 
            color: #e2e8f0; 
            border-left-color: var(--accent); 
        }
        
        .gem-service-card-dark .gem-service-note-box b { 
            color: var(--accent); 
            background: rgba(249, 191, 41, 0.15);
        }

        .gem-service-tag-wrap { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 8px; 
            margin-top: 16px;
        }
        
        .gem-service-tag { 
            background: rgba(255,255,255,0.1); 
            border: 1px solid rgba(255,255,255,0.2); 
            padding: 6px 14px; 
            border-radius: 100px; 
            font-size: 0.75rem; 
            font-weight: 700; 
            color: white; 
            backdrop-filter: blur(5px);
            transition: 0.3s;
        }

        .gem-service-card-dark:hover .gem-service-tag {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        .gem-service-quad-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 12px;
            margin-bottom: 20px; 
        }
        
        .gem-service-quad-box { 
            background: rgba(255,255,255,0.8); 
            padding: 16px; 
            border-radius: 12px; 
            border: 1px solid #e2e8f0; 
            text-align: center; 
            transition: 0.3s;
        }

        .gem-service-card:hover .gem-service-quad-box {
            background: white;
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.04);
        }
        
        .gem-service-quad-box span { 
            display: block; 
            font-weight: 800; 
            color: var(--accent); 
            font-size: 0.75rem; 
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        
        .gem-service-quad-box b { 
            font-size: 0.95rem; 
            color: var(--primary); 
            font-weight: 800;
        }
        @keyframes fadeUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 1100px) {
            .gem-service-bento-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .gem-service-span-8, .gem-service-span-6, .gem-service-span-4, .gem-service-span-12 { grid-column: span 2; }
            
            .gem-service-card { 
                text-align: center; 
                align-items: center; 
            }
            .gem-service-icon-wrap { 
                margin-left: auto; 
                margin-right: auto; 
            }
            .gem-service-feature-list { 
                width: 100%; 
            }
            .gem-service-feature-list li { 
                justify-content: flex-start; 
                text-align: left;            
            }
            .gem-service-tag-wrap { 
                justify-content: center; 
            }
            .gem-service-note-box { 
                text-align: center; 
            }
            .gem-service-card-dark > div, 
            .gem-service-card-dark > div > div {
                align-items: center !important;
                text-align: center !important;
            }
            .gem-service-card > div[style*="display: grid"] {
                width: 100%;
                justify-content: center;
            }
            /* Adjust creative grid for mobile */
            .gem-service-creative-box { width: 100%; }
            .gem-service-creative-box h4 { justify-content: center; }
        }
        @media (max-width: 768px) {
            body { padding: 30px 0; }
            .gem-service-bento-grid { grid-template-columns: 1fr; }
            .gem-service-span-8, .gem-service-span-6, .gem-service-span-4, .gem-service-span-12 { grid-column: span 1; }
            .gem-service-card { padding: 20px; border-radius: 16px; }
            .gem-service-icon-wrap { width: 44px; height: 44px; margin-bottom: 16px; }
            .gem-service-feature-list { grid-template-columns: 1fr; }
            .gem-service-quad-grid { grid-template-columns: 1fr; }
            
            .gem-service-card-dark > div { gap: 20px !important; }
        }

        @media (max-width: 480px) {
            .gem-service-container { padding: 0 16px; }
            .gem-service-header .gem-service-badge { font-size: 0.65rem; padding: 6px 12px; }
            .gem-service-card { padding: 16px; border-radius: 12px; }
            .gem-service-card h2 { font-size: 1.15rem; }
            .gem-service-note-box { padding: 12px; font-size: 0.75rem; }
            .gem-service-tag { padding: 6px 12px; font-size: 0.7rem; }
        }
</style>
<div class="gem-service-container">
    <header class="gem-service-header">
        <h1>Mastering the <span>GeM Marketplace</span></h1>
        <p>Your strategic partner for end-to-end GeM lifecycle management. We simplify complex procurement hurdles into seamless business growth.</p>
    </header>

    <div class="gem-service-bento-grid">
        
        <!-- 01 SELLER REGISTRATION -->
        <div class="gem-service-card gem-service-span-8">
            <div class="gem-service-icon-wrap"><i data-lucide="user-check" size="24"></i></div>
            <div>
                <h3>Streamlined Vendor Onboarding Process</h3>
                <h2>Seller Registration</h2>
                <p>By validation of your documents and details you will be able to sell on gem portal.</p>
            </div>
            <ul class="gem-service-feature-list">
                <li><i data-lucide="check-circle" size="16"></i> GeM Registration Assistance</li>
                <li><i data-lucide="check-circle" size="16"></i> Profile Optimization</li>
                <li><i data-lucide="check-circle" size="16"></i> Compliance Management</li>
            </ul>

            <div class="gem-service-creative-box">
                <h4><i data-lucide="zap" size="16"></i> Onboarding Fast-Track</h4>
                <div class="gem-service-creative-grid">
                    <div class="gem-service-creative-item"><i data-lucide="clock" size="16"></i> Swift Turnaround</div>
                    <div class="gem-service-creative-item"><i data-lucide="shield-check" size="16"></i> Zero Rejections</div>
                    <div class="gem-service-creative-item"><i data-lucide="bar-chart-3" size="16"></i> Max Trust Score</div>
                </div>
            </div>

            <div class="gem-service-note-box" style="margin-top: 0;">
                We will handle your registration process; you only need to provide documents we ask.
            </div>
        </div> 
        
        <!-- 02 VENDOR ASSESSMENT -->
        <div class="gem-service-card gem-service-span-4">
            <div class="gem-service-icon-wrap"><i data-lucide="clipboard-list" size="24"></i></div>
            <div>
                <h3>Vendor Assessment & Compliance Support</h3>
                <h2>Vendor Assesment</h2>
                <p>Vendor Assessment is an essential process to evaluate a supplier’s capability, reliability, and compliance with industry standards. It ensures that manufacturers, importers, or third-party producers meet the required quality, infrastructure, and operational benchmarks before approval.</p>
            </div>
            <ul class="gem-service-feature-list" style="grid-template-columns: 1fr;">
                <li><i data-lucide="monitor" size="16"></i> Desktop Assessment (Evaluation of submitted documents and certifications)</li>
                <li><i data-lucide="video" size="16"></i> Video Assessment (Virtual inspection of production facility and processes)</li>
            </ul>
            <div class="gem-service-note-box" style="margin-top: auto;">
                <b>Note:</b> For desktop assessment, detailed documentation related to your manufacturing setup, quality control, and process flow will be required. Our team will guide you through the requirements and share reference formats where applicable, but document preparation will remain the applicant’s responsibility.
            </div>
        </div>
        

        <!-- 03 VAE EXEMPTION -->
        <div class="gem-service-card gem-service-span-12 gem-service-card-dark">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; height: 100%;">
                <div style="flex: 1; min-width: 250px; display: flex; flex-direction: column;">
                    <div class="gem-service-icon-box"><div class="gem-service-icon-wrap"><i data-lucide="shield-check" size="24"></i></div></div>
                    <h3>Exemption from Vendor Assessment Criteria</h3>
                    <h2>Vendor Assessment Exemption</h2>
                    <p>If you have documentation according to Vendor assessment exemption policy than we can claim your VAE:</p>
                </div>
                <div style="flex: 1; min-width: 250px; display: flex; flex-direction: column; justify-content: center;">
                    <div class="gem-service-tag-wrap" style="margin-top: 0; display: flex; flex-direction: column;">
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">OEMs holding BIS License for the product category</span>
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">Vaccine manufacturer as per list provided by Ministry of Health & Family Welfare</span>
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">Drugs/Medicine manufacturer with "Notarized Undertaking" & "Valid certified copy of Drug Licenses from the issuing/concerned Drug Authority"</span>
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">Medical Device manufacturer with "Valid Manufacturing License” from the issuing Licensing Authority</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 04 OEM PANEL & BRAND -->
        <div class="gem-service-card gem-service-span-6">
            <div class="gem-service-icon-wrap"><i data-lucide="award" size="24"></i></div>
            <div>
                <h3>OEM Panel Creation & Brand Accreditation</h3>
                <h2>OEM Panel Creation / Brand Approval</h2>
                <p>We can help you register your brands on GeM portal.<br><br>
                If you are Manufacturer and your Vendor assessment / Vendor Assessment Exemption is approved than to receive OEM benefits and access, you must claim OEM dashboard with your brand with 2 options:<br>
                1. Trademark<br>
                2. Notarized undertaking for brand.<br><br>
                If you are a reseller and your manufacturer is not available on gem, then you can apply their brand with their registered trademark.</p>
            </div>
            
            <!-- CREATIVE FILLER 2 -->
            <div class="gem-service-creative-box">
                <h4><i data-lucide="crown" size="16"></i> OEM Dashboard Perks</h4>
                <div class="gem-service-creative-grid" style="grid-template-columns: repeat(2, 1fr);">
                    <div class="gem-service-creative-item"><i data-lucide="users" size="16"></i> Reseller Control</div>
                    <div class="gem-service-creative-item"><i data-lucide="lock" size="16"></i> Brand Protection</div>
                    <div class="gem-service-creative-item"><i data-lucide="shopping-cart" size="16"></i> Direct Orders</div>
                    <div class="gem-service-creative-item"><i data-lucide="trending-up" size="16"></i> Q1/Q2 Priority</div>
                </div>
            </div>

            <div class="gem-service-note-box" style="margin-top: 0;">
                <b>Note:</b> Trademark is required registered only to apply brand / OEM dashboard.
            </div>
        </div>

        <!-- 05 CATALOGUING -->
        <div class="gem-service-card gem-service-span-6">
            <div class="gem-service-icon-wrap"><i data-lucide="layout-grid" size="24"></i></div>
            <div>
                <h3>End-to-End Product/Service Cataloguing</h3>
                <h2>Products / Service Cataloguing</h2>
                <p>We will help you your product / service catalogue on GeM portal.<br><br>GeM has quadrant policy and according to that:</p>
            </div>
            <div class="gem-service-quad-grid" style="grid-template-columns: 1fr;">
                <div class="gem-service-quad-box" style="text-align: left; display: flex; flex-direction: column;">
                    <span>Q1 Quadrant</span><b style="font-size: 0.85rem; font-weight: 600;">allows only manufacturers to list and sell products.</b>
                </div>
                <div class="gem-service-quad-box" style="text-align: left; display: flex; flex-direction: column;">
                    <span>Q2 Quadrant</span><b style="font-size: 0.85rem; font-weight: 600;">allows only manufacturers to list and sell products, and for reseller with OEM’s authorization code can sell their listed products.</b>
                </div>
                <div class="gem-service-quad-box" style="text-align: left; display: flex; flex-direction: column;">
                    <span>Q3 and Q4 Quadrant</span><b style="font-size: 0.85rem; font-weight: 600;">allows resellers and manufacturers to list and sell products.</b>
                </div>
            </div>
            <div class="gem-service-note-box" style="margin-top: auto;">
                <b>Note:</b> To list any product requires product specification according to category, and if category is not available then product can’t be uploaded.<br><br>
                <b>Note:</b> If any category mandatory requires any license number or test report number with any details then you must provide it accordingly. If those details are not provided, then cataloguing will be not possible.
            </div>
        </div>

        <!-- 06 TENDER BIDDING -->
        <div class="gem-service-card gem-service-span-8">
            <div class="gem-service-icon-wrap"><i data-lucide="gavel" size="24"></i></div>
            <div>
                <h3>Expert-Led Tender Bidding Assistance</h3>
                <h2>Tenders Bidding</h2>
                <p>We understand the business and profile of the customer, as our service is personalized service, we assign a dedicated personal manager to the user, who manages the following tasks for the customer:</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                <ul class="gem-service-feature-list" style="grid-template-columns: 1fr; margin-bottom: 0;">
                    <li><i data-lucide="check" size="16"></i> Study whole document and prepare a summary</li>
                    <li><i data-lucide="check" size="16"></i> Applying product which is required in bid</li>
                    <li><i data-lucide="check" size="16"></i> Collecting documents required for bid participation</li>
                    <li><i data-lucide="check" size="16"></i> Helping understand requirements and how to prepare docs</li>
                </ul>
                <ul class="gem-service-feature-list" style="grid-template-columns: 1fr; margin-bottom: 0;">
                    <li><i data-lucide="check" size="16"></i> Department coordination and follow-up</li>
                    <li><i data-lucide="check" size="16"></i> Uploading tender documents and submission</li>
                    <li><i data-lucide="check" size="16"></i> Reverse auction participation if needed</li>
                    <li><i data-lucide="check" size="16"></i> EMD Refund follow-up</li>
                </ul>
            </div>
            <div class="gem-service-note-box" style="margin-top: auto;">
                <b>Note:</b> Consultancy fees exclude govt charges like EMD, tender document fee, courier etc. Paid by customer.<br><br>
                <b>Note:</b> We will not create/draft any annexures or documents. We only guide.
            </div>
        </div>

        <!-- 07 ORDER PROCESSING -->
        <div class="gem-service-card gem-service-span-4">
            <div class="gem-service-icon-wrap"><i data-lucide="package-check" size="24"></i></div>
            <div>
                <h3>Complete Post-Bid Order Processing & Compliance</h3>
                <h2>Order Processing</h2>
                <p>If you have received any order than further processes will be done from our side like:</p>
            </div>
            <ul class="gem-service-feature-list" style="grid-template-columns: 1fr;">
                <li><i data-lucide="send" size="16"></i> Submitting invoice for received order</li>
                <li><i data-lucide="send" size="16"></i> Submitting ePBG if required</li>
                <li><i data-lucide="send" size="16"></i> Guidance for milestone/transactional charges</li>
                <li><i data-lucide="send" size="16"></i> Taking follow up for payment on customer’s behalf</li>
            </ul>
            <div class="gem-service-note-box" style="margin-top: auto;">
                <b>Note:</b> Consultancy fees exclude any government fees / charges like Milestone / Transactional / Late Delivery etc.
            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')

<script>
    lucide.createIcons();
</script>
@endsection