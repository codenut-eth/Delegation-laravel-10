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
      <div class="form-group col-4">
        <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-4">
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

      <div class="form-group col-4">
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

      <div class="form-group col-4">
        <label for="inputSDate" class="col-form-label">Start Date</label>
        <input id="inputSDate" type="date" name="start_date" placeholder="Enter start date" value="{{ old('start_date', date('Y-m-d')) }}" class="form-control">
        @error('startDate')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-4">
        <label for="inputEDate" class="col-form-label">End Date</label>
        <input id="inputEDate" type="date" name="end_date" placeholder="Enter end date" value="{{old('end_date', date('Y-m-d'))}}" class="form-control">
        @error('endDate')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group col-4">
        <label for="status" class="col-form-label">Status</label>
        <select name="status" class="form-control">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
        @error('status')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      
      <div class="form-group col-12">
        <label for="status" class="col-form-label">Work Result</label>
        <table class="table table-bordered text-center" id="user-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-primary">Year</th>
              @for ($i=1; $i<13; $i++)
              <th>{{ $i }}</th>
              @endfor
              <th class="text-danger">Sum</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-primary">Year</th>
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
        <input type="hidden" name="work_results" id="work_results_input">
        <div class="form-group mb-3 col-6">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button class="btn btn-success" type="submit">Submit</button>
        </div>
        <div class="col-5 d-flex justify-content-end">
          <span class="text-danger" id="total-sum">Total sum: 0</span>
        </div>
      </form>
  </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $(document).ready(function () {
    // Initialize the file manager
    $('#lfm').filemanager('image');

    function generateTable(startDate, endDate) {
      let start = new Date(startDate);
      let end = new Date(endDate);
      
      if (start > end) {
        alert("Start date should be earlier than end date.");
        return;
      }
      
      let tbody = $('#user-dataTable tbody');
      tbody.empty();

      for (let year = start.getFullYear(); year <= end.getFullYear(); year++) {
        let row = $('<tr></tr>');
        row.append(`<td class="text-primary">${year}</td>`);
        
        for (let month = 1; month <= 12; month++) {
          let monthInput = $('<input>').attr('type', 'number').addClass('form-control month-input text-center').data('year', year).data('month', month).val(0);
          row.append($('<td></td>').addClass('month-td').append(monthInput));
        }

        let sumCell = $('<td class="text-danger sum-cell"></td>').text('0');
        row.append(sumCell);
        tbody.append(row);
      }
    }

    function updateSums() {
      let totalSum = 0;
      $('#user-dataTable tbody tr').each(function () {
        let sum = 0;
        $(this).find('.month-input').each(function () {
          let val = parseFloat($(this).val());
          if (!isNaN(val)) {
            sum += val;
          }
        });
        $(this).find('.sum-cell').text(sum);
        totalSum += sum;
      });
      $('#total-sum').text(`Total sum: ${totalSum}`);
    }

    function gatherWorkResults() {
        let workResults = [];
        $('#user-dataTable tbody tr').each(function () {
            let yearResults = {};
            let year = $(this).find('td').first().text();
            yearResults['year'] = year;
            yearResults['months'] = [];

            $(this).find('.month-input').each(function () {
                let value = $(this).val();
                yearResults['months'].push(value);
            });

            workResults.push(yearResults);
        });
        return workResults;
    }

    // Attach change event listeners to the date inputs
    $(document).on('change', "[name='start_date'], [name='end_date']", function () {
      let startDate = $("[name='start_date']").val();
      let endDate = $("[name='end_date']").val();

      if (startDate && endDate) {
        generateTable(startDate, endDate);
      }
    });

    // Attach change event listener to month inputs to update sums
    $(document).on('input', '.month-input', function () {
      updateSums();
    });

    // Serialize table data and set it to hidden input before form submission
    $('form').on('submit', function() {
      let workResults = gatherWorkResults();
      $('#work_results_input').val(JSON.stringify(workResults));
    });
    
    // Generate initial table if start and end dates are already set
    let initialStartDate = $("[name='start_date']").val();
    let initialEndDate = $("[name='end_date']").val();
    if (initialStartDate && initialEndDate) {
      generateTable(initialStartDate, initialEndDate);
    }

  });
</script>
@endpush
