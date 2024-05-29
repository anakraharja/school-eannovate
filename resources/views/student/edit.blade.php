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
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
                <form action="{{ route('student.update',$student->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Username <sup class="text-danger">*</sup></label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ @old('username',$student->username) }}" placeholder="Username..">
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email <sup class="text-danger">*</sup></label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ @old('email',$student->email) }}" placeholder="Email..">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Age <sup class="text-danger">*</sup></label>
                        <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ @old('age',$student->age) }}" placeholder="Age..">
                        @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>
                            Class
                            @if (count($student->student_class) > 0)
                            <sup><a href="javascript:void(0)" class="badge badge-primary ml-1" data-toggle="modal" data-target="#showClassModal"><i class="fas fa-eye"></i> Class already axists</a></sup>
                            @endif
                        </label>
                        <select name="class[]" class="form-control @if(session('error')) is-invalid @endif" multiple>
                            @foreach ($class as $val_c)
                            <option value="{{ $val_c['id'] }}">{{ $val_c['name'] }}</option>
                            @endforeach
                        </select>
                        @if(session('error'))<div class="invalid-feedback">{{ session('error') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ @old('phone_number',$student->phone_number) }}" placeholder="phone_number..">
                        @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Picture</label><br>
                        @if ($student->picture != NULL)
                            <a href="{{ asset('storage/images/'.$student->picture) }}" target="_blank">
                                <img src="{{ asset('storage/images/'.$student->picture) }}" width="100" height="100" alt="" title="">
                            </a><br>
                            <a href="{{ route('student.destroy-picture',$student->id) }}" class="badge badge-danger mb-3"><i class="fas fa-trash mr-1"></i> Delete</a>
                        @endif
                        <div class="custom-file">
                            <input type="file" name="picture" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit mr-1"></i> Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<!-- Modal Show Class -->
<div class="modal fade" id="showClassModal" data-backdrop="static" data-keyboard="false" aria-labelledby="showClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showClassModalLabel">Show Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeClass()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ol class="display-class">
                    @foreach ($student->student_class as $val)
                        <li>
                            {{ $val->class->name }} ({{ $val->class->major }})
                            <a href="{{ route('student-class',$val->id) }}" class="badge badge-danger ml-1"><i class="fas fa-trash"></i></a>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeClass()">Close</button>
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
    setTimeout(function() {
        $('.alert-danger').remove()
    },2000)
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
});
</script>
@endsection
