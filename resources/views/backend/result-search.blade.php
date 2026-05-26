@extends('backend.layouts.app')
@section('content')
    @php 
        $myuserproduct = array(); 
        $tenderfilters = array(); 
        $selected_eproductid = array(); 
        //dd(Session::get('loginuser.tender.filter'));
    @endphp 
    @php 
        $myuserproduct = Session::get('loginuser.tender.filter.0'); 
        $tenderfilters = Session::get('loginuser.tender.filter'); //dd($myuserproduct); 
    @endphp 
    @if(isset($type))
        @php 
        $myuserproduct = array(); 
        @endphp 
    @endif

    <div class="tender-listing-sticky-filters">  
        <div class="tender-listing-filter-ribbon">
             <!-- my Preferences -->
            @if(isset($tenderfilters))
            <div class="tender-listing-filter-item">
                 @foreach($tenderfilters as $tfk => $tfval) 
                <div class="tender-listing-filter-trigger" onclick="togglePanel('prefPanel')">My Preference <i data-lucide="chevron-down" size="14"></i></div>
                <div id="prefPanel" class="tender-listing-filter-panel" style="max-width: 350px;">
                    <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">My Filters</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                    <label class="tender-listing-checkbox-item" style="background: #f0f0f0; padding: 10px; border-radius: 8px;">
                        <input type="radio" {{ ($tfval['filter_name'] == "My Preference") ? "checked" : "" }} id="customCheck_{{ $tfval['id'] }}" data="{{ $tfval['id'] }}" data-main="{{ ($tfval['filter_name'] == "My Preference") ? 1 : 0 }}" name="example1"> {{ $tfval['filter_name'] }} {{ ($tfval['filter_name'] == "My Preference") ? "(Not Editable)" : "" }}
                    </label>
                    <div class="tender-listing-panel-footer">
                        <button class="tender-listing-btn-panel tender-listing-btn-apply filter_apply">Apply Filter</button></div>
                </div>
                 @endforeach
            </div>
            @endif <!-- end my Preferences -->
            <div class="tender-listing-filter-item">
                <div class="tender-listing-filter-trigger" onclick="togglePanel('catPanel')">Category <i data-lucide="chevron-down" size="14"></i></div>
                <div id="catPanel" class="tender-listing-filter-panel">
                    <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Search Category</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                    <input type="text" class="tender-listing-panel-search searchsubcategory" name="searchsubcategory" id="searchsubcategory" placeholder="Search Category..." onkeyup="filterChecks(this)">
                    <div class="tender-listing-selected-accordion">
                        <div class="tender-listing-accordion-header" onclick="toggleAccordion(this)">
                            <span>Selected Categories (<span class="tender-listing-sel-count">0</span>)</span>
                            <i data-lucide="chevron-down" size="16" class="tender-listing-acc-icon"></i>
                        </div>
                        <div class="tender-listing-accordion-body"></div>
                    </div>
                    <div class="tender-listing-checkbox-grid list_login_subcategory_list">
                         @if(isset($myuserproduct['subcategoryid']) && $myuserproduct['subcategoryid'] != '') @if(count(explode(',',$myuserproduct['subcategoryid'])) > 0) @php $subcategoryname = []; $subcategoryname = explode(',',$myuserproduct['subcategoryidname']); @endphp @foreach(explode(',',$myuserproduct['subcategoryid']) as $key => $row) 
                         <div class="list_category">
                        <label class="tender-listing-checkbox-item"><input class="subcategoryid" checked data-title="{{$subcategoryname[$key]}}" type="checkbox" value="{{$row}}" id="sFilters_subcategory_{{$row}}" data="{{$subcategoryname[$key]}}" name="Filters[subcategoryid][]"> {{$subcategoryname[$key]}}</label>
                        @endforeach @endif @endif @if(isset($type)) @if($type == "subcategory" && $selectedsubcategoryid != "") 
                        <label class="tender-listing-checkbox-item"><input class="subcategoryid" checked data-title="{{$selectedsubcategoryid}}" type="checkbox" value="{{$selectedsubcategoryid}}" id="sFilters_subcategory_{{$selectedsubcategoryid}}" data="{{$selectedsubcategoryname}}" name="Filters[subcategoryid][]">{{$selectedsubcategoryname}}</label>
                    </div>
                    @endif @endif
                    </div>
                    <div class="tender-listing-panel-footer">
                        <button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item btn_for_mobile" data="subcategory">Reset</button>
                        <button class="tender-listing-btn-panel tender-listing-btn-apply sector_apply" data="subcategory">Apply Now</button></div>
                    </div>
            </div>
            <div class="tender-listing-filter-item">
                    <div class="tender-listing-filter-trigger" onclick="togglePanel('keyPanel')">Keyword <i data-lucide="chevron-down" size="14"></i></div>
                    <div id="keyPanel" class="tender-listing-filter-panel">
                        <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Keywords</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                        <input type="text" class="tender-listing-panel-search search_filter_text_keyword" placeholder="Type keyword eg-civil, cable etc.">
                        
                        <div class="tender-listing-selected-accordion">
                            <div class="tender-listing-accordion-header" onclick="toggleAccordion(this)">
                                <span>Selected Keywords (<span class="tender-listing-sel-count">0</span>)</span>
                                <i data-lucide="chevron-down" size="16" class="tender-listing-acc-icon"></i>
                            </div>
                            <div class="tender-listing-accordion-body"></div>
                        </div>

                        <div class="tender-listing-checkbox-grid list_login_keyword_list">
                            <div class="keyword_list">
                            @if(isset($myuserproduct['keyword']) && $myuserproduct['keyword'] != '') @if(count(explode(',',$myuserproduct['keyword'])) > 0) @foreach(explode(',',$myuserproduct['keyword']) as $key => $row)
                            <label class="tender-listing-checkbox-item"><input type="checkbox" class="keywordid" data-title="keyword" checked value="{{$row}}" id="keyword_{{$row}}" data="{{$row}}" data-id="{{$row}}" name="Filters[keyword][]"> {{$row}}</label>
                            @endforeach @endif @endif @if(isset($type)) @if($type == "keyword" && $keyword != "") <div class="form-check col-md-6">
                            <label class="tender-listing-checkbox-item"><input type="checkbox" class="keywordid" data-title="keyword" checked value="{{$keyword}}" id="keyword_{{$keyword}}" data="{{$keyword}}" data-id="{{$keyword}}" name="Filters[keyword][]"> {{$keyword}}</label>
                                @endif @endif
                            </div>
                        </div>
                        <div class="tender-listing-panel-footer">
                        <button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item" data="keyword">Reset</button>
                        <button class="tender-listing-btn-panel tender-listing-btn-apply sector_apply" data="keyword">Apply Now</button>
                    </div>
                    </div>
                </div>

                <div class="tender-listing-filter-item">
                    <div class="tender-listing-filter-trigger" onclick="togglePanel('departPanel')">Department <i data-lucide="chevron-down" size="14"></i></div>
                    <div id="departPanel" class="tender-listing-filter-panel">
                        <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Department</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                        <input type="text" class="tender-listing-panel-search search-department" onkeyup="filterChecks(this)" placeholder="Search Department...">
                        
                        <div class="tender-listing-selected-accordion">
                            <div class="tender-listing-accordion-header" onclick="toggleAccordion(this)">
                                <span>Selected Departments (<span class="tender-listing-sel-count">0</span>)</span>
                                <i data-lucide="chevron-down" size="16" class="tender-listing-acc-icon"></i>
                            </div>
                            <div class="tender-listing-accordion-body"></div>
                        </div>

                        <div class="tender-listing-checkbox-grid dipartment-list">
                           <div class="list-department">
                             @if(isset($myuserproduct['Agency']) && $myuserproduct['Agency'] != '') @if(count(explode(',',$myuserproduct['Agency'])) > 0) @php $dipartment = []; $dipartment = explode(',',$myuserproduct['Agency_name']); @endphp @foreach(explode(',',$myuserproduct['Agency']) as $key => $row)
                            <label class="tender-listing-checkbox-item"><input class="agencyid" data-title="dipartment" type="checkbox" value="{{$row}}" id="dipartment_{{$row}}" data="{{$dipartment[$key]}}" data-id="{{$row}}" checked name="Filters[agency][]"> {{$dipartment[$key]}}</label>
                             @endforeach @endif @endif @if(isset($type)) @if($type == "agency" && $selectedagencyid != "") 
                            <label class="tender-listing-checkbox-item"><input class="agencyid" data-title="dipartment" type="checkbox" value="{{$selectedagencyid}}" id="dipartment_{{$selectedagencyid}}" data="{{$selectedagencyname}}" data-id="{{$selectedagencyid}}" checked name="Filters[agency][]"> Agriculture</label>
                            @endif @endif
                            </div>
                        </div>

                        <div class="tender-listing-panel-footer">
                            <button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item" data="Dipartment">Reset</button>
                            <button class="tender-listing-btn-panel tender-listing-btn-apply sector_apply" data="Dipartment">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="tender-listing-filter-item">
                    <div class="tender-listing-filter-trigger" onclick="togglePanel('statePanel')">State <i data-lucide="chevron-down" size="14"></i></div>
                    <div id="statePanel" class="tender-listing-filter-panel">
                        <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Search State</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                        <input type="text" class="tender-listing-panel-search searchkeywords" placeholder="Search State...">
                        
                        <div class="tender-listing-selected-accordion">
                            <div class="tender-listing-accordion-header" onclick="toggleAccordion(this)">
                                <span>Selected States (<span class="tender-listing-sel-count">0</span>)</span>
                                <i data-lucide="chevron-down" size="16" class="tender-listing-acc-icon"></i>
                            </div>
                            <div class="tender-listing-accordion-body"></div>
                        </div>

                        <div class="tender-listing-checkbox-grid state_list">
                            <div class="list-state">
                             @if(isset($myuserproduct['state']) && $myuserproduct['state'] != '') @if(count(explode(',',$myuserproduct['state'])) > 0) @php $state = []; $state = explode(',',$myuserproduct['state_name']); @endphp @foreach(explode(',',$myuserproduct['state']) as $key => $row) 
                                <label class="tender-listing-checkbox-item"><input class="stateid" type="checkbox" checked value="{{$row}}" id="sFilters_state_{{$row}}" name="Filters[state][]" data="{{$state[$key]}}"> {{$state[$key]}}</label>
                                @endforeach @endif @endif @if(isset($type)) @if(($type == "state" && $selectedstateid != "") || ($type == "city" && $selectedcityname !="")) 
                                <label class="tender-listing-checkbox-item"><input class="stateid" type="checkbox" checked value="{{$selectedstateid}}" id="sFilters_state_{{$selectedstateid}}" name="Filters[state][]" data="{{$selectedstatename}}"> {{$selectedstatename}}</label>
                                @endif @endif 
                             </div>
                        </div>
                        <div class="tender-listing-panel-footer">
                            <button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item" data="state">Reset</button>
                            <button class="tender-listing-btn-panel tender-listing-btn-apply sector_apply" data="state">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="tender-listing-filter-item">
                    <div class="tender-listing-filter-trigger" onclick="togglePanel('cityPanel')">City <i data-lucide="chevron-down" size="14"></i></div>
                    <div id="cityPanel" class="tender-listing-filter-panel">
                        <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Search City</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                        <input type="text" class="tender-listing-panel-search" onkeyup="filterChecks(this)" placeholder="Search City...">
                        
                        <div class="tender-listing-selected-accordion">
                            <div class="tender-listing-accordion-header" onclick="toggleAccordion(this)">
                                <span>Selected Cities (<span class="tender-listing-sel-count">0</span>)</span>
                                <i data-lucide="chevron-down" size="16" class="tender-listing-acc-icon"></i>
                            </div>
                            <div class="tender-listing-accordion-body"></div>
                        </div>
                        <div class="tender-listing-checkbox-grid city_list">
                            <div class="list-city">
                            @if(isset($type)) @if($type == "city" && $selectedcityname != "") 
                            <label class="tender-listing-checkbox-item"><input class="cityid" type="checkbox" checked value="{{$selectedcityid}}" id="sFilters_city_{{$selectedcityid}}" name="Filters[city][]" data="{{$selectedcityname}}"> {{$selectedcityname}}</label>
                            @endif @endif 
                            </div>
                        </div>
                        <div class="tender-listing-panel-footer">
                            <button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item" data="city">Reset</button>
                            <button class="tender-listing-btn-panel tender-listing-btn-apply sector_apply" data="city">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="tender-listing-filter-item">
                    <div class="tender-listing-filter-trigger" onclick="togglePanel('amtPanel')">Amount <i data-lucide="chevron-down" size="14"></i></div>
                    <div id="amtPanel" class="tender-listing-filter-panel">
                        <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Amount Range</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                        <div class="tender-listing-amount-row">
                            <div class="tender-listing-amount-input-group">
                                <label>Minimum Amount</label>
                                <div class="tender-listing-input-with-icon"><span>₹</span><input type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="txtminprice" name="min_amount" value="{{ (isset($tenderfilters) && $tfval['Min_Amount'] != '') ? $tfval['Min_Amount'] : '' }}" placeholder="Enter Amount"></div>
                            </div>
                            <div class="tender-listing-amount-input-group">
                                <label>Maximum Amount</label>
                                <div class="tender-listing-input-with-icon"><span>₹</span><input type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="txtmaxprice" name="max_amount" value="{{ (isset($tenderfilters) && $tfval['Max_Amount'] != '') ? $tfval['Max_Amount'] : '' }}" placeholder="Enter Amount"></div>
                            </div>
                        </div>
                        <label class="tender-listing-checkbox-item" style="margin-top: 15px;"><input type="checkbox" class="chk_estimate" name="estimate_values" value="1" id="estimate_values"> Not Estimated Amount</label>
                        <div class="tender-listing-panel-footer">
                            <button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item" data="tenderamount">Reset</button>
                            <button class="tender-listing-btn-panel sector_apply tender-listing-btn-apply" data="tenderamount">Apply Now</button></div>
                    </div>
                </div>

                <div class="tender-listing-filter-item">
                    <div class="tender-listing-filter-trigger" onclick="togglePanel('morePanel')">More Filters <i data-lucide="chevron-down" size="14"></i></div>
                    <div id="morePanel" class="tender-listing-filter-panel" style="max-width: 500px;">
                        <div class="tender-listing-panel-header"><span class="tender-listing-panel-title">Advanced Search</span><i data-lucide="x" class="tender-listing-panel-close" onclick="closeAll()"></i></div>
                        <div class="tender-listing-more-filters-form">
                            <div class="tender-listing-form-row"><label>Within Search</label><input type="text" class="clearallinput" id="Filters_keyword2" value="" placeholder="Search For Tenders i.e : road, valve" autocomplete="off"></div>
                            <div class="tender-listing-form-row"><label>Publish Date</label><input type="date" class="clearallinput" id="Filters_dt" placeholder="Search For datewise" autocomplete="off"></div>
                            <div class="tender-listing-form-row"><label>TRID Search</label><input type="text" class="clearallinput" id="Filters_ntid" placeholder="Search For GCID i.e : 26974461, 26974160" autocomplete="off"></div>
                            <div class="tender-listing-form-row"><label>Portal Search</label><select class="portal" name="portal" id="portal">
                          <option {{ (isset($myuserproduct['portal']) && $myuserproduct['portal'] == '') ? 'selected' : '' }} value="">ALL</option>
                          <option {{ (isset($myuserproduct['portal']) && $myuserproduct['portal'] == 'GEM') ? 'selected' : '' }} value="GEM">GEM</option>
                          <option {{ (isset($myuserproduct['portal']) && $myuserproduct['portal'] == 'NON-GEM') ? 'selected' : '' }} value="NON-GEM">NON GEM</option>
                        </select></div>
                        </div>
                        <div class="tender-listing-panel-footer"><button class="tender-listing-btn-panel tender-listing-btn-reset-panel btn_clear_selected_item" data="morefilter">Reset</button>
                        <button class="tender-listing-btn-panel tender-listing-btn-apply sector_apply" data="morefilter" >Apply Now</button></div>
                    </div>
                </div>
                <button class="tender-listing-filter-trigger tender-listing-btn-reset-top btn_clear_selected_item"  data="clearallfilter">Reset Filter</button>
            </div>
        </div>
    
     <form id="filter_form"> @csrf <input type="hidden" name="input_s_product" value="{{ (isset($myuserproduct['productid']) && $myuserproduct['productid'] != '') ? $myuserproduct['productid'] : '' }}">
              <input type="hidden" name="input_s_eproduct" value="{{ (isset($myuserproduct['exe_productid']) && $myuserproduct['exe_productid'] != '') ? $myuserproduct['exe_productid'] : '' }}">
              <input type="hidden" name="input_s_category" value="{{ isset($type) && ($type == 'category' || $type == 'subcategory') ? $selectedcategoryid : ((isset($myuserproduct['categoryid']) && $myuserproduct['categoryid'] != '') ? $myuserproduct['categoryid'] : '') }}" />
              <input type="hidden" name="input_s_ecategory" value="{{ (isset($myuserproduct['exe_categoryid']) && $myuserproduct['exe_categoryid'] != '') ? $myuserproduct['exe_categoryid'] : '' }}">
              <input type="hidden" name="input_s_subcategory" value="{{ isset($type) && $type == 'subcategory' ? $selectedsubcategoryid : ((isset($myuserproduct['subcategoryid']) && $myuserproduct['subcategoryid'] != '') ? $myuserproduct['subcategoryid'] : '') }}">
              <input type="hidden" name="input_s_esubcategory" value="{{ (isset($myuserproduct['exe_subcategoryid']) && $myuserproduct['exe_subcategoryid'] != '') ? $myuserproduct['exe_subcategoryid'] : '' }}">
              <input type="hidden" name="input_s_keyword" value="{{ isset($type) && ($type == 'keyword') ? $keyword : ((isset($myuserproduct['keyword']) && $myuserproduct['keyword'] != '') ? $myuserproduct['keyword'] : '') }}">
              <input type="hidden" name="input_s_ekeyword" value="{{ (isset($myuserproduct['excludingkeyword']) && $myuserproduct['excludingkeyword'] != '') ? $myuserproduct['excludingkeyword'] : '' }}">
              <input type="hidden" name="input_s_org" value="{{ isset($type) && ($type == 'agency') ? $selectedagencyid : ((isset($myuserproduct['Agency']) && $myuserproduct['Agency'] != '') ? $myuserproduct['Agency'] : '') }}">
              <input type="hidden" name="input_s_eorg" value="{{ (isset($myuserproduct['excluding_agency']) && $myuserproduct['excluding_agency'] != '') ? $myuserproduct['excluding_agency'] : '' }}">
              <input type="hidden" name="input_s_state" value="{{ isset($type) && ($type == 'state' || $type == 'city') ? $selectedstateid : ((isset($myuserproduct['state']) && $myuserproduct['state'] != '') ? $myuserproduct['state'] : '') }}">
              <input type="hidden" name="input_s_city" value="{{ isset($type) && ($type == 'city') ? $selectedcityname : ((isset($myuserproduct['city']) && $myuserproduct['city'] != '') ? $myuserproduct['city'] : '') }}">
              <input type="hidden" name="input_min_amount" value="{{ (isset($myuserproduct['Min_Amount']) && $myuserproduct['Min_Amount'] != '') ? $myuserproduct['Min_Amount'] : '' }}">
              <input type="hidden" name="input_max_amount" value="{{ (isset($myuserproduct['Max_Amount']) && $myuserproduct['Max_Amount'] != '') ? $myuserproduct['Max_Amount'] : '' }}">
              <input type="hidden" name="input_estimate_values" value="{{ (isset($myuserproduct['estimate_values']) && $myuserproduct['estimate_values'] != '') ? $myuserproduct['estimate_values'] : '' }}">
              <input type="hidden" name="input_within_search" value="{{ (isset($myuserproduct['refine_keyword']) && $myuserproduct['refine_keyword'] != '') ? $myuserproduct['refine_keyword'] : '' }}">
              <input type="hidden" name="input_publish_date" value="{{ (isset($myuserproduct['tender_publish_date']) && $myuserproduct['tender_publish_date'] !='') ? $myuserproduct['tender_publish_date'] : '' }}">
              <input type="hidden" name="input_ntid_search" value="">
              <input type="hidden" name="input_isexactkeyword_values" value="{{ (isset($myuserproduct['is_exact_keyword']) && $myuserproduct['is_exact_keyword'] == 1) ? 1 : 0 }}">
              <input type="hidden" name="input_portal_search" value="{{ (isset($myuserproduct) ? (($myuserproduct['portal'] == '') ? '' : $myuserproduct['portal']) : '') }}">
              <input id="searchbox" class="clearallinput" type="hidden" name="Filters[searchbox]" value="">
            </form> 

    
    <div class="tender-listing-toolbar">
        <div class="tender-listing-status-switches">
             @php
                if(isset($_GET['data'])){
                  $selecttype = $_GET['data'];
                }else{
                  $selecttype = 'live';
                }
              @endphp
            <div class="tender-listing-switch tender-listing-active"
                data="live"
                onclick="toggleStatus(this)">
                Live
                <span class="box_number1"></span>
            </div>
            <div class="tender-listing-switch"
                data="fresh"
                onclick="toggleStatus(this)">
                Fresh
                <span class="box_number1"></span>
            </div>
        </div>
        <div style="display: flex; gap: 15px; align-items: center;">
          
            <select class="sortfilter" style="background: transparent; border: 1px solid rgba(255,255,255,0.2); color: white; padding: 5px; border-radius: 4px; font-size: 0.7rem;">
                <option value="" style="color:#000;">Relevance</option>
                <option value="hl" style="color:#000;" >Price: High to Low</option>
                <option value="lh" style="color:#000;">Price: Low to High</option>
                <option value="ad" style="color:#000;">Closing Date: Asc to Desc</option>
                <option value="da" style="color:#000;">Closing Date: Desc to Asc</option>
            </select>
        </div>
    </div>
    <main class="tender-listing-content-area">
        <div id="Live" class="p-0 mt-3">
            <div id="lev1"></div>
            <div class="LoadMoreBtnInner">
              <div id="loader_image" class="text-center">
                <div class="loader-demo-box border-0">
                  <div class="bar-loader">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                  </div>
                </div>
              </div>
              <div id="loader_message" class=""></div>
            </div>
          </div>
    </main>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/main.js') }}"></script>
