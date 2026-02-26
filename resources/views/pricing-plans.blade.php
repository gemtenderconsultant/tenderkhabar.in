{{-- 

@extends('layouts.app')

@section('title', 'Affordable Pricing Plans for Tender Alerts | Choose Your Coverage')
@section('meta_description', 'Discover our tailored pricing plans for tender alerts! Choose from Single State, Five States, or All India coverage to suit your needs. Enjoy email support, document assistance, and more. Get started today!')

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
 
   h1 {
     text-align: center;
     font-size: 32px;
     color: var(--secondary);
     margin-bottom: 50px;
     position: relative;
     margin-top: 50px;
 }

 .pricing-grid {
     display: grid;
     grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
     gap: 40px;
     max-width: 1200px;
     margin: 0 auto;
 }

 .pricing-card {
     background: var(--card-bg);
     backdrop-filter: var(--glass-blur);
     border-radius: 20px;
     box-shadow: 0 8px 20px var(--card-shadow);
     overflow: hidden;
     transition: transform 0.3s ease, box-shadow 0.3s ease;
     display: flex;
     flex-direction: column;
     position: relative;
     margin-bottom: 80px;
 }

 .pricing-card:hover {
     transform: translateY(-8px);
     box-shadow: 0 12px 28px var(--highlight-shadow);
 }

 .plan-header {
     background: var(--primary);
     color: #000;
     padding: 24px;
     text-align: center;
     font-weight: 700;
     font-size: 20px;
     text-transform: uppercase;
     letter-spacing: 1px;
 }

 .plan-icon {
     font-size: 36px;
     color: var(--secondary);
     text-align: center;
     margin: 20px 0 -10px;
 }

 .plan-price {
     text-align: center;
     padding: 16px;
     font-size: 28px;
     font-weight: bold;
     color: var(--secondary);
 }

 .gst-note {
     text-align: center;
     font-size: 12px;
     color: #555;
     margin-top: -10px;
     margin-bottom: 16px;
 }

 .plan-features {
     padding: 0 24px 24px;
     list-style: none;
 }

 .plan-features li {
     padding: 10px 0;
     border-bottom: 1px solid #ddd;
     font-size: 15px;
     display: flex;
     align-items: center;
     gap: 10px;
     color: #333;
 }

 .plan-features li::before {
     content: '\f058';
     font-family: 'Font Awesome 6 Free';
     font-weight: 900;
     color: var(--primary);
 }

 .plan-footer {
     text-align: center;
     padding: 20px;
     margin-top: auto;
 }

 .plan-footer button {
     padding: 12px 24px;
     background: var(--secondary);
     color: #fff;
     border: none;
     border-radius: 8px;
     font-size: 15px;
     cursor: pointer;
     transition: background 0.3s ease;
 }

 .plan-footer button:hover {
     background: #162e6b;
 }

 .modal {
     display: none;
     position: fixed;
     z-index: 999;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, 0.4);
     overflow-y: auto;
     margin-top:80px;
 }

 .modal-content {
     background-color: #fff;
     margin: 5% auto;
     padding: 20px;
     border-radius: 15px;
     max-width: 600px;
     box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
     animation: fadeIn 0.3s ease;
     width: 90%;
     box-sizing: border-box;
 }

 @keyframes fadeIn {
     from {
         opacity: 0;
         transform: translateY(-10px);
     }

     to {
         opacity: 1;
         transform: translateY(0);
     }
 }

 .modal-content label {
     display: block;
     margin-top: 12px;
     font-weight: 200;
     color: #1e3a8a;
 }

 .modal-content input,
 .modal-content textarea {
     width: 100%;
     padding: 8px;
     margin-top: 5px;
     border: 1px solid #ccc;
     border-radius: 5px;
     box-sizing: border-box;
 }

 .modal-content button[type="submit"] {
     margin-top: 20px;
     background-color: var(--primary);
     border: none;
     padding: 10px 15px;
     border-radius: 5px;
     cursor: pointer;
     width: 100%;
     font-size: 16px;
 }

 .modal-content button[type="submit"]:hover {
     background-color: #e6b800;
 }

 .close-btn {
     float: right;
     font-size: 24px;
     font-weight: bold;
     color: red;
     cursor: pointer;
 }

 @media (max-width: 768px) {
     :root {
         --primary: #f5c518;
         --secondary: #1e3a8a;
         --text: #333;
         --bg: #ffffff;
         --card-bg: #ffffff;
         --card-shadow: rgba(0, 0, 0, 0.05);
         --highlight-shadow: rgba(245, 197, 24, 0.2);
         --glass-blur: none;
     }
 }

 .modal {
     display: none;
     position: fixed;
     z-index: 999;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, 0.4);
     overflow-y: auto;
 }

 .modal-content {
     background-color: #fff;
     margin: 5% auto;
     padding: 20px;
     border-radius: 15px;
     max-width: 600px;
     box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
     animation: fadeIn 0.3s ease;
     width: 90%;
     box-sizing: border-box;
 }

 @keyframes fadeIn {
     from {
         opacity: 0;
         transform: translateY(-10px);
     }

     to {
         opacity: 1;
         transform: translateY(0);
     }
 }

 .modal-content label {
     display: block;
     margin-top: 12px;
     font-weight: bold;
 }

 .modal-content input,
 .modal-content textarea {
     width: 100%;
     padding: 8px;
     margin-top: 5px;
     border: 1px solid #ccc;
     border-radius: 5px;
     box-sizing: border-box;
 }

 .modal-content button[type="submit"] {
     margin-top: 20px;
     background-color: var(--primary);
     border: none;
     padding: 10px 15px;
     border-radius: 5px;
     cursor: pointer;
     width: 100%;
     font-size: 16px;
 }

 .modal-content button[type="submit"]:hover {
     background-color: #e6b800;
 }

 .close-btn {
     float: right;
     font-size: 24px;
     font-weight: bold;
     color: red;
     cursor: pointer;
 }

