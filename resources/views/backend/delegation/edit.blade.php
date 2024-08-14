@extends('backend.layouts.master')
@section('title','DELE || Delegation Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Delegation</h5>
    <div class="card-body">
      <form method="post" class="row" action="{{route('delegation.update',$delegation->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group col-4">
          <label for="inputName" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputName" type="text" name="name" placeholder="Enter name"  value="{{$delegation->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- {{$ratifications}} --}}

        <div class="form-group col-4">
          <label for="ratification" class="col-form-label">Ratification <span class="text-danger">*</span></label>
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

        <div class="form-group col-4">
          <label for="number" class="col-form-label">Number <span class="text-danger">*</span></label>
          <input id="number" type="number" name="number" placeholder="Enter number"  value="{{$delegation->number}}" class="form-control">
          @error('number')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group col-8">
          <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
          <select name="type[]" class="form-control selectpicker"  multiple data-live-search="true">
            <option value="">--Select any type--</option>
            @php 
            $data=explode(',',$delegation->type);
            @endphp
            @foreach ($types as $type)
              <option value="{{ $type->id }}"  @if( in_array( $type->id, $data ) ) selected @endif>{{ $type->name }}</option>
            @endforeach
          </select>
          @error('type')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
       
        <div class="form-group col-4">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($delegation->status=='active')? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($delegation->status=='inactive')? 'selected' : '')}}>Inactive</option>
        </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group col-12">
          <label for="work_content" class="col-form-label">Work content</label>
          <textarea class="form-control" id="work_content" name="work_content">{{$delegation->work_content}}</textarea>
          @error('work_content')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group col-2">
            <label for="inputYear" class="col-form-label">Work Year</label>
            <input id="inputYear" type="text" name="work_year" placeholder="Enter year" value="{{ old('year', date('Y')) }}" class="form-control year-picker">
            @error('work_year')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-12">
          <label for="status" class="col-form-label">Work Result</label>
          <table class="table table-bordered text-center" id="user-dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="text-primary">Name</th>
                @for ($i=1; $i<13; $i++)
                <th>{{ $i }}</th>
                @endfor
                <th class="text-danger">Sum</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th class="text-primary">Name</th>
                @for ($i=1; $i<13; $i++)
                <th>{{ $i }}</th>
                @endfor
                <th class="text-danger">Sum</th>
              </tr>
            </tfoot>
            <tbody>
            </tbody>
          </table>
        </div>

        <div class="form-group mb-3 col-6">
           <button class="btn btn-success" type="submit">Update</button>
        </div>

        <div class="col-5 d-flex justify-content-end">
          <span class="text-danger" id="total-sum">Total sum: 0</span>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/bootstrap-select.css')}}" /> 
<link href="{{asset('backend/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"> 
<link href="{{asset('backend/css/custom.css')}}" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="{{asset('backend/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('backend/js/bootstrap-datepicker.min.js')}}"></script>

<script>
  $(document).ready(function () {
    $('.year-picker').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

    $('#work_content').summernote({
      placeholder: "Write work content.....",
        tabsize: 2,
        height: 150
    });

    const members = {!! json_encode($members) !!};
    const delegation = {!! json_encode($delegation) !!};
    let totalSum = 0;

    function updateTable(year) {
      const tbody = $('#user-dataTable tbody');
      tbody.empty();

      members.forEach(member => {
        const workResults = JSON.parse(member.work_results);
        const yearlyResults = workResults.find(result => result.year == year);

        if (yearlyResults) {
          let monthlySums = yearlyResults.months.map((month, index) => {
            return `<td class="month-td"><input type="number" name="work_results[${member.id}][months][${index}]" value="${month}" class="form-control month-input text-center"></td>`;
          });

          let row = $(`
            <tr>
              <td class="text-primary">${member.name}</td>
              ${monthlySums.join('')}
              <td class="text-danger">${yearlyResults.months.reduce((acc, curr) => acc + Number(curr), 0)}</td>
            </tr>
          `);

          tbody.append(row);
        }
      });

      updateTotalSum();
    }

    function updateTotalSum() {
      totalSum = 0;
      $('#user-dataTable tbody tr').each(function() {
        let rowSum = 0;
        $(this).find('.month-input').each(function() {
          rowSum += Number($(this).val());
        });
        totalSum += rowSum;
        $(this).find('.text-danger').text(rowSum);
      });

      $('#total-sum').text(`Total sum: ${totalSum}`);
    }

    $('#inputYear').on('change', function() {
      const year = $(this).val();
      updateTable(year);
    });

    $(document).on('input', '.month-input', function() {
      updateTotalSum();
    });

    // Initialize table with current year
    updateTable(new Date().getFullYear());
  });
</script>
@endpush