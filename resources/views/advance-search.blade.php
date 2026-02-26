@extends('layouts.app')
@section('stylesheet')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
.select2-container .select2-search--inline .select2-search__field{
  height: 1.5rem;
}
</style>
@endsection
@section('content')
<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('assets/img/page-header.jpg');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Advance Search</h2>
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li><a href="{{ asset('/') }}">Home</a></li>
          <li>Advance Search</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Breadcrumbs -->
  <!-- ======= Advance Search Section ======= -->
  <section id="about" class="about">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-md-10 offset-md-1 advance_search_form">
          <div class="card shadow">
            <div class="card-body">
              <form class="advance-search-form" method="GET" action="{{ route('postadvancesearch')}}">
                <div class="row">
                  <h1 class="text-center">Advance Search</h1>
                  <div class="col-lg-12 col-sm-12 col-md-12 col-12 mb-3">
                    <label class="mb-1">Keyword</label>
                    <input type="text" name="keyword" value="" class="form-control" placeholder="Search Keyword">
                  </div>
                  <div class="col-lg-6 col-sm-6 col-md-12 col-12 mb-3">
                    <label class="mb-1">State</label>
                    <select class="form-control form-control-lg js-example-basic-multiple stateid" multiple="multiple" name="state[]" id="stateid">
                      @if($state_data->count() > 0)
                        @foreach($state_data as $key => $value)
                        <option value="{{ $value->id }}">{!! $value->name !!}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="col-lg-6 col-sm-6 col-md-12 col-12 mb-3">
                    <label class="mb-1">City</label>
                    <select class="form-control form-control-lg js-example-basic-multiple city" multiple="multiple" name="city[]">
                    </select>
                  </div>
                  <div class="col-lg-6 col-sm-6 col-md-12 col-12 mb-3">
                      <label class="mb-1">GCID</label>
                      <input id="ntid" class="form-control" name="ntid" type="text" placeholder="GCID [ put comma separated between multiple values ]" autocomplete="off">
                    </div>
                  <!-- <div class="col-lg-6 col-sm-6 col-md-12 col-12 mb-3">
                    <label class="mb-1">Closing Date</label>
                    <input id="closing_date" class="form-control" name="closing_date" type="date" placeholder="Closing Date" autocomplete="off">
                  </div> -->
                  <div class="col-lg-6 col-sm-6 col-md-12 col-12 mb-3">
                    <label class="mb-1">Department</label>
                    <select class="form-control form-control-lg agency" multiple="multiple" name="agency[]" id="agency">Select Department</select>
                  </div>
                  <div class="col-lg-3 col-sm-3 col-md-12 col-12 mb-3">
                    <label class="mb-1">Min Amount</label>
                    <input id="min_amount" class="form-control" name="min_amount" type="text" placeholder="Min Amount" autocomplete="off">
                  </div>
                  <div class="col-lg-3 col-sm-3 col-md-12 col-12 mb-3">
                    <label class="mb-1">Max Amount</label>
                    <input id="max_amount" class="form-control" name="max_amount" type="text" placeholder="Max Amount" autocomplete="off">
                  </div>
                  <div class="col-lg-6 col-sm-6 col-md-12 col-12 mb-3">
                    <label class="mb-1">Within Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Search">
                  </div>
                  <div class="col-lg-12 col-sm-12 col-md-12 col-12">
                    <div class="form-check mt-3">
                      <input class="form-check-input" name="estimate_values" type="checkbox" value="no_estimates" id="estimate_values">
                      <label class="form-check-label" for="estimate_values">
                          Not Estimated Amount
                      </label>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-end">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <!-- <a href="{{ asset('/')}}" class="btn btn-secondary">Cancel</a> -->
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Advance Search Section -->
</main>
<!-- End #main -->
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var _token = $('meta[name="csrf-token"]').attr('content');

  $('.js-example-basic-multiple').select2({
    width:"100%",
    placeholder:"Select State",
  });
  $('.city').select2({
    width:"100%",
    placeholder:"Select City"
  });
  $('body').on('change ','.stateid', function () {
    var selectedState = new Array();
    var selectedState = $(this).val();
    $.ajax({
        'type': 'POST',
        'url': "{{ route('city-filter-select2') }}",
        'data': {'data':selectedState,'_token':_token},
        'cache': false,
        'success': function (response){
          if(response.success == true){
            $(".city").empty().append(response.data);
            $(".city").select2({
              width:"100%",
              placeholder:"Select City"
            })
          } 
        }
    });
  });
});

$(".agency").select2({
    placeholder:"Select Department",
    ajax: {
        url: '{{ route('getdepartmentlist') }}',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function(response) {
            return {
                results: response
            };
        },
        cache: true
    },
    escapeMarkup: function(markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 3,
});
</script>
@endsection