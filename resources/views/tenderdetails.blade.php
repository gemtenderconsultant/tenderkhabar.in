@extends('layouts.app')
 @section('content')   

    <div class="tender-details-bg-layer"></div>
    <main class="tender-details-main">
        <!-- Hero Section -->
        <section class="tender-details-hero">
            <div class="tender-details-container">
                <div class="tender-details-hero-flex">
                    <div class="tender-details-hero-left">
                        <div class="tender-details-org-header">
                            <i data-lucide="lock" size="18" class="tender-details-icon-navy"></i>
                            <h1 class="tender-details-org-name">ORGANIZATION</h1>
                            <div class="tender-details-utility-bar">
                                <span>Sign In to unlock</span> 
                            </div>
                        </div>
                        <div class="tender-details-tag-row">
                            <span class="tender-details-tag">Building</span>
                            <span class="tender-details-tag">Electrical Work</span>
                            <span class="tender-details-tag">Platform</span>
                            <span class="tender-details-tag">Dismantling Work</span>
                            <span class="tender-details-tag">Earth Work</span>
                            <span class="tender-details-tag">More...</span>
                        </div>
                        <div class="tender-details-location-strip">
                            <i data-lucide="map-pin" size="14"></i> {{ $data->city ?? 'Refer Documents' }}, {{ $data->state_name ?? '' }}
                        </div>
                        <div class="tender-details-text-section">
                            <p><strong>Brief :</strong> {{ $data->Work }} </p>
                            <p><strong>Description :</strong> Refer To Documents.</p>
                        </div>
                    </div>

                    <!-- Days Left Badge -->
                    <div class="tender-details-days-badge"> 
                        @if($data->submitdate >= date('Y-m-d'))
                                @if($data->submitdate == date('Y-m-d'))
                                    <span class="tender-details-days-text">Ending Today</span>
                                @else
                                    @php 
                                    $fdate = date('Y-m-d');
                                    $toDate = \Carbon\Carbon::parse($data->submitdate);
                                    $fromDate = \Carbon\Carbon::parse($fdate);
                                    $days = $fromDate->diffInDays($toDate);
                                    @endphp 
                                    <span class="tender-details-days-number">{{ $days }} </span>
                                    <span class="tender-details-days-text">Days Left</span>
                                @endif
                            @else
                                <span class="tender-details-days-text">Closed</span>
                            @endif
                    </div>
                </div>
                <!-- Financial Metrics Bar -->
                <div class="tender-details-metrics-row">
                    <div class="tender-details-metric-item">
                        <span class="tender-details-metric-label">Submission Date</span>
                        <span class="tender-details-metric-val">{{ \Carbon\Carbon::parse($data->submitdate)->format('jS M, Y') }}</span>
                    </div>
                    <div class="tender-details-metric-item">
                        <span class="tender-details-metric-label">Opening Date</span>
                        <span class="tender-details-metric-val">{{ \Carbon\Carbon::parse($data->opendate)->format('jS M, Y') }}</span>
                    </div>
                    <div class="tender-details-metric-item">
                        <span class="tender-details-metric-label">Tender Estimated Cost</span>
                        <span class="tender-details-metric-val tender-details-font-bold">{{ ($data->tenderamount != 0) ? $data->tenderamount : 'Refer Documents' }}</span>
                    </div>
                    <div class="tender-details-metric-item">
                        <span class="tender-details-metric-label">EMD</span>
                        <span class="tender-details-metric-val tender-details-font-bold">{{ ($data->earnestamount != 0) ? $data->earnestamount : 'Refer Documents' }}</span>
                    </div>
                    <div class="tender-details-metric-item">
                        <span class="tender-details-metric-label">Tender Document Fees</span>
                        <span class="tender-details-metric-val">{{ ($data->doccost != 0) ? $data->doccost : 'Refer Documents' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="tender-details-container">
            <!-- Tender Overview Card -->
            <div class="tender-details-card-flat">
                <div class="tender-details-card-header">
                    <span>Tender Overview</span>
                    <i data-lucide="chevron-up" size="16"></i>
                </div>
                <div class="tender-details-overview-grid">
                    <div class="tender-details-grid-item"><span>TK ID -</span><strong>{{ $data->ourrefno }}</strong></div>
                    <div class="tender-details-grid-item"><span>Organization Tender ID -</span><strong class="tender-details-blur">Click Here To View</strong></div>
                    <div class="tender-details-grid-item"><span>Quantity -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Website -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Msme Exemption -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Startup Exemption -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Site Location -</span><strong>{{ $data->city ?? 'Refer Documents' }}, {{ $data->state_name ?? '' }}</strong></div>
                    <div class="tender-details-grid-item"><span>Contact Person -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Contact Address -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Contact Number -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Contact Email -</span><a href="#">Click Here</a></div>
                    <div class="tender-details-grid-item"><span>Surety Bond -</span><a href="#">Click Here</a></div>
                </div>
            </div>
            <!-- Tender Documents Card -->
            <div class="position-relative">
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
                @php $url = str_replace('document.nationaltenders.in','document.tenderkhabar.com',$url); @endphp
                
                <div class="tender-details-card-flat">
                    <div class="tender-details-card-header">
                        <span>Tender Documents</span>
                        <i data-lucide="chevron-up" size="16"></i>
                    </div>
                    <div class="tender-details-docs-grid">
                        <div class="tender-details-doc-row"><span>NIT</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Corrigendum Document-1</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Corrigendum Document-2</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Tender Document-1 {{-- pathinfo($url, PATHINFO_FILENAME) --}}</span><a href="{{ $url }}">Download</a></div>
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
                                    
                        <div class="tender-details-doc-row"><span>Tender Document-2{{$k + 2}} {{-- pathinfo($urlo, PATHINFO_FILENAME) --}}</span><a href="{{ $urlo }}">Download</a></div>
                        @endforeach
                            @endif
                    </div>
                    <div class="tender-details-footer-action">
                        <a href="#" class="tender-details-link-bold">Download All Documents</a>
                    </div>
                </div>
            
            @else
                <div class="tender-details-card-flat blur-section">
                    <div class="tender-details-card-header">
                        <span>Tender Documents</span>
                        <i data-lucide="chevron-up" size="16"></i>
                    </div>
                    <div class="tender-details-docs-grid">
                        <div class="tender-details-doc-row"><span>NIT</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Corrigendum Document-1</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Corrigendum Document-2</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Tender Document-1</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Tender Document-2</span><a href="#">Download</a></div>
                        <div class="tender-details-doc-row"><span>Tender Document-3</span><a href="#">Download</a></div>
                    </div>
                    <div class="tender-details-footer-action">
                        <a href="#" class="tender-details-link-bold">Download All Documents</a>
                    </div>
                </div>
                {{-- OVERLAY --}}
                <div class="document-overlay">
                    <h4>Unlock Tender Documents</h4>
                    <a href="javascript:void(0)" onclick="singelpayNow('Single Tender', 149, {{ $data->ourrefno }})"  class="btn btn-primary btn-block planpurchase buy-now-btn" data="doc" popup-year="32511649">
                        Buy Now
                    </a>
                </div>
          @endif
          </div>
        </div>
        <form id="singlepayuRedirect" method="POST" action="{{ route('singlepayment.singlepayu') }}" style="display:none;">
        @csrf
        <input type="hidden" name="plan">
        <input type="hidden" name="amount">
        <input type="hidden" name="tenderid">
    </form>
    </main>
@endsection
@section('scripts')
<script>
function singelpayNow(plan, amount, tenderid) {
    const form = document.getElementById('singlepayuRedirect');
    form.plan.value = plan;
    form.amount.value = amount;
    form.tenderid.value = tenderid;
    form.submit();
}
</script>
    <script>
        lucide.createIcons();
    </script>
@endsection