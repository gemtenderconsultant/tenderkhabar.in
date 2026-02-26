@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.css">
<style type="text/css">
.ui-widget-header {
    border: 1px solid #e78f08;
    background: var(--color-primary) url(images/ui-bg_gloss-wave_35_f6a828_500x100.png) 50% 50% repeat-x;
    color: #ffffff;
    font-weight: bold;
}
.ui-state-hover,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus {
    border: 1px solid #df5f39;
    font-weight: bold;
    color: #c73305;
}
#ui-id-1{margin-top: 15px !important;}
.accordion {
  --bs-accordion-btn-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
  --bs-accordion-btn-active-icon: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='white'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

input:active, input:focus { 
  border: 2px solid red;
  outline: none; // add this
  background-color: #ffffff;
}
.form-check-input:checked{
  background-color: var(--color-primary);
  border-color: var(--color-primary);
}
.form-check-input:focus {
  border-color: #e88060;
  outline: 0;
  box-shadow: 0 0 0 0.25rem rgb(194 148 112 / 25%);
}

#state label,#city label,.dipartment-list label{
  font-size: 14px;
}
.ui-menu .ui-menu-item{
  padding-bottom: 20px;
}

.ui-menu .ui-menu-item-wrapper{
  position: ABSOLUTE;
  WIDTH: 100%;
  padding: 8px 1em 8px .4em;
}

.ui-state-highlight, .ui-widget-content .ui-state-highlight{
  border: 1px solid var(--color-secondary);
  background: var(--color-secondary);
  color: #fff;
}
.ui-state-active{
  background-color: var(--color-secondary) !important;
  border: 1px solid var(--color-secondary) !important;
}
@media only screen and (max-width: 575px) {
  .SearchBox ul li.BtnBox button {
    padding: 10px 10px;
    font-size: 15px;
    right: 18px;
    width: 10%;
  }
  .hero form .form-control {
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 0px;
    padding-right: 0px;
    border: none;
    margin-right: 10px;
    border: none !important;
    background: none !important;
}

.hero form .btn-primary {
    background-color: var(--color-primary);
    border: var(--color-primary);
    padding: 10px 10px;
}
 
}
</style>
@endsection
@section('content')
<main id="main">
  <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="page-header d-flex align-items-center" style="background-image: url('../assets/img/page-header.jpg');">
        <div class="container position-relative">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-12 text-center">
                <h2>Search Latest Tenders</h2>
                <div class="SearchBox">
                  
                  <form action="{{ route('statesearch') }}" id="home_searchbar_new" method="get">
                    @csrf
                    <ul>
                      <li class="SlctBox">
                        <select name="searchbar">
                          <option value="Tender">Tender</option>
                          <option value="Tender Results">Tender Result</option>
                        </select>
                      </li>
                      <li class="InputBox">
                        <input type="text" name="searchbox" id="searchbox" placeholder="Type Keyword i.e. Road, Road Construction etc." value="{{ (isset($statename) && $statename !='') ? $statename  : '' }}" autocomplete="off"  class="searchbox_input ui-autocomplete-input">
                      </li>
                      <li class="BtnBox">
                        <button type="submit"><i class="fa fa-search"></i></button>
                      </li>
                    </ul>
                  </form>
                </div>
                <!-- <p>We at Marvel Infocomm Pvt. ltd. are highly concerned about the privacy of our customers and the website visitors.</p> -->
            </div>
          </div>
        </div>
      </div>
      <nav>
        <div class="container">
          <ol>
            <li><a href="{{ asset('/') }}">Home</a></li>
            <li><a href="{{ route('searchkeyword') }}">Search By Keyword</a></li>
            <li>Tenders</li>
          </ol>
        </div>
      </nav>
    </div>
    <section class="category_main pt-5 pb-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3 sidemenu">
            <button type="button" class="btn btn-block" id="mobile_close_filter"><i class="fa fa-times"></i>&nbsp;&nbsp;Close Filter</button>
            <div class="scrollbar_main">
              <div class="tender_filter_main">
                <!--<input type="hidden" name="cat_in" value="" id="cat_in">-->
                <input type="hidden" name="searchbox" value="fureniture" id="searchbox">
                <input type="hidden" name="mobile_filter_value" value="0" id="mobile_filter_value">
                <input type="hidden" name="ntid" value="{{ isset($selecetd_gcid) ? $selecetd_gcid : '' }}" id="ntid">
                <div class="card">
	                <div class="card-header">
	                    <h5 class="mb-0 p-2">Filters</h5>
	                </div>
                  <div class="card-body py-grid-gutter px-lg-grid-gutter">
                    <div class="accordion mb-2">
                      <!-- Within Search-->
                      <div class="accordion-item">
                         <h3 class="accordion-header"><a class="accordion-button" href="#within-search" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="within-search">Within Search</a></h3>
                        <div class="accordion-collapse collapse show" id="within-search" data-bs-parent="#within-search" style="">
                          <div class="accordion-body">
                            <div class="input-group mb-3">
                              <input type="text" class="form-control border-right-0" id="within-text" placeholder="Search" name="search" value="{{ isset($within_search) ? $within_search : '' }}">
                              <div class="input-group-btn">
                                  <button class="btn btn-secondary rounded-0 bg-primary within-btn" type="submit"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Within Search-->
                    <!-- State-->
                     
                    <div class="accordion mb-2">
                      <div class="accordion-item">
                         <h3 class="accordion-header"><a class="accordion-button" href="#state" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="state">State</a></h3>
                        <div class="accordion-collapse collapse show" id="state" data-bs-parent="#state">
                          <div class="accordion-body">
                          	<div class="form-group has-search state_div">
													    <input type="text" class="form-control search_filter_text  mb-3" placeholder="Search State" autocomplete="off">
													  </div>

                            <div class="col-12 search_filter_text_scroll">
                              @if($state_data->count() > 0)
                                @foreach($state_data as $key => $value)
                               
                                  <div class="form-check m-1 main">
                                    <input class="form-check-input stateid"
                                    name="Filters[state][]" 
                                    type="checkbox"
                                    @if(isset($selecetd_state) && $selecetd_state !="") 
                                      @if(in_array($value->id, $selecetd_state))
                                        {{ "checked=checked" }}
                                      @endif
                                    @endif
                                    value="{{$value->name}}" 
                                    data="{{$value->id}}"
                                    id="Filters_state_{{$value->id}}">
                                    <label class="form-check-label" for="Filters_state_{{$value->id}}">
                                        {!! $value->name !!}
                                    </label>
                                  </div>
                                @endforeach
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Within Search-->
                     <!-- city-->
                      
                    <div class="accordion mb-2 city_filter"  @if(isset($selecetd_state) && $selecetd_state !="") @else style="display: none;" @endif>
                      <div class="accordion-item ">
                         <h3 class="accordion-header"><a class="accordion-button" href="#city" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="city">City</a></h3>
                        <div class="accordion-collapse collapse show" id="city" data-bs-parent="#city">
                          <div class="accordion-body">
                            <div class="form-group has-search city_div">
                              <input type="text" class="form-control search_filter_text mb-3" placeholder="Search City" autocomplete="off">
                            </div>
                            <div class="col-12 left_city_filter search_filter_text_scroll">
                              @if(isset($selecetd_city_data) && $selecetd_city_data != "")
                               @if($selecetd_city_data->count() > 0)
                                @foreach($selecetd_city_data as $ckey => $cvalue)
                                  <div class="form-check m-1 main">
                                    <input class="form-check-input city" name="city" type="checkbox" 
                                    
                                    @if(isset($selected_city) && $selected_city !="") 
                                      @if(in_array($cvalue->name, $selected_city))
                                        {{ "checked=checked" }}
                                      @endif
                                    @endif
                                    value="{{ $cvalue->name }}" data="{{ $cvalue->name }}" id="city_{{ $cvalue->id }}">
                                    <label class="form-check-label" for="city_{{ $cvalue->id }}">
                                        {{ $cvalue->name }}
                                    </label>
                                  </div>
                                @endforeach
                                @endif
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Within Search-->
                    <!-- Department-->
                    <div class="accordion mb-2">
                      <div class="accordion-item">
                        <h3 class="accordion-header"><a class="accordion-button" href="#department" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="department">Department</a></h3>
                        <div class="accordion-collapse collapse show" id="department" data-bs-parent="#department" style="">
                          <div class="accordion-body">
                          	<input type="text" class="form-control mb-3 rounded-0 search-department" placeholder="Search Department" id="search-department" name="Search Department">
                            <div class="col-12  search_filter_text_scroll dipartment-list dipartment-div">
                              @if(isset($selecetd_agency_data) && $selecetd_agency_data != "")
                                @foreach($selecetd_agency_data as $key => $value)
                                  <div class="form-check m-1 main">
                                    <input class="form-check-input agencyid" data-title="{!! $value->agencyname !!}" type="checkbox" value="{{ $value->agencyid}}" id="dipartment_{{ $value->agencyid}}" data="{!! $value->agencyname !!}" data-id="{{ $value->agencyid}}" checked="checked"  name="Filters[agency][]"><label class="form-check-label" for="dipartment_{{ $value->agencyid}}">{!! $value->agencyname !!}</label></div>
                                @endforeach
                             @endif
                            </div>
                          </div>
                        </div>
                        <!-- Department-->
                      </div>
                    </div>
                    <!-- Tender Value-->
                    <div class="accordion mb-2">
                      <div class="accordion-item">
                        <h3 class="accordion-header"><a class="accordion-button" href="#tendervalue" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="tendervalue">Awarded Value</a></h3>
                        <div class="accordion-collapse collapse show" id="tendervalue" data-bs-parent="#tendervalue" style="">
                          <div class="accordion-body">
                            <!-- <p class="price">Min Max [50 lac]</p> -->
                            <div class="mb-2">
                              <label class="control-label filtertxtprice">Min <span id="minspan"></span></label>
                              <label class="control-label filtertxtprice">Max <span id="maxspan"></span></label>
                            </div>
                            <div class="col-12">
                              <div class="input-group mb-3">
                                <input type="text" id="txtminprice" name="txtminprice" placeholder="0.00 rs." min="1" readonly="" class="form-control filtertxtprice" value="{{ isset($selecetd_min_amount) ? $selecetd_min_amount : '' }}" autocomplete="off">
                                <input type="text" id="txtmaxprice" name="txtmaxprice" placeholder="0.00 rs." max="1000000" readonly="" class="form-control filtertxtprice" value="{{ isset($selecetd_max_amount) ? $selecetd_max_amount : '' }}" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-12">
                                <div id="slider-range"></div>
                            </div>
                            <div class="col-12">
                              <div class="form-check mt-3">
                                <input class="form-check-input"
                                name="estimate_values" 
                                type="checkbox" 
                                value="no_estimates" 
                                id="estimate_values" {{ isset($selecetd_estimate_values) && $selecetd_estimate_values != "" ? 'checked' : '' }}>
                                <label class="form-check-label" for="estimate_values">
                                    Not Estimated Amount
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <!-- Tender Value-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center mobile_apply_filter">
                <button type="button" class="btn btn-block" id="btn_apply_filter">Apply Filter</button>
            </div>
          </div>
          <div class="col-lg-9 col-sm-12 col-md-12 col-12 tender_list">
            <div class="tender_count">
              <div class="row">
                <div class="col-sm-7 col-12">
                   <h5 class="mt-2 active"><span class="box_number1">{!! !empty($total) ? "(".$total.")" : '' !!}</span> Matched Results</h5>
                </div>
                <div class="col-sm-2 col-6">
                  <select id="tender_check_status" class="form-control pull-right">
                    <option value="live">Live</option>
                    <option value="fresh">Fresh</option>
                    <option value="archive">Archive</option>
                  </select>
                </div>
                <div class="col-sm-3 col-6">
                  <select id="sortfilter" class="form-control pull-right">
                    <option value="">Sort By</option>
                    <option class="sortfilter" value="hl">
                        Price: High to Low
                    </option>
                    <option class="sortfilter" value="lh">
                        Price:Low to High
                    </option>
                    <option class="sortfilter" value="ad">
                        Closing Date:Asc to Desc
                    </option>
                    <option class="sortfilter" value="da">
                        Closing Date:Desc to Asc
                    </option>
                  </select>
                </div>
              </div>
             </div>
            <div class="row">

              <div id="lev1">

                 @if(!empty($allEvents))
                      
                        @foreach($allEvents as $key => $val)
                        
                        @php 
                           $str = (strlen($val->Work) > 280) ? substr($val->Work, 0, 280).'...' : $val->Work;
                            $res = explode(',',$statename);
                            $sid = $val->ourrefno;
                            $smalldesc = substr($val->Work, 0, 40);
                            $smalldesc = $smalldesc . " " . strtolower($val->city);
                            $smalldesc = preg_replace('/(\W+)/', ' ', $smalldesc);
                            $smalldesc = preg_replace('/[^a-z A-Z]/', '', $smalldesc);
                            $smalldesc = strtolower($smalldesc);
                            $smalldesc = trim($smalldesc);
                            $linkdesc = $smalldesc . " tenders " . $sid;
                            $linktitle = $smalldesc." tenders ";
                            $linktitle = ucwords($linktitle);
                            $linkdesctitle = $linktitle;
                            $linkdesc = urlencode($linkdesc);
                           
                            $linkdesc = str_replace('+', '-', $linkdesc);
                        @endphp 
 
                  <div class="col-12">
                    <div class="card mb-2">
                      <div class="card-body">
                        <div class="d-flex justify-content-between">
                          <p class="mb-2 org_main">
                            <span class="pe-2">
                              <i class="fa  fa-building me-2"></i>{{ $val->agencyname }}</span>
                            <span class="ps-2 date_status">
                              @if($val->submitdate >= date('Y-m-d'))
                                  @if($val->submitdate == date('Y-m-d'))
                                      <span>Ending Today</span>
                                  @else
                                      @php 
                                      $fdate = date('Y-m-d');
                                      $toDate = \Carbon\Carbon::parse($val->submitdate);
                                      $fromDate = \Carbon\Carbon::parse($fdate);
                                      $days = $toDate->diffInDays($fromDate);
                                      @endphp 
                                      <span>{{ $days }} days left</span>
                                  @endif
                              @endif
                            </span>
                          </p>
                          <p class="tenderid">GCID {{ $val->ourrefno }}</p>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            @if (!empty($res))
                                @foreach($res as $key => $keyval) 
                                    @php $mkeyword = trim($keyval); @endphp 
                                    @if (!empty($mkeyword))
                                         @php $str = @preg_replace("/($mkeyword)/i", "<span class='khighlight'>$1</span>", $str); @endphp 
                                    @endif
                                @endforeach
                            @endif
                            @if($str == "")
                                @php $str = (strlen($val->Work) > 280) ? substr($val->Work, 0, 280).'...' : $val->Work; @endphp 
                            @endif
                          <p class="desc">{!! $str !!}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <p class="mb-2 org_main">
                              <span class="pe-2 location"><i class="fa fa-map-marker"></i> {{ $val->city }}, {{ $val->name }}, India</span>
                              <span class="pe-2 ps-2 border-left"><i class="fa fa-calendar"></i> End Date: <span class="text-danger">{{ $val->show_ti_submit_date }}</span></span>
                              <span class="ps-2 pe-2 date_status"><i class="fa fa-inr"></i> {{ $val->ti_amount }}</span>
                          </p>
                          <p class="view_link">
                            <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('tenderview',$val->ourrefno) }}" title="View Tender" target="_blank"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('tenderview',$val->ourrefno) }}" title="Download Document" target="_blank"><i class="fa fa-download"></i></a>
                          </p>
                        </div>
                        <a class="stretched-link" href="{{ route('tenderview',$val->ourrefno) }}" target="_blank"></a>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  @endif

              </div> 

              <div class="LoadMoreBtnInner">
                <div id="loader_image">
                    <div class="loader-demo-box border-0">
                        <div class="bar-loader">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!--<span style="font-weight:bold">Loading please wait...</span>-->
                </div>
                <div class="margin10"></div>
                <div id="loader_message"></div>
                
                <!--<a href="#" class="LoadMore">LOAD MORE</a>-->
              </div>

            </div>
          </div>
          <!-- mobile filter -->
          <div class="mobile_filter_main p-0">
            <div class="mobile_other_btn">
              @if(!Auth::check())
              <a href="{{ route('login') }}" class="btn btn-light btn-block">Login</a>
              @else
              <a href="{{ route('contact-us') }}" class="btn btn-light btn-block">Contact</a>
              @endif
            </div>
            <div class="mobile_filter_btn_main">
              <button type="button" id="mobile_filter_btn" class="btn btn-secondary btn-block"><i class="fa fa-sliders"></i>&nbsp;&nbsp;Filters</button>
            </div>
          </div>
          <!-- mobile filter -->
        </div>
      </div>
    </section>
  
