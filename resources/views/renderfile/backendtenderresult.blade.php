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

      <div class="tender-listing-tender-card">
        <div class="tender-listing-card-info">
            <div class="tender-listing-card-meta"><span>{{ $val->Organisation }}</span> </div>
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
            <h3 class="tender-listing-card-title">{!! $str !!}</h3>
            <div class="tender-listing-card-details">
                <span><i class="fa-solid fa-location-dot" size="12"></i> <strong>{{ $val->city }}, {{ $val->state_name }}, India</strong></span>
                <span><i class="fa-solid fa-calendar" size="12"></i> AOC Date: <strong>{{ \Carbon\Carbon::parse($val->aoc)->format('D jS F, Y') }}</strong></span>
                <span><i class="fa-solid fa-indian-rupee-sign" size="12"></i> <strong> {{ $val->ti_amount }}</strong></span>
            </div>
        </div>
        <div class="tender-listing-card-actions">
            <div class="tender-listing-btn-group">
                <div class="tender-listing-btn-icon"> <a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('backendtenderresultview', ['id' => $tencodeid]) }}" title="backendtenderresultview" target="_blank"><i class="fa-solid fa-eye" size="16"></i></a></div>
                <div class="tender-listing-btn-icon"><a class="btn btn-sm btn-default btn-hover-bg me-1" href="{{ route('backendtenderresultview', ['id' => $tencodeid]) }}" title="Download Document" target="_blank"><i class="fa-solid fa-download" size="16"></i></a></div>
                <div class="tender-listing-btn-icon"><a href="{{ route('backendtenderresultview',['id' => $tencodeid]) }}" target="_blank" class="btn btn-sm btn-default btn-hover-bg me-1" title="backendtenderresultview"><i class="fa-solid fa-envelope" size="16"></i></a></div>
            </div>
        </div>
          <a class="stretched-link" href="{{ route('backendtenderresultview',['id' => $tencodeid]) }}" target="_blank"></a>
      </div>

  @endforeach
@endif