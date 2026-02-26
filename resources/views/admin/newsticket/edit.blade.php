@extends('admin.layouts.app')
@section('stylesheet')
  
@endsection
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>News Ticket</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('newsticket-list')}}">News Tickets</a></li>
          <li class="breadcrumb-item"><a href="{{route('newsticket-edit',$newsticket->id)}}">Edit</a></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit</h3>
          </div>
          <!-- /.card-header -->
          <form name="newsticket-form" method="post" action="{{ route('newsticket-update') }}" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                 @csrf
                <input type="hidden" name="id" value="{{$newsticket->id}}">
                <label for="subject">Subject</label>
                <input type="text" class="form-control {{ ($errors->has('subject')) ? 'is-invalid' : '' }}" id="subject" name="subject" placeholder="Enter Subject" value="{{ $newsticket->subject }}">
                @if ($errors->has('subject'))
                    <span class="error invalid-feedback">{{ $errors->first('subject') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="source">Source</label>
                <input type="text" class="form-control {{ ($errors->has('source')) ? 'is-invalid' : '' }}"  name="source" placeholder="Enter Source" value="{{ $newsticket->source }}">
                @if ($errors->has('source'))
                    <span class="error invalid-feedback">{{ $errors->first('source') }}</span>
                @endif
              </div>
              <div class="form-group">
                    <label class="control-label" for="image">Image</label>
                    <input type="hidden" id="pimage" name="pimage" value="{{ $newsticket->image }}" >
                    <input type="file" id="image" class=" {{ ($errors->has('image')) ? 'is-invalid' : '' }}" name="image" value="{{ $newsticket->image }}">
                    @if ($errors->has('image'))
                      <span class="error invalid-feedback">{{ $errors->first('image') }}</span>
                    @endif
              </div>
              @if($newsticket->image != "")   
              <img src="{{ asset('frontend/'.$newsticket->image)}}" width="250" height="250" />  
              @endif
              <div class="form-group">
                <label for="message">Message</label>
                <textarea style="height: 150px;" class="form-control {{ ($errors->has('message')) ? 'is-invalid' : '' }}"  id="message" name="message" placeholder="Enter Message">{{ $newsticket->message }}</textarea>
                @if ($errors->has('message'))
                    <span class="error invalid-feedback">{{ $errors->first('message') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="link">Link</label>
                <input type="text" class="form-control {{ ($errors->has('link')) ? 'is-invalid' : '' }}"  name="link" placeholder="Enter link" value="{{ $newsticket->link }}" />
                @if ($errors->has('link'))
                    <span class="error invalid-feedback">{{ $errors->first('link') }}</span>
                @endif
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">Update</button>
              <a href="{{route('newsticket-list')}}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section> 
@endsection
@section('scripts')
<script type="text/javascript">
</script>
@endsection