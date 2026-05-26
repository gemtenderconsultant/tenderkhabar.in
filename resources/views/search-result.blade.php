@extends('layouts.app')
@section('content')   
    <div class="search-result-bg-layer"></div>

    <div class="search-result-header">
        <div class="search-result-global-search">
             <i data-lucide="search" size="16"></i>
            <form action="{{ route('searchresults') }}" id="home_searchbar_new" method="get">
                <input type="text" name="searchbox" id="searchbox" placeholder="Type Keyword i.e. Road, Road Construction etc." value="{{ $keyword }}" autocomplete="off"  class="searchbox_input ui-autocomplete-input">
            </form>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
           <button class="search-result-btn-export" style="padding: 11px 16px; width: auto;">Advance Search</button>
        </div>
    </div>

    <main class="search-result-dashboard">
        <!-- SIDEBAR -->
        <aside class="search-result-sidebar">
             <input type="hidden" name="mobile_filter_value" value="0" id="mobile_filter_value">
               
            <div class="search-result-filter-section">
               <div class="search-result-select-wrapper">
                    <div class="search-result-select-trigger" onclick="toggleDropdown('stateDrop')">
                        <span>States</span>
                        <i data-lucide="chevron-down" size="14"></i>
                    </div>
                    <div id="stateDrop" class="search-result-select-dropdown">
                        <input type="text" class="search-result-dropdown-search" placeholder="Search..." onkeyup="filterOptions(this)">
                         @if($state_data->count() > 0)
                            @foreach($state_data as $key => $value)
                                <label class="search-result-option"><input class ="stateid" type="checkbox" name="Filters[state][]"
                                    value="{{$value->name}}" 
                                    data="{{$value->id}}"
                                    id="Filters_state_{{$value->id}}">{!! $value->name !!}</label>
                            @endforeach
                         @endif
                    </div>
                </div>
            </div>
            <div class="search-result-filter-section">
                <div class="search-result-select-wrapper">
                    <div class="search-result-select-trigger" onclick="toggleDropdown('orgDrop')">
                        <span>Department</span>
                        <i data-lucide="chevron-down" size="14"></i>
                    </div>
                    <div id="orgDrop" class="search-result-select-dropdown">
                        <input type="text" class="search-result-dropdown-search" placeholder="Search..." onkeyup="filterOptions(this)">
                        <div class="dipartment-list">
                            @if($department_data->count() > 0)
                                @foreach($department_data as $key => $value)
                                    <label class="search-result-option"><input type="checkbox" name="Filters[agency][]"
                                    @if(isset($selecetd_department) && $selecetd_department !="") 
                                        @if(in_array($value->id, $selecetd_department))
                                            {{ "checked=checked" }}
                                        @endif
                                    @endif 
                                    class="agencyid"
                                    data-title="{!! $value->agencyname !!}" 
                                    value="{{ $value->agencyid}}" 
                                    id="dipartment_{{ $value->agencyid}}" 
                                    data="{!! $value->agencyname !!}" 
                                    data-id="{{ $value->agencyid}}" 
                                     > {!! $value->agencyname !!}
                                    </label>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-result-filter-section city_filter" style="display:none;">
                <div style="position:relative;">
                    <div class="search-result-select-trigger" onclick="toggleDropdown('cityDrop')">
                        <span>City</span>
                        <i data-lucide="chevron-down" size="14"></i>
                    </div>
                    <div id="cityDrop" class="search-result-select-dropdown">
                        <input type="text" class="search-result-dropdown-search" placeholder="Search cities..." onkeyup="filterOptions(this)">
                        <div class="left_city_filters"></div>
                    </div>
                </div>
            </div>
            <div class="search-result-filter-section">
                <span class="search-result-filter-title">Contract Value</span>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="txtminprice" placeholder="Min" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border); font-size: 0.75rem;">
                    <input type="text"  id="txtmaxprice" placeholder="Max" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border); font-size: 0.75rem;">
                </div>
            </div>

            <div class="search-result-filter-section">
                    <div class="sw-header" onclick="toggleFilter('searchPanel', 'searchChevron')">
                        <i data-lucide="chevron-down" id="searchChevron" size="14"></i>
                        <span class="search-result-filter-title">SEARCH WITHIN</span>
                    </div>
                    <div id="searchPanel" class="sw-content ">
                        <input type="text" class="sw-input border-right-0" id="within-text" placeholder="Search" name="search" value="{{ isset($within_search) ? $within_search : '' }}">
                             
                        <label class="sw-checkbox-label">
                            <input type="checkbox"> <span>Exact Search</span>
                        </label>
                        <div class="input-group-btn" style="display: flex; justify-content: flex-end; margin-top: 10px;">
                                  <button class="sw-apply-btn within-btn" type="submit">Apply</button>
                              </div>
                    </div>
                </div>

                <div class="search-result-filter-section">
                    <div class="sw-header" onclick="toggleFilter('bidderPanel', 'bidderChevron')">
                        <i data-lucide="chevron-down" id="bidderChevron" size="14"></i>
                        <span class="search-result-filter-title">Bidder Name</span>
                    </div>
                    <div id="bidderPanel" class="sw-content ">
                        <input type="text" class="sw-input" placeholder="Search Bidder...">
                        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                            <button class="sw-apply-btn">Apply</button>
                        </div>
                    </div>
                </div>

                <div class="search-result-filter-section">
                    <div class="sw-header" onclick="toggleFilter('winnerbidderPanel', 'winnerbidderChevron')">
                        <i data-lucide="chevron-down" id="winnerbidderChevron" size="14"></i>
                        <span class="search-result-filter-title">Winner Bidder </span>
                    </div>
                    <div id="winnerbidderPanel" class="sw-content ">
                        <input type="text" class="sw-input" placeholder="Search Bidder...">
                        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                            <button class="sw-apply-btn">Apply</button>
                        </div>
                    </div>
                </div>
        </aside>
        <!-- FEED -->
        <section class="search-result-feed">
            <div class="search-result-feed-header">
                <div class="search-result-results-count">{!! !empty($total) ? $total : '' !!} <span>Matched Tender Results</span></div>
                 <div class="search-result-header-actions">
                    <div class="search-result-select-wrapper">
                        <div class="search-result-top-filter-btn" onclick="toggleDropdown('freshDrop')">
                            All Result <i data-lucide="chevron-down" size="14"></i>
                        </div>
                        <div id="freshDrop" class="search-result-select-dropdown" style="width: 120px;">
                            <div class="search-result-option" onclick="setSelect(this, 'All Result')">All Result</div>
                            <div class="search-result-option" onclick="setSelect(this, 'Fresh')">Fresh</div>
                        </div>
                    </div>
                    <div class="search-result-select-wrapper">
                        <div class="search-result-top-filter-btn" onclick="toggleDropdown('sortDrop')">
                            Sort By <i data-lucide="chevron-down" size="14"></i>
                        </div>
                        <div id="sortDrop" class="search-result-select-dropdown" style="width: 200px; right: 0;">
                            <div class="search-result-option">Relevance</div>
                            <div class="search-result-option">Awarded Value: High to Low</div>
                            <div class="search-result-option">Awarded Value: Low to High</div>
                            <div class="search-result-option">AOC Date: Asc to Desc</div>
                            <div class="search-result-option">AOC Date: Desc to Asc</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <div id="lev1">
                <!-- RESULT CARD -->
                @if(!empty($allEvents))
                    @foreach($allEvents as $key => $val)
                        @php 
                        $str = (strlen($val->title) > 280) ? substr($val->title, 0, 280).'...' : $val->title;
                            $res = explode(',',$keyword);
                            $sid = $val->id;
                            $smalldesc = substr($val->title, 0, 40);
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
                        <div class="search-result-result-row">
                            <div class="search-result-tender-info">
                                <span class="search-result-tender-id">TRD-{{ $val->id }}</span>
                                @if (!empty($res))
                                    @foreach($res as $key => $keyval) 
                                        @php $mkeyword = trim($keyval); @endphp 
                                        @if (!empty($mkeyword))
                                            @php $str = @preg_replace("/($mkeyword)/i", "<span class='khighlight'>$1</span>", $str); @endphp 
                                        @endif
                                    @endforeach
                                @endif
                                @if($str == "")
                                    @php $str = (strlen($val->title) > 80) ? substr($val->title, 0, 80).'...' : $val->title; @endphp 
                                @endif
                                <h3 class="search-result-tender-title">{!! $str !!}</h3>
                                <div class="search-result-winner-stripe">
                                    <i data-lucide="trophy" size="12" style="color:var(--gold)"></i>
                                    <span class="search-result-winner-label">Winner:</span>
                                    <span class="search-result-winner-name">{{ $val->selected_bidder }}</span>
                                </div>
                                <div class="search-result-meta-strip">
                                    <div class="search-result-meta-cell"><span class="search-result-m-label">Location</span><span class="search-result-m-val">{{ $val->city }}, {{ $val->state_name }}</span></div>
                                    <div class="search-result-meta-cell"><span class="search-result-m-label">Authority</span><span class="search-result-m-val">{{ $val->Organisation }}</span></div>
                                    <div class="search-result-meta-cell"><span class="search-result-m-label">Stage</span><span class="search-result-m-val">AOC</span></div>
                                    <div class="search-result-meta-cell"><span class="search-result-m-label">Submission Date</span><span class="search-result-m-val">{{ \Carbon\Carbon::parse($val->aoc)->format('D jS F, Y') }}</span></div>
                                </div>
                            </div>
                            <div class="search-result-result-side">
                                @php
                                    $amount = str_replace(',', '', $val->ti_amount);
                                        $amounts = number_format($amount);
                                    if($amount >= 10000000){
                                        $display = round($amount/10000000) . '+Cr';
                                    }elseif($amount >= 100000){
                                        $display = round($amount/100000) . '+L';
                                    }else{
                                        $display = number_format($amount);
                                    }
                                @endphp
                                <span class="search-result-award-amount">₹{{ $amounts }}</span>
                                <a class="search-result-btn-mini stretched-link" href="{{ route('tenderresultview',$val->id) }}" target="_blank"><i data-lucide="eye" size="15"></i></a>
                                
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
                </div>
                <div class="margin10"></div>
                <div id="loader_message"></div>
              </div>
            </div>
        </section>
    </main>
