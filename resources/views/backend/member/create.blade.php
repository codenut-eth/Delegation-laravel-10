@extends('backend.layouts.master')
@section('title', 'DELE || Member Create')
@push('styles')
<link href="{{asset('backend/css/custom.css')}}" rel="stylesheet">
@endpush
@section('main-content')

<div class="card">
  <h5 class="card-header">Add Member</h5>
  <div class="card-body">
    <form method="post" class="row" action="{{route('member.store')}}">
      {{csrf_field()}}
      <div class="form-group col-6">
        <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-6">
        <label for="inputPhoto" class="col-form-label">Photo</label>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
        @error('photo')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-6">
        <label for="inputSDate" class="col-form-label">Start Date</label>
        <input id="inputSDate" type="date" name="start_date" placeholder="Enter start date" value="{{ old('start_date', date('Y-m-d')) }}" class="form-control">
        @error('startDate')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-6">
        <label for="inputEDate" class="col-form-label">End Date</label>
        <input id="inputEDate" type="date" name="end_date" placeholder="Enter end date" value="{{old('end_date', date('Y-m-d'))}}" class="form-control">
        @error('endDate')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-6">
        <label for="dele_id" class="col-form-label">Delegation</label>
        <select name="dele_id" class="form-control">
          <option value="">-----Select Delegation-----</option>
          @foreach($delegations as $delegation)
          <option value="{{$delegation->id}}">{{$delegation->number.' ('.$delegation->name.')'}}</option>
          @endforeach
        </select>
        @error('dele_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group col-6">
        <label for="status" class="col-form-label">Status</label>
        <select name="status" class="form-control">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
        @error('status')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group mb-3 member-btn-group">
        <button type="reset" class="btn btn-warning">Reset</button>
        <button class="btn btn-success" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#lfm').filemanager('image');
</script>
@endpush