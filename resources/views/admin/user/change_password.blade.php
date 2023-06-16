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
					<!-- {!! Form::model(['route' => 'admin.user.add', 'id' => 'change_password_form', 'class' => 'cmxform', 'method' => 'PUT', 'novalidate'] ) !!} -->
					{{Form::open(['files' => true, 'route' => 'admin.user.changePassword', 'id' => 'change_password_form'])}}
						<h4 class="card-title">{{ __('Change Password') }}</h4>
						<fieldset>
							<div class="form-group">
								<label for="first_name">{{ __('Current Password') }}<span class="text-danger">&#042;</span></label>
								{!! Form::password('old_password', array('required', 'class'=>'form-control', 'placeholder' => __('Enter Current Password'), 'id' => 'cp_old_password')) !!}
								@if ($errors->has('old_password'))
									<span class="error">
										{{ $errors->first('old_password') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="password">{{ __('New Password') }}<span class="text-danger">&#042;</span></label>
								{!! Form::password('password', array('required', 'class'=>'form-control', 'placeholder' => __('Enter the new password'), 'id' => 'cp_password')) !!}
								@if ($errors->has('password'))
									<span class="error">
										{{ $errors->first('password') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="confirm_password">{{ __('Confirm New Password') }}<span class="text-danger">&#042;</span></label>
								{!! Form::password('confirm_password', array('required', 'class'=>'form-control', 'placeholder' => __('Enter confirm password'), 'id' => 'cp_confirm_password')) !!}
								@if ($errors->has('confirm_password'))
									<span class="error">
										{{ $errors->first('confirm_password') }}
									</span>
								@endif
							</div>
							<input class="btn btn-primary" type="submit" value="Submit">
							<a class="btn btn-info" href="{{ route('admin.dashboard') }}">Cancel</a>
						</fieldset>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
    $("#change_password_form").validate({
        rules: {
            old_password: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#cp_password"
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
</script>
@endsection