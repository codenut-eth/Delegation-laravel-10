@extends('backend.layouts.master')
@section('title','DELE || Ratification Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Ratification</h5>
    <div class="card-body">
      <form method="post" action="{{route('ratification.update',$ratification->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputDate" class="col-form-label">Date <span class="text-danger">*</span></label>
          <input id="inputDate" type="date" name="date" placeholder="Enter date"  value="{{$ratification->date}}" class="form-control">
          @error('date')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Summary</label>
          <textarea class="form-control" id="summary" name="content">{{$ratification->content}}</textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active" {{(($ratification->status=='active')? 'selected' : '')}}>Active</option>
              <option value="inactive" {{(($ratification->status=='inactive')? 'selected' : '')}}>Inactive</option>
          </select>
          @error('status')
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
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write the content......",
          tabsize: 2,
          height: 150
      });
    });
</script>

@endpush