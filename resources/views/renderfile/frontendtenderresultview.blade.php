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
            {{-- <button class="search-result-btn-mini"><i data-lucide="eye" size="14"></i></button> --}}
        </div>
    </div>
  @endforeach
@endif