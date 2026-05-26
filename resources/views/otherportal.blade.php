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

        .gem-service-creative-box {
            margin-top: auto;
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
        <span class="gem-service-badge"><i data-lucide="gavel" size="14" style="margin-right: 6px;"></i> Tender & Portal Management</span>
        <h1>Premium <span>Tender Bidding Services</span></h1>
        <p>Expert assistance for multi-portal procurement, personalized bidding strategies, and seamless vendor empanelment designed to scale your business.</p>
    </header>

    <div class="gem-service-bento-grid">
        
        <!-- 01 TENDERS BIDDING -->
        <div class="gem-service-card gem-service-span-12">
            <div class="gem-service-icon-wrap"><i data-lucide="file-text" size="24"></i></div>
            <div>
                <h3>Personalized Tender Support</h3>
                <h2>Tenders Bidding</h2>
                <p>We understand the business and profile of the customer, as our service is a personalized service, we assign a dedicated personal manager to the user, who manages the following tasks for the customer whenever the customer sends a tender they want to bid.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-bottom: 20px; width: 100%;">
                <ul class="gem-service-feature-list" style="margin-bottom: 0; grid-template-columns: 1fr;">
                    <li><i data-lucide="book-open" size="16"></i> Study whole document and prepare a summary that includes eligibility criteria, Department requirement, payment terms and condition. This helps customers to identify the right tender for bidding.</li>
                    <li><i data-lucide="folder" size="16"></i> Collecting documents from you which are required for vendor registration.</li>
                    <li><i data-lucide="user-check" size="16"></i> Proceeding for vendor registration with customer credentials.</li>
                    <li><i data-lucide="headphones" size="16"></i> Taking follow-up with the department for any query. Also becoming a bridge between the user and department.</li>
                </ul>
                <ul class="gem-service-feature-list" style="margin-bottom: 0; grid-template-columns: 1fr;">
                    <li><i data-lucide="help-circle" size="16"></i> Helping you to understand the document requirements, how to prepare documentations.</li>
                    <li><i data-lucide="upload-cloud" size="16"></i> Uploading the document for tendering, submitting tender online. If required, also taking part in a reverse auction for the customer.</li>
                    <li><i data-lucide="award" size="16"></i> If the position is L1 then supporting customer to get Purchase order & also taking the follow up for payment on behalf of the customer.</li>
                    <li><i data-lucide="refresh-cw" size="16"></i> And if the customer did not win then also taking the follow up for EMD Refund on behalf of the customer.</li>
                </ul>
            </div>

            <div class="gem-service-note-box" style="margin-top: 0;">
                <b>Note:</b> Our consultancy fees are for above mentioned scope of work and do not include any government fees / charges. Whatever fees for registration on any procurement portal, tender document fee / processing fee, EMD, bid security, courier charges or any other charges will be paid by you (customer).
            </div>
        </div> 
        
        <!-- 02 VENDOR REGISTRATION -->
        <div class="gem-service-card gem-service-span-6">
            <div class="gem-service-icon-wrap"><i data-lucide="globe" size="24"></i></div>
            <div>
                <h3>Procurement Portal Registration</h3>
                <h2>Vendor Registration</h2>
                <p>We can register you on any procurement portal for submitting your bids. Each procurement portal has a different process of registration and according to their requirement and process we collect documents from you and process accordingly.</p>
            </div>
            
            <ul class="gem-service-feature-list" style="grid-template-columns: 1fr;">
                <li><i data-lucide="key" size="16"></i> DSC Mapping & System Integration</li>
                <li><i data-lucide="settings" size="16"></i> Advanced Browser Configuration Setup</li>
            </ul>

            <div class="gem-service-creative-box">
                <h4><i data-lucide="zap" size="16"></i> Portal Readiness</h4>
                <div class="gem-service-creative-grid" style="grid-template-columns: repeat(2, 1fr);">
                    <div class="gem-service-creative-item"><i data-lucide="check-circle" size="16"></i> Multi-Portal Setup</div>
                    <div class="gem-service-creative-item"><i data-lucide="shield" size="16"></i> Secure Access</div>
                </div>
            </div>

            <div class="gem-service-note-box" style="margin-top: 0;">
                <b>Note:</b> Our consultancy fees are for above mentioned scope of work and do not include any government fees / charges. Whatever fees for registration on any procurement portal or any other charges will be paid by you (customer).
            </div>
        </div>

        <!-- 03 VENDOR EMPANELMENT -->
        <div class="gem-service-card gem-service-span-6 gem-service-card-dark">
            <div class="gem-service-icon-wrap"><i data-lucide="building-2" size="24"></i></div>
            <div>
                <h3>Department Empanelment Support</h3>
                <h2>Vendor Empanelment</h2>
                <p>We can help you enrolled with any department / organization as registered vendor / Empanelled Vendor.</p>
            </div>
            
            <div class="gem-service-tag-wrap" style="margin-bottom: 20px; display: flex; flex-direction: column;">
                <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.5; border-radius: 12px; font-size: 0.85rem; padding: 12px 16px;">
                    <i data-lucide="layers" size="16" style="color: var(--accent); margin-right: 8px; vertical-align: middle;"></i> 
                    Each department / organization has a different process of vendor empanelment and according to their requirement and process we collect documents from you and do process accordingly.
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px; margin-top: auto;">
                <div class="gem-service-note-box" style="margin-top: 0;">
                    <b>Note:</b> Our consultancy fees are for above mentioned scope of work and do not include any government fees / charges. Whatever fees for registration on any procurement portal or any other charges will be paid by you (customer).
                </div>
                <div class="gem-service-note-box" style="margin-top: 0;">
                    <b>Important:</b> If any department requires to verify original documents physically then you (client) must visit their location for verification of their documents.
                </div>
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