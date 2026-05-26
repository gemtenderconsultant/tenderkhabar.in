@extends('backend.layouts.app')
 @section('content') 
<body class="result-details-body">

    <div class="result-details-bg-layer"></div>

    <main class="result-details-main">
        <!-- Hero Section -->
        <section class="result-details-hero">
            <div class="result-details-container">
                <div class="result-details-hero-top">
                    <div class="result-details-org-title">
                        <i data-lucide="lock" size="18" style="color:var(--navy)"></i>
                        <h1>ORGANIZATION</h1>
                        <div class="result-details-hero-socials">
                            <span>Sign In to unlock</span>
                        </div>
                    </div>
                </div>

                <div class="result-details-tag-row">
                    @if(!empty($keywords))
                    @foreach($keywords as $val)
                        <span class="result-details-category-tag">{{ $val }} </span>
                     @endforeach
                     @endif
                </div>

                <div class="result-details-location">
                    <i data-lucide="map-pin" size="14"></i>{{ $data->state }}, {{$data->city}}
                </div>

                <div class="result-details-brief-box">
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
                    <strong>Brief:</strong> {{ $str }}
                </div>

                <!-- Metrics Row -->
                <div class="result-details-metrics-row">
                    <div class="result-details-metric">
                        <span class="result-details-metric-label">Submission Date</span>
                        <span class="result-details-metric-val">{{ \Carbon\Carbon::parse($data->aoc)->format('D jS F, Y') }}</span>
                    </div>
                    <div class="result-details-metric">
                        <span class="result-details-metric-label">Contract Date</span>
                        <span class="result-details-metric-val">{{ \Carbon\Carbon::parse($data->contract_date)->format('D jS F, Y') }}</span>
                    </div>
                    <div class="result-details-metric">
                        <span class="result-details-metric-label">Contract Value</span>
                        <span class="result-details-metric-val">₹{{ $data->contract_value }}</span>
                    </div>
                    <div class="result-details-metric">
                        <span class="result-details-metric-label">Tender Value</span>
                        <span class="result-details-metric-val result-details-val-gold">₹{{ $data->awarded_value }}</span>
                    </div>
                    <div class="result-details-metric">
                        <span class="result-details-metric-label">Result Stage</span>
                        <span class="result-details-metric-val">{{ $data->result_stage }}</span>
                    </div>
                </div>
            </div>
        </section>
        <div class="result-details-container">
            <div class="result-details-layout-grid">
                <!-- Main Content -->
                <div class="result-details-main-column">
                    <!-- Result Overview Card -->
                    <div class="result-details-card">
                        <div class="result-details-section-header">
                            <span class="result-details-section-title">Result Overview</span>
                            <i data-lucide="chevron-up" size="16"></i>
                        </div>
                        <div class="result-details-overview-grid">
                            <div class="result-details-table-row"><span>Result ID -</span><strong>{{ $data->id }}</strong></div>
                            <div class="result-details-table-row"><span>Organization Tender ID -</span><strong class="result-details-blur">Click Here To View</strong></div>
                            <div class="result-details-table-row"><span>Website -</span><a href="#">Click Here</a></div>
                            <div class="result-details-table-row"><span>Ownership -</span><strong class="result-details-blur">Click Here To View</strong></div>
                            <div class="result-details-table-row"><span>Site Location -</span><strong> {{ $data->state }}, {{$data->city}}</strong></div>
                        </div>
                    </div>
                    <!-- Result Documents Card -->
                    <div class="result-details-card" id="resultdocument">
                        <div class="result-details-section-header">
                            <span class="result-details-section-title">Result Documents</span>
                            <i data-lucide="chevron-up" size="16"></i>
                        </div>
                        <div class="result-details-docs-grid">
                            <div class="result-details-doc-item"><span>NIT</span> <a href="#">Download</a></div>
                            <div class="result-details-doc-item"><span>BOQ</span> <a href="#">Download</a></div>
                            <div class="result-details-doc-item"><span>Technical Evaluation 2</span> <a href="#">Download</a></div>
                            <div class="result-details-doc-item"><span>Financial Opening 3</span> <a href="#">Download</a></div>
                        </div>
                        <a href="#" class="result-details-download-all">Download All Documents</a>
                    </div>
                </div>

                <!-- Sidebar Area -->
                <aside class="result-details-sidebar-column">
                    <!-- Participants Table -->
                    <div class="result-details-sidebar-card">
                        <span class="result-details-sidebar-label">Participants Bidders:</span>
                        <table class="result-details-sidebar-table">
                            <thead>
                                <tr>
                                    <th>COMPANY NAME</th>
                                    <th>RATES</th>
                                    <th>RANK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Laxmi Enterprises</td>
                                    <td class="result-details-blur">75,000.00</td>
                                    <td class="result-details-blur">L1</td>
                                </tr>
                                <tr>
                                    <td>Rail Tech Infraventure</td>
                                    <td class="result-details-blur">82,000.00</td>
                                    <td class="result-details-blur">L2</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="result-details-sidebar-blue-btn">CLICK TO KNOW MAXIMUM WIN</button>
                    </div>

                    <!-- Bidders Report Table -->
                    <div class="result-details-sidebar-card">
                        <span class="result-details-sidebar-label">Bidders Report:</span>
                        <table class="result-details-sidebar-table">
                            <thead>
                                <tr>
                                    <th>Bidder Name</th>
                                    <th>Participated</th>
                                    <th>Awarded</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Laxmi Enterprises</td>
                                    <td class="result-details-blur">120</td>
                                    <td class="result-details-blur">45</td>
                                </tr>
                                <tr>
                                    <td>Rail Tech Infraventure</td>
                                    <td class="result-details-blur">85</td>
                                    <td class="result-details-blur">12</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="result-details-sidebar-blue-btn">CLICK TO KNOW MAXIMUM WIN</button>
                    </div>
                    <button class="result-details-view-prev-btn">VIEW PREVIOUS RESULTS</button>
                </aside>
            </div>
        </div>
    </main>
@endsection
