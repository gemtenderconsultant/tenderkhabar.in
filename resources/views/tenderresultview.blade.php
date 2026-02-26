@extends('layouts.app')
@section('stylesheet')
<style>
  .tab_title{
    background-color: var(--color-secondary);
    color: #fff;
  }
  .days{
    font-size: 50px;
    color: var(--color-primary);
    font-weight: bold;
  }
  .Box{
    font-size: 20px;
    color: var(--color-primary);
    font-weight: bold;
  }
  .error{color:var(--color-primary);}
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
<main id="main">
     <!-- ======= Breadcrumbs class="padding-top" ======= -->
  <div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('../assets/img/page-header.jpg');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-12 text-center">
            <h2>Tender Result Details</h2>
            <!-- <p>Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p> -->
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('searchresult') }}">Tender Result</a></li>
          <li>Tender Result for {{ $data->Organisation }} - TDID : {{ $data->id }}</li>
        </ol>
      </div>
    </nav>
  </div>
  <!-- End Breadcrumbs -->
  <section class="pt-3">
    <div class="container">
      <div class="row justify-content-center">
          
        <div class="col-md-12">
          <div class="card p-0 mb-2">
            <div class="card-body p-0 m-0">    
              <div class="disc_text p-3">
                <div class="d-flex justify-content-between">
                  <p class="mb-2 org_main">
                    <span class="pe-2">
                      <i class="fa  fa-building me-2"></i><strong>{{$data->Organisation}}</strong>
                    </span>
                  </p>
                  <p class="tenderid"><strong>TRID {{$data->id}}</strong></p>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <p class="mb-2 org_main">
                      <span class="pe-2 location"><i class="fa fa-map-marker"></i> {{ $data->state }}, {{$data->city}}, India</span>
                      <span class="pe-2 ps-2 border-left"><i class="fa fa-calendar"></i> AOC Date: <span class="text-danger">{{ \Carbon\Carbon::parse($data->aoc)->format('D jS F, Y') }}</span></span>
                      <span class="ps-2 pe-2 date_status"><i class="fa fa-inr"></i> {{ $data->awarded_value }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>  
        <div class="col-md-12">
          <div class="card p-0 mb-2">
            <div class="card-body p-0 m-0">    
              <div class="tab_title p-2">
                  <h1 class="h5"><i class="fa-solid fa-person-digging"></i> Work Description</h1>
              </div>
              @php
                $str = $data->title;
                $str = trim($str);
                $str = str_replace('xxnxx', ' ', $str);
                $str = str_replace('XXNXXX', ' ', $str);
                $str = str_replace('XXXXN', ' ', $str);
                $str = str_replace('XXNXX', ' ', $str);
                $str = str_replace('XXDFN', ' ', $str);
                $str = str_replace('Nxxx', ' ', $str);
                $str = str_replace('NXXX', ' ', $str);
                $str = str_replace('XXN', ' ', $str);
                $str = str_replace('xxn', ' ', $str);
                $str = str_replace('xx', ' ', $str);
              @endphp
              <div class="disc_text p-3">
                  <p class="mb-2 org_main">{{ $str }}</p>
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
          $urlp = $data->tender_document;
          $url = preg_replace("/^http:/i", "$protocol:", $urlp);
          $arrdate = explode('/',$url);
          
          $urlp2 = $data->document_link1;
          $url2 = preg_replace("/^http:/i", "$protocol:", $urlp2);
          @endphp
          
          @if($arrdate[4] < $documentlink->date)
           @php $url = str_replace('https://resultdoc.nationaltenders.in',$documentlink->url,$url); @endphp
          @endif    
          
          @if($urlp2 != "")  
          @php $arrdate2 = explode('/',$url2); @endphp
            @if($arrdate2[4] < $documentlink->date)
               @php $url2 = str_replace('https://resultdoc.nationaltenders.in',$documentlink->url,$url2); @endphp
            @endif
          @endif 
          
          @php
          $url = str_replace('resultdoc.nationaltenders.in','resultdocument.tenderkhabar.in',$url);

          $url2 = str_replace('resultdoc.nationaltenders.in','resultdocument.tenderkhabar.in',$url2);
          @endphp
          <div class="col-12">
            <div class="card p-0 mb-2">
              <div class="card-body p-0 m-0">    
                <div class="tab_title p-2">
                  <h5><i class="fa-solid fa-money-bill"></i> Document</h5>
                </div>
                <div class="disc_text p-4 text-center">
                  <div class="pdf_file">
                    @if($url != "")
                      <a class="doc_link" href="{{ $url }}" target="_blank"  title="Document-1">
                        <div class="d-flex justify-content-between">
                           <p class="doc_name p-2">Document-1</p>
                           <span class="p-2">{{ pathinfo($url, PATHINFO_FILENAME) }}<i class="fa-sharp fa-solid fa-download"></i></span>
                        </div>
                      </a>
                    @endif
                    @if($urlp2 != "")
                    <a class="doc_link" href="{{ $url2 }}" target="_blank"  title="Document-2">
                      <div class="d-flex justify-content-between">
                         <p class="doc_name p-2">Document-2</p>
                         <span class="p-2">{{ pathinfo($url2, PATHINFO_FILENAME) }} <i class="fa-sharp fa-solid fa-download"></i></span>
                      </div>
                    </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @else
          <div class="col-12">
            <div class="card p-0 mb-2">
              <div class="card-body p-0 m-0">    
                <div class="tab_title p-2">
                  <h5><i class="fa-solid fa-money-bill"></i> Document</h5>
                </div>
                <div class="disc_text p-4 text-center">
                    <div class="UnlockBox">
                      <a href="javascript:void(0)" class="btn btn-primary planpurchase" data="doc" popup-year="32511649" data-bs-toggle="modal" data-bs-target="#inquirymodal">Contact to Admin</a>
                    </div>
                   @include('popup.inquiry',['flag'=>'contract-to-admin'])
                </div>
              </div>
            </div>
          </div>
        @endif
        <div class="col-12">
          <div class="card p-0 mb-2">
            <div class="card-body p-0 m-0">    
              <div class="tab_title p-2">
                <h5><i class="fa-solid fa-money-bill"></i> Cost</h5>
              </div>
              <div class="disc_text p-2">
                <div class="d-flex justify-content-between my-2">
                  <p><strong>Awarded Value</strong></p>
                  <a href="#" class="text-black" title="{{ $data->awarded_value != 0 ? $data->awarded_value : 'Refer Documents' }}">{{ $data->awarded_value != 0 ? $data->awarded_value : 'Refer Documents' }}</a>
                </div>
                <div class="d-flex justify-content-between my-2">
                  <p><strong>Selected Bidder</strong></p>
                  <a href="#" class="text-black" title="{{ $data->selected_bidder != '' ? $data->selected_bidder : 'Refer Documents' }}">{{ $data->selected_bidder != '' ? $data->selected_bidder : 'Refer Documents' }}</a>
                </div>
              </div>          
            </div>
          </div>
        </div>
        @if(count($bidderlist) > 0)
        <div class="col-12">
          <div class="card p-0 mb-2">
            <div class="card-body p-0 m-0">    
              <div class="tab_title p-2">
                <h5><i class="fa-sharp fa-solid fa-map-location"></i> Bidder List</h5>
              </div>
              <div class="disc_text p-2">
                <table class="table boq_items">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Value</th>
                        <th scope="col">Position</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                     @foreach($bidderlist as $bik => $biv)   
                      <tr>
                        <th scope="row">{{ $bik+1 }}</th>
                        <td>{{ $biv->bid_name }}</td>
                        <td>{{ $biv->bid_val }}</td>
                        <td>{{ $biv->bid_rank }}</td>
                        <td>{{ $biv->bid_status }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
              </div>          
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>
</main> 
@endsection