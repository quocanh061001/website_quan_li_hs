<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href={{ asset('assets/css/bootstrap.css') }}>
    <link rel="stylesheet" href={{asset('assets/vendors/bootstrap-icons/bootstrap-icons.css')  }}>
    <link rel="stylesheet" href={{ asset('assets/css/app.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/pages/auth.css') }}>
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href={{ asset('#') }}><img src={{ asset('assets/images/logo/logo.png') }} alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Sign Up</h1>
                    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

                    <form action="{{ url('register') }}" method="POST">
                      @csrf
                      @if(Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                      @endif
                      @if(Session::has('fail'))
                      <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                      @endif
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl" placeholder="Username" value="{{ old('username') }}"> 
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <span class="text-danger">@error('username'){{ $message }} @enderror</span>

                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="role" class="form-control form-control-xl" placeholder="role">  
                            <span class="text-danger">@error('role'){{ $message }} @enderror</span>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <select name="gvcn" class="gvcn form-select" id="update_gvcn">
                                  @foreach ($teachers as $item)
                                  <option value="{{ $item->id }}"> {{ $item->name }}</option>
                                  @endforeach
                            </select>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href={{ asset('/') }}
                                class="font-bold">Log
                                in</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
</body>

</html>