</main>
<!-- End #main -->
@endsection
@section('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>

<script type="text/javascript">
@if(isset($page) && $page == "advancesearch")
    offset = 1;
    busy == false;
    $("#lev1").html('');
    setTimeout(function () {
        getFilter2();
    }, 1000);
@endif  
/*$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();
    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('#date_range').val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        //starting_point();     
        //getfilter(offset,'date_range');
    }
    
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Tomorrow': [moment().add(1, 'days'), moment().add(1, 'days')],
            'Next 7 Days': [moment(), moment().add(6, 'days')],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
        }
    }, cb);
});*/
var busy = false;
var offset = 1;
var limit = 10; 

var _token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function () {

    var max = $("#txtminprice").val();
    var min = $("#txtmaxprice").val();
    if (min == '') {
        min = 0;
    }
    if (max == '') {
        max = 10000000000;
    }

    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 12,
        step: 1,
        slide: function(event, ui) {
            if (ui.values[0] == '1') {
                $("#txtminprice").val('100000');
                $("#minspan").text('[1 lac]');
            }
            if (ui.values[0] == '2') {
                $("#txtminprice").val('2500000');
                $("#minspan").text('[25 lac]');
            }
            if (ui.values[0] == '3') {
                $("#txtminprice").val('5000000');
                $("#minspan").text('[50 lac]');
            }
            if (ui.values[0] == '4') {
                $("#txtminprice").val('10000000');
                $("#minspan").text('[1 cr]');
            }
            if (ui.values[0] == '5') {
                $("#txtminprice").val('250000000');
                $("#minspan").text('[25 cr]');
            }
            if (ui.values[0] == '6') {
                $("#txtminprice").val('500000000');
                $("#minspan").text('[50 cr]');
            }
            if (ui.values[0] == '7') {
                $("#txtminprice").val('750000000');
                $("#minspan").text('[75 cr]');
            }
            if (ui.values[0] == '8') {
                $("#txtminprice").val('1000000000');
                $("#minspan").text('[100 cr]');
            }
            if (ui.values[0] == '9') {
                $("#txtminprice").val('5000000000');
                $("#minspan").text('[500 cr]');
            }
            if (ui.values[0] == '10') {
                $("#txtminprice").val('10000000000');
                $("#minspan").text('[1 k cr]');
            }
            if (ui.values[0] == '11') {
                $("#txtminprice").val('50000000000');
                $("#minspan").text('[5 k cr]');
            }
            if (ui.values[0] == '12') {
                $("#txtminprice").val('100000000000');
                $("#minspan").text('[10 k cr]');
            }
            if (ui.values[1] == '1') {
                $("#txtmaxprice").val('100000');
                $("#maxspan").text('[1 lac]');
            }
            if (ui.values[1] == '2') {
                $("#txtmaxprice").val('2500000');
                $("#maxspan").text('[25 lac]');
            }
            if (ui.values[1] == '3') {
                $("#txtmaxprice").val('5000000');
                $("#maxspan").text('[50 lac]');
            }
            if (ui.values[1] == '4') {
                $("#txtmaxprice").val('10000000');
                $("#maxspan").text('[1 cr]');
            }
            if (ui.values[1] == '5') {
                $("#txtmaxprice").val('250000000');
                $("#maxspan").text('[25 cr]');
            }
            if (ui.values[1] == '6') {
                $("#txtmaxprice").val('500000000');
                $("#maxspan").text('[50 cr]');
            }
            if (ui.values[1] == '7') {
                $("#txtmaxprice").val('750000000');
                $("#maxspan").text('[75 cr]');
            }
            if (ui.values[1] == '8') {
                $("#txtmaxprice").val('1000000000');
                $("#maxspan").text('[100 cr]');
            }
            if (ui.values[1] == '9') {
                $("#txtmaxprice").val('5000000000');
                $("#maxspan").text('[500 cr]');
            }
            if (ui.values[1] == '10') {
                $("#txtmaxprice").val('10000000000');
                $("#maxspan").text('[1 k cr]');
            }
            if (ui.values[1] == '11') {
                $("#txtmaxprice").val('50000000000');
                $("#maxspan").text('[5 k cr]');
            }
            if (ui.values[1] == '12') {
                $("#txtmaxprice").val('100000000000');
                $("#maxspan").text('[10 k cr]');
            }
        }
    });

    $("#slider-range").slider({
        change: function (event, ui) {
            //$(".page").val(1);
            //refineresult();  
            
             starting_point();
              //setTimeout(function () {
                  getFilter2();
              //}, 800);
        }
    });
    $('#slider-range').draggable();

});
$('body').on('click', '#mobile_filter_btn', function() {
    $("#mobile_filter_value").val(1);
    $('.sidemenu').show('slow');
});

