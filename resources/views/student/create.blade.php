@extends('layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
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
                    <a href="{{ route('student.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Username <sup class="text-danger">*</sup></label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ @old('username') }}" placeholder="Username..">
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email <sup class="text-danger">*</sup></label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ @old('email') }}" placeholder="Email..">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Age <sup class="text-danger">*</sup></label>
                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ @old('age') }}" placeholder="Age..">
                        @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Class <sup class="text-danger">*</sup></label>
                        <select name="class[]" class="form-control @error('class') is-invalid @enderror" multiple>
                            @foreach ($class as $val_c)
                            <option value="{{ $val_c['id'] }}" class="text-muted">{{ $val_c['name'] }}</option>
                            @endforeach
                        </select>
                        @error('class')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ @old('phone_number') }}" placeholder="08**********..">
                        @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Picture</label>
                        <div class="custom-file">
                            <input type="file" name="picture" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
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
    setTimeout(function() {
        $('.alert-success').remove()
    },2000)
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
});
</script>
@endsection
