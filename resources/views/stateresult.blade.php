@extends('layouts.app')
@section('content')   
    <div class="search-tender-bg-layer"></div>

    <header class="search-tender-header">
        <a href="#" class="search-tender-logo">
            <i data-lucide="shield-check" style="color:var(--gold)"></i>
            Tender<span>Khabar</span>
        </a>
        <div class="search-tender-global-search">
            <form action="{{ route('searchtenders') }}" id="home_searchbar_new" method="get">
            <i data-lucide="search" size="16"></i>
            <input type="text" placeholder="Search tenders..." id="searchbox" value="{{ (isset($statename) && $statename !='') ? $statename  : '' }}"  autocomplete="off" class="searchbox_input ui-autocomplete-input">
            </form>
        </div>
        <div style="display: flex; gap: 12px;">
            <button class="search-tender-btn-view" style="padding: 11px 16px; width: auto;">Advance Search</button>
        </div>
    </header>

    <main class="search-tender-dashboard">
        <!-- SIDEBAR -->
        <aside class="search-tender-sidebar">
            <div class="search-tender-filter-section">
                <input type="hidden" name="mobile_filter_value" value="0" id="mobile_filter_value">
                <div style="position:relative;">
                    <div class="search-tender-select-trigger" onclick="toggleDropdown('stateDrop')">
                        <span>States</span>
                        <i data-lucide="chevron-down" size="14"></i>
                    </div>
                    <div id="stateDrop" class="search-tender-select-dropdown">
                        <input type="text" class="search-tender-dropdown-search" placeholder="Search states..." onkeyup="filterOptions(this)">
                        @if($state_data->count() > 0)
                            @foreach($state_data as $key => $value)
                            <label class="search-tender-option">
                                <input type="checkbox"  name="Filters[state][]" class="form-check-input stateid" 
                                @if(isset($selecetd_state) && $selecetd_state !="") 
                                    @if(in_array($value->id, $selecetd_state))
                                    {{ "checked=checked" }}
                                    @endif
                                @endif
                                value="{{$value->name}}" 
                                data="{{$value->id}}"
                                id="Filters_state_{{$value->id}}" >  {!! $value->name !!}</label>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="search-tender-filter-section">
                <div style="position:relative;">
                    <div class="search-tender-select-trigger" onclick="toggleDropdown('authDrop')">
                        <span>Department</span>
                        <i data-lucide="chevron-down" size="14"></i>
                    </div>
                    <div id="authDrop" class="search-tender-select-dropdown">
                        <input type="text" class="search-tender-dropdown-search search-department" placeholder="Search..." id="search-department" onkeyup="filterOptions(this)">
                        <div class="dipartment-list">
                            @if($department_data->count() > 0)
                                @foreach($department_data as $key => $value)
                                    <label class="search-tender-option"><input type="checkbox" name="Filters[agency][]"
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
            <div class="search-tender-filter-section city_filter" style="display:none;">
                <div style="position:relative;">
                    <div class="search-tender-select-trigger" onclick="toggleDropdown('cityDrop')">
                        <span>City</span>
                        <i data-lucide="chevron-down" size="14"></i>
                    </div>
                    <div id="cityDrop" class="search-tender-select-dropdown">
                        <input type="text" class="search-tender-dropdown-search" placeholder="Search cities..." onkeyup="filterOptions(this)">
                        <div class="left_city_filter"></div>
                    </div>
                </div>
            </div>

            <div class="search-tender-filter-section">
                <span class="search-tender-filter-title">Procurement Value</span>
                <div style="display: flex; gap: 8px;">
                    <input type="text" id="txtminprice" placeholder="Min" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border); font-size: 0.75rem;">
                    <input type="text"  id="txtmaxprice" placeholder="Max" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border); font-size: 0.75rem;">
                </div>
            </div>
            <div class="search-tender-filter-section">
                <div style="position:relative;">
                  <select id="tender_check_status" class="search-tender-select-trigger pull-right">
                    <option value="live">Live</option>
                    <option value="fresh">Fresh</option>
                    <option value="archive">Archive</option>
                  </select>
                </div>  
            </div>  
            <div class="search-tender-filter-section">
                    <span class="search-tender-filter-title">Closing Date</span>
                     <div style="display: flex; gap: 8px;">
                       <input type="date" id="closingdate"  style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid var(--border); font-size: 0.95rem;">
                    </div>
            </div>  
        </aside>

        <!-- FEED -->
        <section class="search-tender-feed">
            <div class="search-tender-feed-header">
                <div class="search-tender-results-count">{!! !empty($total) ? "".$total."" : '' !!} <span>Tenders Found</span></div>
                <div style="display: flex; gap: 8px;">
                    <button class="search-tender-btn-mini" style="font-size: 0.9rem; font-weight: 700; padding: 10px 12px;">Most Recent</button>
                </div>
            </div>
            <div class="row">
                <div id="lev1">
                    @if(!empty($allEvents))
                        @foreach($allEvents as $key => $val)
                            @php 
                                $str = (strlen($val->Work) > 280) ? substr($val->Work, 0, 280).'...' : $val->Work;
                                $res = explode(',', $keyword ?? '');
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
                            <div class="search-tender-tender-row">
                                <div class="search-tender-tender-main">
                                    <span class="search-tender-badge gold">TKID: {{ $val->ourrefno }}</span>
                                    <span class="search-tender-badge">{{ $val->agencyname }}</span>
                                     @if (!empty($res))
                                            @foreach($res as $key => $keyval) 
                                                @php $mkeyword = trim($keyval); @endphp 
                                                @if (!empty($mkeyword))
                                                    @php $str = @preg_replace("/($mkeyword)/i", "<span class='khighlight'>$1</span>", $str); @endphp 
                                                @endif
                                            @endforeach
                                        @endif
                                        @if($str == "")
                                            @php $str = (strlen($val->Work) > 280) ? substr($val->Work, 0, 180).'...' : $val->Work; @endphp 
                                        @endif
                                    <h3>{!! $str !!}</h3>
                                    <div class="search-tender-info-strip">
                                        <div class="search-tender-info-cell"><span class="search-tender-cell-label">Location</span><span class="search-tender-cell-val">{{ $val->city }}, {{ $val->name }}, India</span></div>
                                        <div class="search-tender-info-cell"><span class="search-tender-cell-label">Authority</span><span class="search-tender-cell-val">{{ $val->org_name }}</span></div>
                                        <div class="search-tender-info-cell"><span class="search-tender-cell-label">EMD</span><span class="search-tender-cell-val">1 Cr</span></div>
                                        <div class="search-tender-info-cell"><span class="search-tender-cell-label">Closing</span><span class="search-tender-cell-val" style="color: #EF4444;">{{ $val->show_ti_submit_date }}</span></div>
                                    </div>
                                </div>
                                <div class="search-tender-tender-actions">
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
                                        
                                    <span class="search-tender-val-amount">₹{{ $amounts }}</span>
                                    <a class="search-tender-btn-view stretched-link" href="{{ route('tenderdetail', $val->ourrefno) }}" target="_blank">View Details</a>
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
        $('body').on('change', '#closingdate', function () {
            starting_point();
            getFilter2();
        });
        $(document).ready(function () {
            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
                    if (busy == false) {
                        busy = true;
                        offset++;
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
            var closingdate = $("#closingdate").val();
            if($("#estimate_values").prop( "checked")){
            var est = 1;    
            }else{
            var est = ""; 
            }
            var within = $('#within-text').val();

            $.ajax({
                'type': 'POST',
                'dataType': "json",
                'url': '{{ route("gettenderslist") }}',
                'data':{ "_token": $('meta[name="csrf-token"]').attr('content'),input_s_keyword:keyword,input_s_product:"",input_s_category:"",input_s_subcategory:category,input_s_eproduct:"",input_s_ecategory:"",input_s_esubcategory:"",input_s_state:state,input_s_city:city,input_s_org:agency,input_s_eorg:"",input_min_amount:minamount,input_max_amount:maxamount,input_closingdate:closingdate,input_estimate_values:est,input_within_search:within,input_ntid_search:ntid,input_publish_date:"",input_s_ekeyword:"",data:data,sortby:sortby,lpage:offset},
                'cache': false,
                beforeSend: function () {
                $("input[type='text']").prop("disabled", true);
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
        $('body').on('change','select[name="searchbar"]',function(){
            var ac = $(this).val();
            var ac_name = '';
            if (ac == 'Tenders') {
                ac_name = "{{ route('searchtenders') }}";
            }else if (ac == 'Tender Results') {
                ac_name = "{{ route('searchresults') }}";
            }
            $('#home_searchbar_new').attr('action', ac_name);
        });
    </script>
    
    <script type="text/javascript">
        lucide.createIcons();
        function toggleDropdown(id) {
            document.querySelectorAll('.search-tender-select-dropdown').forEach(d => {
                if(d.id !== id) d.classList.remove('active');
            });
            document.getElementById(id).classList.toggle('active');
        }
        function filterOptions(input) {
            const filter = input.value.toLowerCase();
            const options = input.parentElement.querySelectorAll('.search-tender-option');
            options.forEach(opt => {
                const txt = opt.textContent.toLowerCase();
                opt.style.display = txt.includes(filter) ? "" : "none";
            });
        }
        window.onclick = function(e) {
            if (!e.target.closest('.search-tender-select-trigger') && !e.target.closest('.search-tender-select-dropdown')) {
                document.querySelectorAll('.search-tender-select-dropdown').forEach(d => d.classList.remove('active'));
            }
        }
    </script>
@endsection