@extends('backend.layouts.app')
@section('stylesheet')
<style type="text/css">
.dropdown-menu {visibility: visible;width: 600px;}
.dp-mypreference{visibility: visible;width: 400px; !important}
.accordion-button{ background-color:#d4d4d4;}
.accordion-item{border:1px solid #d4d4d4;}
li,.form-check label {cursor: pointer;}
.ContentBoxFilterWrapDrop {overflow-y: auto;overflow-x: hidden;max-height: 230px !important;}
.ListWrapDrop {overflow: auto;max-height: 90px;}
.ListWrapDrop li {float: left;margin-bottom: 5px;margin-right:5px;}
.breadcrumbs .page-header{padding:20px 0 80px 0}
.pointer{cursor: pointer;}
.ContentBoxFilterWrapDrop .form-check .form-check-input {
    border-radius: 0;
    border: 1px solid #265285;
}
.w-65{width: 65% !important;}
.btn-red,.btn-red:hover,.btn-red:active{
  color: #fff;
  background-color: var(--color-primary);
  border: 1px solid var(--color-primary);
}
.dropdown-item.active, .dropdown-item:active,.BtnRange.active{
    color: #ffff !important;
    text-decoration: none;
    background-color: var(--color-primary);
}
.BtnRange.active{
  border: 1px solid var(--color-primary) !important ;
}
li, .form-check label {
    white-space: initial;
}

.btn_for_mobile_main{
    position:absolute;
    bottom:0px;
    left:0px;
}
.btn_for_mobile{
    display:none;
}
#scroll-div > .dropdown {
    white-space: initial;
}

.BarBtn {
    background: #FFFFFF;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    border-radius: 6px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 20px;
}
.ArchToggle .dropdown-menu {
    min-width: 250px;
    padding: 15px !important;
}
.dropdown-menu .BtnRange {
    font-weight: 500;
    font-size: 14px;
    line-height: 26px;
    cursor: pointer;
    color: #3A3A3A;
    display: inline-block;
    line-height: normal;
    border: 1px solid #265285;
    padding: 4px 10px !important;
    border-radius: 5px;
    margin-bottom: 10px !important;
}
.nav-pills.nav-pills-custom .nav-link {
    border-radius: 6px;
    background: #fcfcfd;
    color: #000;
    margin-right:15px;
}
.nav-pills.nav-pills-custom .nav-link.active {
    background-color: var(--color-primary);
    color: #fff;
}
@media only screen and (max-width: 576px) {
  .ContentBoxFilterWrapDrop {overflow-y: auto;overflow-x: hidden;max-height: 430px !important;}
  #pills-tab-custom .dropdown .dropdown-toggle{
    min-width: 105px !important; 
    font-size: 12px;  
  }
  #pills-tab-custom .dropdown .dropdown-menu{
    font-size: 12px;
  }
  
  .header{z-index: 10 !important}
  #pills-tab-custom > li{
    font-size: 12px !important;
  }
  ::-webkit-scrollbar{
    height: 1px;
  }
  div#scroll-div {
      overflow-x: auto;
      white-space: nowrap;
  }
  .scroll-div {
    overflow-x: auto;
    overflow-y:hidden;
    white-space: nowrap;
  }
  #pills-tab-custom > li{
    font-size: 12px;
  }
  .BarBtn{width: 30px;height: 33px}
  .nav-pills.nav-pills-custom .nav-link {
      border-radius: 6px;
      background: #fcfcfd;
      color: #000;
      margin-right:5px;
  }
  .search_filter_wrap {
    width: 100% !important;
  }
  .ContentBoxFilterWrapDrop {
    max-height: calc(100vh - 110px);
  }
  .btn-light, .btn-light:hover {
    background-color: #b7b7b0;
    border: 1px solid #b7b7b0;
  }
  p{float:left;}
  .dropdown_with_search {
    width: 100% !important;
    transform: translate3d(0px, 0px, 0px) !important;
    position: fixed !important;
    z-index: 1111;
    border-radius: 0px;
    margin-top: 0px;
    height: 92vh;
    /* height: calc(var(--vh, 1vh) * 100); */
    transition: ease-in-out .5s;
  }
  .btn_for_desktop{
      display:none;
  }
  .btn_for_mobile{
      display:block;
  }
  .btn_for_mobile_main{
      margin-bottom:5px;
  }
}
.list-scroll {
    overflow: auto;
    max-height: 255px;
}
 
.radio-tile-group .input-container {
    position: relative;
    /* height: 7rem; */
    width: fit-content;
    margin: 0.5rem;
}
 .radio-tile-group .input-container .radio-button {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    margin: 0;
    cursor: pointer;
}
.radio-tile-group .input-container .radio-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    border: 1px solid var(--color-primary);
    border-radius: 5px;
    transition: transform 300ms ease;
}
.radio-tile-group .input-container .radio-button:checked + .radio-tile .radio-tile-label {
    color: white;
    background-color: var(--color-primary);
}
label.radio-tile-label {
    padding: 5px 5px;
}
#scroll-div{
  overflow:auto;
  white-space: nowrap;
}
.main-section{position: relative;}
.main_div{
  padding:12px 0px;
  top:100px;
  background: #fff;
  position: sticky;
  z-index: 15;
  webkit-box-shadow: 0px 3px 4px 0px rgba(0,0,0,0.4);
    -moz-box-shadow: 0px 3px 4px 0px rgba(0,0,0,0.4);
    box-shadow: 0px 3px 4px 0px rgba(0,0,0,0.4);
}

.header.sticked a, .header.sticked a:hover {
    color: #000;
}

