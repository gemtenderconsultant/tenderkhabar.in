<style type="text/css">
.has-error {
    color: red;
    font-size: 14px;
    float: left;
    margin-top: 5px;
}
</style>
<!-- Modal -->
<div class="modal fade" id="inquirymodal" tabindex="-1" aria-labelledby="inquirymodalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="inquirymodalLabel">Tender Information & Bidding</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form class="quote-form" method="post" id="inquiry_popup_form" name="inquiry_popup_form" action="">
      <div class="modal-body">
          <div class="errors"></div>  
          @csrf
          <input type="hidden" class="form-control" name="flag" value="{{ $flag }}" id="blog_popup_flag" autocomplete="off">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" autocomplete="off" value="">
              <span class="has-error name_error"></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group mt-3 mt-md-0">
              <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Your Company" value="">
              <span class="has-error company_name_error"></span>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
              <input type="tel" name="user_primary_phone" class="form-control" id="user_primary_phone" placeholder="Your Mobile number" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" autocomplete="off">
              <span class="has-error user_primary_phone_error"></span>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
              <span class="has-error email_error"></span>
            </div>
          </div>
          <div class="form-group mt-3 mb-3">
            <textarea class="form-control" name="looking_for" rows="3" placeholder="Message"></textarea>
            <span class="has-error looking_for_error"></span>
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
          <button type="submit" id="inquiry_popup_form" class="btn btn-dark">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
<script type="text/javascript">
     var formSubmitted;
$('#inquiry_popup_form').on('submit', function(e) {
   e.preventDefault(); 
   $('.has-error').empty();
   if (formSubmitted) return; 
        formSubmitted = true;

   $.ajax({
       type: "POST",
       url: "{!! route('userinquiry') !!}",
       data: $('#inquiry_popup_form').serialize(),
       success: function(response) {
          if(response.success == true){
              var msg ='<div class="alert alert-success success_inquiry_pop_msg">';    
                  msg+=response.msg+'Our Executive will connect Shortly';    
                  msg+='</div>';
                  $('.errors').empty().append(msg);          
                  setTimeout(function () {
                    $('#inquiry_popup_form')[0].reset();
                    $('#inquirymodal').modal('hide');
                      formSubmitted = false;
                  }, 500);
          }
       },
       error: function(xhr, status, error) 
        {
          $('.has-error').empty();
          $.each(xhr.responseJSON.errors, function (key, item) 
          {   
             $('.'+key+'_error').append(item);
             
          });
        }
   });
});
</script>