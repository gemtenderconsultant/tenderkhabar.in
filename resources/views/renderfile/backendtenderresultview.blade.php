@if(!empty($resultdata))
  @foreach($resultdata as $key => $val)
    @php 
      $str = (strlen($val->title) > 280) ? substr($val->title, 0, 280).'...' : $val->title;
      $userkeyword = str_replace(',', '', $userkeyword);
      $userkeyword = trim($userkeyword);
      $res = explode(' ',$userkeyword);
      $sid = $val->id;
      $smalldesc = substr($val->title, 0, 50);
      $smalldesc = $smalldesc . " " . strtolower($val->city);

      $smalldesc = preg_replace('/(\W+)/', ' ', $smalldesc);
      $smalldesc = preg_replace('/[^a-z A-Z]/', '', $smalldesc);
      $smalldesc = trim($smalldesc);
      $smalldesc = str_replace('xxnxx', ' ', $smalldesc);
      $smalldesc = str_replace('XXNXXX', ' ', $smalldesc);
      $smalldesc = str_replace('XXXXN', ' ', $smalldesc);
      $smalldesc = str_replace('XXNXX', ' ', $smalldesc);
      $smalldesc = str_replace('XXDFN', ' ', $smalldesc);
      $smalldesc = str_replace('Nxxx', ' ', $smalldesc);
      $smalldesc = str_replace('NXXX', ' ', $smalldesc);
      $smalldesc = str_replace('XXN', ' ', $smalldesc);
      $smalldesc = str_replace('xxn', ' ', $smalldesc);
      $smalldesc = str_replace('xx', ' ', $smalldesc);
      $smalldesc = strtolower($smalldesc);
      $smalldesc = trim($smalldesc);
      $linkdesc = $smalldesc." tender-result ".$sid;
      $linktitle = $smalldesc." tender result ";
      $linktitle = ucwords($linktitle);
      $linkdesc = urlencode($linkdesc);
      $linkdesc = str_replace('+', '-', $linkdesc);
      $tencodeid = base64_encode($val->id);
      @endphp 
      
      @if (!empty($res))

          @foreach($res as $key => $keyval) 
              @php $mkeyword = trim($keyval); @endphp 
              @if (!empty($mkeyword))
                   @php $str = @preg_replace("/($mkeyword)/i", "<span class='khighlight'>$1</span>", $str); @endphp 
              @endif
          @endforeach
      @endif
      @if($str == "")
          @php $str = (strlen($val->title) > 280) ? substr($val->title, 0, 280).'...' : $val->title; @endphp 
      @endif
      <div class="col-12 tender_list">
        <div class="card mb-2">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="mb-2 org_main">
                <span class="pe-2">
                  <i class="fa  fa-building me-2"></i>{{ $val->Organisation }}</span>
                <span class="ps-2 date_status">
                  @if($val->aoc >= date('Y-m-d'))
                      @if($val->aoc == date('Y-m-d'))
                          <span>Ending Today</span>
                      @else
                          @php 
                          $fdate = date('Y-m-d');
                          $toDate = \Carbon\Carbon::parse($val->dt);
                          $fromDate = \Carbon\Carbon::parse($fdate);
                          $days = $toDate->diffInDays($fromDate);
                          @endphp 
                          <span>{{ $days }} days left</span>
                      @endif
                  @endif
                </span>
              </p>
              <p class="tenderid">TRID {{ $val->id }}</p>
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
                    @php $str = (strlen($val->title) > 280) ? substr($val->title, 0, 280).'...' : $val->title; @endphp 
                @endif
              <p class="desc">{!! $str !!}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <p class="mb-2 org_main">
                  <span class="pe-2 location"><i class="fa fa-map-marker"></i> {{ $val->city }}, {{ $val->state_name }}, India</span>
                  <span class="pe-2 ps-2 border-left"><i class="fa fa-calendar"></i> AOC Date: <span class="text-danger">{{ \Carbon\Carbon::parse($val->aoc)->format('D jS F, Y') }}</span></span>
                  <span class="ps-2 pe-2 date_status"><i class="fa fa-inr"></i> {{ $val->ti_amount }}</span>
              </p>
              <p class="view_link">
                <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('backendtenderresultview', ['id' => $tencodeid]) }}" title="backendtenderresultview" target="_blank"><i class="fa-solid fa-eye"></i></a>
                
                <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('backendtenderresultview', ['id' => $tencodeid]) }}" title="Download Document" target="_blank"><i class="fa-solid fa-download"></i></a>
                <a href="{{ route('backendtenderresultview',['id' => $tencodeid]) }}" target="_blank" class="btn btn-sm btn-default btn-hover-bg me-1" title="backendtenderresultview"><i class="fa-solid fa-envelope"></i></a>
              </p>
            </div>
            <a class="stretched-link" href="{{ route('backendtenderresultview',['id' => $tencodeid]) }}" target="_blank"></a>
          </div>
        </div>
      </div>
  @endforeach
@endif