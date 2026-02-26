

@extends('layouts.app')

@section('title', 'Professional Certification Services for CE Marking Compliance')
@section('meta_description', 'Ensure your products meet European safety standards with our expert Certification Services. We help you navigate CE marking requirements for safe and compliant trade in the EEA. Get started today!')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@section('stylesheet')
<style>
:root {
     /* --primary: #f5c518; */
     /* --primary: #f6cb30; */
     --primary: #E0B223;
     --secondary: #1e3a8a;
     --text: #333;
     --bg: #f8f9fc;
     --card-bg: #fff;
     --card-shadow: rgba(0, 0, 0, 0.1);
     /* --highlight: #fffbcc; */
     --highlight: #fff9b3;
     --highlight-shadow: rgba(245, 197, 24, 0.4);
     --error-color: #d93025;
 }

   .section-heading {
     text-align: center;
     font-size: 32px;
     color: var(--secondary);
     margin: 160px 0 50px;
     text-transform: uppercase;
     letter-spacing: 1px;
     position: relative;
 }

 .section-heading::after {
     content: '';
     display: block;
     width: 80px;
     height: 4px;
     background: var(--primary);
     margin: 10px auto 0;
     border-radius: 2px;
 }

 .timeline-section {
     display: flex;
     align-items: flex-start;
     gap: 60px;
     margin-bottom: 100px;
     flex-wrap: wrap;
     padding-left: 60px;
     animation: fadeInUp 1s ease forwards;
     position: relative;
     z-index: 1;
 }

 .timeline-title {
     display: none;
 }

 .timeline-card {
     display: flex;
     align-items: flex-start;
     gap: 15px;
     background: linear-gradient(to right, #fff, #fef9e7);
     border-left: 5px solid var(--primary);
     border-radius: 10px;
     padding: 24px;
     box-shadow: 0 4px 12px var(--card-shadow);
     flex: 1;
     transition: transform 0.4s ease, box-shadow 0.4s ease;
     position: relative;
     flex-direction: column;
 }

 .timeline-card:hover {
     transform: translateY(-5px);
     box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
 }

 @keyframes pulse {
     0% {
         transform: scale(1);
     }

     50% {
         transform: scale(1.05);
     }

     100% {
         transform: scale(1);
     }
 }

 @keyframes fadeInUp {
     from {
         opacity: 0;
         transform: translateY(20px);
     }

     to {
         opacity: 1;
         transform: translateY(0);
     }
 }

 .card-content {
     flex: 1;
 }

 .card-content h3 {
     margin: 0 0 12px;
     font-size: 20px;
     color: var(--secondary);
     font-weight: 600;
     letter-spacing: 0.5px;
     transition: color 0.3s ease;
 }

 .timeline-card:hover .card-content h3 {
     color: var(--primary);
 }

 .card-content p {
     margin: 0 0 12px;
     font-size: 17px;
     line-height: 1.6;
 }

 .note {
     font-size: 15px;
     color: var(--text);
     background: #f5f5f5;
     padding: 12px;
     border-left: 4px solid var(--primary);
     margin-top: 12px;
     line-height: 1.5;
 }

 .icon-circle {
     font-size: 36px;
     margin-bottom: 12px;
     animation: pulse 2s infinite;
     color: var(--icon-color);
     transition: transform 0.3s ease, color 0.3s ease;
     border-radius: 12px;
     width: 60px;
     height: 60px;
     display: flex;
     justify-content: center;
     align-items: center;
     background: white;
 }

 .title-with-icon {
     display: flex;
     align-items: center;
     gap: 10px;
     font-size: 22px;
     font-weight: bold;
     color: var(--secondary);
     margin-bottom: 16px;
 }

 @media (max-width: 768px) {
     .timeline-section {
         flex-direction: column;
         padding-left: 20px;
         gap: 30px;
     }

     .timeline-title {
         display: none;
     }

     .timeline-card {
         width: 100%;
         padding: 20px;
     }

     .card-content h3 {
         font-size: 18px;
     }

     .card-content p,
     .note {
         font-size: 14px;
     }
 }

  </style>
@section('content')
<main id="main">
  <div class="content-wrapper">

        <h2 class="section-heading">Certification Services</h2>

        <div class="timeline-section">
            <div class="timeline-card">
                <div class="title-with-icon">
                    <i class="fas fa-file-alt icon-circle"></i>
                    <div class="icon-label">Seller Registration</div>
                </div>
                <div class="card-content">
                    <h3>CE Certificate</h3>
                    <p>Conformité Européenne (CE) certification is a regulatory standard that verifies certain products
                        are
                        safe for sale and use in the European Economic Area (EEA). Manufacturers place a CE marking on
                        certified products to indicate that the product complies with European safety rules and can be
                        traded freely within the EEA. Unlike other certification marks, CE marking is not granted by a
                        particular regulatory body, although certain products require an independent conformity
                        assessment
                        by a notified body to ensure they meet CE certification requirements. Ultimately, manufacturers
                        are
                        responsible for the proper use of CE marking on their products.</p>
                </div>
            </div>
        </div>

        <div class="timeline-section">
            <div class="timeline-card">
                <div class="title-with-icon">
                    <i class="fas fa-file-alt icon-circle"></i> ISO Certificate
                </div>
                <div class="card-content">
                    <h3>ISO Certificate</h3>
                    <p>ISO certificate is a stamp of authorization by an independent body that an organization adheres
                        to
                        according to any of the standards created that are published by ISO (International Organization
                        for
                        Standardization).</p>
                </div>
            </div>
        </div>

        <div class="timeline-section">
            <div class="timeline-card">
                <div class="title-with-icon">
                    <i class="fas fa-file-alt icon-circle"></i> Udyam Certificate
                </div>
                <div class="card-content">
                    <h3>Udyam Certificate</h3>
                    <p>An enterprise registered with any other organisation under the Ministry of Micro, Small and
                        Medium
                        Enterprises shall register itself under Udyam Registration.</p>
                </div>
            </div>
        </div>

        <div class="timeline-section">
            <div class="timeline-card">
                <div class="title-with-icon">
                    <i class="fas fa-file-alt icon-circle"></i> Startup Certificate
                </div>
                <div class="card-content">
                    <h3>Startup Certificate</h3>
                    <p>The DPIIT Certificate of Recognition for Startups will be issued after examination of the
                        application
                        and documents submitted. Once the ministry approves the application and provides the unique
                        startup
                        recognition number, the startup can be registered with tax benefits.</p>
                </div>
            </div>
        </div>

        <div class="timeline-section">
            <div class="timeline-card">
                <div class="title-with-icon">
                    <i class="fas fa-file-alt icon-circle"></i> Digital Signature Certificate
                </div>
                <div class="card-content">
                    <h3>Digital Signature Certificate</h3>
                    <p>Digital Signature Certificates (DSC) are the digital equivalent (that is electronic format) of
                        physical or paper certificates. Few Examples of physical certificates are drivers' licenses,
                        passports, or membership cards.</p>
                </div>
            </div>
        </div>
    </div>
  
</main>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection