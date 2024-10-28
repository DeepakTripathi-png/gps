@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-6 card-header border-0 px-4 py-3 bg-transparent">
        <h5 class="mb-0">{{$pageTitle}}</h5>
    </div>
    @can('admin.roles.add')
        <div class="col-6 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('admin.roles.add') }}" style="height: 2.5rem;"><i class="las la-plus"></i>Add New</a>
        </div>
    @endcan
</div>
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-borderd dc-table" style="border-collapse: collapse!important;">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Role Name</th>
                            <th>Created At</th>
                          @can('admin.roles.edit')
                            <th>Action</th>
                          @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ date('d-m-Y', strtotime($role->created_at)) }}</td>
                            @can('admin.roles.edit')
                            <td>
                                <a class="" href="{{ route('admin.roles.edit',['id' => $role->id]) }}"><img class="p-1" src="{{asset('assets/icon/edit.png')}}" /></a>
                            </td>
                            @endcan
                        </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script-lib')
  <script src="{{ asset("/assets/plugins/datatable/js/jquery.dataTables.min.js") }}"></script>
@endpush
@push('style-lib')
    <style>
      table thead tr th {
        background-color: #2E3192 !important;
        color: #fff!important;
      }
      .btn-sm{
        --bs-btn-padding-y: 0.1rem;
      }
      table tbody tr td {
    text-align: center;
   }
     </style>

@endpush
@push('script')
<script>
  $(document).ready(function() {
      var table = $('#example2').DataTable({
          lengthChange: false,
          ordering: false,
          buttons: [
              {
                  extend: 'copy',
                  exportOptions: {
                      columns: [0, 1, 2] 
                  }
              },
              {
                  extend: 'excel',
                  exportOptions: {
                      columns: [0, 1, 2] 
                  }
              },
              {
                  extend: 'pdf',
                  exportOptions: {
                      columns: [0, 1, 2] 
                  }
              },
              {
                  extend: 'print',
                  exportOptions: {
                      columns: [0, 1, 2] 
                  }
              }
          ]
      });
      table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
      $('[data-toggle="tooltip"]').tooltip();
  });

   $(document).ready(function() {
     $('#example').DataTable();
     } );
</script>
@endpush
