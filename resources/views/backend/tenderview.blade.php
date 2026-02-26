@extends('backend.layouts.app')

@php
$schematitle = preg_replace('/[^A-Za-z0-9\-]/', ' ', strip_tags(substr($data->Work, 0, 30))); 
$schematitle = str_replace('xxnxx', ' ', $schematitle);
$schematitle = str_replace('XXNXXX', ' ', $schematitle);
$schematitle = str_replace('XXXXN', ' ', $schematitle);
$schematitle = str_replace('XXNXX', ' ', $schematitle);
$schematitle = str_replace('XXDFN', ' ', $schematitle);
$schematitle = str_replace('Nxxx', ' ', $schematitle);
$schematitle = str_replace('NXXX', ' ', $schematitle);
$schematitle = str_replace('XXN', ' ', $schematitle);
$schematitle = str_replace('xxn', ' ', $schematitle);

$schemadesc = $schematitle." tender, GeM tender, Railway Tender, ".$data->state_name." Tender, ".$data->org_name." Tender, ".$data->city." Tender";
$schematitle = $schematitle." | Tender bidding, Tender submission, Tender information | ".$data->city." tender result";
$schemakey = $schematitle." tender, GeM tender, ".$data->state_name." tender, ".$data->org_name." tender,".$data->city." tender, Railway Tender";

@endphp

    @section('title','TenderKhabar')
    @section('meta_description', 'TenderKhabar')
    @section('meta_keywords', 'TenderKhabar')
    @section('meta_category', 'TenderKhabar')
    
@section('stylesheet')
<style>
  .tab_title{
    background-color: var(--color-secondary);
    color: #fff;
  }
  .days{
    font-size: 50px;
    color: red;
    font-weight: bold;
  }
  .Box{
    font-size: 20px;
    color: red;
    font-weight: bold;
  }
  .error{color:red;}
  .btn-block{ width:100%; }
  .pdf_file {
    border-bottom: 1px solid #ccc;
    }
    .blink_me_offer{
        animation: animate 1s linear infinite;
    }
    @keyframes animate {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 0;
        }
    }
  /*AAC637*/
  .List{
    margin: 0;
    padding: 0;
  }
  .List li{
    float: left;
    margin: 3px 5px;
    list-style: none;
  }
  .List li a{
  text-decoration: none;
    }
  .List li a:after {
        font-family: "FontAwesome";
        content: "\f101";
        margin: 0px 5px;
        line-height: 20px;
    }
    .breadcrumb{
        float: left;
        width: 100%;
    }
</style>  
@endsection

@section('content')

<main id="main">
     <!-- ======= Breadcrumbs class="padding-top" ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('../assets/img/page-header.jpg');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Tender Details</h2>
            <!-- <p>Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p> -->
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Tender of {{ $data->org_name }} - GCID : {{ $data->ourrefno }}</li>
        </ol>
      </div>
    </nav>
  </div><!-- End Breadcrumbs -->
  
  

  <!-- ======= About Us Section ======= -->
  <section id="about" class="about">