</style>
@endsection
@section('content')
<main id="main">
  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center"></div>
    <nav>
      <div class="container">
        <ol>
          <li>
            <a href="{{ asset('/') }}">Home</a>
          </li>
          <li>Tender Result</li>
        </ol>
      </div>
    </nav>
  </div>
  <!-- End Breadcrumbs -->
  <!-- ======= Featured Services Section ======= -->
  <section class="main-section pt-2">
    <div class="main_div">
      <div class="container-fluid">
      <!-- <button class="abc">abc</button> -->
        <div class="row">
          <div class="col-md-12" id="scroll-div"> 
            @php $myuserproduct = array(); 
            $tenderfilters = array(); 
            $selected_eproductid = array(); 
            //dd(Session::get('loginuser.tenderresult.filter')); 
            @endphp 
           
            @php 
            $myuserproduct = Session::get('loginuser.tenderresult.filter.0'); $tenderfilters = Session::get('loginuser.tenderresult.filter'); //dd($myuserproduct); 
            @endphp 
            @if(isset($type)) 
              @php $myuserproduct = array(); 
              @endphp 
            @endif

            @if(isset($tenderfilters))
            <!-- my Preferences -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" type="button" id="dp-mypreference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"> My Preference </button>
              <div class="dropdown-menu p-0 dropdown_with_search open_dropdown dp-mypreference" aria-labelledby="dp-mypreference">
                <div class="d-flex justify-content-between p-3">
                  <h6 class="w-75">My Filters</h6>
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="accordian-box">
                  <div class="accordion accordion-flush saved_filter_body_scroll filter_main_wrap" id="accordionFlushExample"> @foreach($tenderfilters as $tfk => $tfval) <div class="accordion-item {{ ($tfval['filter_name'] == "My Preference") ? "main_activation" : "" }}" data="main_card_{{ $tfval['id'] }}">
                      <div class="HeaderAccordian">
                        <div class="accordion-header" id="flush-heading_{{ $tfval['id']}}">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse_{{ $tfval['id'] }}" aria-expanded="false" aria-controls="flush-collapse_{{ $tfval['id'] }}">
                            <div class="InputBox">
                              <input type="hidden" value="0" name="updatefiltermsg_{{ $tfval['id'] }}">
                              <input type="radio" {{ ($tfval['filter_name'] == "My Preference") ? "checked" : "" }} id="customCheck_{{ $tfval['id'] }}" data="{{ $tfval['id'] }}" data-main="{{ ($tfval['filter_name'] == "My Preference") ? 1 : 0 }}" name="example1">
                              <label for="customCheck_{{ $tfval['id'] }}" data-text="{{ $tfval['filter_name'] }}">{{ $tfval['filter_name'] }}
                                <span>{{ ($tfval['filter_name'] == "My Preference") ? "(Not Editable)" : "" }}</span>
                              </label>
                            </div>
                          </button>
                        </div>
                      </div>
                      <div class="ContentAccordians">
                        <div id="flush-collapse_{{ $tfval['id'] }}" class="accordion-collapse collapse" aria-labelledby="flush-heading1_{{ $tfval['id'] }}" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body" id="collapse_{{ $tfval['id'] }}"> @if($tfval['filter_name'] != "My Preference") <div class="TopBoxMyFilter delete_filter_main">
                              <div class="TopCont">
                                <h4>Filter Name</h4>
                                <button class="ResetBtn Btn delete_filter" name="delete_filter">Delete Filter</button>
                              </div>
                              <div class="InputBot">
                                <input type="text" name="filter_name_input" value="{{ $tfval['filter_name'] }}">
                              </div>
                              <div class="delete_filter_confirmation" style="display:none;">
                                <span>Are you sure! you want to delete this filter?</span>
                                <div class="text-center mt-2">
                                  <button type="button" class="btn btn-xs btn-white border delete_filter_cancel">Cancel</button>
                                  <button type="button" class="btn btn-xs btn-primary delete_filter_ok" data="{{ $tfval['id'] }}">Yes</button>
                                </div>
                              </div>
                            </div> @endif @if((isset($tfval['productid']) && $tfval['productid'] != "") || (isset($tfval['exe_productid']) && $tfval['exe_productid'] != "")) @if(isset($tfval['productid']) && $tfval['productid'] != "") @php $myproductid = explode(',',$tfval['productid']); $myproductidname = explode(',',$tfval['productidname']); @endphp <div class="accordion border rounded mb-1">
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_product_{{ $tfval['id'] }}" aria-expanded="false" aria-controls="KeywordPre">
                                    <h6 class="mb-0">Industry</h6>
                                  </button>
                                </h2>
                                <div id="Keyword_product_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#Keyword_product_{{ $tfval['id'] }}">
                                  <div class="">
                                    <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myproductidname as $pk => $mpv) @php $apid = $myproductid[$pk]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_product remove_item" data="{{ $apid }}" title="{{ $mpv }}">{{ $mpv }}
                                        <i class="ms-2 fa-solid fa-xmark"></i>
                                      </li> @endforeach </ul>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['exe_productid']) && $tfval['exe_productid'] != "") @php $myeproductid = explode(',',$tfval['exe_productid']); $myeproductidname = explode(',',$tfval['eproductidname']); @endphp <div class="accordion border rounded mb-1" id="accordion_excluding_product_{{ $tfval['id'] }}">
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_excluding_product_{{ $tfval['id'] }}" aria-expanded="false" aria-controls="KeywordPre">
                                    <h6 class="mb-0">Excluding Industry</h6>
                                  </button>
                                </h2>
                                <div id="Keyword_excluding_product_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_excluding_product_{{ $tfval['id'] }}">
                                  <div class="">
                                    <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myeproductidname as $pek => $mepv) @php $eapid = $myeproductid[$pek]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_eproduct remove_item" data="{{ $eapid }}" title="{{ $mepv }}">{{ $mepv }}
                                        <i class="ms-2 fa-solid fa-xmark"></i>
                                      </li> @endforeach </ul>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @endif @if((isset($tfval['categoryid']) && $tfval['categoryid'] != "") || (isset($tfval['exe_categoryid']) && $tfval['exe_categoryid'] != "")) @if(isset($tfval['categoryid']) && $tfval['categoryid'] != "") @php $mycategoryid = explode(',',$tfval['categoryid']); $mycategoryname = explode(',',$tfval['categoryidname']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_category_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_category_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">SubIndustry</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_category_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_category_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($mycategoryname as $catk => $mctv) @php $acatid = $mycategoryid[$catk] @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_category remove_item" data="{{ $acatid }}" title="{{ $mctv }}">{{ $mctv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['exe_categoryid']) && $tfval['exe_categoryid'] != "") @php $myecategoryid = explode(',',$tfval['exe_categoryid']); $myecategoryname = explode(',',$tfval['ecategoryidname']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_excluding_category_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_excluding_category_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Excluding SubIndustry</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_excluding_category_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_excluding_category_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myecategoryname as $catek => $mectv) @php $eacatid = $myecategoryid[$catek]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_ecategory remove_item" data="{{ $eacatid }}" title="{{ $mectv }}">{{ $mectv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @endif @if((isset($tfval['subcategoryid']) && $tfval['subcategoryid'] != "") || (isset($tfval['exe_subcategoryid']) && $tfval['exe_subcategoryid'] != "")) @if(isset($tfval['subcategoryid']) && $tfval['subcategoryid'] != "") @php $mysubcategoryid = explode(',',$tfval['subcategoryid']); $mysubcategoryidname = explode(',',$tfval['subcategoryidname']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_subcategory_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_subcategory_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Category</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_subcategory_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_subcategory_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($mysubcategoryidname as $scatk => $msctv) @php $ascatid = $mysubcategoryid[$scatk]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_subcategory remove_item" data="{{ $ascatid }}" title="{{ $msctv }}">{{ $msctv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['exe_subcategoryid']) && $tfval['exe_subcategoryid'] != "") @php $myesubcategoryid = explode(',',$tfval['exe_subcategoryid']); $myesubcategoryidname = explode(',',$tfval['esubcategoryidname']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_excluding_subcategory_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_excluding_subcategory_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Excluding Category</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_excluding_subcategory_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_excluding_subcategory_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myesubcategoryidname as $scatek => $mesctv) @php $eascatid = $myesubcategoryid[$scatek]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_esubcategory remove_item" data="{{ $eascatid }}" title="{{ $mesctv }}">{{ $mesctv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @endif @if(isset($tfval['keyword']) && $tfval['keyword'] != "") @php $mykey = explode(',',$tfval['keyword']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_keyword_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword1_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Keyword</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword1_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_keyword_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($mykey as $mkv) <li class="badge bg-primary rounded-0 BtnAddList filter_keyword remove_item" data="{{ $mkv }}">{{ $mkv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['excludingkeyword']) && $tfval['excludingkeyword'] != "") <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_exclude_keyword_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#exclude_keyword_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="exclude_keyword_{{ $tfval['id'] }}">
                                      <h6 class="mb-0">Excluding Keyword</h6>
                                    </button>
                                  </h2>
                                  <div id="exclude_keyword_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_exclude_keyword_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @if(count(explode(',',$tfval['excludingkeyword'])) > 0) @foreach(explode(',',$tfval['excludingkeyword']) as $key => $mkv) <li class="badge bg-primary rounded-0 BtnAddList filter_ekeyword remove_item" data="{{ $mkv }}">{{ $mkv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach @endif </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['refine_keyword']) && $tfval['refine_keyword'] != "") @php $myrkey = explode(',',$tfval['refine_keyword']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_refine_keyword_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#refine_keyword_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Refine Keywords</h6>
                                    </button>
                                  </h2>
                                  <div id="refine_keyword_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_refine_keyword_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myrkey as $mkv) <li class="badge bg-primary rounded-0 BtnAddList filter_rkeyword remove_item" data="{{ $mkv }}">{{ $mkv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if((isset($tfval['Agency']) && $tfval['Agency'] != "") || (isset($tfval['excluding_agency']) && $tfval['excluding_agency'] != "")) @if(isset($tfval['Agency']) && $tfval['Agency'] != "") @php $myAgencyid = explode(',',$tfval['Agency']); $myAgencyname = explode(',',$tfval['Agency_name']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_agency_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_agency_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Department</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_agency_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_agency_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myAgencyname as $ak => $mav) @php $akid = $myAgencyid[$ak]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_org remove_item" data="{{ $akid }}" title="{{ $mav }}">{{ $mav }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['excluding_agency']) && $tfval['excluding_agency'] != "") @php $myeAgencyid = explode(',',$tfval['excluding_agency']); $myeAgencyname = explode(',',$tfval['eAgency_name']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_excluding_agency_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_excluding_agency_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Excluding Department</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_excluding_agency_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_excluding_agency_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($myeAgencyname as $aek => $maev) @php $eakid = $myeAgencyid[$aek]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_eorg remove_item" data="{{ $eakid }}" title="{{ $maev }}">{{ $maev }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @endif @if(isset($tfval['state']) && $tfval['state'] != "") @php $mystateid = explode(',',$tfval['state']); $mystatename = explode(',',$tfval['state_name']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1" id="accordion_state_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#keyword_state_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">State</h6>
                                    </button>
                                  </h2>
                                  <div id="keyword_state_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_state_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($mystatename as $sk => $msv) @php $skid = $mystateid[$sk]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_state remove_item" data="{{ $skid }}" title="{{ $msv }}">{{ $msv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if(isset($tfval['city']) && $tfval['city'] != "") @php $mycity = explode(',',$tfval['city']); @endphp <div class="CheckBoxSelectedValue">
                              <div class="accordion border rounded mb-1 mb-2" id="accordion_city_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#Keyword_city_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">City</h6>
                                    </button>
                                  </h2>
                                  <div id="Keyword_city_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#accordion_city_{{ $tfval['id'] }}">
                                    <div class="p-3">
                                      <ul class="ListWrapDrop ps-2 mb-0"> @foreach($mycity as $mcv) @php $skid = $mystateid[$sk]; @endphp <li class="badge bg-primary rounded-0 BtnAddList filter_city remove_item" data="{{ $mcv }}">{{ $mcv }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endforeach </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif @if ($tfval['Min_Amount'] != "" || $tfval['Max_Amount'] != "") <div class="CheckBoxSelectedValue">
                              <div class="accordion mb-2 border rounded" id="tender_amount_{{ $tfval['id'] }}">
                                <div class="accordion-item">
                                  <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#tender_{{ $tfval['id'] }}" aria-expanded="true" aria-controls="KeywordPre">
                                      <h6 class="mb-0">Tender Amount</h6>
                                    </button>
                                  </h2>
                                  <div id="tender_{{ $tfval['id'] }}" class="accordion-collapse collapse" data-bs-parent="#tender_amount_{{ $tfval['id'] }}">
                                    <div class="">
                                      <ul class="ListWrapDrop filter_type_wise_scroll"> @if(!empty($tfval['Min_Amount']) && !empty($tfval['Max_Amount']) && $tfval['Min_Amount'] != "" && $tfval['Max_Amount'] != "") <li class="badge bg-primary rounded-0 BtnAddList filter_tender_amount remove_item" datamin="{{ $tfval['Min_Amount'] }}" datamax="{{ $tfval['Max_Amount'] }}">{{ $tfval['Min_Amount']." to ".$tfval['Max_Amount'] }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @elseif(!empty($tfval['Min_Amount']) && empty($tfval['Max_Amount'])) <li class="badge bg-primary rounded-0 BtnAddList filter_tender_amount remove_item" datamin="{{ $tfval['Min_Amount'] }}" datamax="{{ $tfval['Max_Amount'] }}">More than {{ $tfval['Min_Amount'] }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @elseif (empty($tfval['Min_Amount']) && !empty($tfval['Max_Amount'])) <li class="badge bg-primary rounded-0 BtnAddList filter_tender_amount remove_item" datamin="{{ $tfval['Min_Amount'] }}" datamax="{{ $tfval['Max_Amount'] }}">Less than {{ $tfval['Max_Amount'] }}
                                          <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endif @if($tfval['no_estimates'] != 0) <li class="badge bg-primary rounded-0 BtnAddList filter_not_estimate remove_item" data="1">With Not Estimated <i class="ms-2 fa-solid fa-xmark"></i>
                                        </li> @endif </ul>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div> @endif </div>
                        </div>
                      </div>
                    </div> @endforeach </div>
                </div>
                <div class="text-center pt-3 pb-3">
                  <button class="btn btn-sm btn-primary filter_apply me-2">Apply Filter</button>
                  <button class="btn btn-sm btn-primary filter_update" data="saved_filter_body_scroll" type="button">Update Filter</button>
                </div>
              </div>
            </div>
            <!-- my Preferences -->
            @endif
            <!--industry-->
            <div class="dropdown d-inline-block me-2 d-none">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" data-title="keywords" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Industry <span class="counts product_count">@if(isset($myuserproduct['productid']) && $myuserproduct['productid'] != '') @if(count(explode(',',$myuserproduct['productid'])) > 0) {{ '('.count(explode(',',$myuserproduct['productid'])).')'; }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 search-dropdown-box">
                <div class="d-flex justify-content-between p-3">
                  <h6 class="mb-0">Industry</h6>
                  <span class="ClsBtn">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="ContentBoxFilterWrapDrop keyword_scroll_div">
                  <div class="CheckBoxSelectedValue">
                    <div class="accordion">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_selected_product" aria-expanded="false" aria-controls="accordion_selected_product">
                            <h6 class="mb-0">Selected Industry <span class="counts product_count"> @if(isset($myuserproduct['productid']) && $myuserproduct['productid'] != '') @if(count(explode(',',$myuserproduct['productid'])) > 0) {{ '('.count(explode(',',$myuserproduct['productid'])).')'; }} @endif @endif </span>
                            </h6>
                          </button>
                        </h2>
                      </div>
                      <div id="accordion_selected_product" class="accordion-collapse collapse" data-bs-parent="#accordion_selected_product">
                        <div class="accordion-body">
                          <ul class="ListWrapDrop list_selected_login_product"> @if(isset($myuserproduct['productid']) && $myuserproduct['productid'] != '') @if(count(explode(',',$myuserproduct['productid'])) > 0) @php $productname = []; $productname = explode(',',$myuserproduct['productidname']); @endphp @foreach(explode(',',$myuserproduct['productid']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_product" data="{{$row}}">{{$productname[$key]}}
                              <i class="ms-2 fa-solid fa-xmark"></i> @endforeach @endif @endif
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="CheckBoxSelectedValue">
                    <div class="accordion">
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_selected_eproduct" aria-expanded="false" aria-controls="accordion_selected_eproduct">
                            <h6 class="mb-0">Selected Excluding Industry <span class="counts eproduct_count"> @if(isset($myuserproduct['exe_productid']) && $myuserproduct['exe_productid'] != '') @if(count(explode(',',$myuserproduct['exe_productid'])) > 0) {{ '('.count(explode(',',$myuserproduct['exe_productid'])).')'; }} @endif @endif </span>
                            </h6>
                          </button>
                        </h2>
                        <div id="accordion_selected_eproduct" class="accordion-collapse collapse" data-bs-parent="#accordion_selected_eproduct">
                          <div class="accordion-body">
                            <ul class="ListWrapDrop list_selected_login_exe_product"> @if(isset($myuserproduct['exe_productid']) && $myuserproduct['exe_productid'] != '') @if(count(explode(',',$myuserproduct['exe_productid'])) > 0) @php $exe_productname = []; $exe_productname = explode(',',$myuserproduct['eproductidname']); @endphp @foreach(explode(',',$myuserproduct['exe_productid']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_product" data="{{$row}}">{{$exe_productname[$key]}}
                                <i class="ms-2 fa-solid fa-xmark"></i>
                              </li> @endforeach @endif @endif </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--subindustry-->
            <div class="dropdown d-inline-block me-2 d-none">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" data-title="keywords" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">SubIndustry <span class="counts main_category_count"> @if(isset($myuserproduct['categoryid']) && $myuserproduct['categoryid'] != '') @if(count(explode(',',$myuserproduct['categoryid'])) > 0) {{ '('.count(explode(',',$myuserproduct['categoryid'])).')'; }} @endif @endif @if(isset($type)) @if(($type == "category" && $selectedcategoryid != "") || ($type == "subcategory" && $selectedsubcategoryid != "")) {{ '(1)' }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 search-dropdown-box">
                <div class="d-flex justify-content-between p-3">
                  <h6 class="mb-0">SubIndustry</h6>
                  <span class="ClsBtn">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="PosSetBg">
                  <div class="ContentBoxFilterWrapDrop keyword_scroll_div">
                    <div class="CheckBoxSelectedValue">
                      <div class="accordion">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_selected_category" aria-expanded="false" aria-controls="accordion_selected_category">
                              <h6 class="mb-0">Selected MainSubIndustry <span class="counts main_category_count"> @if(isset($myuserproduct['categoryid']) && $myuserproduct['categoryid'] != '') @if(count(explode(',',$myuserproduct['categoryid'])) > 0) {{ '('.count(explode(',',$myuserproduct['categoryid'])).')'; }} @endif @endif @if(isset($type)) @if(($type == "category" && $selectedcategoryid != "") || ($type == "subcategory" && $selectedsubcategoryid != "")) {{ '(1)' }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                        </div>
                        <div id="accordion_selected_category" class="accordion-collapse collapse" data-bs-parent="#accordion_selected_category">
                          <div class="accordion-body">
                            <ul class="ListWrapDrop p-0 list_selected_login_category"> @if(isset($myuserproduct['categoryid']) && $myuserproduct['categoryid'] != '') @if(count(explode(',',$myuserproduct['categoryid'])) > 0) @php $maincategoryname = []; $maincategoryname = explode(',',$myuserproduct['categoryidname']); @endphp @foreach(explode(',',$myuserproduct['categoryid']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_category" data="{{$row}}">{{$maincategoryname[$key]}}
                                <i class="ms-2 fa-solid fa-xmark"></i>
                              </li> @endforeach @endif @endif @if(isset($type)) @if(($type == "category" && $selectedcategoryid != "") || ($type == "subcategory" && $selectedsubcategoryid != "")) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_category" data="{{$selectedcategoryid}}">{{$selectedcategoryname}}
                                <i class="ms-2 fa-solid fa-xmark"></i>
                              </li> @endif @endif </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxSelectedValue">
                      <div class="accordion">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion_selected_exe_category" aria-expanded="false" aria-controls="accordion_selected_exe_category">
                              <h6 class="mb-0">Selected Excluding SubIndustry <span class="counts emaincategory_count"> @if(isset($myuserproduct['exe_categoryid']) && $myuserproduct['exe_categoryid'] != '') @if(count(explode(',',$myuserproduct['exe_categoryid'])) > 0) {{ '('.count(explode(',',$myuserproduct['exe_categoryid'])).')'; }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="accordion_selected_exe_category" class="accordion-collapse collapse" data-bs-parent="#accordion_selected_exe_category">
                            <div class="accordion-body">
                              <ul class="ListWrapDrop p-0 list_selected_login_exe_category"> @if(isset($myuserproduct['exe_categoryid']) && $myuserproduct['exe_categoryid'] != '') @if(count(explode(',',$myuserproduct['exe_categoryid'])) > 0) @php $exe_maincategoryname = []; $exe_maincategoryname = explode(',',$myuserproduct['ecategoryidname']); @endphp @foreach(explode(',',$myuserproduct['exe_categoryid']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_category remove_item" data="{{$row}}">{{$exe_maincategoryname[$key]}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--subindustry-->
            <!-- category -->
            <div class="dropdown d-inline-block me-2 ">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" data-title="category" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Category <span class="counts subcategory_count"> @if(isset($myuserproduct['subcategoryid']) && $myuserproduct['subcategoryid'] != '') @if(count(explode(',',$myuserproduct['subcategoryid'])) > 0) {{ '('.count(explode(',',$myuserproduct['subcategoryid'])).')'; }} @endif @endif @if(isset($type)) @if($type == "subcategory") {{ '(1)' }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 search-dropdown-box scroll-div">
                <div class="d-flex justify-content-end mb-2">
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="PosSetBg subcategoryfiltermain subcategory_scroll_div" data="false">
                  <div class="d-flex justify-content-between">
                    <div class="search_filter_wrap w-65 me-2">
                      <input type="text" class="form-control searchsubcategory form-control-sm mb-2" name="searchsubcategory" id="searchsubcategory" placeholder="Search Category" />
                    </div>
                    <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_mobile" data="subcategory">Reset</button>
                      <!-- <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item " data="subcategory">Reset</button> -->
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="subcategory">Apply</button>
                    </div>
                    <div class="text-right">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="subcategory">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="subcategory">Apply Now</button>
                    </div>
                  </div>
                  <div class="ContentBoxFilterWrapDrop subcategory_scroll_div">
                    <div class="CheckBoxSelectedValue chk_selected_login_subcategory">
                      <div class="accordion mb-2" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedCategories" aria-expanded="false" aria-controls="SelectedCategories">
                              <h6 class="mb-0">Selected Categories <span class="counts subcategory_count"> @if(isset($myuserproduct['subcategoryid']) && $myuserproduct['subcategoryid'] != '') @if(count(explode(',',$myuserproduct['subcategoryid'])) > 0) {{ '('.count(explode(',',$myuserproduct['subcategoryid'])).')'; }} @endif @endif @if(isset($type)) @if($type == "subcategory" && $selectedsubcategoryid != "") {{ '(1)' }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedCategories" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list_selected_login_subcategory"> @if(isset($myuserproduct['subcategoryid']) && $myuserproduct['subcategoryid'] != '') @if(count(explode(',',$myuserproduct['subcategoryid'])) > 0) @php $subcategoryname = []; $subcategoryname = explode(',',$myuserproduct['subcategoryidname']); @endphp @foreach(explode(',',$myuserproduct['subcategoryid']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_subcategory" data="{{$row}}">{{$subcategoryname[$key]}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif @if(isset($type)) @if($type == "subcategory" && $selectedsubcategoryid != "") <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_subcategory" data="{{$selectedsubcategoryid}}">{{$selectedsubcategoryname}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxSelectedValue chk_selected_login_exe_subcategory">
                      <div class="accordion mb-2" id="selected_exe_accordion">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedexeCategories" aria-expanded="false" aria-controls="SelectedexeCategories">
                              <h6 class="mb-0">Selected Excluding Categories <span class="counts exe_subcategory_count"> @if(isset($myuserproduct['exe_subcategoryid']) && $myuserproduct['exe_subcategoryid'] != '') @if(count(explode(',',$myuserproduct['exe_subcategoryid'])) > 0) {{ '('.count(explode(',',$myuserproduct['exe_subcategoryid'])).')'; }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedexeCategories" class="accordion-collapse collapse" data-bs-parent="#selected_exe_accordion">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list_selected_login_exe_subcategory"> @if(isset($myuserproduct['exe_subcategoryid']) && $myuserproduct['exe_subcategoryid'] != '') @if(count(explode(',',$myuserproduct['exe_subcategoryid'])) > 0) @php $exe_subcategoryname = []; $exe_subcategoryname = explode(',',$myuserproduct['esubcategoryidname']); @endphp @foreach(explode(',',$myuserproduct['esubcategoryid']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_subcategory remove_item" data="{{$row}}">{{$exe_subcategoryname[$key]}}
                                  <i class="ms-1 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxWrapPop row list_login_subcategory_list p-3"> @if(isset($myuserproduct['subcategoryid']) && $myuserproduct['subcategoryid'] != '') @if(count(explode(',',$myuserproduct['subcategoryid'])) > 0) @php $subcategoryname = []; $subcategoryname = explode(',',$myuserproduct['subcategoryidname']); @endphp @foreach(explode(',',$myuserproduct['subcategoryid']) as $key => $row) <div class="form-check col-md-6 searchkeyword_tr">
                        <input class="form-check-input subcategoryid" checked data-title="{{$subcategoryname[$key]}}" type="checkbox" value="{{$row}}" id="sFilters_subcategory_{{$row}}" data="{{$subcategoryname[$key]}}" name="Filters[subcategoryid][]">
                        <label class="form-check-label" for="sFilters_subcategory_{{$row}}">{{$subcategoryname[$key]}}</label>
                      </div> @endforeach @endif @endif @if(isset($type)) @if($type == "subcategory" && $selectedsubcategoryid != "") <div class="form-check col-md-6 searchkeyword_tr">
                        <input class="form-check-input subcategoryid" checked data-title="{{$selectedsubcategoryid}}" type="checkbox" value="{{$selectedsubcategoryid}}" id="sFilters_subcategory_{{$selectedsubcategoryid}}" data="{{$selectedsubcategoryname}}" name="Filters[subcategoryid][]">
                        <label class="form-check-label" for="sFilters_subcategory_{{$selectedsubcategoryid}}">{{$selectedsubcategoryname}}</label>
                      </div> @endif @endif </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- category -->
            <!-- keyword -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" data-title="keywords" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Keyword <span class="counts keyword_count"> @if(isset($myuserproduct['keyword']) && $myuserproduct['keyword'] != '') @if(count(explode(',',$myuserproduct['keyword'])) > 0) {{ '('.count(explode(',',$myuserproduct['keyword'])).')'; }} @endif @endif @if(isset($type)) @if($type == "keyword" && $keyword != "") {{ '(1)' }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 search-dropdown-box">
                <div class="d-flex justify-content-end mb-2">
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="PosSetBg keywordfiltermain" data="false">
                  <div class="d-flex justify-content-between">
                    <div class="search_filter_wrap w-65 me-2">
                      <input type="text" class="form-control search_filter_text_keyword form-control-sm mb-2" placeholder="Type keyword eg-civil, cable etc.">
                    </div>
                    <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_mobile" data="keyword">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="keyword">Apply</button>
                  </div>
                    <div class="text-right">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="keyword">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="keyword">Apply Now</button>
                    </div>
                  </div>
                  <div class="ContentBoxFilterWrapDrop keyword_scroll_div">
                    <div class="CheckBoxSelectedValue chk_selected_login_keyword">
                      <div class="accordion mb-2 mt-1" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedKeyword" aria-expanded="true" aria-controls="SelectedKeyword">
                              <h6 class="mb-0">Selected Keyword <span class="counts keyword_count"> @if(isset($myuserproduct['keyword']) && $myuserproduct['keyword'] != '') @if(count(explode(',',$myuserproduct['keyword'])) > 0) {{ '('.count(explode(',',$myuserproduct['keyword'])).')'; }} @endif @endif @if(isset($type)) @if($type == "keyword" && $keyword != "") {{ '(1)' }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedKeyword" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list_selected_login_keyword"> @if(isset($myuserproduct['keyword']) && $myuserproduct['keyword'] != '') @if(count(explode(',',$myuserproduct['keyword'])) > 0) @foreach(explode(',',$myuserproduct['keyword']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_keyword" data="{{$row}}">{{$row}}
                                  <i class="ms-2 fa-solid fa-xmark"></i></li> @endforeach @endif @endif @if(isset($type)) @if($type == "keyword" && $keyword != "")
                                <li class="BtnAddList remove_login_select_keyword" data="{{$keyword}}">{{$keyword}}
                                  <i class="ms-2 fa-solid fa-xmark"></i></li> @endif @endif
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxSelectedValue chk_selected_login_exe_keyword">
                      <div class="accordion mb-2" id="excludingkeyword">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#excluding_keyword" aria-expanded="true" aria-controls="SelectedKeyword">
                              <h6 class="mb-0">Excluding Keyword <span class="counts excluding_keyword_count"> @if(isset($myuserproduct['excludingkeyword']) && $myuserproduct['excludingkeyword'] != '') @if(count(explode(',',$myuserproduct['excludingkeyword'])) > 0) {{ '('.count(explode(',',$myuserproduct['excludingkeyword'])).')'; }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="excluding_keyword" class="accordion-collapse collapse" data-bs-parent="#excluding_keyword">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list_selected_login_ekeyword"> @if(isset($myuserproduct['excludingkeyword']) && $myuserproduct['excludingkeyword'] != '') @if(count(explode(',',$myuserproduct['excludingkeyword'])) > 0) @foreach(explode(',',$myuserproduct['excludingkeyword']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_ekeyword remove_item" data="{{$row}}">{{$row}}
                                  <i class="ms-2 fa-solid fa-xmark"></i></li> @endforeach @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxWrapPop p-3 row list_login_keyword_list"> @if(isset($myuserproduct['keyword']) && $myuserproduct['keyword'] != '') @if(count(explode(',',$myuserproduct['keyword'])) > 0) @foreach(explode(',',$myuserproduct['keyword']) as $key => $row) <div class="form-check col-md-6">
                        <input class="form-check-input keywordid" data-title="keyword" type="checkbox" checked value="{{$row}}" id="keyword_{{$row}}" data="{{$row}}" data-id="{{$row}}" name="Filters[keyword][]">
                        <label class="form-check-label" for="keyword_{{$row}}">{{$row}}</label>
                      </div> @endforeach @endif @endif @if(isset($type)) @if($type == "keyword" && $keyword != "") <div class="form-check col-md-6">
                        <input class="form-check-input keywordid" data-title="keyword" type="checkbox" checked value="{{$keyword}}" id="keyword_{{$keyword}}" data="{{$keyword}}" data-id="{{$keyword}}" name="Filters[keyword][]">
                        <label class="form-check-label" for="keyword_{{$keyword}}">{{$keyword}}</label>
                      </div> @endif @endif </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- keyword -->
            <!-- Department -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" type="button" data-title="dipartment" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Department <span class="counts dipartment_count"> @if(isset($myuserproduct['Agency']) && $myuserproduct['Agency'] != '') @if(count(explode(',',$myuserproduct['Agency'])) > 0) {{ '('.count(explode(',',$myuserproduct['Agency'])).')'; }} @endif @endif @if(isset($type)) @if($type == "agency" && $selectedagencyid != "") {{ '(1)' }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 search-dropdown-box">
                <div class="d-flex justify-content-end mb-2 btn_for_desktop">
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="PosSetBg departmentfiltermain" data="false">
                  <div class="d-flex justify-content-between">
                    <div class="search_filter_wrap w-65 me-2">
                      <input type="text" class="form-control search-department form-control-sm mb-2" placeholder="Department Search">
                    </div>
                    <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-light btn_clear_selected_item btn_for_mobile" data="Dipartment">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="Dipartment">Apply</button>
                    </div>
                    <div class="text-right">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="Dipartment">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="Dipartment">Apply Now</button>
                    </div>
                  </div>
                  <div class="ContentBoxFilterWrapDrop dipartment-div">
                    <div class="CheckBoxSelectedValue chk_selected_login_org">
                      <div class="accordion mb-2 mt-1" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedDepartment" aria-expanded="true" aria-controls="SelectedDepartment">
                              <h6 class="mb-0">Selected Department <span class="counts dipartment_count"> @if(isset($myuserproduct['Agency']) && $myuserproduct['Agency'] != '') @if(count(explode(',',$myuserproduct['Agency'])) > 0) {{ '('.count(explode(',',$myuserproduct['Agency'])).')'; }} @endif @endif @if(isset($type)) @if($type == "agency" && $selectedagencyid != "") {{ '(1)' }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedDepartment" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list-selected-dipartment"> @if(isset($myuserproduct['Agency']) && $myuserproduct['Agency'] != '') @if(count(explode(',',$myuserproduct['Agency'])) > 0) @php $dipartment = []; $dipartment = explode(',',$myuserproduct['Agency_name']); @endphp @foreach(explode(',',$myuserproduct['Agency']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_dipartment" data="{{$row}}">{{$dipartment[$key]}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif @if(isset($type)) @if($type == "agency" && $selectedagencyid != "") <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_dipartment" data="{{$selectedagencyid}}">{{$selectedagencyname}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxSelectedValue chk_selected_login_exe_org">
                      <div class="accordion" id="accordion_exe_department">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedexeDepartment" aria-expanded="true" aria-controls="SelectedexeDepartment">
                              <h6 class="mb-0">Selected Excluded Department <span class="counts exe_dipartment_count"> @if(isset($myuserproduct['eAgency']) && $myuserproduct['eAgency'] != '') @if(count(explode(',',$myuserproduct['eAgency'])) > 0) {{ '('.count(explode(',',$myuserproduct['eAgency'])).')'; }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedexeDepartment" class="accordion-collapse collapse" data-bs-parent="#accordion_exe_department">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list-selected-exe-dipartment"> @if(isset($myuserproduct['eAgency']) && $myuserproduct['eAgency'] != '') @if(count(explode(',',$myuserproduct['eAgency'])) > 0) @php $exe_dipartment = []; $exe_dipartment = explode(',',$myuserproduct['eAgency_name']); @endphp @foreach(explode(',',$myuserproduct['eAgency']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_exe_dipartment" data="{{$row}}">{{$exe_dipartment[$key]}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxWrapPop row p-3 dipartment-list"> @if(isset($myuserproduct['Agency']) && $myuserproduct['Agency'] != '') @if(count(explode(',',$myuserproduct['Agency'])) > 0) @php $dipartment = []; $dipartment = explode(',',$myuserproduct['Agency_name']); @endphp @foreach(explode(',',$myuserproduct['Agency']) as $key => $row) <div class="form-check col-md-6">
                        <input class="form-check-input agencyid" data-title="dipartment" type="checkbox" value="{{$row}}" id="dipartment_{{$row}}" data="{{$dipartment[$key]}}" data-id="{{$row}}" checked name="Filters[agency][]" />
                        <label class="form-check-label" for="dipartment_{{$row}}">{{$dipartment[$key]}}</label>
                      </div> @endforeach @endif @endif @if(isset($type)) @if($type == "agency" && $selectedagencyid != "") <div class="form-check col-md-6">
                        <input class="form-check-input agencyid" data-title="dipartment" type="checkbox" value="{{$selectedagencyid}}" id="dipartment_{{$selectedagencyid}}" data="{{$selectedagencyname}}" data-id="{{$selectedagencyid}}" checked name="Filters[agency][]" />
                        <label class="form-check-label" for="dipartment_{{$selectedagencyid}}">{{$selectedagencyname}}</label>
                      </div> @endif @endif </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Department -->
            <!-- state -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" type="button" data-title="state" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">State <span class="counts state_count"> @if(isset($myuserproduct['state']) && $myuserproduct['state'] != '') @if(count(explode(',',$myuserproduct['state'])) > 0) {{ '('.count(explode(',',$myuserproduct['state'])).')'; }} @endif @endif @if(isset($type)) @if(($type == "state" && $selectedstateid != "") || ($type == "city" && $selectedcityname !="")) {{ '(1)' }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 search-dropdown-box">
                <div class="d-flex justify-content-end mb-2">
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="PosSetBg statefiltermain" data="false">
                  <div class="d-flex justify-content-between">
                    <div class="search_filter_wrap w-65 me-2">
                      <input type="text" class="form-control searchkeywords form-control-sm mb-2" placeholder="Search State">
                    </div>
                    <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-light btn_clear_selected_item btn_for_mobile" data="state">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="state">Apply</button>
                    </div>
                    <div class="text-right">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="state">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="state">Apply Now</button>
                    </div>
                  </div>
                  <div class="ContentBoxFilterWrapDrop">
                    <div class="CheckBoxSelectedValue chk_selected_login_state">
                      <div class="accordion mb-2 mt-1" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedState" aria-expanded="true" aria-controls="SelectedState">
                              <h6 class="mb-0">Selected State <span class="counts state_count"> @if(isset($myuserproduct['state']) && $myuserproduct['state'] != '') @if(count(explode(',',$myuserproduct['state'])) > 0) {{ '('.count(explode(',',$myuserproduct['state'])).')'; }} @endif @endif @if(isset($type)) @if(($type == "state" && $selectedstateid != "") || ($type == "city" && $selectedcityname !="")) {{ '(1)' }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedState" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list_selected_login_state"> @if(isset($myuserproduct['state']) && $myuserproduct['state'] != '') @if(count(explode(',',$myuserproduct['state'])) > 0) @php $state = []; $state = explode(',',$myuserproduct['state_name']); @endphp @foreach(explode(',',$myuserproduct['state']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_state" data="{{$row}}">{{$state[$key]}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif @if(isset($type)) @if(($type == "state" && $selectedstateid != "") || ($type == "city" && $selectedcityname !="")) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_state" data="{{$selectedstateid}}">{{$selectedstatename}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxWrapPop row p-3 state_list"> @if(isset($myuserproduct['state']) && $myuserproduct['state'] != '') @if(count(explode(',',$myuserproduct['state'])) > 0) @php $state = []; $state = explode(',',$myuserproduct['state_name']); @endphp @foreach(explode(',',$myuserproduct['state']) as $key => $row) <div class="form-check col-md-6">
                        <input class="form-check-input stateid" type="checkbox" checked value="{{$row}}" id="sFilters_state_{{$row}}" name="Filters[state][]" data="{{$state[$key]}}">
                        <label class="form-check-label" for="sFilters_state_{{$row}}">{{$state[$key]}}</label>
                      </div> @endforeach @endif @endif @if(isset($type)) @if(($type == "state" && $selectedstateid != "") || ($type == "city" && $selectedcityname !="")) <div class="form-check col-md-6">
                        <input class="form-check-input stateid" type="checkbox" checked value="{{$selectedstateid}}" id="sFilters_state_{{$selectedstateid}}" name="Filters[state][]" data="{{$selectedstatename}}">
                        <label class="form-check-label" for="sFilters_state_{{$selectedstateid}}">{{$selectedstatename}}</label>
                      </div> @endif @endif </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- state -->
            <!-- city -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" type="button" data-title="city" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">City <span class="counts city_count"> @if(isset($myuserproduct['city']) && $myuserproduct['city'] != '') @if(count(explode(',',$myuserproduct['city'])) > 0) {{ '('.count(explode(',',$myuserproduct['city'])).')'; }} @endif @endif @if(isset($type)) @if($type == "city" && $selectedcityname != "") {{ '(1)' }} @endif @endif </span>
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 dropdown_with_search search-dropdown-box">
                <div class="d-flex justify-content-end mb-2">
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="PosSetBg cityfiltermain" data="false">
                  <div class="d-flex justify-content-between">
                    <div class="search_filter_wrap w-65 me-2">
                      <input type="text" class="form-control searchkeywords form-control-sm mb-2" placeholder="Search City">
                    </div>
                    <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-light btn_clear_selected_item btn_for_mobile" data="city">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="city">Apply</button>
                    </div>
                    <div class="text-right">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="city">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="city">Apply Now</button>
                    </div>
                  </div>
                  <div class="ContentBoxFilterWrapDrop">
                    <div class="CheckBoxSelectedValue chk_selected_login_city">
                      <div class="accordion mb-2" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button p-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#SelectedCity" aria-expanded="true" aria-controls="SelectedCity">
                              <h6 class="mb-0">Selected City <span class="counts city_count"> @if(isset($myuserproduct['city']) && $myuserproduct['city'] != '') @if(count(explode(',',$myuserproduct['city'])) > 0) {{ '('.count(explode(',',$myuserproduct['city'])).')'; }} @endif @endif @if(isset($type)) @if($type == "city" && $selectedcityname != "") {{ '(1)' }} @endif @endif </span>
                              </h6>
                            </button>
                          </h2>
                          <div id="SelectedCity" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                              <ul class="ListWrapDrop p-0 mb-1 list_selected_login_city"> @if(isset($myuserproduct['city']) && $myuserproduct['city'] != '') @if(count(explode(',',$myuserproduct['city'])) > 0) @foreach(explode(',',$myuserproduct['city']) as $key => $row) <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_city" data="{{$row}}">{{$row}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endforeach @endif @endif @if(isset($type)) @if($type == "city" && $selectedcityname != "") <li class="badge bg-primary rounded-0 BtnAddList remove_login_select_city" data="{{$selectedcityname}}">{{$selectedcityname}}
                                  <i class="ms-2 fa-solid fa-xmark"></i>
                                </li> @endif @endif </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="CheckBoxWrapPop row city_list p-3"> @if(isset($type)) @if($type == "city" && $selectedcityname != "") <div class="form-check col-md-6 searchkeyword_tr">
                        <input class="form-check-input cityid" type="checkbox" checked value="{{$selectedcityid}}" id="sFilters_city_{{$selectedcityid}}" name="Filters[city][]" data="{{$selectedcityname}}">
                        <label class="form-check-label" for="sFilters_city_{{$selectedcityid}}">{{$selectedcityname}}</label>
                      </div> @endif @endif </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- city -->
            <!-- Tender Amotunt -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" type="button" data-title="tenderamount" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Amount
              </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 dropdown_with_search search-dropdown-box">
                <div class="d-flex justify-content-between">
                  <h6 class="w-75">Amount</h6>
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label for="txtminprice" class="mb-2">Minimum Amount</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">₹</span>
                      </div>
                      <input type="text" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="txtminprice" name="min_amount" value="{{ (isset($tenderfilters) && (isset($myuserproduct) && $myuserproduct['Min_Amount'])) ? $myuserproduct['Min_Amount'] : '' }}" placeholder="Enter Or Select Amount" required="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="mb-2" for="txtmaxprice mb-2">Maximum Amount</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">₹</span>
                      </div>
                      <input type="text" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" id="txtmaxprice" name="max_amount" value="{{ (isset($tenderfilters) && isset($myuserproduct) &&( $myuserproduct['Max_Amount'] != '')) ? $myuserproduct['Max_Amount'] : '' }}" placeholder="Enter Or Select Amount" required="">
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-12">
                    <div class="form-check">
                      <input class="form-check-input chk_estimate" type="checkbox" name="estimate_values" value="1" id="estimate_values">
                      <label class="form-check-label" for="estimate_values"> Not Estimated Amount </label>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-light  btn_for_mobile btn_clear_selected_item btn_for_mobile" data="tenderamount">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="tenderamount">Apply</button>
                    </div>
                    <div class="text-end">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="tenderamount">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="tenderamount">Apply Now</button>
                    </div>
                  </div>
                </div>
              </div>
            <!-- Tender Amoutn -->
            <!-- More Filters -->
            <div class="dropdown d-inline-block me-2">
              <button class="btn btn-white border d-inline-block btn-sm dropdown-toggle" type="button" id="dp-more-filter" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside"> More Filters </button>
              <div class="dropdown-menu open_dropdown dropdown_with_search p-3 dropdown_with_search" aria-labelledby="dp-more-filter">
                <div class="d-flex justify-content-end mb-2">
                  <span class="close-btn pointer text-end">
                    <i class="fa-solid fa-xmark"></i>
                  </span>
                </div>
                <div class="d-flex justify-content-end">
                   <div class="btn-group w-100 btn_for_mobile_main">
                      <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_mobile" data="morefilter">Reset</button>
                      <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_mobile" data="morefilter">Apply</button>
                  </div>
                  <div class="text-right">
                    <button type="button" class="btn btn-sm btn-outline-secondary btn_clear_selected_item btn_for_desktop" data="morefilter">Reset</button>
                    <button type="button" class="btn btn-sm btn-primary sector_apply btn_for_desktop" data="morefilter">Apply Now</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card bg-light my-2">
                      <div class="card-body p-2">
                        <form role="search" method="get" action="">
                          <label class="mb-2">Within Search</label>
                          <div class="input-group input-group-sm">
                            <input type="text" class="form-control clearallinput" id="Filters_keyword2" value="" placeholder="Search For Tenders i.e : road, valve" autocomplete="off">
                            <!-- <div class="input-group-append">
                              <button class="btn btn-primary py-1 sector_apply" type="button">
                                <i class="fa fa-search"></i>
                              </button>
                            </div> -->
                          </div>
                        </form>
                        <input id="searchbox" class="form-control clearallinput" type="hidden" value="" name="Filters[searchbox]" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card bg-light my-2">
                      <div class="card-body p-2">
                        <label class="mb-2">Publish Date</label>
                        <div class="input-group input-group-sm">
                          <input type="date" class="form-control clearallinput" id="Filters_dt" placeholder="Search For datewise" autocomplete="off">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="card bg-light my-2">
                      <div class="card-body p-2">
                        <label class="mb-2">TBID Search</label>
                        <div class="input-group input-group-sm">
                          <input type="text" class="form-control clearallinput" id="Filters_ntid" placeholder="Search For TBID i.e : 26974461, 26974160" autocomplete="off">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- More Filters -->
            <div class="ClearBtn d-inline-block me-2 me-4">
              <a href="javascript:void(0)" class="Clear btn_clear_selected_item btn btn-red btn-sm rounded-4" data="clearallfilter"> Reset Filter </a>
            </div>
            <form id="filter_form">
              @csrf
              <input type="hidden" name="input_s_product" value="{{ (isset($myuserproduct['productid']) && $myuserproduct['productid'] != '') ? $myuserproduct['productid'] : '' }}">
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
              <input type="hidden" name="input_publish_date" value="{{ (isset($myuserproduct['tender_publish_date']) && $myuserproduct['tender_publish_date'] !="") ? $myuserproduct['tender_publish_date'] : '' }}">
              <input type="hidden" name="input_ntid_search" value="">
              <input type="hidden" name="input_isexactkeyword_values" value="{{ (isset($myuserproduct['is_exact_keyword']) && $myuserproduct['is_exact_keyword'] == 1) ? 1 : 0 }}">
              <input id="searchbox" class="clearallinput" type="hidden" name="Filters[searchbox]" value="">
            </form> 
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="col-12 bg-primary p-2 mt-2 rounded">
            <ul id="pills-tab-custom" class="nav nav-pills  nav-pills-custom pb-0 justify-content-end" id="pills-tab-custom" role="tablist">
              @php
                if(isset($_GET['data'])){
                  $selecttype = $_GET['data'];
                }else{
                  $selecttype = 'live';
                }
              @endphp
              
              <li class="BtnSearch nav-item mt-0">
                <a class="nav-link tablinksfilter {{ ($selecttype == 'live') ? 'active' : ''}}" href="javascript:void(0)" data="live">All Result<span class="box_number1"></span>
                </a>
              </li>
              <li class="BtnSearch nav-item mt-0">
                <a class="nav-link tablinksfilter {{ ($selecttype == 'fresh') ? 'active' : ''}}" href="javascript:void(0)" data="fresh">Fresh <span class="box_number1"></span>
                </a>
              </li>
              <!-- <li class="nav-item dropdown me-2">
                  <a class="btn btn-white text-black rounded dropdown-toggle bg-white border-white" href="#" role="button" id="archive" data-bs-toggle="dropdown" aria-expanded="false" style="min-width: 150px;">
                  Archive
                </a>
                  <div class="dropdown-menu open_dropdown w-auto" aria-labelledby="archive">
                    <a class="dropdown-item " href="javascript:void(0)" data="archive">Archieve</a>
                    <a class="dropdown-item" href="javascript:void(0)" data="archive2021">Archieve-2021</a>
                    <a class="dropdown-item" href="javascript:void(0)" data="archive2020">Archieve-2020</a>
                  </div>
              </li> -->
              <li class="nav-item">
                <p class="BarBtn m-0" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="https://www.nationaltenders.com/frontend/assets/barbtn.svg">
                </p>
                <div class="dropdown-menu p-2 w-auto">
                  <div class="radio-tile-group">
                        <div class="input-container">
                            <input id="relevance" class="radio-button sortfilter" type="radio" value="" name="radioSort" autocomplete="off">
                            <div class="radio-tile">
                                <label for="relevance" class="radio-tile-label">Relevance</label>
                            </div>
                        </div>
                        <div class="input-container">
                            <input id="highlow" class="radio-button sortfilter" type="radio" value="hl" name="radioSort" autocomplete="off">
                            <div class="radio-tile">
                                <label for="highlow" class="radio-tile-label">Awarded Value : High to Low</label>
                            </div>
                        </div>
                    
                        <div class="input-container">
                            <input id="lowhigh" class="radio-button sortfilter" type="radio" value="lh" name="radioSort" autocomplete="off">
                            <div class="radio-tile">
                                <label for="lowhigh" class="radio-tile-label">Awarded Value: Low to High</label>
                            </div>
                        </div>
                    
                        <div class="input-container">
                            <input id="asc-dsc" class="radio-button sortfilter" type="radio" value="ad" name="radioSort" autocomplete="off">
                            <div class="radio-tile">
                                <label for="asc-dsc" class="radio-tile-label">AOC Date: Asc to Desc</label>
                            </div>
                        </div>
                    
                        <div class="input-container">
                            <input id="closing-date" class="radio-button sortfilter" type="radio" value="da" name="radioSort" autocomplete="off">
                            <div class="radio-tile">
                                <label for="closing-date" class="radio-tile-label">AOC Date: Desc to Asc</label>
                            </div>
                        </div>
                    </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <!-- Live tab Content -->
        <div class="col-md-12">
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
              <!--<a href="#" class="LoadMore">LOAD MORE</a>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Featured Services Section -->
</main>
<!-- End #main -->
@endsection
@section('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('assets/js/gautish.js') }}"></script>
<script type="text/javascript">
// $('body').on('click','.abc',function(){
//     alert("hi");
// });

// $(".dropdown-menu").click(function(event) {
//     event.stopPropagation();
// });
$('body').on("click", ".dropdown-menu", function (e) {
  $(this).parent().is(".show") && e.stopPropagation();
});

@if(isset($page) && $page == "tenderresultlisting")
  offset = 1;
  busy == false;
  $("#lev1").html('');
  setTimeout(function () {
    getFilter2(offset);
  }, 1000);
@else
  checkselecteditems();
@endif

// $('body').on('click', '.modalFilterSave', function(){
//   @if(Auth::check())
//     selected_adding_new_items();
//     $(".SaveFilterPopUpBox").addClass("Active");
//   @else
//     alert("Please login first!");
//   @endif
// });

// $('body').on('click', '.umodalFilterSave', function (e) {
// @if(Auth::check())
//   var filterid = $(this).attr('data');
//   if(filterid != ""){
//     $('input[name="updatefiltermsg_'+filterid+'"]').val(0);
//     $(".updatefiltermsg_filteryes,.updatefiltermsg_filterno").attr('data','');
//     $(".updatefiltermsg_popup").hide();   
//     var filtername = $(".buttonsavedfilters").text();
//     selected_adding_new_items();
//     selected_filter_add_merge(filterid,filtername);
//   }else{
//       alert('Please select filter!');
//   }
//   @else
//     alert('Please login first!');
//   @endif
// });


// $('body').on('click', '.ArchToggle > .navbar-nav > li > .dropdown-menu > li > a', function () {
//     var prevdata = $(".ArchToggle > .navbar-nav > li > .dropdown-menu > li > .active").attr('data');
//     $(".tablinksfilter").removeClass('active');
//     $(".ArchToggle > .navbar-nav > li > .dropdown-menu > li > a").removeClass('active');
//     $(this).addClass('active');
//     var data = $(".ArchToggle > .navbar-nav > li > .dropdown-menu > li > .active").attr('data');
//     var img = '{{ asset("frontend/assets/arc.svg") }}';
//     $('.ArchToggle > .navbar-nav > li > .dropdown-toggle').html("<img src='"+img+"'> "+$(this).html());
//     if(data != prevdata){
//       offset = 1;
//       busy == false;
//       $("#lev1").html('');
//       getFilter2(offset);
//     }
// });

//filter update
// function selected_filter_update(filterid){
//    var collapseid = $(".filter_main_wrap").find("#collapse_"+filterid);
//    var filtername = $(collapseid).find("input[name='filter_name_input']").val();
//    var product_str = '';
//    var eproduct_str = '';
//    var category_str = '';
//    var ecategory_str = '';
//    var subcategory_str = '';
//    var esubcategory_str = '';
   
//    if($(collapseid).find(".filter_product").length > 0){
//           var product = new Array();
//           jQuery($(collapseid).find(".filter_product")).each(function () {
//               product.push($(this).attr('data'));
//           });
//        product_str = product.join(",");
//    }
//    if($(collapseid).find(".filter_eproduct").length > 0){
//           var eproduct = new Array();
//           jQuery($(collapseid).find(".filter_eproduct")).each(function () {
//               eproduct.push($(this).attr('data'));
//           });
//        eproduct_str = eproduct.join(",");
//    } 
   
//    if($(collapseid).find(".filter_category").length > 0){
//           var category = new Array();
//           jQuery($(collapseid).find(".filter_category")).each(function () {
//               category.push($(this).attr('data'));
//           });
//        category_str = category.join(",");
//    } 
//    if($(collapseid).find(".filter_ecategory").length > 0){
//           var ecategory = new Array();
//           jQuery($(collapseid).find(".filter_ecategory")).each(function () {
//               ecategory.push($(this).attr('data'));
//           });
//        ecategory_str = ecategory.join(",");
//    } 
   
//    if($(collapseid).find(".filter_subcategory").length > 0){
//           var subcategory = new Array();
//           jQuery($(collapseid).find(".filter_subcategory")).each(function () {
//               subcategory.push($(this).attr('data'));
//           });
//        subcategory_str = subcategory.join(",");
//    }
//    if($(collapseid).find(".filter_esubcategory").length > 0){
//           var esubcategory = new Array();
//           jQuery($(collapseid).find(".filter_esubcategory")).each(function () {
//               esubcategory.push($(this).attr('data'));
//           });
//        esubcategory_str = esubcategory.join(",");
//    }
   
//    var keywords = '';
//    if($(collapseid).find(".filter_keyword").length > 0){
//           var keyword = new Array();
//           jQuery($(collapseid).find(".filter_keyword")).each(function () {
//               keyword.push($(this).attr('data'));
//           });
//        keywords = keyword.join(",");
//    }
//    var ekeywords = '';
//    if($(collapseid).find(".filter_ekeyword").length > 0){
//           var ekeyword = new Array();
//           jQuery($(collapseid).find(".filter_ekeyword")).each(function () {
//               ekeyword.push($(this).attr('data'));
//           });
//           ekeywords = ekeyword.join(",");
//    }
//    var org_str = '';
//    var eorg_str = '';
//    if($(collapseid).find(".filter_org").length > 0){
//           var agency = new Array();
//           jQuery($(collapseid).find(".filter_org")).each(function () {
//               agency.push($(this).attr('data'));
//           });
//        org_str = agency.join(",");
//    }
//    if($(collapseid).find(".filter_eorg").length > 0){
//           var eagency = new Array();
//           jQuery($(collapseid).find(".filter_eorg")).each(function () {
//               eagency.push($(this).attr('data'));
//           });
//        eorg_str = eagency.join(",");   
//    }
//    var state_str = '';
//    if($(collapseid).find(".filter_state").length > 0){
//           var state = new Array();
//           jQuery($(collapseid).find(".filter_state")).each(function () {
//               state.push($(this).attr('data'));
//           });
//        state_str = state.join(",");
//    }
//    var city_str = '';
//    if($(collapseid).find(".filter_city").length > 0){
//           var city = new Array();
//           jQuery($(collapseid).find(".filter_city")).each(function () {
//               city.push($(this).attr('data'));
//           });
//        city_str = city.join(",");
//    }
//    var datamin = '';
//    var datamax = '';
//    if($(collapseid).find(".filter_tender_amount").length > 0){
//        datamin = $(collapseid).find(".filter_tender_amount").attr('datamin');
//        datamax = $(collapseid).find(".filter_tender_amount").attr('datamax');
//    }
   
//    var not_estimate = 0;
//    if($(collapseid).find(".filter_not_estimate").length > 0){
//        not_estimate = 1;
//    }
//    var refine_keyword = '';
//    if($(collapseid).find(".filter_rkeyword").length > 0){
//           var rkeywords = new Array();
//           jQuery($(collapseid).find(".filter_rkeyword")).each(function () {
//               rkeywords.push($(this).attr('data'));
//           });
//        refine_keyword = rkeywords.join(",");
//    }
   
//   $.ajax({
//       'type': 'POST',
//       //'dataType': "json",
//       'url': '{{ route("tenderlist-filterupdate") }}',
//       'data': {"_token": $('meta[name="csrf-token"]').attr('content'),"filterid":filterid,"append":"no","filtername":filtername,"state": state_str, "city": city_str,'exe_keyword':ekeywords,'exe_org':eorg_str,'exe_product':eproduct_str,'exe_category':ecategory_str,'exe_subcategory':esubcategory_str, "tendervalue": datamin, "tendermaxvalue": datamax,"product":product_str,"category":category_str,"subcategory":subcategory_str,"organization":org_str, "txtRefineSearchText": refine_keyword, "keywords": keywords, 'est': not_estimate},
//       'cache': false,
//       beforeSend: function () {
//           //$("#loader_message").html("").hide();
//           //$('#loader_image').show();
//       },
//       success: function (html) {
          
//           $('label[for="customCheck_'+filterid+'"]').html(''); 
//           $('label[for="customCheck_'+filterid+'"]').html(filtername);
//           $('input[name="updatefiltermsg_'+filterid+'"]').val(0);
//           $(".filter_update,.updatefiltermsg_popup").hide();
//           toastr.success('Success', 'Filter Updated Successfully', {timeOut: 1500});
//       }
//   });
// }
//filter update

// $(".updatefiltermsg_popup").hide();
// $('.umodalFilterSave').hide();
// $('.umodalFilterSave').attr('disabled','disabled');

/*
function selected_filter_add_merge(filterid,filtername){
   //var collapseid = $(".filter_main_wrap").find("#collapse_"+filterid);
   //var filtername = $(collapseid).find("input[name='filter_name_input']").val();
   
   var collapseid = $(".adding_new_filter_inner");
   var product_str = '';
   var eproduct_str = '';
   var category_str = '';
   var ecategory_str = '';
   var subcategory_str = '';
   var esubcategory_str = '';
   
   if($(collapseid).find(".remove_adding_product_item").length > 0){
          var product = new Array();
          jQuery($(collapseid).find(".remove_adding_product_item")).each(function () {
              product.push($(this).attr('data'));
          });
       product_str = product.join(",");
   }
   
   if($(collapseid).find(".remove_adding_eproduct_item").length > 0){
          var eproduct = new Array();
          jQuery($(collapseid).find(".remove_adding_eproduct_item")).each(function () {
              eproduct.push($(this).attr('data'));
          });
       eproduct_str = eproduct.join(",");
   } 
   
   if($(collapseid).find(".remove_adding_category_item").length > 0){
          var category = new Array();
          jQuery($(collapseid).find(".remove_adding_category_item")).each(function () {
              category.push($(this).attr('data'));
          });
       category_str = category.join(",");
   } 
   if($(collapseid).find(".remove_adding_ecategory_item").length > 0){
          var ecategory = new Array();
          jQuery($(collapseid).find(".remove_adding_ecategory_item")).each(function () {
              ecategory.push($(this).attr('data'));
          });
       ecategory_str = ecategory.join(",");
   } 
   
   if($(collapseid).find(".remove_adding_subcategory_item").length > 0){
          var subcategory = new Array();
          jQuery($(collapseid).find(".remove_adding_subcategory_item")).each(function () {
              subcategory.push($(this).attr('data'));
          });
       subcategory_str = subcategory.join(",");
   }
   if($(collapseid).find(".remove_adding_esubcategory_item").length > 0){
          var esubcategory = new Array();
          jQuery($(collapseid).find(".filter_esubcategory")).each(function () {
              esubcategory.push($(this).attr('data'));
          });
       esubcategory_str = esubcategory.join(",");
   }
   
   var keywords = '';
   if($(collapseid).find(".remove_adding_keyword_item").length > 0){
          var keyword = new Array();
          jQuery($(collapseid).find(".remove_adding_keyword_item")).each(function () {
              keyword.push($(this).attr('data'));
          });
       keywords = keyword.join(",");
   }
   var ekeywords = '';
   if($(collapseid).find(".remove_adding_ekeyword_item").length > 0){
          var ekeyword = new Array();
          jQuery($(collapseid).find(".remove_adding_ekeyword_item")).each(function () {
              ekeyword.push($(this).attr('data'));
          });
          ekeywords = ekeyword.join(",");
   }
   var org_str = '';
   var eorg_str = '';
   if($(collapseid).find(".remove_adding_org_item").length > 0){
          var agency = new Array();
          jQuery($(collapseid).find(".remove_adding_org_item")).each(function () {
              agency.push($(this).attr('data'));
          });
       org_str = agency.join(",");
   }
   if($(collapseid).find(".remove_adding_eorg_item").length > 0){
          var eagency = new Array();
          jQuery($(collapseid).find(".remove_adding_eorg_item")).each(function () {
              eagency.push($(this).attr('data'));
          });
       eorg_str = eagency.join(",");   
   }
   var state_str = '';
   if($(collapseid).find(".remove_adding_state_item").length > 0){
          var state = new Array();
          jQuery($(collapseid).find(".remove_adding_state_item")).each(function () {
              state.push($(this).attr('data'));
          });
       state_str = state.join(",");
   }
   var city_str = '';
   if($(collapseid).find(".remove_adding_city_item").length > 0){
          var city = new Array();
          jQuery($(collapseid).find(".remove_adding_city_item")).each(function () {
              city.push($(this).attr('data'));
          });
       city_str = city.join(",");
   }
   var datamin = '';
   var datamax = '';
   if($(collapseid).find(".remove_adding_amount_item").length > 0){
       datamin = $(collapseid).find(".remove_adding_amount_item").attr('datamin');
       datamax = $(collapseid).find(".remove_adding_amount_item").attr('datamax');
   }
   
   var not_estimate = 0;
   if($(collapseid).find(".remove_adding_amount_item").length > 0){
       not_estimate = 1;
   }
   var refine_keyword = '';
   if($(collapseid).find(".remove_adding_rkeyword_item").length > 0){
          var rkeywords = new Array();
          jQuery($(collapseid).find(".remove_adding_rkeyword_item")).each(function () {
              rkeywords.push($(this).attr('data'));
          });
       refine_keyword = rkeywords.join(",");
   }
  
  if(filterid != 0){
      
      $.ajax({
              'type': 'POST',
              //'dataType': "json",
              'url': '{{ route("tenderlist-filterupdate") }}',
              'data': {"_token": $('meta[name="csrf-token"]').attr('content'),"filterid":filterid,"append":"yes","filtername":filtername,"state": state_str, "city": city_str,'exe_keyword':ekeywords,'exe_org':eorg_str,'exe_product':eproduct_str,'exe_category':ecategory_str,'exe_subcategory':esubcategory_str, "tendervalue": datamin, "tendermaxvalue": datamax,"product":product_str,"category":category_str,"subcategory":subcategory_str,"organization":org_str, "txtRefineSearchText": refine_keyword, "keywords": keywords, 'est': not_estimate},
              'cache': false,
              beforeSend: function () {
                  //$("#loader_message").html("").hide();
                  //$('#loader_image').show();
              },
              success: function (html) {
                  
                  $('label[for="customCheck_'+filterid+'"]').html(''); 
                  $('label[for="customCheck_'+filterid+'"]').html(filtername);
                  $('input[name="updatefiltermsg_'+filterid+'"]').val(0);
                  $(".filter_update,.updatefiltermsg_popup").hide();
                  
                  $('div[data="main_card_'+filterid+'"]').html('');
                  $('div[data="main_card_'+filterid+'"]').html(html);
                  $(".delete_filter_confirmation").hide();
                  //alert('Succefully updated!');
                  //$(".SaveFilterPopUpBox").removeClass("Active");
                  toastr.success('Success', 'Filter Updated Successfully', {timeOut: 1500});
                  
                  // $.toast({
                  //   heading: 'Success',
                  //   text: 'Filter Updated Successfully',
                  //   showHideTransition: 'slide',
                  //   icon: 'success',
                  //   loaderBg: '#f96868',
                  //   position: 'top-right'
                  // });
              }

      });
  
   }else{
      $.ajax({
          'type': 'POST',
          //'dataType': "json",
          'url': '{{ route("tenderlist-filtercreate") }}',
          'data': {"_token": $('meta[name="csrf-token"]').attr('content'),"filterid":filterid,"append":"yes","filtername":filtername,"state": state_str, "city": city_str,'exe_keyword':ekeywords,'exe_org':eorg_str,'exe_product':eproduct_str,'exe_category':ecategory_str,'exe_subcategory':esubcategory_str, "tendervalue": datamin, "tendermaxvalue": datamax,"product":product_str,"category":category_str,"subcategory":subcategory_str,"organization":org_str, "txtRefineSearchText": refine_keyword, "keywords": keywords, 'est': not_estimate},
          'cache': false,
          beforeSend: function () {
              //$("#loader_message").html("").hide();
              //$('#loader_image').show();
          },
          success: function (html) {
              
              $('.filter_main_wrap').append(html);
              $(".delete_filter_confirmation").hide();
              //alert('Succefully updated!');
               $(".SaveFilterPopUpBox").removeClass("Active");
               toastr.success('Success', 'Filter Created Successfully', {timeOut: 1500});
              // $.toast({
              //   heading: 'Success',
              //   text: 'Filter Created Successfully',
              //   showHideTransition: 'slide',
              //   icon: 'success',
              //   loaderBg: '#f96868',
              //   position: 'top-right'
              // });
          }

      });
  }
} */

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
  // var data = $(".BtnSearch > .tablinksfilter.active").attr('data');
  // if (typeof data === "undefined") {    
  //   data = $(".ArchToggle > .navbar-nav > li > .dropdown-menu > li > .active").attr('data'); 
  // }
  var data = $("#pills-tab-custom > li > .active").attr('data');
  if (typeof data === "undefined") {    
      data = $("#pills-tab-custom > li > .dropdown-menu > .active").attr('data'); 
  }
  //var filter_scope = $(".sortfilter > .tablinksfilter.active").attr('data');
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
            //jQuery(".box_number1").empty();
            //jQuery(".active > .box_number1").append('('+html.res2+')');
        }else{
           if(offset == 1){
           //jQuery(".box_number1").empty();
           //jQuery(".active > .box_number1").append('(0)'); 
           }
        }
      
        if (html.res1 == "") {
            $("#loader_message").html('<div class="alert alert-primary alert-dismissible fade show text-center" role="alert">No more tenders.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>').show();
        } else {
            if(offset == 1){
              if(html.total_count < 10){
                  busy = false;
              // $("#loader_message").html('<div class="alert alert-primary alert-dismissible fade show text-center" role="alert">No more tenders.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>').show();      
              }else{  
              busy = false;
              $("#loader_message").html('<div class="text-center" ><b>Loading please wait...</b></button>').show();  
              }
            }else{
             busy = false;
             $("#loader_message").html('<div class="text-center" ><b>Loading please wait...</b></button>').show();
            }
        }
        //window.busy = false;
      }
  });    
  return false;
}
$('body').on('click','.close-btn',function(e){
  $(this).parents('.dropdown').find('button.dropdown-toggle').dropdown('toggle');
  // $(e.target).append(dropdownMenu.detach());
  // dropdownMenu.hide();
});

$('body').on('click', '#pills-tab-custom > li > .dropdown-menu > a', function () {
  var prevdata = $("#pills-tab-custom > li > .dropdown-menu > .active").attr('data');
  $("#pills-tab-custom > li > a").removeClass('active');
  $("#pills-tab-custom > li > .dropdown-menu > a").removeClass('active');
  $(this).addClass('active');
  var data = $("#pills-tab-custom > li > .dropdown-menu > .active").attr('data');
  $('#pills-tab-custom > li >.dropdown-toggle').html($(this).html());    
  if(data != prevdata){
   offset = 1;
   busy == false;
   $("#lev1").html('');
   getFilter2(offset);
   
  }
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
  //add on scroll for table holder
  // $(".ak-holder").scroll(function() {
  //   var $ddHolder = $(this).find(".dropdown")
  //   var $btnDropDown = $(this).find(".dropdown-toggle");
  //   var $listHolder = $(this).find(".dropdown-menu");
  //   if ($listHolder.data("open")) {
  //     $listHolder.css({
  //       "top": ($btnDropDown.offset().top + $btnDropDown.outerHeight(true)) + "px",
  //       "left": $btnDropDown.offset().left + "px"
  //     });
  //     $ddHolder.toggleClass("open", ($btnDropDown.offset().left > $(this).offset().left))
  //   }
  // })
});
</script>
@endsection