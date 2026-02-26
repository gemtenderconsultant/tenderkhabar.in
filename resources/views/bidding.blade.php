

@extends('layouts.app')

@section('title', 'Expert Tender Bidding Services for Personalized Support')
@section('meta_description', 'Discover our tailored Tender Bidding Services, featuring dedicated personal managers who help you navigate eligibility criteria, requirements, and payment terms. Maximize your chances of success with our comprehensive support for every tender bid.')

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

    <h2 class="section-heading">Tender Bidding Services</h2>

    <div class="timeline-section">
      <div class="timeline-card">
        <div class="title-with-icon">
          <i class="fas fa-file-signature icon-circle"></i> Tenders Bidding
        </div>
        <div class="card-content">
          <h3>Personalized Tender Support</h3>
          <p>We understand the business and profile of the customer, as our service is personalized service, we assign a
            dedicated personal manager to the user, who manages the following tasks for the customer whenever customer
            sends tender he wants to bid.</p>
          <p>Study whole document and prepare a summary that includes eligibility criteria, Department requirement,
            payment terms and condition. This helps customers to identify the right tender for bidding.</p>
          <p>Collecting documents from you which are required for vendor registration.</p>
          <p>Proceeding for vendor registration with customer credentials.</p>
          <p>Taking follow-up with the department for any query. Also becoming a bridge between the user and department.
          </p>
          <p>Helping you to understand the document requirements, how to prepare documentations.</p>
          <p>Uploading the document for tendering, submitting tender online. If required, also taking part in a reverse
            auction for the customer.</p>
          <p>If the position is L1 then supporting customer to get Purchase order & also taking the follow up for
            payment
            on behalf of the customer.</p>
          <p>And if the customer did not win then also taking the follow up for EMD Refund on behalf of the customer.
          </p>
          <div class="note">Note: Our consultancy fees are for above mentioned scope of work and do not include any
            government fees / charges. Whatever fees for registration on any procurement portal, tender document fee /
            processing fee, EMD, bid security, courier charges or any other charges will be paid by you (customer).
          </div>
        </div>
      </div>
    </div>

    <div class="timeline-section">
      <div class="timeline-card">
        <div class="title-with-icon">
          <i class="fas fa-clipboard-check icon-circle"></i> Vendor Registration
        </div>
        <div class="card-content">
          <h3>Procurement Portal Registration</h3>
          <p>We can register you on any procurement portal for submitting your bids.</p>
          <p>Each procurement portal has a different process of registration and according to their requirement and
            process we collect documents from you and process accordingly.</p>
          <p>If required for browser setting, DSC mapping we will do.</p>
          <div class="note">Note: Our consultancy fees are for above mentioned scope of work and do not include any
            government fees / charges. Whatever fees for registration on any procurement portal or any other charges
            will
            be paid by you (customer).</div>
        </div>
      </div>
    </div>

    <div class="timeline-section">
      <div class="timeline-card">
        <div class="title-with-icon">
          <i class="fas fa-building icon-circle"></i> Vendor Empanelment
        </div>
        <div class="card-content">
          <h3>Department Empanelment Support</h3>
          <p>We can help you enrolled with any department / organization as registered vendor / Empanelled Vendor.</p>
          <p>Each department / organization has a different process of vendor empanelment and according to their
            requirement and process we collect documents from you and do process accordingly.</p>
          <div class="note">Note: Our consultancy fees are for above mentioned scope of work and do not include any
            government fees / charges. Whatever fees for registration on any procurement portal or any other charges
            will
            be paid by you (customer).</div>
          <div class="note">Note: If any department requires to verify original documents physically then you (client)
            must visit their location for verification of their documents.</div>
        </div>
      </div>
    </div>
  </div>

</main>
@endsection