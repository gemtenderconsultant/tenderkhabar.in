<section id="contact" class="contact p-3">
  <div class="container" data-aos="fade-up">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="section-header">
              <span>Inquiry Now</span>
              <h2>Inquiry Now</h2>
            </div>
            <div class="errors"></div>
            <form class="quote-form" method="post" id="inquiry_form" name="inquiry_form" action="{{ route('userinquiry') }}">
              @csrf
              <input type="hidden" class="form-control" name="flag" value="{{$flag}}" id="blog_popup_flag" autocomplete="off">
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
          </div>
        </div>
      </div><!-- End Contact Form -->
    </div>
  </div>
</section><!-- End Contact Section -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> -->
<script type="text/javascript">
/*  $('#inquiry_form').on('submit', function(e) {
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
  });*/
  </script>