<div class="container">
    

    <div class="row justify-content-center">
        

        <div class="col-md-8">
            <div class="card p-0 mb-2">
                <div class="card-body p-0 m-0">    
                    <div class="tab_title p-2">
                        <h5><i class="fa-solid fa-person-digging"></i> Description</h5>
                    </div>
                    <div class="disc_text p-2">
                        <p> {{ $data->Work }} </p>
                    </div>          
                </div>
            </div>
            <div class="card p-0 mb-2">
                <div class="card-body p-2 m-0">  
                  <h5 class="title"><strong><i class="fa-solid fa-building"></i> Tendering Authority: </strong>{{ $data->org_name }}</h5>  
                    <div class="disc_text">
                        <!-- <p class="tender_location">
                         {{ $data->city }}, {{ $data->state_name }}, India
                        </p> -->
                    </div>    
                    <div class="d-md-flex justify-content-between">
                        <div class="basic_details mb-2 mb-md-0">
                            <p>GCID</p>
                            <h4>{{ $data->ourrefno }}</h4>
                        </div>
                        <div class="basic_details mb-2 mb-md-0">
                            <p>Last Date For Submission</p>
                            <h4 class="error">{{ \Carbon\Carbon::parse($data->submitdate)->format('jS M, Y') }}</h4>
                        </div>
                        <div class="basic_details mb-2 mb-md-0">
                            <p>Opening Date</p>
                            <h4>{{ \Carbon\Carbon::parse($data->opendate)->format('jS M, Y') }}</h4>     
                        </div>
                    </div>      
                </div>
            </div>
            <div class="card p-0 mb-2">
                <div class="card-body p-0 m-0">    
                    <div class="tab_title p-2">
                        <h5><i class="fa-solid fa-money-bill"></i> Cost</h5>
                    </div>

                    <div class="disc_text p-2">
                        <div class="d-flex justify-content-between my-2">
                            <p><strong>Document Cost</strong></p>
                            <p class="value">{{ ($data->doccost != 0) ? $data->doccost : 'Refer Documents' }}</p>
                        </div>
                        <div class="d-flex justify-content-between my-2">
                            <p><strong>EMD</strong></p>
                            <p class="value">{{ ($data->earnestamount != 0) ? $data->earnestamount : 'Refer Documents' }}</p>
                        </div>
                        <div class="d-flex justify-content-between my-2">
                            <p><strong>Estimated Cost</strong></p>
                            <p class="value">{{ ($data->tenderamount != 0) ? $data->tenderamount : 'Refer Documents' }}</p>
                        </div>

                    </div>          
                </div>
            </div>
            <div class="card p-0 mb-2">
                <div class="card-body p-0 m-0">    
                    <div class="tab_title p-2">
                        <h5><i class="fa-sharp fa-solid fa-map-location"></i> Location</h5>
                    </div>

                    <div class="disc_text p-2">
                        <div class="d-flex justify-content-between my-2">
                            <p><strong>City</strong></p>
                            <p class="value">{{ ($data->city != "") ? $data->city : 'Refer Documents' }}</p>
                        </div>
                        <div class="d-flex justify-content-between my-2">
                            <p><strong>State</strong></p>
                            <p class="value">{{ ($data->state_name != "") ? $data->state_name : 'Refer Documents' }}</p>
                        </div>
                     </div>          
                </div>
            </div>
   
        </div>
        <div class="col-md-4">
            <div class="card p-0 mb-2">
                <div class="card-body p-0 m-0">    
                    <div class="tab_title p-2">
                        <h5><i class="fa-solid fa-calendar-days"></i> {{ \Carbon\Carbon::parse($data->submitdate)->format('jS M, Y') }}</h5>
                    </div>

                    <div class="disc_text p-2">
                        <div class="text-center p-4">
                            @if($data->submitdate >= date('Y-m-d'))
                                @if($data->submitdate == date('Y-m-d'))
                                    <p class="Box">Ending Today</p>
                                @else
                                    @php 
                                    $fdate = date('Y-m-d');
                                    $toDate = \Carbon\Carbon::parse($data->submitdate);
                                    $fromDate = \Carbon\Carbon::parse($fdate);
                                    $days = $toDate->diffInDays($fromDate);
                                    @endphp 
                                    <p class="days blink_me_offer">{{ $days }} </p>
                                    <p class="Box">days left</p>
                                @endif
                            @else
                                <p class="Box">Closed</p>
                            @endif
                        </div>
                     </div>          
                </div>
            </div>
                @if($checkdownload['is_download'] == 1)
            
                @if(isset($_SERVER['HTTPS']))
                   @php $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http"; @endphp
                @else
                   @php $protocol = 'http'; @endphp
                @endif
                
                @php
                $urlp = $data->documentpath;
                $url = preg_replace("/^http:/i", "$protocol:", $urlp);
                $arrdate = explode('/',$url);
                @endphp
            
                @if($arrdate[4] < $documentlink->date)
                   @php $url = str_replace('https://document.nationaltenders.in',$documentlink->url,$url); @endphp
                @endif    

                @php $url = str_replace('document.nationaltenders.in','document.tenderkhabar.in',$url); @endphp
                <div class="card p-0 mb-2">
                    <div class="card-body p-0 m-0">    
                        <div class="tab_title p-2">
                            <h5><i class="fa-solid fa-download"></i> Download Documents</h5>
                        </div>

                        <div class="pdf_file">
                            <a class="doc_link" href="{{ $url }}" target="_blank">
                              <div class="d-flex justify-content-between">
                                 <p class="doc_name p-2">Document-1 {{-- pathinfo($url, PATHINFO_FILENAME) --}}</p>
                                 <span class="p-2"><i class="fa-sharp fa-solid fa-download"></i></span>
                              </div>
                            </a>
                        </div>

                        @if(count((array) $tenderdocuments) > 0)
                            @foreach($tenderdocuments as $k => $tender_doc)
                                @php
                                $urlo = preg_replace("/^http:/i", "$protocol:", $tender_doc->documentpath);
                                $arrdate = explode('/',$urlo);
                                @endphp
                                @if($arrdate[4] < $documentlink->date)
                                   @php $urlo = str_replace('https://document.nationaltenders.in',$documentlink->url,$urlo); @endphp
                                @endif 
                                @php $urlo = str_replace('document.nationaltenders.in','document.nationaltenders.in',$urlo); @endphp
                                <div class="pdf_file">
                                    <a class="doc_link" href="{{ $urlo }}" target="_blank">
                                      <div class="d-flex justify-content-between">
                                         <p class="doc_name p-2">Document-{{$k + 2}} {{-- pathinfo($urlo, PATHINFO_FILENAME) --}}</p>
                                         <span class="p-2"><i class="fa-sharp fa-solid fa-download"></i></span>
                                      </div>
                                    </a>
                                </div>

                                
                            @endforeach
                        @endif

                           
                    </div>
                </div>

          @else
            <div class="card p-0 mb-2">
                    <div class="card-body p-0 m-0"> 
                        <a href="javascript:void(0)" class="btn btn-primary btn-block planpurchase" data="doc" popup-year="32511649" data-bs-toggle="modal" data-bs-target="#inquirymodal">
                            Contact to Admin
                        </a>
                    </div>
            </div>        
            @include('popup.inquiry',['flag'=>'contract-to-admin'])
          @endif

        </div>  
    </div>
