@extends('backend.layouts.master')
@section('title','DELE || Delegation Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Delegation</h5>
    <div class="card-body">
      <form method="post" action="{{route('delegation.update',$delegation->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputName" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{$delegation->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- {{$ratifications}} --}}

        <div class="form-group">
          <label for="ratification">Ratification <span class="text-danger">*</span></label>
          <select name="ratification" id="ratification" class="form-control">
              <option value="">--Select any ratification--</option>
              @foreach($ratifications as $key=>$rat_data)
                  <option value='{{$rat_data->id}}' {{(($delegation->rat_id==$rat_data->id)? 'selected' : '')}}>{{$rat_data->date}} TASK</option>
              @endforeach
          </select>
          @error('ratification')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="number" class="col-form-label">Number <span class="text-danger">*</span></label>
          <input id="number" type="number" name="number" placeholder="Enter number"  value="{{$delegation->number}}" class="form-control">
          @error('number')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="type">Type <span class="text-danger">*</span></label>
          <select name="type[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">--Select any type--</option>
                @php 
                $data=explode(',',$delegation->type);
                @endphp
              <option value="IT"  @if( in_array( "IT",$data ) ) selected @endif>Information Technology (IT)</option>
              <option value="M"  @if( in_array( "M",$data ) ) selected @endif>Medicine (M)</option>
              <option value="C"  @if( in_array( "C",$data ) ) selected @endif>Construction (C)</option>
          </select>
          @error('type')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
       
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($delegation->status=='active')? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($delegation->status=='inactive')? 'selected' : '')}}>Inactive</option>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

@endpush