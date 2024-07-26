@extends('backend.layouts.master')
@section('title','DELE || Delegation Page')
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Delegation Lists</h6>
      <a href="{{route('delegation.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Delegation</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($delegations)>0)
        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Ratification</th>
              <th>Number</th>
              <th>Type</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Ratification</th>
              <th>Number</th>
              <th>Type</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>

            @foreach($delegations as $index => $delegation)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$delegation->name}}</td>
                    <td>{{$delegation->rat_info['date']}} TASK</td>
                    <td>{{$delegation->number}}</td>
                    <td>{{$delegation->type}}</td>
                    <td>
                        @if($delegation->status=='active')
                            <span class="badge badge-success">{{$delegation->status}}</span>
                        @else
                            <span class="badge badge-warning">{{$delegation->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('delegation.edit',$delegation->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('delegation.destroy',[$delegation->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$delegation->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$delegations->links()}}</span>
        @else
          <h6 class="text-center">No Delegations found!!! Please create Delegation</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(5);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#product-dataTable').DataTable( {
        "scrollX": false,
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5,6]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
