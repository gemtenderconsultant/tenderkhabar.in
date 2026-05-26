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
        <div class="tender-listing-tender-card">
            <div class="tender-listing-card-info">
                <div class="tender-listing-card-meta"><span>{{ $val->agencyname }}</span> • TKID {{ $val->ourrefno }}</div>
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
                <h3 class="tender-listing-card-title">{!! $str !!}</h3>
                <div class="tender-listing-card-details">
                    <span><i class="fa-solid fa-location-dot" size="12"></i> <strong>{{ $val->city }}, {{ $val->name }}, India</strong></span>
                    <span><i class="fa-solid fa-calendar" size="12"></i> End Date: <strong>{{ $val->show_ti_submit_date }}</strong></span>
                    <span><i class="fa-solid fa-indian-rupee-sign" size="12"></i> <strong> {{$val->ti_amount}}</strong></span>
                </div>
            </div>
            <div class="tender-listing-card-actions">
                 @if($val->submitdate >= date('Y-m-d'))
                  @if($val->submitdate == date('Y-m-d'))
                      <span class="tender-listing-days-left">Ending Today</span>
                  @else
                      @php 
                      $fdate = date('Y-m-d');
                      $toDate = \Carbon\Carbon::parse($val->submitdate);
                      $fromDate = \Carbon\Carbon::parse($fdate);
                      $days = $fromDate->diffInDays($toDate);
                      @endphp 
                <span class="tender-listing-days-left">{{ $days }} days left</span>
                 @endif
                @endif
                <div class="tender-listing-btn-group">
                    <div class="tender-listing-btn-icon"><a href="{{ route('backendtenderview',['id' => $tencodeid]) }}" title="View Tender" target="_blank"><i class="fa-solid fa-eye" size="16"></i></a></div>
                    <div class="tender-listing-btn-icon"><a href="{{ route('backendtenderview',['id' => $tencodeid]) }}" title="Download Document" target="_blank"><i class="fa-solid fa-download" size="16"></i></a></div>
                </div>
            </div>
            <a class="stretched-link" href="{{ route('backendtenderview',['id' => $tencodeid]) }}" target="_blank"></a>
        </div>
  @endforeach
@endif