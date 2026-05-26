@if(!empty($resultdata))
    
      @foreach($resultdata as $key => $val)
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