$('body').on('click', '#btn_apply_filter', function() {
    $("#mobile_filter_value").val(0);
    $('.sidemenu').hide('slow');
    starting_point();
    getFilter2();
});

$('body').on('click', '#mobile_close_filter', function() {
    $("#mobile_filter_value").val(0);
    $('.sidemenu').hide('slow');
});

//search filter text
$('body').on('keyup','.search_filter_text',function(){
    var value = $(this).val().toLowerCase();
    var $li = $(this).parent().parent().parent("div").find(".main");
    $li.hide();
    $li.filter(function () {
        return $(this).text().toLowerCase().indexOf(value) > -1;
    }).show();
})

var dipartment_list = [];
var countdept = 1;
var busy_dept = false;
function tabloaddepartment(){
  if($('.dipartment-list').find('.form-check').length < 10){
      var url = "{{ asset('agency.json') }}";
      $.getJSON(url, function(data) { 
        $.each(data,function(i,item){ 
            dipartment_list.push({id:item.id,text:item.text}); 
        }); 
      });
      setTimeout(function () {
        get_dipartment_data();                
      },1000);
  }
}
tabloaddepartment();

function get_dipartment_data(){
  var searchField = $(".search-department").val().toLowerCase();
  var output = ''; 
  //console.log("ss "+subcategory_list.length);
  if(searchField === ''){
    $.each(dipartment_list,function(i,item){
      if (countdept > 16){ return false; }
      var ischecked = '';
      // if($(".remove_login_select_dipartment[data='"+item.name+"']").length > 0){
      //   ischecked = 'checked';
      // } 
      if($(".agencyid[data-id='"+item.id+"']").length == 0){    
        output+='<div class="form-check m-1 main">'+
                '<input class="form-check-input agencyid" data-title="'+item.text+'" '+ischecked+' type="checkbox" value="'+item.id+'" id="dipartment_'+item.id+'" data="'+item.text+'" data-id="'+item.id+'" name="Filters[agency][]" >'+
                '<label class="form-check-label" for="dipartment_'+item.id+'">'+item.text+'</label>'+
              '</div>';
         countdept++;
      }     
    });
  }else{
    if(searchField.length >=3){
      $.each(dipartment_list,function(i,item){
        if (countdept > 10){ return false; }
        var ischecked = '';
        // if($(".remove_login_select_dipartment[data='"+item.name+"']").length > 0){
        //   ischecked = 'checked';
        // } 
        var regex = new RegExp(searchField, "i");
        if (item.text.search(regex) != -1) {
          if($(".agencyid[data-id='"+item.id+"']").length == 0){ 
            output+='<div class="form-check m-1 main">'+
              '<input class="form-check-input agencyid" data-title="'+item.text+'" '+ischecked+' type="checkbox" value="'+item.id+'" id="dipartment_'+item.id+'" data="'+item.text+'" data-id="'+item.id+'" name="Filters[agency][]" >'+
              '<label class="form-check-label" for="dipartment_'+item.id+'">'+item.text+'</label>'+
            '</div>';
            countdept++;
          }  
        }
      });  
    }
  }
    //console.log("cc "+i);
  $('.dipartment-list').append(output);
  if(busy_dept){
    busy_dept = false;
  }
}

