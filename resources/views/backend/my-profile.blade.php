@extends('backend.layouts.app')
@section('stylesheet')
@endsection
@section('content')
@php 
  $tender = Session::get('loginuser.tender.filter'); 
  $tenderresult = Session::get('loginuser.tenderresult.filter'); 
  //dd($tender);
@endphp
<section class="py-5 bg-light mt-5">
  <div class="container pt-5">
    <div class="row g-4">
      <!-- User Profile Card -->
      <div class="col-lg-4">
        <div class="card shadow-sm border-0 text-center p-4">
          <i class="fa fa-user-circle display-1"></i>
          <h4 class="mb-1">{{ $user->name }}</h4>
          <p class="text-muted">{{ $user->company_name }}</p>
          <div class="d-flex justify-content-center gap-2 mt-2">
            <span class="badge bg-{{ $user->status == 'Paid' ? 'success' : 'danger' }}">{{ $user->status }}</span>
            <span class="badge bg-{{ $user->is_tender ? 'success' : 'danger' }}">Tender</span>
            <span class="badge bg-{{ $user->is_result ? 'success' : 'danger' }}">Result</span>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-secondary text-white">
            <i class="bi bi-person-lines-fill me-2"></i>User Details
          </div>
          <div class="card-body">
            @php
              $fields = [
                'Full Name' => $user->name,
                'Email' => $user->email,
                'Mobile' => '+91 ' . $user->mobile,
                'Company' => $user->company_name,
                'Created At' => \Carbon\Carbon::parse($user->created_at)->format('d-m-Y'),
              ];
            @endphp
            @foreach($fields as $label => $value)
              <div class="row mb-3">
                <div class="col-lg-4 col-md-4 col-4 fw-bold">{{ $label }}:</div>
                <div class="col-lg-8 col-md-8 col-8 text-muted">{{ $value }}</div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div> 
    <div class="row mt-3">
      <div class="col-lg-12">
         <ul class="nav nav-tabs" id="myTab" role="tablist">
          @if($user->is_tender == 1 && isset($tender))
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tender-tab" data-bs-toggle="tab" data-bs-target="#tender" type="button" role="tab">Tender</button>
            </li>
          @endif
          @if($user->is_result == 1 && isset($tenderresult))
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="tenderresult-tab" data-bs-toggle="tab" data-bs-target="#tenderresult" type="button" role="tab">Result</button>
            </li>
          @endif
          </ul>
          <!-- Tab panes -->
          <div class="tab-content mt-3">
            @if($user->is_tender == 1 && isset($tender))
            <div class="tab-pane fade show active" id="tender" role="tabpanel">
              <div class="card shadow-sm border-0 mt-4">
                  <div class="card-header bg-success text-white">
                    <i class="bi bi-filter-circle me-2"></i>Tender Filter Info
                  </div>
                  <div class="card-body">
                    @if(isset($tender[0]['productidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Industry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tender[0]['productidname']; !!}
                      </div>
                    </div>
                    @endif
                    @if(isset($tender[0]['eproductidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Industry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tender[0]['eproductidname']; !!}
                      </div>
                    </div>
                    @endif
                    @if(isset($tender[0]['categoryidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">SubIndustry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['categoryidname']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    @endif
                    @if(isset($tender[0]['ecategoryidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding SubIndustry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['ecategoryidname']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Category :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['subcategoryidname']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Category :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['esubcategoryidname']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Exact Keyword :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tender[0]['is_exact_keyword'] == 1)
                        <span class="badge bg-success">Yes</span>
                        @else
                        <span class="badge bg-danger">No</span>
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Keyword :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['keyword']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Keyword :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['excludingkeyword']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Department :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['Agency_name']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Department :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tender[0]['eAgency_name']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">State :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tender[0]['state_name'] == "")
                        {!! ($tender[0]['state_name'] == "") ? "All" : $tender[0]['state_name'] !!}
                        @else
                          @foreach(explode(',',$tender[0]['state_name']) as $key => $value)
                            <span class="badge bg-info">{!! $value !!}</span>
                          @endforeach
                        @endif
                        
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">City :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tender[0]['city'] == "")
                        {!! ($tender[0]['city'] == "") ? "All" : $tender[0]['state_name'] !!}
                        @else
                          @foreach(explode(',',$tender[0]['city']) as $key => $value)
                            <span class="badge bg-info">{!! $value !!}</span>
                          @endforeach
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Min Amount :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tender[0]['Min_Amount']; !!}
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Max Amount :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tender[0]['Max_Amount']; !!}
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Not Estimated :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tender[0]['no_estimates'] == 1)
                        <span class="badge bg-success">Yes</span>
                        @else
                        <span class="badge bg-danger">No</span>
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">From Date :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!!  \Carbon\Carbon::parse($tender[0]['fromdate'])->format('d M Y'); !!}
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">To Date :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!!  \Carbon\Carbon::parse($tender[0]['todate'])->format('d M Y'); !!}
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            @endif 
            @if($user->is_result == 1 && isset($tenderresult))
            <div class="tab-pane fade" id="tenderresult" role="tabpanel">
              <div class="card shadow-sm border-0 mt-4">
                  <div class="card-header bg-success text-white">
                    <i class="bi bi-filter-circle me-2"></i>Tender Result Filter Info
                  </div>
                  <div class="card-body">
                    @if(isset($tenderresult[0]['productidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Industry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tenderresult[0]['productidname']; !!}
                      </div>
                    </div>
                    @endif
                    @if(isset($tenderresult[0]['eproductidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Industry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tenderresult[0]['eproductidname']; !!}
                      </div>
                    </div>
                    @endif
                    @if(isset($tenderresult[0]['categoryidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">SubIndustry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['categoryidname']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    @endif
                    @if(isset($tenderresult[0]['ecategoryidname']))
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding SubIndustry :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['ecategoryidname']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    @endif
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Category :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['subcategoryidname']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Category :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['esubcategoryidname']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Exact Keyword :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tenderresult[0]['is_exact_keyword'] == 1)
                        <span class="badge bg-success">Yes</span>
                        @else
                        <span class="badge bg-danger">No</span>
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Keyword :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['keyword']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Keyword :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['excludingkeyword']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Department :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['Agency_name']) as $key => $value)
                          <span class="badge bg-info">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Excluding Department :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @foreach(explode(',',$tenderresult[0]['eAgency_name']) as $key => $value)
                          <span class="badge bg-warning">{!! $value !!}</span>
                        @endforeach
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">State :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tenderresult[0]['state_name'] == "")
                        {!! ($tenderresult[0]['state_name'] == "") ? "All" : $tenderresult[0]['state_name'] !!}
                        @else
                          @foreach(explode(',',$tenderresult[0]['state_name']) as $key => $value)
                            <span class="badge bg-info">{!! $value !!}</span>
                          @endforeach
                        @endif
                        
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">City :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tenderresult[0]['city'] == "")
                        {!! ($tenderresult[0]['city'] == "") ? "All" : $tenderresult[0]['state_name'] !!}
                        @else
                          @foreach(explode(',',$tenderresult[0]['city']) as $key => $value)
                            <span class="badge bg-info">{!! $value !!}</span>
                          @endforeach
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Min Amount :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tenderresult[0]['Min_Amount']; !!}
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Max Amount :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!! $tenderresult[0]['Max_Amount']; !!}
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">Not Estimated :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        @if($tenderresult[0]['no_estimates'] == 1)
                        <span class="badge bg-success">Yes</span>
                        @else
                        <span class="badge bg-danger">No</span>
                        @endif
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">From Date :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!!  \Carbon\Carbon::parse($tenderresult[0]['fromdate'])->format('d M Y'); !!}
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-lg-4 col-md-4 col-4 fw-bold">To Date :</div>
                      <div class="col-lg-8 col-md-8 col-8 text-muted">
                        {!!  \Carbon\Carbon::parse($tenderresult[0]['todate'])->format('d M Y'); !!}
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            @endif
          </div>
      </div>
    </div>
  </div>
</section>
@endsection