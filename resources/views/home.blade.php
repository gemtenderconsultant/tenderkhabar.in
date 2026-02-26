

@extends('layouts.app')
@section('title', 'Tender Khabar: Daily Shortlisted Government Tenders Just for You')
@section('meta_description', 'Stay ahead with Tender Khabar! Get daily updates on government tenders tailored to your specific needs. Sign up now for exclusive access to the best opportunities!')
@section('stylesheet')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.css">
<style type="text/css">
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

 * {
     box-sizing: border-box;
 }

 body {
     margin: 0;
     font-family: 'Poppins', sans-serif;
     background: var(--bg);
     color: var(--text);
     /* cursor: none !important; */
 }

.hero-section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh; /* Use min-height to adapt to content */
  padding:80px 20px 60px 20px; /* Added more padding */
  background-color: var(--secondary);
  background-image: linear-gradient(135deg, #1e3a8a, #2a5298);
  box-sizing: border-box;
}

/* ========================================================== */
/* START: NEW CSS FOR TEXT OVERLAY & ANIMATIONS               */
/* ========================================================== */

.text-overlay {
    margin-bottom: 40px; /* Increased space between text and search bar */
    color: var(--secondary);
}

.text-overlay h2 {
    font-size: 35px; 
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.3;
     color: var(--secondary);
}

.text-overlay p {
    font-size: 25px;
    max-width: 650px; 
    margin-left: auto;
    margin-right: auto;
    opacity: 0.9;
}

.fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeSlideUp 0.8s ease-out forwards;
}

@keyframes fadeSlideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.delay-0 {
    animation-delay: 0.2s;
}

.delay-1 {
    animation-delay: 0.6s;
}

@media (max-width: 768px) {
    .text-overlay h2 {
        font-size: 2rem;
    }
    .text-overlay p {
        font-size: 1rem;
    }
}


.search-container {
  width: 100%;
  max-width: 800px;
  background-color: rgba(255, 255, 255, 0.05);
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 10px 30px var(--card-shadow);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  /* text-align: center; */
  color: #ffffff;
}

.search-container h2 {
  font-size: 2.5rem;
  margin-top: 0;
  margin-bottom: 10px;
  font-weight: 600;
}

.search-container p {
  font-size: 1.1rem;
  margin-bottom: 30px;
  font-weight: 400;
  opacity: 0.9;
}

.search-type-tabs {
  display: flex;
  justify-content: flex-start;
  margin-bottom: 20px;
}

.searchbox {
  background-color: transparent;
  color: #ffffff;
  border: 2px solid rgba(255, 255, 255, 0.4);
  padding: 10px 25px;
  margin: 0 5px;
  border-radius: 50px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 500;
  transition: all 0.3s ease;
  display: inline-block; 
}

.searchbox:hover {
  background-color: rgba(255, 255, 255, 0.2);
}

.searchbox.btn-active:hover {
    color: var(--secondary);
}

.searchbox:not(.btn-active) {
    background-color: #f8f9fc;    
    color: var(--secondary);        
    border: 1px solid var(--secondary);    
}

.searchbox:not(.btn-active):hover {
    background-color: #ffffff;    
    color: #000000;
}

.searchbox.btn-active {
    background-color: var(--primary);
    color: var(--secondary); 
    border: 1px solid var(--primary);
    font-weight: 600;
}

.form-search {
  display: flex;
  width: 100%;
  border-radius: 50px;
  overflow: hidden;
  box-shadow: 0 4px 15px var(--card-shadow);
}

.searchbox_input {
  flex-grow: 1;
  border: none;
  padding: 18px 25px;
  font-size: 1rem;
  color: var(--text);
  outline: none;
  background-color: var(--card-bg);
}

.searchbox_input:focus {
  background-color: var(--highlight);
  box-shadow: 0 0 0 4px var(--highlight-shadow);
}

.searchbox_input::placeholder {
  color: #888;
}

