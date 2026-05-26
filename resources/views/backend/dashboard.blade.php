@extends('backend.layouts.app')
@section('content')
    <main class="login-dashboard-main">
        <h1 class="login-dashboard-page-title">Dashboard</h1>

        <div class="login-dashboard-stats-grid">
            <div class="login-dashboard-stat-card">
                <div class="login-dashboard-card-top">
                    <span class="login-dashboard-stat-label">Live: Bid/Tender</span>
                    <i data-lucide="bell" class="login-dashboard-stat-icon" size="28"></i>
                </div>
                <div class="login-dashboard-stat-value">{{ $totallive }}</div>
            </div>

            <div class="login-dashboard-stat-card">
                <div class="login-dashboard-card-top">
                    <span class="login-dashboard-stat-label">Fresh: Bid/Tender</span>
                    <i data-lucide="bell" class="login-dashboard-stat-icon" size="28"></i>
                </div>
                <div class="login-dashboard-stat-value">{{ $totalfresh }}</div>
            </div>

            <div class="login-dashboard-stat-card">
                <div class="login-dashboard-card-top">
                    <span class="login-dashboard-stat-label">Service Expire Date</span>
                    <i data-lucide="calendar-days" class="login-dashboard-stat-icon" size="28"></i>
                </div>
                <div class="login-dashboard-stat-value">{{ \Carbon\Carbon::parse($tendertodate)->format('d M, Y') }}</div>
            </div>
        </div>

        
    </main>
@endsection
<!-- @section('scripts')
    
@endsection -->