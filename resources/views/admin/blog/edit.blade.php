@extends('admin.layouts.app') 
@section('stylesheet')
<link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
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
        <h1>Edit Blogs</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="{{route('blog-list')}}">Blogs</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{route('blog-edit',$data->id)}}">Edit</a>
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
            <h3 class="card-title">Edit Blog</h3>
          </div>
          <form name="Blogmeta-form" method="post" action="{{ route('blog-update',$data->id) }}" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                 @csrf
                <label for="blog-name">Name</label>
                <input type="hidden" name="id" value="{{$data->id}}">
                <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" id="blog-name" name="name" placeholder="Enter Name" value="{{$data->name}}">
                @if ($errors->has('name'))
                    <span class="error invalid-feedback">{{ $errors->first('name') }}</span>
                @endif
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea class="{{ ($errors->has('name')) ? 'is-invalid' : '' }}" id="description" name="description" row="5" placeholder="Enter Description">{{$data->description}}</textarea>
                @if ($errors->has('description'))
                    <span class="error invalid-feedback">{{ $errors->first('description') }}</span>
                @endif
              </div>
              <div class="form-group">
                  <label for="category">Category</label>
                  <select class="form-control {{ ($errors->has('category')) ? 'is-invalid' : '' }}" name="category" id="category">
                      <option value="" {{ ($data->category == "") ? "selected" : ''  }}>Select Category</option>
                      <option value="1" {{ ($data->category  == 1) ? "selected" : ''  }}>Tender</option>
                      <option value="2" {{ ($data->category  == 2) ? "selected" : ''  }}>GeM</option>
                  </select>
                  @if ($errors->has('category'))
                    <span class="error invalid-feedback">{{ $errors->first('category') }}</span>
                  @endif
              </div>
              <div class="form-group">
                <label for="UploadBy">UploadBy</label>
                <input type="text" class="form-control {{ ($errors->has('uploadby')) ? 'is-invalid' : '' }}" id="uploadby" name="uploadby" placeholder="Enter UploadBy" value="{{ $data->uploadby }}">
                @if ($errors->has('uploadby'))
                  <span class="error invalid-feedback">{{ $errors->first('uploadby') }}</span>
                @endif
              </div>
              <div class="form-group">
                  <label for="blog-type">Type</label>
                  <select class="form-control {{ ($errors->has('type')) ? 'is-invalid' : '' }}" name="type" id="blog-type">
                      <option value="" {{ ($data->type == "") ? "selected" : ''  }}>Select Type</option>
                      <option value="0" {{ ($data->type == 0) ? "selected" : ''  }}>Image</option>
                      <option value="1" {{ ($data->type == 1) ? "selected" : ''  }}>Video</option>
                  </select>
                  @if ($errors->has('type'))
                    <span class="error invalid-feedback">{{ $errors->first('type') }}</span>
                  @endif
              </div> 
              <div class="txt_image {{ ($data->type == 0) ? 'show' : 'hide' }}">
                  <div class="form-group">
                    <label class="control-label" for="image">Image</label>
                    <input type="file" class="{{ ($errors->has('image')) ? 'is-invalid' : '' }}" name="image" value="{{$data->image}}" enctype="multipart/form-data" >
                    <input type="hidden" name="pimage" value="{{$data->image}}">
                    @if ($errors->has('image'))
                      <span class="error invalid-feedback">{{ $errors->first('image') }}</span>
                    @endif
                  </div>
                  @if($data->type == 0)   
                  <img src="{{ asset('frontend/'.$data->image)}}" width="250" height="250" />  
                  @endif
              </div>
              <div class="form-group txt_video {{ ($data->type == 1) ? 'show' : 'hide' }}">
                  <label class="control-label" for="blog-youtube_url">Youtube Url</label>
                  <input type="text" name="youtube_url" class="form-control {{ ($errors->has('youtube_url')) ? 'is-invalid' : '' }}" value="{{ $data->image }}">
                  @if ($errors->has('youtube_url'))
                  <span class="error invalid-feedback">{{ $errors->first('youtube_url') }}</span>
                  @endif

              </div>
              <div class="form-group">
                  <label for="tags">  </label>
                  <input type="text" name="tags" id="tags" value="{{ $data->tags }}" class="form-control {{ ($errors->has('tags')) ? 'is-invalid' : '' }}" placeholder="Enter Tags">
                  @if ($errors->has('tags'))
                    <span class="error invalid-feedback">{{ $errors->first('tags') }}</span>
                  @endif
              </div>
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">Update</button>
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
<script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
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

   $(function () {
    // Summernote
    $('#description').summernote()
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
@endsection