.search-button {
  background-color: var(--primary);
  color: var(--secondary);
  border: none;
  padding: 18px 35px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.search-button:hover {
  background-color: #f6cb30;
}

.advanced-search-link {
  margin-top: 15px;
  text-align: right;
}

.advanced-search-link a {
  color: #ffffff;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s ease;
}

.advanced-search-link a:hover {
  color: var(--primary);
}

@media (max-width: 600px) {
  .search-container h2 {
    font-size: 2rem;
  }
  
  .form-search {
    flex-direction: column;
    border-radius: 15px;
  }

  .searchbox_input {
    border-radius: 15px 15px 0 0;
  }
  
  .search-button {
    border-radius: 0 0 15px 15px;
  }

  .advanced-search-link {
    text-align: center;
    margin-top: 20px;
  }
}

 /* card */
 .card-section {
     max-width: 1200px;
     /* margin: 3rem auto; */
     padding: 1rem;
     text-align: center;
     margin: 1rem auto;
     /* margin-top: 5px; */
     background-color: #f0f1f2;
     border-radius: 16px;
 }

 .card-section h2 {
     color: var(--secondary);
     margin-bottom: 1.5rem;
     font-weight: 700;
     font-size: 2rem;
     margin-top: 10px;
 }

 .card-section:first-of-type h2 {
     font-size: 2rem;
     margin-top: 0px;
     font-weight: 700;
     color: var(--secondary);
 }

 .card-container {
     display: grid;
     grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
     gap: 1.2rem;
     justify-items: center;
 }

 .card-item {
     background: white;
     border-radius: 15px;
     box-shadow: 0 4px 12px var(--card-shadow);
     padding: 1rem 1.5rem;
     font-weight: 600;
     color: var(--secondary);
     width: 100%;
     max-width: 220px;
     cursor: pointer;
     transition: 0.3s ease;
     user-select: none;
     text-align: center;
     border: 2px solid transparent;
 }


 .card-item:hover {
     background-color: var(--highlight);
     box-shadow: 0 8px 24px var(--highlight-shadow);
     transform: translateY(-6px);
     border-color: var(--primary);
 }

 /* ===== Why TenderKhabar as Table ===== */
 .pyramid-section {
     text-align: center;
     margin: 2rem 1rem;
 }

 .pyramid-row {
     display: flex;
     justify-content: center;
     flex-wrap: wrap;
     gap: 1rem;
     margin-bottom: 1rem;
     opacity: 0;
     transform: translateY(60px);
     animation: riseUp 0.8s ease-out forwards;
 }

 .pyramid-block {
     background-color: var(--card-bg);
     border: 2px solid var(--primary);
     color: var(--text);
     padding: 1rem;
     border-radius: 10px;
     min-width: 180px;
     box-shadow: 0 4px 10px var(--card-shadow);
     font-weight: bold;
     display: flex;
     flex-direction: column;
     align-items: center;
     gap: 0.5rem;
     transition: transform 0.3s;
     flex: 1 1 200px;
     max-width: 300px;
 }

 .pyramid-block:hover {
     transform: translateY(-5px);
 }

 .pyramid-icon {
     font-size: 2rem;
     color: var(--primary);
 }

 .pyramid-row:nth-child(1) {
     animation-delay: 0.2s;
 }

 .pyramid-row:nth-child(2) {
     animation-delay: 0.4s;
 }

 .pyramid-row:nth-child(3) {
     animation-delay: 0.6s;
 }

 .pyramid-row:nth-child(4) {
     animation-delay: 0.8s;
 }

 @keyframes riseUp {
     0% {
         transform: translateY(60px) scale(0.95);
         opacity: 0;
     }

     100% {
         transform: translateY(0) scale(1);
         opacity: 1;
     }
 }

 @media (max-width: 768px) {
     .pyramid-block {
         min-width: 140px;
         font-size: 0.9rem;
     }

     .pyramid-icon {
         font-size: 1.5rem;
     }
 }

 /* Inquiry Form Styles */
 .inquiry-form {
     background: var(--card-bg);
     max-width: 900px;
     margin: 2rem auto;
     padding: 2rem 3rem;
     border-radius: 12px;
     box-shadow: 0 3px 15px var(--card-shadow);
     color: var(--text);
     font-family: 'Poppins', sans-serif;
 }

 .inquiry-form h2 {
     text-align: center;
     margin-bottom: 1.8rem;
     font-weight: 700;
     font-size: 40px;
     color: var(--secondary);
     position: relative;
 }

 .inquiry-form h2::after {
     content: '';
     display: block;
     width: 70px;
     height: 4px;
     background: var(--primary);
     margin: 0.75rem auto 0;
     border-radius: 2px;
 }

 form {
     display: grid;
     grid-template-columns: 1fr 1fr;
     gap: 1.5rem 2rem;
 }

 form label {
     display: block;
     margin-bottom: 0.5rem;
     font-weight: 600;
     color: var(--secondary);
 }

 form input,
 form textarea {
     width: 100%;
     padding: 0.6rem 0.8rem;
     border: 2px solid #ccc;
     border-radius: 6px;
     font-size: 0.95rem;
     font-family: inherit;
     transition: border-color 0.3s ease, background 0.3s ease;
     background: #fff;
     color: var(--text);
     resize: vertical;
 }

 form input:focus,
 form textarea:focus {
     border-color: var(--primary);
     outline: none;
     background: var(--highlight);
     box-shadow: 0 0 0 4px var(--highlight-shadow);
 }

 form textarea {
     grid-column: span 2;
     min-height: 100px;
 }

 form button[type="submit"] {
     grid-column: span 2;
     padding: 0.8rem 0;
     background-color: var(--primary);
     color: #000;
     font-weight: 700;
     font-size: 1rem;
     border: none;
     border-radius: 10px;
     cursor: pointer;
     transition: background-color 0.3s ease;
 }

 form button:hover {
     background-color: var(--secondary);
     color: #fff;
 }

 .error {
     border-color: var(--error-color) !important;
     background: #fff5f5;
 }

 .error-message {
     color: var(--error-color);
     font-size: 0.85rem;
     margin-top: 0.25rem;
 }

 .inquiry-form {
     background: var(--bg);
     padding: 3rem 1rem;
 }

 .inquiry-card {
     background-color: var(--card-bg);
     box-shadow: 0 8px 24px var(--card-shadow);
     border-radius: 16px;
     padding: 1.5rem 1.5rem;
     max-width: 900px;
     margin: 0 auto;
     transition: box-shadow 0.3s ease;
     position: relative;
     z-index: 1;
 }

 @media (max-width: 768px) {
     form {
         grid-template-columns: 1fr;
     }

     form textarea,
     form button[type="submit"] {
         grid-column: span 1;
     }

     .inquiry-form {
         padding: 1.5rem;
     }

     .inquiry-form h2 {
         font-size: 1.6rem;
     }
 }

 @media (max-width: 480px) {
     .inquiry-form {
         padding: 1rem;
     }

     .inquiry-form h2 {
         font-size: 1.4rem;
     }

     form input,
     form textarea {
         font-size: 0.95rem;
     }

     form button {
         font-size: 1rem;
         padding: 0.9rem 0;
     }
 }

 /* checkbox */
 
 .checkbox-group {
    grid-column: span 2;
    display: flex;
    align-items: center;
    gap: 10px; 
    margin-top: 5px; 
}

.checkbox-group input[type="checkbox"] {
    width: auto; 
    margin: 0; 
    padding: 0; 
    transform: scale(1.2); 
    accent-color: var(--primary); 
}

.checkbox-group label {
    margin-bottom: 0; 
    font-weight: 500;
    color: var(--secondary); 
    cursor: pointer; 
}

@media (max-width: 768px) {
    .checkbox-group {
        grid-column: span 1; 
    }
}
 
</style>
@endsection
@section('content')
    <div class="d-flex h-100 text-center align-items-center">
    <div class="w-100 text-white">
        <section id="hero" class="hero d-flex align-items-center">
            <div class="container">
                <div class="row gy-4 d-flex justify-content-between">
                    <div class="col-lg-12 order-2 order-lg-1 d-flex flex-column justify-content-center">

                        <!-- === NEW TEXT OVERLAY ADDED HERE === -->
                        <div class="text-overlay">
                            <br>
                            <br>
                            <h2 class="fade-in delay-0">Get daily Government Tenders shortlisted to your exact scope</h2>
                            <p class="fade-in delay-1">what matters to your Business?? - Tenders of your scope — delivered daily...</p>
                        </div>
                        <!-- === END OF NEW TEXT === -->

                        <div class="d-flex ml-1 justify-content-center aos-init aos-animate">
                            <span class="btn btn-rounded-outline mr-1 btn-active searchbox" action="{{route('searchtenders')}}">Tender</span>
                            <span class="btn btn-rounded-outline searchbox" action="{{route('searchresult')}}">Tender Result</span>
                        </div>

                        <form action="{{ route('searchtenders') }}" class="form-search d-flex align-items-stretch mt-3" id="home_searchbar_new" data-aos="fade-up" data-aos-delay="200">
                            <input type="text" class="form-control searchbox_input" name="searchbox" id="searchbox" placeholder="Type Keyword i.e. Road, Road Construction etc." />
                            <button type="submit" class="btn btn-primary search-button">Search</button>
                        </form>

                        <div class="col-lg-12 text-end mt-2">
                            <a href="{{ route('advancesearch')}}" style="color: var(--secondary);"><b>Advance Search</b></a>
                        </div>
                    </div>
                </div>       
            </div>
        </section>
    </div>
</div>

 <!-- Tenders by State -->
    <section class="card-section" id="state-section">
        <h2>Tenders by State</h2>
        <div class="card-container" id="state-cards">
        </div>
    </section>

    <!-- Tenders by Category -->
    <section class="card-section" id="category-section">
        <h2>Tenders by Category</h2>
        <div class="card-container" id="category-cards">
        </div>
    </section>

    <!-- Tenders by Authority -->
    <section class="card-section" id="authority-section">
        <h2>Tenders by Authority</h2>
        <div class="card-container" id="authority-cards">
        </div>
    </section>

    <!-- Why TenderKhabar as Pyramid -->
    <section class="pyramid-section">
        <h1 style="text-align:center; padding-top: 20px; color:var(--secondary); font-size:35px ; font-weight: 700; margin-bottom: 40px;">Why
            Choose TenderKhabar?</h1>
        <div class="pyramid-row">
            <div class="pyramid-block">
                <div class="pyramid-icon">13</div>
                Since 2013
            </div>
        </div>
        <div class="pyramid-row">
            <div class="pyramid-block">
                <div class="pyramid-icon">10k+</div>
                10000+ Customers
            </div>
            <div class="pyramid-block">
                <div class="pyramid-icon">1k+</div>
                1000+ Departments
            </div>
        </div>
        <div class="pyramid-row">
            <div class="pyramid-block">
                <div class="pyramid-icon">🔒</div>
                Secure Technology
            </div>
            <div class="pyramid-block">
                <div class="pyramid-icon">💡</div>
                Save Cost & Time
            </div>
        </div>
        <div class="pyramid-row">
            <div class="pyramid-block">
                <div class="pyramid-icon">🌐</div>
                All Sectors Covered
            </div>
        </div>
    </section>
    
    <!-- Inquiry Form -->
    <!-- <section class="inquiry-form" aria-label="Inquiry Form">
        <div class="inquiry-card">
            <h2>Send Us an Inquiry</h2>
            <form id="inquiryForm" novalidate>
                <div>
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" required placeholder="Your full name" />
                    <div class="error-message" aria-live="polite"></div>
                </div>
                <div>
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required placeholder="you@example.com" />
                    <div class="error-message" aria-live="polite"></div>
                </div>
                <div>
                    <label for="company name">Company Name *</label>
                    <input type="text" id="company" name="company" required placeholder="ABC pvt ltd" />
                    <div class="error-message" aria-live="polite"></div>
                </div>
                <div>
                    <label for="phone">Phone *</label>
                    <input type="tel" id="phone" name="phone" required placeholder="+91 1234567890" />
                    <div class="error-message" aria-live="polite"></div>
                </div>
                <div>
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required placeholder="Write your inquiry here..."
                        rows="4"></textarea>
                    <div class="error-message" aria-live="polite"></div>
                </div>
                <button type="submit">Submit Inquiry</button>
            </form>
        </div>
    </section> -->
        <section class="inquiry-form" aria-label="Inquiry Form" >
            <div class="inquiry-card">
                <div class="errors"></div>
                <h2>Send Us an Inquiry</h2>
                <form id="inquiryForm" method="post" name="inquiryForm" action="{{ route('userinquirynew') }}">
                     @csrf
                    <input type="hidden" class="form-control" name="flag" value="contact-us" id="blog_popup_flag" autocomplete="off">
                    <div>
                        <label for="name">Name *</label>
                        <input type="text" id="name" name="name" required placeholder="Your full name" />
                        <div class="error-message" aria-live="polite"></div>
                    </div>
                    <div>
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required placeholder="you@example.com" />
                        <div class="error-message" aria-live="polite"></div>
                    </div>
                    <div>
                        <label for="company_name">Company Name *</label>
                        <input type="text" id="company_name" name="company_name" required placeholder="ABC pvt ltd" />
                        <div class="error-message" aria-live="polite"></div>
                    </div>
                    <div>
                        <label for="user_primary_phone">Phone *</label>
                        <input type="tel" id="user_primary_phone" name="user_primary_phone" required placeholder="+91 1234567890" />
                        <div class="error-message" aria-live="polite"></div>
                    </div>
                    <div>
                        <label for="message">Message *</label>
                        <textarea id="looking_for" name="looking_for" required placeholder="Write your inquiry here..." rows="4"></textarea>
                        <div class="error-message" aria-live="polite"></div>
                    </div>
                    <div class="checkbox-group">
                         <input type="checkbox" id="myCheckbox" name="authorize_contact" required>
                         <label for="myCheckbox">I authorize ATCPL and its representatives to contact me.</label>
                         <div class="error-message" aria-live="polite"></div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LeyH3YsAAAAAK5FxKO0bASRuC2nB1KDsABsjUwF"></div>
                    <button type="submit">Submit Inquiry</button>
                </form>
            </div>
        </section>
<!-- End -->
  
</main>
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript">
      var formSubmitted;
  $('#inquiryForm').on('submit', function(e) {
     e.preventDefault(); 
      if (formSubmitted) return; 
        formSubmitted = true;

    //  for popup check
    if(!$('#myCheckbox').is(':checked')){
        $("#form-message").html("<span style='color:red;'>Please agree to the terms before submitting.</span>");
        return;
    }
     var name = $('#name').val();
     var message = $('#message').val();
     var valid = true;
    var captchaResponse = grecaptcha.getResponse();
    if(captchaResponse.length === 0) {
        alert("Please verify that you are not a robot.");
        valid = false;
    }

    if (!valid) return;
     $('.errors').empty().fadeIn();
     $.ajax({
         type: "POST",
         url: "{{ route('userinquirynew') }}",
         data: $('#inquiryForm').serialize(),
         success: function(response) {
            if(response.success == true){
                var msg ='<div class="alert alert-success success_inquiry_pop_msg">';    
                    msg+=response.msg;
                    msg+='</div>';    
                    $('.errors').empty().append(msg).delay(5000).fadeOut();          
                $('#inquiryForm')[0].reset();
               
            }
             formSubmitted = false;
         },
         error: function(xhr, status, error) 
          {
            var msg ='<div class="alert alert-danger">';    
            $.each(xhr.responseJSON.errors, function (key, item) 
            { 
               msg+=item+'<br>';
            });
            msg+='</div>';
            $('.errors').append(msg).delay(5000).fadeOut();
          }
     });
  });
  </script> 
<script type="text/javascript">
$('.searchbox').on('click',function(){
    $('.searchbox').removeClass('btn-active');
    $(this).addClass('btn-active');
    $('#home_searchbar_new').attr('action',$(this).attr('action'));
});  
var sr_length =  $(".searchbox_input").length;
if(sr_length > 0){
   $.widget("app.autocomplete", $.ui.autocomplete, {
    // Which class get's applied to matched text in the menu items.
    options: {
        highlightClass: "ui-state-highlight"
    },
    _renderItem: function (ul, item) {
        // Replace the matched text with a custom span. This
        // span uses the class found in the "highlightClass" option.
        var re = new RegExp("(" + this.term + ")", "gi"),
                cls = this.options.highlightClass,
                template = "<span class='" + cls + "'>$1</span>",
                label = item.label.replace(re, template),
                $li = jQuery("<li/>").appendTo(ul);
        // Create and return the custom menu item content.
        jQuery("<a/>").attr("href", "#")
                .html(label)
                .appendTo($li);
        return $li;
    }
  });

  if(sr_length > 0){
    var _token = $('meta[name="csrf-token"]').attr('content');
    $(".searchbox_input").autocomplete({
      minLength: 3,
      //source: arr,
      source: function (request, response) {
          $.ajax({
              url: '{!! route("get-keyword-list") !!}',
              dataType: "json",
              type: "POST",
              data: {
                  keyword: request.term,
                  _token:_token
              },
              success: function (data) {
                response($.map(data.data, function (item) {
                    return {
                        label: item.name,
                        value: item.name    
                    }
                }));
              }
          });
      },
      select: function (event, ui) {
          $(this).val(ui.item.value);
          $("#home_searchbar_new").submit();
      }
    });
  } 
}
const stateData = [
    "Maharashtra", "Uttar Pradesh", "Karnataka", "Gujarat", "Chhattisgarh",
    "Goa"
];

const categoryData = [
    "Construction", "Healthcare", "IT Services", "Transport", "Education",
    "Software", "Furniture", "Agriculture", "Electrical", "Consulting"
];

const authorityData = [
    "NHAI", "CPWD", "PWD", "BHEL", "ONGC",
    "GAIL", "BPCL", "MoRTH", "PHED", "Railways"
];

// View All
function renderCards(containerId, dataList, limit = 5) {
   
const container = document.getElementById(containerId);
    container.innerHTML = '';

    const visibleItems = dataList.slice(0, limit);
    visibleItems.forEach(name => {
        const div = document.createElement('div');
        div.className = 'card-item';
        div.textContent = `${name} Tenders`;

        // redirect logic for each state/category/authority
        div.addEventListener('click', () => {
            let url = '';
            if (containerId === 'state-cards') {
                url = "{{ url('stateresult') }}/" + encodeURIComponent(name);
            } else if (containerId === 'category-cards') {
                url = "{{ url('categoryresult') }}/" + encodeURIComponent(name);
            } else if (containerId === 'authority-cards') {
                url = "{{ url('authoritiesresult') }}/" + encodeURIComponent(name);
            }
            if (url) {
                window.location.href = url;
            }
        });

        container.appendChild(div);
    });

    const viewAll = document.createElement('div');
    viewAll.className = 'card-item';
    viewAll.textContent = 'View All';

    // redirect logic for View All
    viewAll.addEventListener('click', () => {
        let url = '';
        if (containerId === 'state-cards') {
            url = "{{ route('state') }}";
        } else if (containerId === 'category-cards') {
            url = "{{ route('category') }}";
        } else if (containerId === 'authority-cards') {
            url = "{{ route('authorities') }}";
        }
        if (url) {
            window.location.href = url;
        }
    });

    container.appendChild(viewAll);
}

// Initial rendering
renderCards('state-cards', stateData, 4);
renderCards('category-cards', categoryData, 4);
renderCards('authority-cards', authorityData, 4);


</script>  
@endsection


