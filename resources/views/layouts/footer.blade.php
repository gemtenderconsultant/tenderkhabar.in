
 <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">       
<style type="text/css">
    :root {
     /* --primary: #f5c518; */
     --primary: #f6cb30;
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

 * {
     box-sizing: border-box;
 }

 body {
     margin: 0;
     font-family: 'Poppins', sans-serif;
     background: var(--bg);
     color: var(--text);
     cursor: none !important;
 }
 
 /* Footer */
 .site-footer {
     background: #f0f2f5;
     color: #333;
     padding: 40px 20px 20px;
     font-size: 14px; 
 }

 .footer-container {
     display: grid;
     grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
     gap: 30px; 
     max-width: 1200px; 
     margin: auto; 
     text-align: left;
 }

 .footer-col {
     padding: 0 10px;
 }

 .footer-col h4 {
     color: #1e3a8a;
     font-size: 16px; 
     margin-bottom: 12px; 
     position: relative;
     padding-bottom: 8px; 
 }

 .footer-col h4::after {
     content: '';
     position: absolute;
     left: 0;
     bottom: 0;
     width: 40px; 
     height: 2px; 
     background-color: var(--primary); 
 }

 .footer-col ul {
     list-style: none; 
     padding: 0; 
     margin: 0;
 }

 .footer-col li {
     margin-bottom: 8px; 
 }

 .footer-col a {
     color: #555; 
     text-decoration: none; 
     transition: color 0.2s; 
 }

 .footer-col a:hover {
     color: var(--secondary); 
 }

 .footer-col p {
     margin-bottom: 8px; 
     line-height: 1.5; 
     color: #555;
 }

 .footer-col.contact-info p {
     display: flex;
     align-items: flex-start; 
     gap: 8px; 
 }

 .footer-col.contact-info p i {
     width: 16px; 
     height: 16px; 
     filter: invert(30%) sepia(10%) saturate(600%) hue-rotate(200deg) brightness(90%); 
     flex-shrink: 0;
     margin-top: 2px; 
 }

 .footer-col.social-media {
    margin-top: 15px;
 }
 .social-icons {
     display: flex;
     gap: 15px; 
     margin-top: 10px;
 }

 .social-icons a i {
     width: 24px; 
     height: 24px;
     transition: transform 0.2s ease; 
     filter: grayscale(100%); }

 .social-icons a:hover i {
     transform: scale(1.1); 
     filter: grayscale(0%); 
 }

 .footer-bottom {
     text-align: center; 
     margin-top: 30px; 
     border-top: 1px solid #ddd; 
     padding-top: 15px;
     color: var(--secondary); 
 }

 /* Responsive adjustments */
 @media (max-width: 768px) {
     .footer-container {
         grid-template-columns: 1fr; /
         text-align: center; 
     }

     .footer-col h4::after {
         left: 50%; 
         transform: translateX(-50%);
     }

     .footer-col.contact-info p {
         justify-content: center; /
     }

     .social-icons {
         justify-content: center; 
     }
 }
</style>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-col about-us">
            <h4>TenderKhabar</h4>
            <p>Your trusted partner for comprehensive GeM services, tender information, and business certifications. We simplify government procurement.</p>
            <div class="social-icons social-media">
                        <a href="https://www.facebook.com/share/1B6x1Mb8HR/"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/aarav-tender-consultant-private-limited/?viewAsMember=true"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.instagram.com/gemtenderconsultant.in?igsh=Nm1xd3Q3eG9ld3Jv"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <div class="footer-col quick-links">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('gem') }}">GeM Services</a></li>
                <li><a href="{{ route('bidding') }}">Other Portal Services</a></li>
                <li><a href="{{ route('pricing-plans') }}">Pricing Plan</a></li>
                <li><a href="{{ route('certification') }}">Certificates</a></li>
                {{-- <li><a href="{{ route('about-us') }}">About Us</a></li> --}}
                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
            </ul>
        </div>

        <div class="footer-col inquiry-support">
            <h4>Inquiry</h4>
            <p class="contact-info">
               {{-- <i class="fas fa-phone"></i> --}}
                +91 9824895546
            </p>
            <p class="contact-info">
                {{-- <i class="fas fa-envelope"></i> --}}
                sales@gemtenderconsultant.com
            </p>

            <h4>Support</h4>
            <p class="contact-info">
                {{-- <i class="fas fa-phone"></i> --}}
                +91 9274686490
            </p>
            <p class="contact-info">
               {{-- <i class="fas fa-envelope"></i> --}}
                support1@gemtenderconsultant.com
            </p>
        </div>

        <div class="footer-col registered-office">
            <h4>Registered Office</h4>
            <p>Aarav Tender Consultant Pvt. Ltd</p>
            <p>2nd Floor, Jagadish Chamber's Back Side Building, Malgodown Road, Rajkamal Cross Road, Mehsana -384002, Gujarat</p>

            <h4>Branch Office</h4>
            <p>Aarav Tender Consultant Pvt. Ltd</p>
            <p>301, Wall Street Annexe, Nr. Hotel Jungle Bhookh, Gujarat Collage, Ellisbridge Ahmedabad - 380006, Gujarat</p>
        </div>
    </div>
    <div class="footer-bottom">
        © {{ date('Y') }} Aarav Tender Consultant Pvt. Ltd • All rights reserved
    </div>
</footer>