</style>
@section('content')
<main id="main">
 <div class="content-wrapper">

    <h1 style="margin-top:150px; margin-botton:20px;"></h1>
    <div class="pricing-grid">

      <div class="pricing-card">
        <div class="plan-header">Single State</div>
        <div class="plan-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="plan-price">₹11,800</div>
        <div class="gst-note">(Including GST)</div>
        <ul class="plan-features">
          <li>1 State Coverage</li>
          <li>Basic Tender Alerts</li>
          <li>Email Support</li>
          <li>Document Upload Assistance</li>
        </ul>
        <div class="plan-footer">
          <button>Buy Now</button>
        </div>
      </div>

      <div class="pricing-card">
        <div class="plan-header">Five States</div>
        <div class="plan-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="plan-price">₹17,700</div>
        <div class="gst-note">(Including GST)</div>
        <ul class="plan-features">
          <li>5 States Coverage</li>
          <li>Standard Tender Alerts</li>
          <li>Phone & Email Support</li>
          <li>Document Submission Help</li>
        </ul>
        <div class="plan-footer">
          <button>Buy Now</button>
        </div>
      </div>

      <div class="pricing-card">
        <div class="plan-header">All India</div>
        <div class="plan-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div class="plan-price">₹23,600</div>
        <div class="gst-note">(Including GST)</div>
        <ul class="plan-features">
          <li>All India Coverage</li>
          <li>Premium Tender Alerts</li>
          <li>Dedicated Account Manager</li>
          <li>End-to-End Bidding Support</li>
        </ul>
        <div class="plan-footer">
          <button>Buy Now</button>
        </div>
      </div>
    </div>

  </div>

  <div id="buyNowModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="document.getElementById('buyNowModal').style.display='none'">&times;</span>

      <form>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="mobile">Mobile Number</label>
        <input type="tel" id="mobile" name="mobile" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="4"></textarea>

        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

</main>
@endsection

@section('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
  document.querySelectorAll('.plan-footer button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.getElementById('buyNowModal').style.display = 'block';
      });
    });

    window.onclick = function (event) {
      const modal = document.getElementById('buyNowModal');
      if (event.target === modal) {
        modal.style.display = "none";
      }
    }
</script>
@endsection --}}


@extends('layouts.app')

@section('title', 'Affordable Pricing Plans for Tender Alerts | Choose Your Coverage')

