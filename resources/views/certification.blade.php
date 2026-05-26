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
        <!-- <span class="gem-service-badge"><i data-lucide="shield-check" size="14" style="margin-right: 6px;"></i> Seller Registration & Compliance</span> -->
        <h1>Premium <span>Certification Services</span></h1>
        <p>Your trusted partner for all essential business registrations and certifications. We simplify global and domestic compliance so you can focus on scale.</p>
    </header>

    <div class="gem-service-bento-grid">
        
        <!-- 01 CE CERTIFICATE -->
        <div class="gem-service-card gem-service-span-8">
            <div class="gem-service-icon-wrap"><i data-lucide="globe" size="24"></i></div>
            <div>
                <h3>European Conformity Standard</h3>
                <h2>CE Certificate</h2>
                <p>Conformité Européenne (CE) certification is a regulatory standard that verifies certain products are safe for sale and use in the European Economic Area (EEA). Manufacturers place a CE marking on certified products to indicate that the product complies with European safety rules and can be traded freely within the EEA. Unlike other certification marks, CE marking is not granted by a particular regulatory body, although certain products require an independent conformity assessment by a notified body to ensure they meet CE certification requirements.</p>
            </div>

            <div class="gem-service-creative-box">
                <h4><i data-lucide="shield" size="16"></i> Key CE Marking Benefits</h4>
                <div class="gem-service-creative-grid">
                    <div class="gem-service-creative-item"><i data-lucide="map" size="16"></i> Trade Freely in EEA</div>
                    <div class="gem-service-creative-item"><i data-lucide="check-circle" size="16"></i> Safety Compliant</div>
                    <div class="gem-service-creative-item"><i data-lucide="bar-chart-3" size="16"></i> High Market Trust</div>
                </div>
            </div>

            <div class="gem-service-note-box" style="margin-top: 0;">
                Ultimately, manufacturers are responsible for the proper use of CE marking on their products. We help streamline conformity assessment.
            </div>
        </div> 
        
        <!-- 02 ISO CERTIFICATE -->
        <div class="gem-service-card gem-service-span-4">
            <div class="gem-service-icon-wrap"><i data-lucide="award" size="24"></i></div>
            <div>
                <h3>Global Organization Standardization</h3>
                <h2>ISO Certificate</h2>
                <p>ISO certificate is a stamp of authorization by an independent body that an organization adheres to according to any of the standards created that are published by ISO (International Organization for Standardization).</p>
            </div>
            <ul class="gem-service-feature-list" style="grid-template-columns: 1fr;">
                <li><i data-lucide="check-circle" size="16"></i> Internationally Recognized</li>
                <li><i data-lucide="check-circle" size="16"></i> Process Standardization</li>
                <li><i data-lucide="check-circle" size="16"></i> Quality Assurance Mark</li>
            </ul>
            <div class="gem-service-note-box" style="margin-top: auto;">
                <b>Note:</b> Elevate your business reputation globally by integrating recognized standardized practices across your operations.
            </div>
        </div>
        

        <!-- 03 UDYAM CERTIFICATE -->
        <div class="gem-service-card gem-service-span-12 gem-service-card-dark">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px; height: 100%;">
                <div style="flex: 1; min-width: 250px; display: flex; flex-direction: column;">
                    <div class="gem-service-icon-box"><div class="gem-service-icon-wrap"><i data-lucide="building-2" size="24"></i></div></div>
                    <h3>Ministry of MSME Registration</h3>
                    <h2>Udyam Certificate</h2>
                    <p>An enterprise registered with any other organisation under the Ministry of Micro, Small and Medium Enterprises shall register itself under Udyam Registration. It forms the core foundation for claiming various subsidies and benefits provided by the government.</p>
                </div>
                <div style="flex: 1; min-width: 250px; display: flex; flex-direction: column; justify-content: center;">
                    <div class="gem-service-tag-wrap" style="margin-top: 0; display: flex; flex-direction: column;">
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">Mandatory for Micro, Small & Medium Enterprises</span>
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">Direct entry to government schemes and tender waivers</span>
                        <span class="gem-service-tag" style="white-space: normal; text-align: left; line-height: 1.4; border-radius: 12px;">Easy access to banking credit and low-interest rates</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 04 STARTUP CERTIFICATE -->
        <div class="gem-service-card gem-service-span-6">
            <div class="gem-service-icon-wrap"><i data-lucide="rocket" size="24"></i></div>
            <div>
                <h3>DPIIT Certificate of Recognition</h3>
                <h2>Startup Certificate</h2>
                <p>The DPIIT Certificate of Recognition for Startups will be issued after examination of the application and documents submitted. Once the ministry approves the application and provides the unique startup recognition number, the startup can be registered with immense benefits.</p>
            </div>
            
            <div class="gem-service-creative-box">
                <h4><i data-lucide="zap" size="16"></i> Startup Recognition Perks</h4>
                <div class="gem-service-creative-grid" style="grid-template-columns: repeat(2, 1fr);">
                    <div class="gem-service-creative-item"><i data-lucide="percent" size="16"></i> Tax Exemptions</div>
                    <div class="gem-service-creative-item"><i data-lucide="file-check" size="16"></i> Tender Ease</div>
                    <div class="gem-service-creative-item"><i data-lucide="trending-up" size="16"></i> Fast-track Approvals</div>
                    <div class="gem-service-creative-item"><i data-lucide="briefcase" size="16"></i> IPR Support</div>
                </div>
            </div>

            <div class="gem-service-note-box" style="margin-top: 0;">
                <b>Note:</b> You must pass the innovation or employment generation criteria set forth by DPIIT to qualify for this exclusive certification.
            </div>
        </div>

        <!-- 05 DIGITAL SIGNATURE CERTIFICATE -->
        <div class="gem-service-card gem-service-span-6">
            <div class="gem-service-icon-wrap"><i data-lucide="pen-tool" size="24"></i></div>
            <div>
                <h3>Electronic Authorization Format</h3>
                <h2>Digital Signature Certificate</h2>
                <p>Digital Signature Certificates (DSC) are the digital equivalent (that is electronic format) of physical or paper certificates. Few Examples of physical certificates are drivers' licenses, passports, or membership cards.</p>
            </div>
            
            <div class="gem-service-quad-grid" style="grid-template-columns: 1fr; margin-top: 15px;">
                <div class="gem-service-quad-box" style="text-align: left; display: flex; flex-direction: column;">
                    <span>Legal Validity</span><b style="font-size: 0.85rem; font-weight: 600;">Serves as legally binding proof of identity in the digital domain.</b>
                </div>
                <div class="gem-service-quad-box" style="text-align: left; display: flex; flex-direction: column;">
                    <span>E-Tendering & Filing</span><b style="font-size: 0.85rem; font-weight: 600;">Crucial for MCA filing, Income Tax Returns, and participating in GeM or Govt. Tenders.</b>
                </div>
            </div>
            <div class="gem-service-note-box" style="margin-top: auto;">
                <b>Note:</b> A valid Class 3 DSC is highly recommended for the highest level of security in e-commerce and electronic government procurements.
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