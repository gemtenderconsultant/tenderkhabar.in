@extends('backend.layouts.app')
@section('content')
    <div class="profile-wrapper">
        <aside class="profile-side-card">
            <div class="profile-img-hex">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=fff&color=0D1B40&size=200" class="profile-img-inner" alt="User">
            </div>
            <h1 class="profile-side-name">{{ $user->name }}</h1>
            <span class="profile-side-id">TENDERKHABARID-{{ $user->id }}</span>
            
            <div class="profile-status-pill">
                <div class="profile-pulse"></div>
                Premium Intelligence Active
            </div>
        </aside>
        <main class="profile-main-grid">
            
            <div class="profile-bento-card">
                <div class="profile-label-row"><i data-lucide="mail" size="14"></i><span>Verified Email</span></div>
                <span class="profile-data-val">{{ $user->email }}</span>
                <span class="profile-data-sub">Primary communication channel</span>
            </div>

            <div class="profile-bento-card">
                <div class="profile-label-row"><i data-lucide="phone" size="14"></i><span>Secure Contact</span></div>
                <span class="profile-data-val">+91 {{ $user->mobile }}</span>
                <span class="profile-data-sub">Two-factor enabled mobile</span>
            </div>

            <div class="profile-bento-card full-width">
                <div class="profile-label-row"><i data-lucide="building-2" size="14"></i><span>Organization Identity</span></div>
                <span class="profile-data-val">{{ $user->company_name }}</span>
            </div>
            <div class="profile-bento-card">
                <div class="profile-label-row"><i data-lucide="calendar" size="14"></i><span>Member Since</span></div>
                <span class="profile-data-val">{{ \Carbon\Carbon::parse($profile[0]['fromdate'])->format('Y') }}</span>
            </div>

            <div class="profile-bento-card">
                <div class="profile-label-row"><i data-lucide="shield-check" size="14"></i><span>Subscription</span></div>
                <span class="profile-data-val" style="color: var(--gold);">
                {{ \Carbon\Carbon::parse($profile[0]['fromdate'])
                    ->diffInYears(\Carbon\Carbon::parse($profile[0]['todate'])) }} 
                Year Subscription
                </span>
            </div>
        </main>
        <div class="profile-bento-card full-width">
            <div class="profile-label-row"><i data-lucide="fingerprint" size="14"></i><span>Intelligence Keywords</span></div>
                <div class="profile-keyword-flex">
                    @if(!empty($profile[0]['keyword']))
                        @php
                            $keywords = explode(',', $profile[0]['keyword']);
                        @endphp
                        @foreach($keywords as $keyword)
                            <div class="profile-tag">
                                <i data-lucide="hash" size="12"></i> {{ trim($keyword) }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
