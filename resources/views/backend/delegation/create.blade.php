@extends('backend.layouts.master')
@section('title','DELE || Delegation Create')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Delegation</h5>
    <div class="card-body">
      <form method="post" action="{{route('delegation.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputName" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- {{$ratifications}} --}}

        <div class="form-group">
          <label for="ratification" class="col-form-label">Ratification <span class="text-danger">*</span></label>
          <select name="ratification" id="ratification" class="form-control">
              <option value="">--Select any ratification--</option>
              @foreach($ratifications as $key=>$rat_data)
                  <option value='{{$rat_data->id}}'>{{$rat_data->date}} TASK</option>
              @endforeach
          </select>
          @error('ratification')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="number" class="col-form-label">Number <span class="text-danger">*</span></label>
          <input id="number" type="number" name="number" min="0" placeholder="Enter Number"  value="{{old('number')}}" class="form-control">
          @error('number')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
          <select name="type[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">--Select any type--</option>
              @foreach ($types as $index => $type )
                <option value="{{ $type->id }}">{{ $type->name }}</option>
              @endforeach
          </select>
          @error('type')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="work_content" class="col-form-label">Work content</label>
          <textarea class="form-control" id="work_content" name="work_content"></textarea>
          @error('work_content')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/bootstrap-select.css')}}" /> 
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="{{asset('backend/js/bootstrap-select.min.js')}}"></script>

<script>
  $(document).ready(function () {

    $('#work_content').summernote({
      placeholder: "Write work content.....",
        tabsize: 2,
        height: 150
    });
  })
</script>

@endpush