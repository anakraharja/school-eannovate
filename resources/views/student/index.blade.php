@extends('layout.app')

@section('css')
<link href="{{ asset('template') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
@if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0">
            <a href="{{ route('student.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Create New
            </a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-student" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Picture</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student as $val)
                    <tr>
                        <td>{{ $val->username }}</td>
                        <td>{{ $val->email }}</td>
                        <td>{{ $val->age }}</td>
                        <td>{{ $val->phone_number }}</td>
                        <td>
                            @if ($val->picture != NULL)
                            <a href="{{ asset('storage/images/'.$val->picture) }}" target="_blank">
                                <img src="{{ asset('storage/images/'.$val->picture) }}" width="50" height="50" alt="" title="">
                            </a>
                            @endif
                        </td>
                        <td>{{ $val->createdby->username }}</td>
                        <td>{{ \Carbon\Carbon::parse($val->created_date)->translatedFormat('d F Y')}}</td>
                        <td>
                            <div class="float-right">
                                <a href="{{ route('student.edit',$val->id) }}" class="badge badge-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('student.destroy',$val->id) }}" class="d-inline border-0" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="badge badge-danger border-0"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('template') }}/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
setTimeout(function() {
    $('.alert-success').remove()
},2000)
$('#datatable-student').DataTable({
    ordering: false
});
</script>
@endsection
