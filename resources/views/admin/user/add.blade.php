@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('js/admin/misc.js') }}"></script>
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
		                @if(Session::has('alert-' . $msg))
		                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
		                @endif
		            @endforeach
					{!! Form::model($users, ['route' => 'admin.user.add', 'id' => 'userAdd', 'class' => 'cmxform', 'method' => 'PUT', 'novalidate'] ) !!}
						<h4 class="card-title">{{ __('Add Customer') }}</h4>
						<fieldset>
							<div class="form-group">
								<label for="name">{{ __('Name') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('name', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter name'), 'id' => 'name')) !!}
								@if ($errors->has('name'))
									<span class="error">
										{{ $errors->first('name') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="email">{{ __('Email') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('email', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter Email ID'), 'id' => 'email')) !!}
								@if ($errors->has('email'))
									<span class="error">
										{{ $errors->first('email') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="mobile">{{ __('Mobile') }}</label>
								{!! Form::text('mobile', null, array('class'=>'form-control', 'placeholder' => __('Enter mobile'), 'id' => 'mobile')) !!}
							</div>
							<div class="form-group">
								<label for="password">{{ __('Password') }}<span class="text-danger">&#042;</span></label>
								{!! Form::password('password', array('required', 'class'=>'form-control', 'placeholder' => __('Enter the password'), 'id' => 'cp_password')) !!}
								@if ($errors->has('password'))
									<span class="error">
										{{ $errors->first('password') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="confirm_password">{{ __('Confirm Password') }}<span class="text-danger">&#042;</span></label>
								{!! Form::password('confirm_password', array('required', 'class'=>'form-control', 'placeholder' => __('Enter confirm password'), 'id' => 'cp_confirm_password')) !!}
								@if ($errors->has('confirm_password'))
									<span class="error">
										{{ $errors->first('confirm_password') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<div class="form-check form-check-flat">
									<label class="form-check-label">
										{!! Form::checkbox('email_verified', 'Y', null, ['class' => 'form-check-input', 'checked']) !!}
										{{ __('Send Verification Link') }}
									</label>
								</div>
							</div>
							<input class="btn btn-primary" type="submit" value="Submit">
							<a class="btn btn-info" href="{{ route('admin.user.list') }}">Cancel</a>
						</fieldset>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$.validator.setDefaults({
        submitHandler: function(form) {
            form.submit();
        }
});
$(function() {
    // validate the comment form when it is submitted
    $("#userAdd").validate({
    	rules: {
            email: {
                required: true,
                email: true
            }
        },
		errorPlacement: function(label, element) {
			label.addClass('mt-2 text-danger');
			label.insertAfter(element);
		},
		highlight: function(element, errorClass) {
			$(element).parent().addClass('has-danger')
			$(element).addClass('form-control-danger')
		}
  	});
});


</script>
@endsection