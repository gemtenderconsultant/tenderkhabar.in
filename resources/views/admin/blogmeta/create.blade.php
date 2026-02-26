@extends('admin.layouts.app') 
@section('stylesheet')
<!-- <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css')}}"> -->
<style type="text/css">
  .hide{
    display: none;
  }
  .show{
    display: blog;
  }
</style>
@endsection 
@section('content') 
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{$blog->name}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="{{route('blog-list')}}">Blogs</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{route('blog-create')}}">create</a>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Create BlogMeta</h3>
          </div>
          <form name="Blogmeta-form" method="post" action="{{ route('blogmeta-store') }}">
            <div class="card-body">
              <div class="form-group">
                 @csrf
                 <input type="hidden" name="blogid" value="{{$blog->id}}">
                <label for="blog-name">Title</label>
                <input type="text" class="form-control {{ ($errors->has('title')) ? 'is-invalid' : '' }}" name="title" placeholder="Enter Title" value="{{ old('title') ? old('title') : (($blogmeta) ? $blogmeta->title : '') }}">
                @if ($errors->has('title'))
                    <span class="error invalid-feedback">{{ $errors->first('title') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="keywords">keywords</label>
                <input type="text" id="keywords" class="form-control {{ ($errors->has('keywords')) ? 'is-invalid' : '' }}" name="keywords" placeholder="Enter keywords" value="{{ old('keywords') ? old('keywords') : (($blogmeta) ? $blogmeta->keywords : '') }}">
                @if($errors->has('keywords'))
                    <span class="error invalid-feedback">{{ $errors->first('keywords') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="keywords">Category</label>
                <input type="text" class="form-control {{ ($errors->has('category')) ? 'is-invalid' : '' }}" name="category" placeholder="Enter category" value="{{ old('category') ? old('category') : (($blogmeta) ? $blogmeta->category : '') }}">
                @if ($errors->has('category'))
                    <span class="error invalid-feedback">{{ $errors->first('category') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control {{ ($errors->has('description')) ? 'is-invalid' : '' }}" id="description" name="description" row="5" placeholder="Enter Description">{{ old('description') ? old('description') : (($blogmeta) ? $blogmeta->description : '')}}</textarea>
                @if($errors->has('description'))
                    <span class="error invalid-feedback">
                    {{ $errors->first('description') }}</span>
                @endif
              </div>
             </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">Save</button>
              <a href="{{route('blog-list')}}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section> 
@endsection 
@section('scripts') 
<!-- <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script> -->
<script type="text/javascript">
  $('body').on('change','#blog-type',function(){
      if($(this).val() == 0){
        $('.txt_image').show();
        $('.txt_video').hide();
      }else if($(this).val() == 1){
        $('.txt_video').show();
        $('.txt_image').hide();
      }
  });

  // $(function () {
  //   // Summernote
  //   $('#description').summernote()
  //   // CodeMirror
  //   CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
  //     mode: "htmlmixed",
  //     theme: "monokai"
  //   });
  // })
</script>
@endsection