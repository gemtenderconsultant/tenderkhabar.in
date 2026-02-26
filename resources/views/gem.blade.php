

@extends('layouts.app')
@section('title', 'GEM Services - Simplified Seller Registration for Seamless Onboarding')
@section('meta_description', 'Discover GEM Services for hassle-free seller registration. Our streamlined vendor onboarding process ensures quick validation of your documents, allowing you to sell on the GeM portal effortlessly. Get started today!')
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

 .card-content ul {
     list-style: none;
     padding-left: 0;
     margin: 12px 0;
     font-size: 15px;
     font-weight: 300;
 }

 .card-content ul li {
     margin-bottom: 8px;
     font-size: 15px;
     line-height: 1.6;
     position: relative;
     padding-left: 16px;
 }

 .card-content ul li::before {
     content: '▸';
     position: absolute;
     left: 0;
     color: var(--secondary);
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
  
 <div class="content-wrapper" style="margin-botton:0px;">
            <h2 class="section-heading">GEM Services</h2>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-user-plus icon-circle"></i> Seller Registration
                    </div>
                    {{-- <div class="card-content">
                        <h3>Streamlined Vendor Onboarding Process</h3>
                        <p>By validation of your documents and details you will be able to sell on gem portal. </p>
                        <p>We will handle your registration process; you only need to provide documents we ask.</p>
                        <ul>
                            <li>If Seller’s Turnover is less than 1 Crore: Rs 5,000/-</li>
                            <li>Seller Turn over > 1 Crore but < 10 Crore: Rs 10,000/-</li>
                            <li>Seller Turn over > 10 Crore: Rs 25,000/-</li>
                        </ul>
                        <div class="note">Note: To list product / service catalogue on gem or to bid tender on gem you
                            must
                            pay
                            caution money which is according to below slab, and it is a deposit to maintain discipline
                            amongst
                            the sellers and you pay to your own virtual account on gem and by closing your gem account
                            it
                            will
                            be refunded to you</div>
                    </div> --}}
                    <div class="card-content">
                        <h3>Streamlined Vendor Onboarding Process</h3>
                        <p>By validation of your documents and details you will be able to sell on gem portal. </p>
                        <p>We will handle your registration process; you only need to provide documents we ask.</p>
                        <ul>
                            <li>GeM Registration Assistance</li>
                            <li>Profile Optimization</li>
                            <li>Compliance Management</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-clipboard-check icon-circle"></i> Vendor Assesment
                    </div>
                    {{-- <div class="card-content">
                        <h3>Comprehensive Supplier Evaluation & Verification</h3>
                        <p>If you are Manufacturer / Importer / Third Party Manufacturer than you can claim OEM benefits
                            by
                            doing Vendor Assessment. For Vendor assessment QCI charges Rs. 13216 and has 2 processes:
                        </p>
                        <ul>
                            <li>Desktop Assessment (Document Verification)</li>
                            <li>Video Assessment (Video Verification)</li>
                        </ul>
                        <div class="note">Note: For desktop assessment many documents will be required related to
                            manufacturing, and you must furnish all documents according to your production process. We
                            will
                            guide you and provide you with any samples available, but we will not draft any documents.
                        </div>
                    </div> --}}
                    <div class="card-content">
                        <h3>Vendor Assessment & Compliance Support</h3>
                        <p>Vendor Assessment is an essential process to evaluate a supplier’s capability, reliability, and compliance with
                           industry standards. It ensures that manufacturers, importers, or third-party producers meet the required
                           quality, infrastructure, and operational benchmarks before approval.</p>
                        <ul>
                          <li>Desktop Assessment (Evaluation of submitted documents and certifications)</li>
                          <li>Video Assessment (Virtual inspection of production facility and processes)</li>
                        </ul>
                    <div class="note">Note: For desktop assessment, detailed documentation related to your manufacturing setup,
                         quality control, and process flow will be required. Our team will guide you through the requirements and share
                        reference formats where applicable, but document preparation will remain the applicant’s responsibility.</div>
                    </div>

                </div>
            </div>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-shield-alt icon-circle"></i> Vendor Assessment Exemption
                    </div>
                    <div class="card-content">
                        <h3>Exemption from Vendor Assessment Criteria</h3>
                        <p>If you have documentation according to Vendor assessment exemption policy than we can claim
                            your
                            VAE:
                        </p>
                        <ul>
                            <li>OEMs holding BIS License for the product category</li>
                            <li>Vaccine manufacturer as per list provided by Ministry of Health & Family Welfare</li>
                            <li>Drugs/Medicine manufacturer with "Notarized Undertaking" & "Valid certified copy of Drug
                                Licenses from the issuing/concerned Drug Authority"</li>
                            <li>Medical Device manufacturer with "Valid Manufacturing License” from the issuing
                                Licensing
                                Authority</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-tags icon-circle"></i> OEM Panel Creation / Brand Approval
                    </div>
                    <div class="card-content">
                        <h3>OEM Panel Creation & Brand Accreditation</h3>
                        <p>We can help you register your brands on GeM portal.</p>
                        <p>If you are Manufacturer and your Vendor assessment / Vendor Assessment Exemption is approved
                            than
                            to
                            receive OEM benefits and access, you must claim OEM dashboard with your brand with 2
                            options: 1.
                            Trademark 2. Notarized undertaking for brand.</p>
                        <p>If you are a reseller and your manufacturer is not available on gem, then you can apply their
                            brand
                            with their registered trademark.</p>
                        <div class="note">Note: Trademark is required registered only to apply brand / OEM dashboard.
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-folder-open icon-circle"></i> Products / Service Cataloguing
                    </div>
                    <div class="card-content">
                        <h3>End-to-End Product/Service Cataloguing</h3>
                        <p>We will help you your product / service catalogue on GeM portal.</p>
                        <p>GeM has quadrant policy and according to that:</p>
                        <ul>
                            <li>Q1 quadrant allows only manufacturers to list and sell products.</li>
                            <li>Q2 quadrant allows only manufacturers to list and sell products, and for reseller with
                                OEM’s
                                authorization code can sell their listed products.</li>
                            <li>Q3 and Q4 quadrant allows resellers and manufacturers to list and sell products.</li>
                        </ul>
                        <div class="note">Note: To list any product requires product specification according to
                            category,
                            and
                            if category is not available then product can’t be uploaded.</div>
                        <div class="note">Note: If any category mandatory requires any license number or test report
                            number
                            with any details then you must provide it accordingly. If those details are not provided,
                            then
                            cataloguing will be not possible.</div>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-file-signature icon-circle"></i> Tenders Bidding
                    </div>
                    <div class="card-content">
                        <h3>Expert-Led Tender Bidding Assistance</h3>
                        <p>We understand the business and profile of the customer, as our service is personalized
                            service,
                            we
                            assign a dedicated personal manager to the user, who manages the following tasks for the
                            customer:
                        </p>
                        <ul>
                            <li>Study whole document and prepare a summary</li>
                            <li>Applying product which is required in bid</li>
                            <li>Collecting documents required for bid participation</li>
                            <li>Helping understand requirements and how to prepare docs</li>
                            <li>Department coordination and follow-up</li>
                            <li>Uploading tender documents and submission</li>
                            <li>Reverse auction participation if needed</li>
                            <li>EMD Refund follow-up</li>
                        </ul>
                        <div class="note">Note: Consultancy fees exclude govt charges like EMD, tender document fee,
                            courier
                            etc. Paid by customer.</div>
                        <div class="note">Note: We will not create/draft any annexures or documents. We only guide.
                        </div>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <div class="timeline-card">
                    <div class="title-with-icon">
                        <i class="fas fa-boxes icon-circle"></i> Order Processing
                    </div>
                    <div class="card-content">
                        <h3>Complete Post-Bid Order Processing & Compliance</h3>
                        <p>If you have received any order than further processes will be done from our side like:</p>
                        <ul>
                            <li>Submitting invoice for received order</li>
                            <li>Submitting ePBG if required</li>
                            <li>Guidance for milestone/transactional charges</li>
                            <li>Taking follow up for payment on customer’s behalf</li>
                        </ul>
                        <div class="note">Note: Consultancy fees exclude any government fees / charges like Milestone /
                            Transactional / Late Delivery etc.</div>
                    </div>
                </div>
            </div>
        </div>
        
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@endsection