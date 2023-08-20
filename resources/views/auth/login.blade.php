@extends('master')
@section('title')
    Login
@endsection

@section('content')
    <div class="content d-flex justify-content-center align-items-center pt-5">

        <!-- Login form -->
        <form class="login-form" action="login" method="POST">
            @csrf
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                        <h5 class="mb-0">Login to your account</h5>
                        <span class="d-block text-muted">Enter your credentials below</span>
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="text" class="form-control <?php if($errors->has('email')) echo "border-danger-400"?>" placeholder="Email" name="email">
                        <div class="form-control-feedback">
                            <i class="icon-user text-muted"></i>
                        </div>
                        @if($errors->has('email'))
                            <span class="form-text text-danger-400">{{$errors->first('email')}}</span>
                        @endif
                    </div>

                    <div class="form-group form-group-feedback form-group-feedback-left">
                        <input type="password" class="form-control <?php if($errors->has('password')) echo "border-danger-400"?>" placeholder="Password" name="password">
                        <div class="form-control-feedback">
                            <i class="icon-lock2 text-muted"></i>
                        </div>
                        @if($errors->has('password'))
                            <span class="form-text text-danger-400">{{$errors->first('password')}}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                    </div>

                    <div class="text-center">
                        <a href="/forgotPasswordCms" class="ml-auto">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- /login form -->

    </div>
@endsection