</div>
</section>
  <!-- End Frequently Asked Questions Section -->
</main>
<!-- End #main -->
@endsection

@section('scripts') 

<script>
$('body').on('click','.redirectDocumentPlansPopup',function(){
    var getNTID = $(this).attr('ntid');
    var title_txt = $(this).attr('data');
    /*$('.btn_document_pay').attr('href','https://nationaltenders.com/dashboard/tenderplanpayment/doc/'+getNTID);
    if(title_txt != ''){
        $('.redirect_popup_title').html('');
        $('.redirect_popup_title').html(title_txt);
    }*/
    $('.doclink').attr('href',"{{-- route('documentcart','') --}}/"+getNTID);
    $('.subscribelink').attr('href',"{{-- route('pricing-plans') --}}");
    $('#subscribepopup').addClass('show');
});
$('body').on('click','.closesubscribepopup',function(){
$('#subscribepopup').removeClass('show');
});
$("body").on('click','.planpurchase', function(){
    var pageurl = $(this).attr('data');
    var pageurl_year = $(this).attr('popup-year');
    $("#page_url_popup").val(pageurl);
    $("#page_url_popup_year").val(pageurl_year);
    //$("#reegisterwithmobile").modal("show");
    $("#reegisterwithmobile").addClass("open");
});
var boqitem = false;
var bpage = 2;
$("body").on('click','.btnboq_viewmore', function(){
   
     if (boqitem == false) {
        boqitem = true;
        var ntid = $(this).attr('data');
        //var page = $(this).attr('data-page');
        
        if(ntid != ""){
         $.ajax({
                 dataType: "json",
                'type': 'POST',
                'url': '{{--route("getboqitemspagewise")--}}',
                'data': {"_token": $('meta[name="csrf-token"]').attr('content'),"ntid":ntid,"page":bpage},
                'cache': false,
                'success': function (data) {
                  $(".boq_items > tbody").append(data.result.html);
                   bpage++;
                   boqitem = data.result.check;
                   if(data.result.check == true){
                       $(".btnboq_viewmore").hide();
                   }
                }
            });
        }
     }
    
});
$('body').on('click','.request-for-rate-btn',function(){
    var flag = $(this).attr('flag');
    $('#popup-inquiry-modal').show();
    $('#blog_popup_flag').val(flag);
});
</script>
@endsection