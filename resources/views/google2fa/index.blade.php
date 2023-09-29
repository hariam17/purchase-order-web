@extends('auth.layouts.auth')
 
@section('body_class', 'login')
 
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
 
                    @if($errors->any())
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                <strong>{{ $errors->first() }}</strong>
                            </div>
                        </div>
                    @endif
 
                    <div class="panel-body text-center">
                        <p>Please enter the OTP generated on your Authenticator App. Ensure you submit the current one
                            because it refreshes every 30 seconds.</p>
                        <form action="{{ route('2fa') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="otp" class="col-sm-2 col-form-label">One Time Password</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="otp" name="one_time_password">
                                </div>
                            </div>
 
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection