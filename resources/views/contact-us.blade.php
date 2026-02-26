@extends('layouts.app')
@section('content')
<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/page-header.jpg');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Contact</h2>
            <!-- <p>Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p> -->
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li>Contact</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Breadcrumbs -->
  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
      <div>
        <iframe style="border:0; width: 100%; height: 340px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3656.414363776547!2d72.3794728!3d23.5894679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c412d111e946f%3A0x7eb3d0d1e90cbcb3!2sIndia&#39;s%20Best%20GeM%20Tender%20Consultant%20%7C%20Best%20GeM%20Registration%20%26%20Bidding%20Submission%20Services!5e0!3m2!1sen!2sin!4v1692261599107!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div><!-- End Google Maps -->
      <div class="row gy-4 mt-4">
        <div class="col-lg-4">
          <div class="info-item d-flex">
            <i class="fas fa-location-dot flex-shrink-0"></i>
            <div>
              <h4>Location:</h4>
              <p>201, Royal Complex, Opp Mahavir Trading, Near Ramdev Sweet, Near Gayatri Mandir, Dharam Cinema Road, Mehsana, Gujarat 384001, India</p>
            </div>
          </div><!-- End Info Item -->
          <div class="info-item d-flex">
            <i class="fa fa-envelope flex-shrink-0"></i>
            <div>
              <h4>Email:</h4>
              <p>sales@gemtenderconsultant.in</p>
              <p>sales1@gemtenderconsultant.in</p>
            </div>
          </div><!-- End Info Item -->
          <div class="info-item d-flex">
            <i class="fas fa-phone flex-shrink-0"></i>
            <div>
              <h4>Call:</h4>
              <p>+91 9824 89 5546</p>
              <!-- <p>+91 9099 9221 01</p> -->
            </div>
          </div><!-- End Info Item -->

        </div>
        <div class="col-lg-8">
          <div class="errors"></div>
          <form class="quote-form" method="post" id="inquiry_form" name="inquiry_form" action="{{ route('userinquiry') }}">
            @csrf
            <input type="hidden" class="form-control" name="flag" value="contact-us" id="blog_popup_flag" autocomplete="off">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"  autocomplete="off" value="{{ old('name') }}">
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group mt-3 mt-md-0">
                <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Your Company"  value="{{ old('company_name') }}">
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                <input type="tel" name="user_primary_phone" class="form-control" id="user_primary_phone" placeholder="Your Mobile number"  onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" autocomplete="off">
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" >
              </div>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="looking_for" rows="5" placeholder="Message" ></textarea>
            </div>
            <div class="text-center mt-3">
              <button class="submit-btn border" type="submit">Submit</button>
            </div>
          </form>
        </div><!-- End Contact Form -->
      </div>
    </div>
  </section><!-- End Contact Section -->
</main><!-- End #main -->
<!-- End #main -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script type="text/javascript">
  $('#inquiry_form').on('submit', function(e) {
     e.preventDefault(); 
     var name = $('#name').val();
     var message = $('#message').val();
     $('.errors').empty().fadeIn();
     $.ajax({
         type: "POST",
         url: "{{ route('userinquiry') }}",
         data: $('#inquiry_form').serialize(),
         success: function(response) {
            if(response.success == true){
                var msg ='<div class="alert alert-success success_inquiry_pop_msg">';    
                    msg+=response.msg;
                    msg+='</div>';    
                    $('.errors').empty().append(msg).delay(5000).fadeOut();          
                $('#inquiry_form')[0].reset();
            }
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
@endsection