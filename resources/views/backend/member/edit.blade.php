@extends('backend.layouts.master')
@push('styles')
<link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
@endpush
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Member</h5>
    <div class="card-body">
        <form method="post" class="row" action="{{ route('member.update', $member->id) }}">
            @csrf
            @method('PATCH')
            <div class="form-group col-4">
                <label for="inputTitle" class="col-form-label">Name</label>
                <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{ $member->name }}" class="form-control">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
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
                    <input id="thumbnail" class="form-control" type="text" name="photo" value="{{ $member->photo }}">
                </div>
                <img id="holder" style="margin-top:15px;max-height:100px;">
                @error('photo')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="dele_id" class="col-form-label">Delegation</label>
                <select name="dele_id" class="form-control">
                    <option value="">-----Select Delegation-----</option>
                    @foreach($delegations as $delegation)
                    <option value="{{ $delegation->id }}" {{ ($member->dele_id == $delegation->id) ? 'selected' : '' }}>{{ $delegation->number.' ('.$delegation->name.')' }}</option>
                    @endforeach
                </select>
                @error('dele_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="inputSDate" class="col-form-label">Start Date</label>
                <input id="inputSDate" type="date" name="start_date" placeholder="Enter start date" value="{{ $member->start_date }}" class="form-control">
                @error('start_date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="inputEDate" class="col-form-label">End Date</label>
                <input id="inputEDate" type="date" name="end_date" placeholder="Enter end date" value="{{ $member->end_date }}" class="form-control">
                @error('end_date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="status" class="col-form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ ($member->status == 'active') ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ ($member->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-12">
                <label for="work_results" class="col-form-label">Work Result</label>
                <table class="table table-bordered text-center" id="user-dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-primary">Year</th>
                            @for ($i = 1; $i <= 12; $i++)
                            <th>{{ $i }}</th>
                            @endfor
                            <th class="text-danger">Sum</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="text-primary">Year</th>
                            @for ($i = 1; $i <= 12; $i++)
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
                <button class="btn btn-success" type="submit">Update</button>
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
        $('#lfm').filemanager('image');
        let work = JSON.parse('{!! addslashes($workResults) !!}');
        let workResults =JSON.parse(work)
        if (!Array.isArray(workResults)) {
          workResults = [];
        }

        function generateTable(startDate, endDate, workResults = []) {
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
                    let value = '0';
                    let yearResult = workResults.find(r => r.year == year);
                    if (yearResult) {
                        value = yearResult.months[month - 1] || '0';
                    }

                    let monthInput = $('<input>').attr('type', 'number').addClass('form-control month-input text-center').data('year', year).data('month', month).val(value);
                    row.append($('<td></td>').addClass('month-td').append(monthInput));
                }

                let sumCell = $('<td class="text-danger sum-cell"></td>').text('0');
                row.append(sumCell);
                tbody.append(row);
            }

            updateSums();
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

        $(document).on('change', "[name='start_date'], [name='end_date']", function () {
            let startDate = $("[name='start_date']").val();
            let endDate = $("[name='end_date']").val();

            if (startDate && endDate) {
                generateTable(startDate, endDate, workResults);
            }
        });

        $(document).on('input', '.month-input', function () {
            updateSums();
        });

        $('form').on('submit', function () {
            let workResults = gatherWorkResults();
            $('#work_results_input').val(JSON.stringify(workResults));
        });

        let initialStartDate = $("[name='start_date']").val();
        let initialEndDate = $("[name='end_date']").val();
        if (initialStartDate && initialEndDate) {
            generateTable(initialStartDate, initialEndDate, workResults);
        }
    });
</script>
@endpush