<script type="text/javascript">
    @if(isset($page) && $page == "tenderresultlisting")
    offset = 1;
    busy = false;
    $("#lev1").html('');
    setTimeout(function () {
        getFilter2(offset);
    }, 1000);
    @else
    checkselecteditems();
    @endif

    var is_sucategory_tab = false;
    var is_keyword_tab = false;
    var is_department_tab = false;
    var is_state_tab = false;
    var is_city_tab = false;

    function togglePanel(id) {
        const panels = document.querySelectorAll('.tender-listing-filter-panel');
        const current = document.getElementById(id);
        const isOpen = current.classList.contains('tender-listing-active');

        panels.forEach(p => p.classList.remove('tender-listing-active'));

        if (!isOpen) {
            current.classList.add('tender-listing-active');

            // 🔽 Load data based on panel
            if (id === "catPanel" && is_sucategory_tab === false) {
                tabloadcategory();
                is_sucategory_tab = true;
            }

            if (id === "keyPanel" && is_keyword_tab === false) {
                tabloadkeyword();
                is_keyword_tab = true;
            }

            if (id === "departPanel" && is_department_tab === false) {
                tabloaddepartment();
                is_department_tab = true;
            }

            if (id === "statePanel" && is_state_tab === false) {
                tabloadstate();
                is_state_tab = true;
            }

            if (id === "cityPanel" && is_city_tab === false) {
                tabloadcity();
                is_city_tab = true;
            }
        }
    }
    function closeAll() {
        document.querySelectorAll('.tender-listing-filter-panel').forEach(p => p.classList.remove('tender-listing-active'));
    }

    // Click outside logic
    window.onclick = function(event) {
        if (!event.target.closest('.tender-listing-filter-item')) {
            closeAll();
        }
    }
    $('body').on('click', '.delete_filter_ok', function (e) {
    var fid = $(this).attr('data');
    if(fid != ""){
        $.ajax({
        'type': 'POST',
        'url': '{{route("tenderlist-filterdelete")}}',
        'data': {"_token": $('meta[name="csrf-token"]').attr('content'),"fid": fid},
        'cache': false,
        'success': function (res) {
            $('div[data="main_card_'+fid+'"]').remove();
            $("#umodalFilterSave").attr('data','');
            toastr.success('Success', res.msg, {timeOut: 1500});
        }
        });
    }
    });

    $('body').on('click', '.like', function(){    
    var clickli = $(this);
    var id = $(this).attr('data');
    var fclass = clickli.find('i').attr('class');

    if(id != ""){
        $.ajax({
        'type': 'POST',
        'url': '{{route("favoritetender")}}',
        'data': {"_token": $('meta[name="csrf-token"]').attr('content'),"fclass":fclass,"id": id},
        'cache': false,
        'success': function (res) {
            if(fclass == "fa-regular fa-heart"){
                clickli.find('i').attr('class','fa-solid fa-heart');
            }else{
                clickli.find('i').attr('class','fa-regular fa-heart'); 
            }
        }
        });
    }
    });

    function getFilter2(offset) {
    checkselecteditems();
    var form_data = $('#filter_form').serializeArray();
    var data = $(".tender-listing-active").attr('data');
    var filter_scope = $('input[name=radioSort]:checked').val();
    form_data.push({'name':'data','value':data});
    form_data.push({'name':'sortby','value':filter_scope});
    form_data.push({'name':'lpage','value':offset});

    $.ajax({
        'headers': {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        'type': 'POST',
        'dataType': "json",
        'url': '{{ route("backendgettenderresultlist") }}',
        'data':form_data,
        'cache': false,
        beforeSend: function () {
            $("#loader_message").html("").hide();
            $('#loader_image').show();
        },
        success: function (html) {
                $("#lev1").append(html.res1);
                $('#loader_image').hide();
                if (html.res2 != ' ' && offset == 1) {
                    jQuery(".box_number1").empty();
                    jQuery(".tender-listing-active .box_number1").append('('+html.res2+')');
                }else{
                if(offset == 1){
                jQuery(".box_number1").empty();
                jQuery(".tender-listing-active .box_number1").append('(0)'); 
                }
                }
            
                if (html.res1 == "") {
                    $("#loader_message").html('<div class="alert alert-primary alert-dismissible fade show" role="alert">No more tenders.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>').show();
                } else {
                    if(offset == 1){
                    if(html.total_count < 10){
                        busy = false;
                    }else{  
                    busy = false;
                    $("#loader_message").html('<div class="text-center" ><b>Loading please wait...</b></button>').show();  
                    }
                    }else{
                    busy = false;
                    $("#loader_message").html('<div class="text-center" ><b>Loading please wait...</b></button>').show();
                    }
                }
            }
        });    
    return false;
    }
    $('body').on('click','.close-btn',function(e){
    $(this).parents('.dropdown').find('button.dropdown-toggle').dropdown('toggle');
    });

    $('.sortfilter').on('change', function () {
        offset = 1;
        busy == false;
        $("#lev1").html('');
        getFilter2(offset);
    });

    $(function() {
    //add BT DD show event
    $("#scroll-div .dropdown").on("show.bs.dropdown", function() {
        var $btnDropDown = $(this).find(".dropdown-toggle");
        var $listHolder = $(this).find(".dropdown-menu");
        //reset position property for DD container
        $(this).css("position", "static");
        $listHolder.css({
        "top": ($btnDropDown.offset().top + $btnDropDown.outerHeight(true)) + "px",
        "left": $btnDropDown.offset().left + "px"
        });
        $listHolder.data("open", true);
    });
    //add BT DD hide event
    $("#scroll-div .dropdown").on("hidden.bs.dropdown", function() {
        var $listHolder = $(this).find(".dropdown-menu");
        $listHolder.data("open", false);
    });

    });

    function filterChecks(input) {
        const filter = input.value.toLowerCase();
        const labels = input.nextElementSibling.querySelectorAll('.tender-listing-checkbox-item');
        labels.forEach(lbl => {
            const text = lbl.textContent.toLowerCase();
            lbl.style.display = text.includes(filter) ? "flex" : "none";
        });
    }

    function updateSelectedTags(panelId) {
        const panel = document.getElementById(panelId);
        if (!panel) return;

        const filterName = panel.getAttribute('data-name');
        const checkboxes = panel.querySelectorAll('.tender-listing-checkbox-grid input[type="checkbox"]');
        const accordion = panel.querySelector('.tender-listing-selected-accordion');
        const accordionBody = panel.querySelector('.tender-listing-accordion-body');
        const countSpan = panel.querySelector('.tender-listing-sel-count');
        const triggerText = panel.closest('.tender-listing-filter-item').querySelector('.tender-listing-trigger-text');
        
        if (!accordion) return;

        let selected =[];
        checkboxes.forEach(cb => {
            if (cb.checked) {

                selected.push(cb.parentNode.textContent.trim());
            }
        });

        const count = selected.length;
        
        if (triggerText && filterName) {
            triggerText.textContent = count > 0 ? `${filterName} (${count})` : filterName;
        }

        if (countSpan) countSpan.textContent = count;
        
        if (count > 0) {
            accordion.style.display = 'block';
            accordionBody.innerHTML = selected.map(item => 
                `<div class="tender-listing-selected-tag">${item} <span onclick="removeSelection('${panelId}', '${item}', event)"><i data-lucide="x" size="14"></i></span></div>`
            ).join('');
            if (window.lucide) lucide.createIcons();
        } else {
            accordion.style.display = 'none';
            accordionBody.innerHTML = '';
            accordionBody.style.display = 'none'; 
            
            const accIcon = accordion.querySelector('.tender-listing-acc-icon');
            if (accIcon) accIcon.setAttribute('data-lucide', 'chevron-down');
            if (window.lucide) lucide.createIcons();
        }
    }

    function removeSelection(panelId, itemText, event) {
        event.stopPropagation();
        const panel = document.getElementById(panelId);
        const checkboxes = panel.querySelectorAll('.tender-listing-checkbox-grid .tender-listing-checkbox-item');
        checkboxes.forEach(label => {
            if (label.textContent.trim() === itemText) {
                label.querySelector('input').checked = false;
            }
        });
        updateSelectedTags(panelId);
    }
    function toggleAccordion(headerEl) {
        const body = headerEl.nextElementSibling;
        const icon = headerEl.querySelector('.tender-listing-acc-icon');
        if (body.style.display === 'none' || body.style.display === '') {
            body.style.display = 'flex';
            icon.setAttribute('data-lucide', 'chevron-up');
        } else {
            body.style.display = 'none';
            icon.setAttribute('data-lucide', 'chevron-down');
        }
        if (window.lucide) lucide.createIcons();
    }
    function resetPanel(panelId) {
        const panel = document.getElementById(panelId);
        if(!panel) return;
        const checkboxes = panel.querySelectorAll('.tender-listing-checkbox-grid input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
        updateSelectedTags(panelId);
    }
    function resetAllFilters() {
        const trackablePanels =['catPanel', 'keyPanel', 'departPanel', 'statePanel', 'cityPanel'];
        trackablePanels.forEach(pid => resetPanel(pid));
    }
     document.addEventListener('change', function(e) {
        if (e.target && e.target.type === 'checkbox') {
            const grid = e.target.closest('.tender-listing-checkbox-grid');
            if (grid) {
                const panel = e.target.closest('.tender-listing-filter-panel');
                if (panel && panel.id) {
                    updateSelectedTags(panel.id);
                }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const trackablePanels =['catPanel', 'keyPanel', 'departPanel', 'statePanel', 'cityPanel'];
        trackablePanels.forEach(pid => {
            updateSelectedTags(pid);
        });
    });
    function toggleStatus(selected) {
        const switches =
            document.querySelectorAll('.tender-listing-switch');
        switches.forEach(sw =>
            sw.classList.remove('tender-listing-active')
        );
        selected.classList.add('tender-listing-active');
        // reset list
        offset = 1;
        busy = false;

        $("#lev1").html('');

        // reload tenders
        getFilter2(offset);
    }
</script>

@endsection