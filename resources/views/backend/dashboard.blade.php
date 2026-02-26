@extends('backend.layouts.app')
@section('content')
<main id="main">
  <section class="pricing dashboard">
    <!-- Start Content-->
      <div class="container mt-5">
        <div class="col-12">
          <div class="page-title-box">                                    
            <h2 class="page-title">Dashboard</h2>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-4 col-sm-6 col-md-6 col-12 mb-3">
            <div class="card border-primary">
              <div class="card-body">
                <div class="float-end">
                    <i class="fa fa-bell fa-3x"></i>
                </div>
                <h5 class="mt-0" title="Number of Customers">Live: Bid/Tender</h5>
                <h4 class="mt-3 mb-3">{{ $totallive }}</h4>
              </div> <!-- end card-body-->
              <a href="{{ route('tender-listing')}}" class="stretched-link"></a>
            </div> <!-- end card-->
          </div> <!-- end col-->
          <div class="col-lg-4 col-sm-6 col-md-6 col-12 mb-3">
            <div class="card border-primary">
              <div class="card-body">
                <div class="float-end">
                    <i class="fa fa-bell fa-3x"></i>
                </div>
                <h5 class="mt-0" title="Number of Customers">Fresh: Bid/Tender</h5>
                <h4 class="mt-3 mb-3">{{ $totalfresh }}</h4>
              </div> <!-- end card-body-->
              <a href="{{ route('tender-listing')}}?data=fresh" class="stretched-link"></a>
            </div> <!-- end card-->
          </div> <!-- end col-->
          <div class="col-lg-4 col-sm-12 col-md-12 col-12 mb-3">
            <div class="card border-primary">
              <div class="card-body">
                <div class="float-end">
                    <i class="fa fa-calendar fa-3x"></i>
                </div>
                <h5 class="mt-0" title="Number of Customers">Service Expire Date</h5>
                <h4 class="mt-3 mb-3">{{ \Carbon\Carbon::parse($tendertodate)->format('d M, Y') }}</h4>
              </div> <!-- end card-body-->
              <a href="{{ route('tender-listing')}}?data=fresh" class="stretched-link"></a>
            </div> <!-- end card-->
          </div> <!-- end col-->
        </div>
      </div>
    </div>
  </section>
</main>
<!-- End #main -->
@endsection