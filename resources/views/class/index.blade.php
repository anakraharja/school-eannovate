@extends('layout.app')

@section('css')
<link href="{{ asset('template') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="message-success"></div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0">
            <a href="{{ route('class.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus mr-1"></i> Create New
            </a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="datatable-class" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Major</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($class as $val)
                    <tr>
                        <td>{{ $val['name'] }}</td>
                        <td>{{ $val['major'] }}</td>
                        <td>{{ $val['createdby']['username'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($val['created_date'])->translatedFormat('d F Y')}}</td>
                        <td>
                            <div class="float-right">
                                <a href="{{ route('class.edit',$val['id']) }}" class="badge badge-success"><i class="fas fa-edit"></i></a>
                                <a href="javascript:void(0)" class="badge badge-danger" onclick="destroy({{ $val['id'] }})"><i class="fas fa-trash"></i></a>
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
$('#datatable-class').DataTable({
    ordering: false
});
function destroy(id){
    // Delete
    $.ajax({
        url: 'http://school-eannovate.test/api/mobile/class/'+id,
        type: "DELETE",
        cache: false,
        data: {"_token": "{{ csrf_token() }}"},
        success: function(response) {
            $('.message-success').append('<div class="alert alert-success">'+response.message+'</div>')
            setTimeout(function() {
                location.reload()
            },2000)
        },
        error: function(error) {
            if (error.responseJSON.errors.name) {
                $('#name').addClass('is-invalid')
                $('.error-name').html(error.responseJSON.errors.name);
            }
        }
    });
}
</script>
@endsection