@endsection
@section('scripts')
    <script src="https://unpkg.com/lucide@latest"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 2. Then jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>

    <script type="text/javascript">
        @if(isset($page) && $page == "advancesearch")
            offset = 1;
            busy = false;
            $("#lev1").html('');
            setTimeout(function () {
                getFilter2();
            }, 1000);
        @endif  
        var busy = false;
        var offset = 1;
        var limit = 10; 
        var _token = $('meta[name="csrf-token"]').attr('content');
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
            $(".left_city_filters").html('');
            $(".city_filter").hide();
        }
        if (n > 0) {
            $.ajax({
                'type': 'POST',
                'url': "{{ route('city-filter-select2') }}",
                'data': {'data':selectedState,'_token':_token},
                'cache': false,
                'success': function (response){
                if(response.success == true){
                    $(".left_city_filters").html(response.data);
                    starting_point();
                    getFilter2();

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
            getFilter2();
        });

        $('body').on('click', '.agencyid,.within-btn,.city,#estimate_values', function () {
        starting_point();
            getFilter2();
        });

        let typingTimer;
        let doneTypingInterval = 800; // 0.8 second

        $('#txtminprice, #txtmaxprice').on('keyup', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                starting_point();
                getFilter2();
            }, doneTypingInterval);
        });
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    if (busy == false) {
                        busy = true;
                        offset++;
                        console.log('offset '+offset);
                        setTimeout(function () {
                            getFilter2();
                        }, 500);
                    }
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
                    if($("#estimate_values").prop( "checked")){
                    var est = 1;    
                    }else{
                    var est = ""; 
                    }
                    var within = $('#within-text').val();
                    $.ajax({
                        'type': 'POST',
                        'dataType': "json",
                        'url': '{{ route("gettenderresultslist") }}',
                        'data':{ "_token": $('meta[name="csrf-token"]').attr('content'),input_s_keyword:keyword,input_s_product:"",input_s_category:"",input_s_subcategory:"",input_s_eproduct:"",input_s_ecategory:"",input_s_esubcategory:"",input_s_state:state,input_s_city:city,input_s_org:agency,input_s_eorg:"",input_min_amount:minamount,input_max_amount:maxamount,input_estimate_values:est,input_within_search:within,input_ntid_search:"",input_publish_date:"",input_s_ekeyword:"",data:data,sortby:sortby,lpage:offset},

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
                                }else{  
                                busy = false;
                                $("#loader_message").html('<div class="loades text-center" ><b>Loading please wait...</b></button>').show();  
                                }
                                }else{
                                busy = false;
                                $("#loader_message").html('<div class="loades text-center" ><b>Loading please wait...</b></button>').show();
                                }
                            }
                        }
                    });  
                return false;
                }else{
                }
        }
        lucide.createIcons();
        function toggleDropdown(id) {
            document.querySelectorAll('.search-result-select-dropdown').forEach(d => {
                if(d.id !== id) d.classList.remove('active');
            });
            document.getElementById(id).classList.toggle('active');
        }
        function filterOptions(input) {
            const filter = input.value.toLowerCase();
            const options = input.parentElement.querySelectorAll('.search-result-option');
            options.forEach(opt => {
                const txt = opt.textContent.toLowerCase();
                opt.style.display = txt.includes(filter) ? "" : "none";
            });
        }
        window.onclick = function(e) {
            if (!e.target.closest('.search-result-select-trigger') && !e.target.closest('.search-result-select-dropdown')) {
                document.querySelectorAll('.search-result-select-dropdown').forEach(d => d.classList.remove('active'));
            }
        }
        function toggleFilter(panelId, chevronId) {
            const panel = document.getElementById(panelId);
            const chevron = document.getElementById(chevronId);
            
            // Toggle the 'active' class on the specific panel
            panel.classList.toggle('active');
            
            // Change the chevron icon based on whether it is active or not
            if (panel.classList.contains('active')) {
                chevron.setAttribute('data-lucide', 'chevron-up');
            } else {
                chevron.setAttribute('data-lucide', 'chevron-down');
            }
            
            // Tell Lucide to redraw the icons
            lucide.createIcons();
        }
    </script>
    
@endsection