@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="message-success"></div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0">
                    <a href="{{ route('class.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </h6>
            </div>
            <div class="card-body">
                <form id="form">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name..">
                        <div class="invalid-feedback error-name"></div>
                    </div>
                    <div class="form-group">
                        <label>Major</label>
                        <select name="major" class="form-control" id="select-major">
                          <option value="" class="text-muted">-select major-</option>
                        </select>
                        <div class="invalid-feedback error-major"></div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-paper-plane mr-1"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function(){
    $('#name').on('keyup',function(){
        $('#name').removeClass('is-invalid')
    });
    $('#select-major').on('change',function(){
        $('#select-major').removeClass('is-invalid')
    });
    // Create
    $('#form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url: 'http://school-eannovate.mochamadmaulana.my.id/api/mobile/class',
            type: "POST",
            cache: false,
            data: {
                "name": $('#name').val(),
                "major": $('#select-major').val(),
                "created_by": {{ auth()->user()->id }},
                "modified_by": {{ auth()->user()->id }},
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                $('#form').trigger("reset");
                $('.message-success').append('<div class="alert alert-success">'+response.message+'</div>')
                setTimeout(function() {
                    $('.alert-success').remove()
                },2000)
            },
            error: function(error) {
                if (error.responseJSON.errors.name) {
                    $('#name').addClass('is-invalid')
                    $('.error-name').html(error.responseJSON.errors.name);
                }
                if (error.responseJSON.errors.major) {
                    $('#select-major').addClass('is-invalid')
                    $('.error-major').html(error.responseJSON.errors.major);
                }
            }
        });
    });

    // Get Major
    $.ajax({
        url: 'https://www.eannov8.com/career/case/getMajor.json',
        type: 'GET',
        dataType: 'json',
        success:function(response){
            if(response.status == 200){
                $.each(response.data, function(key, data){
                    $('#select-major').append('<option value="'+ data.name +'">' + data.name+ '</option>');
                });
            }else{
                $('#select-major').empty();
            }
        },
        error: function (request, error) {
            $('#select-major').empty();
        }
    });
});
</script>
@endsection
