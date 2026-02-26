@if(!empty($resultdata))
  @foreach($resultdata as $key => $val)
    @php 
      $str = (strlen($val->Work) > 280) ? substr($val->Work, 0, 280).'...' : $val->Work;
      $res = array();
      $res = explode(',',$userkeyword);
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
      $tencodeid = base64_encode($val->ourrefno);
    @endphp 

    <div class="col-12">
      <div class="card mb-2 shadow">
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
                 <span class="ps-2 pe-2 date_status"><i class="fa fa-inr"></i> {{$val->ti_amount}}</span>
              </p>
              <p class="view_link">
                 <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('backendtenderview',['id' => $tencodeid]) }}" title="View Tender" target="_blank"><i class="fa fa-eye"></i></a>
                 <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('backendtenderview',['id' => $tencodeid]) }}" title="Download Document" target="_blank"><i class="fa fa-download"></i></a>
              </p>
           </div>
           <a class="stretched-link" href="{{ route('backendtenderview',['id' => $tencodeid]) }}" target="_blank"></a>
        </div>
      </div>
    </div>
  @endforeach
@endif