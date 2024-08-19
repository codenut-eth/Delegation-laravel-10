@extends('backend.layouts.master')
@section('title','DELE || History Page')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit History</h5>
    <div class="card-body">
    <form method="post" action="{{route('history.update')}}">
        @csrf 
        {{-- @method('PATCH') --}}
        {{-- {{dd($history)}} --}}
        
        <div class="form-group">
          <label for="description" class="col-form-label">Content <span class="text-danger">*</span></label>
          <textarea class="form-control" id="description" name="content">{!! html_entity_decode($history->content)!!}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
   
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush