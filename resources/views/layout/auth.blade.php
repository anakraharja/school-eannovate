<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? env('APP_NAME') }} | {{ env('APP_NAME') }}</title>
    <link href="{{ asset('template') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('template') }}/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-9">
                <div class="card o-hidden border-0 shadow-sm my-5 border-bottom-primary">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login <strong class="text-primary font-italic">School Eannovate</strong></h1>
                            </div>
                            <form action="{{ route('store-login') }}" method="POST" class="user">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user @error('username') is-invalid @enderror" value="{{ @old('username') }}" placeholder="Username">
                                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('template') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template') }}/js/sb-admin-2.min.js"></script>

</body>

</html>
