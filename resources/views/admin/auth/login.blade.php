@extends('layouts.admin.login')

@section('content')
<div class="row w-100">
	<div class="col-lg-4 mx-auto">
		<div class="css-woebav">
		<img src="{{ asset('images/admin_logo.png') }}" alt="login" class="admin_logo">
			<h3 class="MuiTypography-root MuiTypography-h3 css-w29fpn">Hi, Welcome Back</h3>
			<img src="{{ asset('images/illustration_login.png') }}" alt="login">
		</div>
	</div>

    <div class="col-lg-8 mx-auto">
        <div class=" text-left p-5 css-26q4qm">
            <h2 style="text-align:left;font-size: 1.5rem;">Sign in to {{ config('app.name') }} {{ __('Admin Panel') }}</h2>
			<p class="MuiTypography-root MuiTypography-body1 css-1s3hfzc">Enter your details below.</p>
			
			<p></p><p></p>
			
			<div class="MuiDivider-root MuiDivider-fullWidth MuiDivider-withChildren css-18rucq9" role="separator">
				<span class="MuiDivider-wrapper css-cbg5f1">
					<p class="MuiTypography-root MuiTypography-body2 css-11r9ii4">E-mail & Password.</p>
				</span>
			</div>
			
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
                @endif
            @endforeach
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('E-Mail Address') }}</label>
                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" value="{{ old('email') }}" required autofocus name="email">
                    <i class="mdi mdi-account"></i>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">{{ __('Password') }}</label>
                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" placeholder="Enter Password" name="password" required>
                    <i class="mdi mdi-eye"></i>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-block btn-info btn-lg font-weight-medium">{{ __('Login') }}</button>
                </div>
                <!-- <div class="mt-3 text-center">
                    <a href="#" class="auth-link text-white">Forgot password?</a>
                </div> -->
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
<script type="text/javascript">
    $('form').validate({
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>
@endsection