$(".dipartment-div").scroll(function(e) {
  e.preventDefault();
  var t = $(this)[0].scrollHeight - 100;
  var t2 = $(this).scrollTop() + $(this).innerHeight();
  var html = '';
  if(t2 >= t) {
    if (busy_dept == false) { 
      busy_dept = true;
      countdept = 1;
      get_dipartment_data();
    }
  }
});

$('body').on('keyup','.search-department',function(){
    $('.dipartment-list').html('');
      countdept = 1;
      busy_dept = false;
      // if($(".remove_login_select_dipartment").length > 0){
      //   $(".remove_login_select_dipartment").each(function () {
      //     var stitle = $(this).text();
      //     stitle = $.trim(stitle);
      //     if($(".agencyid[data-id='"+$(this).attr('data')+"']").length == 0){  
      //       $('.dipartment-list').append('<div class="form-check col-md-6"><input class="form-check-input agencyid" data-title="'+stitle+'" checked type="checkbox" value="'+$(this).attr('data')+'" id="dipartment_'+$(this).attr('data')+'" data="'+stitle+'" data-id="'+$(this).attr('data')+'" name="Filters[agency][]"/><label class="form-check-label" for="dipartment_'+$(this).attr('data')+'">'+stitle+'</label></div>');
      //     }
      //   });
      // }
     
    get_dipartment_data();
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
    $(".searchbox_input").autocomplete({
      minLength: 3,
      max:50,
      scroll:true,
      source: function (request, response) {
          $.ajax({
              url: "{{ route('get-keyword-list') }}",
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
                        value: item.name     // EDIT
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

$('body').on('click ', '.stateid', function () {
  var selectedState = new Array();
  var n = jQuery(".stateid:checked").length;
  if (n > 0) {
      $(".stateid:checked").each(function () {
          selectedState.push($(this).attr('data'));
      });
      $(".city_filter").show();
  }
  if (n == 0) {
      $(".left_city_filter").html('');
      $(".city_filter").hide();
  }
  if (n > 0) {
    $.ajax({
        'type': 'POST',
        'url': "{{ route('city-filter') }}",
        'data': {'data':selectedState,'_token':_token},
        'cache': false,
        'success': function (response){
          if(response.success == true){
            $(".left_city_filter").html(response.data);
            starting_point();
          //setTimeout(function () {
              getFilter2();
        // }, 800);

          } 
        }
    });
  }else{
        starting_point();
        setTimeout(function () {
              getFilter2();
        }, 800);
  }

});
$('body').on('change', '#tender_check_status,#sortfilter', function () {
  starting_point();
  //setTimeout(function () {
      getFilter2();
  //}, 800);
});

$('body').on('click', '.agencyid,.within-btn,.city,#estimate_values', function () {
  starting_point();
  //setTimeout(function () {
      getFilter2();
 // }, 800);
});

$(document).ready(function () {
       
    $(window).scroll(function () {
        // make sure u give the container id of the data to be loaded in.
        //var t = $(document).height() - 480;
        
        if($(window).width() < 767){
            var t = $(document).height() - 1750;
        } else {
            var t = $(document).height() - 600; // 480
        }
        var t2 = $(window).scrollTop() + $(window).height();
         
        //if ($(window).scrollTop() + $(window).height() > $("#livetender").height() && !busy) {
        if (t2 >= t) { 
            //alert(busy);
            if (busy == false) { 
              busy = true;
            offset = 1 + offset;
            setTimeout(function () {
            getFilter2();
            }, 500);  
            


            }
            /*if (busy == false) { 
            busy = true;
            offset = 1 + offset;
            // this is optional just to delay the loading of data
            setTimeout(function () {
                getfilter(offset,'loadmore');
            }, 500);
            }*/
            
            // you can remove the above code and can use directly this function
            // displayRecords(limit, offset);

        }
    });
});

function starting_point(){
    var check_filter = $("#mobile_filter_value").val();
    if(check_filter == 1){
        return false;
    }
    $("html, body").animate({ scrollTop: 116}, "slow");
    offset = 1;
    busy = false; 
    $("#lev1").html('');
}



function getFilter2() {
    var mobile_check = $("#mobile_filter_value").val();

    if(mobile_check == 0){

    /*checkselecteditems();
    var form_data = $('#filter_form').serializeArray();
    var data = $(".BtnSearch > .tablinksfilter.active").attr('data');
    if (typeof data === "undefined") {    
        data = $(".ArchToggle > .navbar-nav > li > .dropdown-menu > li > .active").attr('data'); 
    }
    var filter_scope = $(".sortfilter > .tablinksfilter.active").attr('data');
    form_data.push({'name':'data','value':data});
    form_data.push({'name':'sortby','value':filter_scope});
    form_data.push({'name':'lpage','value':offset});*/
    var keyword = $("#searchbox").val();
    var data =$("#tender_check_status").val();     
    if(data == ""){
        data = "live";
    }

    var ntid = $('#ntid').val();

      var sortby = $("#sortfilter").val();
      
      

      var state_id = new Array();
      var state_check = jQuery(".stateid:checked").length;
      if (state_check > 0) {
          jQuery(".stateid:checked").each(function () {
              state_id.push($(this).attr('data'));
          });
        var state = state_id.join(",");
      }else{
        var state = "";
      }

      var agency_id = new Array();
      var agency_check = jQuery(".agencyid:checked").length;
      if (agency_check > 0) {
          jQuery(".agencyid:checked").each(function () {
              agency_id.push($(this).val());
          });
        var agency = agency_id.join(",");
      }else{
        var agency = "";
      } 
      
      var category_id = new Array();
      var category_check = jQuery(".categoryid:checked").length;
      if (category_check > 0) {
          jQuery(".categoryid:checked").each(function () {
              category_id.push($(this).val());
          });
        var category = category_id.join(",");
      }else{
        var category = "";
      } 

      var city_id = new Array();
      var city_check = jQuery(".city:checked").length;
      if (city_check > 0) {
          jQuery(".city:checked").each(function () {
              city_id.push($(this).val());
          });
        var city = city_id.join(",");
      }else{
        var city = "";
      } 

    var minamount = $("#txtminprice").val();
    var maxamount = $("#txtmaxprice").val();
    //var est = $('input[name="estimate_values"]:checked').val();
    if($("#estimate_values").prop( "checked")){
       var est = 1;    
    }else{
      var est = ""; 
    }
    var within = $('#within-text').val();

    //if (busy == false) { 
     // busy = true;

    $.ajax({
            'type': 'POST',
            'dataType': "json",
            'url': '{{ route("gettenderslist") }}',
            'data':{ "_token": $('meta[name="csrf-token"]').attr('content'),input_s_keyword:keyword,input_s_product:"",input_s_category:"",input_s_subcategory:category,input_s_eproduct:"",input_s_ecategory:"",input_s_esubcategory:"",input_s_state:state,input_s_city:city,input_s_org:agency,input_s_eorg:"",input_min_amount:minamount,input_max_amount:maxamount,input_estimate_values:est,input_within_search:within,input_ntid_search:ntid,input_publish_date:"",input_s_ekeyword:"",data:data,sortby:sortby,lpage:offset},
            'cache': false,
            beforeSend: function () {
              $("input").prop("disabled", true);
              $("#loader_message").html("").hide();
              $('#loader_image').show();
            },
            success: function (html) {
                  
              $("#lev1").append(html.res1);
              $('#loader_image').hide();
              $("input").prop("disabled", false);
              if (html.res2 != '' && offset == 1) {
                  jQuery(".box_number1").empty();
                  jQuery(".active > .box_number1").append('('+html.res2+')');
              }else{
                 if(offset == 1){
                 jQuery(".box_number1").empty();
                 jQuery(".active > .box_number1").append(); 
                 }
              }
            
              if (html.res1 == "") {
                  $("#loader_message").html('<div class="loades text-center"><b>No more tenders.</b></div>').show();
              } else {
                  if(offset == 1){
                    if(html.total_count < 10){
                        busy = false;
                     //$("#loader_message").html('<div class="loades text-center" ><b>No more tenders.</b></button>').show();      
                    }else{  
                    busy = false;
                    $("#loader_message").html('<div class="loades text-center" ><b>Loading please wait...</b></button>').show();  
                    }
                  }else{
                   busy = false;
                   $("#loader_message").html('<div class="loades text-center" ><b>Loading please wait...</b></button>').show();
                  }
              }
                //window.busy = false;
            }

        });  

      //}      

    return false;
  }else{

  }
} 
$('body').on('change','select[name="searchbar"]',function(){
    var ac = $(this).val();
    var ac_name = '';
    if (ac == 'Tenders') {
        ac_name = "{{ route('searchtenders') }}";
    }else if (ac == 'Tender Results') {
        ac_name = "{{ route('searchresult') }}";
    }
    $('#home_searchbar_new').attr('action', ac_name);
});
</script>
@endsection