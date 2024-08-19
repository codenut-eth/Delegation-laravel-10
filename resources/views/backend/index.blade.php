@extends('backend.layouts.master')
@section('title','Dele || DASHBOARD')
@section('main-content')
<div class="container-fluid">
  @include('backend.layouts.notification')
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Ratification -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Ratification</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Ratification::countActiveRatification()}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-book fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delegation -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Delegation</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Delegation::countActiveDelegation()}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-sitemap fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Member -->
    <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Member</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{\App\Models\Member::countActiveMember()}}</div>
                </div>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Work Overview</h6>
          <select id="yearPicker" class="col-2 form-control">
            <option value="">All Years</option>
            @foreach(range(date('Y'), date('Y') - 10) as $y)
            <option value="{{ $y }}">{{ $y }}</option>
            @endforeach
          </select>

        </div>
        <!-- Card Body -->
        <div class="card-body">
          <div class="chart-area">
            <canvas id="workResultsChart" style="height:46vh; width:80vw"></canvas>
          </div>
        </div>
      </div>
    </div>


  </div>
  @endsection

  @push('scripts')
  <script src="{{asset('backend/js/chart.js')}}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var ctx = document.getElementById('workResultsChart').getContext('2d');
      if (!ctx) {
        console.error('Canvas element not found');
        return;
      }

      var workResults = {!!json_encode($workResults) !!};
      var yearPicker = document.getElementById('yearPicker');
      var dataLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

      function updateChart(year) {
        var chartData = [];

        if (!year) { // All Years
          var sumData = Array(12).fill(0);
          for (var yr in workResults) {
            for (var i = 0; i < 12; i++) {
              sumData[i] += workResults[yr][i];
            }
          }
          chartData = [{
            label: 'Sum of All Years',
            data: sumData,
            borderColor: '#1cc88a',
            fill: true,
            tension: 0.3,
          }];
        } else { // Specific Year
          chartData = [{
            label: year,
            data: workResults[year] || [],
            borderColor: '#1cc88a',
            fill: true,
            tension: 0.3,
          }];
        }

        chart.data.datasets = chartData;
        chart.update();
      }

      var chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: dataLabels,
          datasets: []
        },
        options: {
          title: {
            display: true,
            text: 'Work Results'
          },
          scales: {
            x: {
              ticks: {
                color: '#4e73df'
              }
            },
            y: {
              ticks: {
                color: '#4e73df',
                callback: function(value) {
                  return value >= 1000 ? value / 1000 + 'k' : value;
                },
              },
            }
          },
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });

      yearPicker.addEventListener('change', function() {
        var selectedYear = this.value;
        updateChart(selectedYear);
      });

      // Initialize with selected year or all years
      updateChart(yearPicker.value);
    });
  </script>

  @endpush