@section('stylesheet')
<style>
    :root {
        --primary: #E0B223;
        --secondary: #1e3a8a;
        --text: #333;
        --bg: #f8f9fc;
        --card-bg: #fff;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --btn-blue: #1b3a8d;
    }

    /* Main Container Spacing */
    .pricing-wrapper {
        margin-top: 150px; /* Increased top margin for the grid */
        margin-bottom: 80px;
        background-color: #fdfdfd;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Compact Card Design */
    .pricing-card {
        background: var(--card-bg);
        border-radius: 15px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .pricing-card:hover {
        transform: translateY(-5px);
    }

    .plan-header {
        background: var(--primary);
        color: #000;
        padding: 15px;
        text-align: center;
        font-weight: 800;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Compact Features Section */
    .shared-features {
        padding: 25px 30px;
        flex-grow: 1;
    }

    .plan-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .plan-features li {
        padding: 8px 0;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #555;
    }

    .plan-features li::before {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: var(--primary);
        font-size: 16px;
    }

    /* Duration Split Section */
    .duration-container {
        display: flex;
        border-top: 1px solid #f0f0f0;
        background: #fff;
    }

    .duration-section {
        flex: 1;
        padding: 20px 10px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Second column (2 Years) light tint as per screenshot */
    .duration-section.alt-bg {
        background-color: #fffbef;
    }

    .duration-label {
        font-weight: 800;
        color: var(--secondary);
        font-size: 13px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .plan-price {
        font-size: 24px;
        font-weight: 900;
        color: #111;
        margin-bottom: 0;
    }

    .gst-note {
        font-size: 10px;
        color: #888;
        margin-bottom: 15px;
    }

    /* Dark Blue Button */
    .btn-pay {
        width: 85%;
        padding: 10px 0;
        background: var(--btn-blue);
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.3s;
        cursor: pointer;
    }

    .btn-pay:hover {
        opacity: 0.9;
        color: #fff;
    }

    /* MEDIA QUERIES for responsiveness */
    @media (max-width: 992px) {
        .pricing-grid {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .pricing-wrapper {
            padding-top: 120px;
        }
        .pricing-grid {
            gap: 40px;
        }
    }

    @media (max-width: 480px) {
        /* On small phones, stack the 1yr/2yr sections for readability */
        .duration-container {
            flex-direction: column;
        }
        .duration-section {
            border-bottom: 1px solid #eee;
        }
    }
</style>
@endsection

@section('content')
<main id="main">
    <div class="pricing-wrapper">
        <div class="pricing-grid">

            <!-- SINGLE STATE -->
            <div class="pricing-card">
                <div class="plan-header">Single State</div>
                <div class="shared-features">
                    <ul class="plan-features">
                        <li>1 State Coverage</li>
                        <li>Basic Tender Alerts</li>
                        <li>Email Support</li>
                        <li>Document Upload Assistance</li>
                        <li>Mobile Application</li>
                    </ul>
                </div>
                <div class="duration-container">
                    <div class="duration-section">
                        <span class="duration-label">1 Year</span>
                        <div class="plan-price">₹5900</div>
                        <div class="gst-note">(Incl. GST)</div>
                        <a href="javascript:void(0)" onclick="payNow('Single State - 1 Yr', 5900)" class="btn-pay">Pay Now</a>
                    </div>
                    <div class="duration-section alt-bg">
                        <span class="duration-label">2 Years</span>
                        <div class="plan-price">₹8850</div>
                        <div class="gst-note">(Incl. GST)</div>
                        <a href="javascript:void(0)" onclick="payNow('Single State - 2 Yr', 8850)" class="btn-pay">Pay Now</a>
                    </div>
                </div>
            </div>

            <!-- FIVE STATES -->
            <div class="pricing-card">
                <div class="plan-header">Five States</div>
                <div class="shared-features">
                    <ul class="plan-features">
                        <li>5 States Coverage</li>
                        <li>Standard Tender Alerts</li>
                        <li>Phone & Email Support</li>
                        <li>Document Submission Help</li>
                        <li>Mobile Application</li>
                    </ul>
                </div>
                <div class="duration-container">
                    <div class="duration-section">
                        <span class="duration-label">1 Year</span>
                        <div class="plan-price">₹8260</div>
                        <div class="gst-note">(Incl. GST)</div>
                        <a href="javascript:void(0)" onclick="payNow('Five States - 1 Yr', 8260)" class="btn-pay">Pay Now</a>
                    </div>
                    <div class="duration-section alt-bg">
                        <span class="duration-label">2 Years</span>
                        <div class="plan-price">₹11800</div>
                        <div class="gst-note">(Incl. GST)</div>
                        <a href="javascript:void(0)" onclick="payNow('Five States - 2 Yr', 11800)" class="btn-pay">Pay Now</a>
                    </div>
                </div>
            </div>

            <!-- ALL INDIA -->
            <div class="pricing-card">
                <div class="plan-header">All India</div>
                <div class="shared-features">
                    <ul class="plan-features">
                        <li>All India Coverage</li>
                        <li>Premium Tender Alerts</li>
                        <li>Dedicated Account Manager</li>
                        <li>Bidding Support</li>
                        <li>Mobile Application</li>
                    </ul>
                </div>
                <div class="duration-container">
                    <div class="duration-section">
                        <span class="duration-label">1 Year</span>
                        <div class="plan-price">₹11800</div>
                        <div class="gst-note">(Incl. GST)</div>
                        <a href="javascript:void(0)" onclick="payNow('All India - 1 Yr', 11800)" class="btn-pay">Pay Now</a>
                    </div>
                    <div class="duration-section alt-bg">
                        <span class="duration-label">2 Years</span>
                        <div class="plan-price">₹17700</div>
                        <div class="gst-note">(Incl. GST)</div>
                        <a href="javascript:void(0)" onclick="payNow('All India - 2 Yr', 17700)" class="btn-pay">Pay Now</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Payment Redirection Form -->
    <form id="payuRedirect" method="POST" action="{{ route('payment.payu') }}" style="display:none;">
        @csrf
        <input type="hidden" name="plan">
        <input type="hidden" name="amount">
    </form>
</main>
@endsection

@section('scripts')
<script>
function payNow(plan, amount) {
    const form = document.getElementById('payuRedirect');
    form.plan.value = plan;
    form.amount.value = amount;
    form.submit();
}
</script>
@endsection