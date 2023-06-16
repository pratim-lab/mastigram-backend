@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('js/admin/misc.js') }}"></script>
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-body">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
		                @if(Session::has('alert-' . $msg))
		                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
		                @endif
		            @endforeach
					{!! Form::model($users, ['route' => ['admin.user.edit', base64_encode($users->id).'?redirect='.urlencode(Request::query('redirect'))], 'id' => 'userAdd', 'class' => 'cmxform', 'method' => 'PUT', 'novalidate'] ) !!}
						<h4 class="card-title">{{ __('Edit Customer') }}</h4>
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
								<label for="mobile">{{ __('Mobile') }} <span class="text-danger">&#042;</span></label>
								{!! Form::text('mobile', null, array('class'=>'form-control', 'placeholder' => __('Enter mobile'), 'id' => 'mobile')) !!}
							</div>
							<div class="form-group">
							<label for="title">{{ __('Email Verified') }}<span class="text-danger">&#042;</span></label>
							{{Form::select('email_verified',['Y' => 'Varified', 'N' => 'Not Verified'],null,array('required','class'=>'form-control selectpicker','name'=>'email_verified','id'=>'email_verified'))}}
						  </div> 
						  <div class="form-group">
							<label for="title">{{ __('Wallet Status') }}<span class="text-danger">&#042;</span></label>
							{{Form::select('wallet_status',['A' => 'Active', 'I' => 'Inactive'],null,array('required','class'=>'form-control selectpicker','name'=>'wallet_status','id'=>'wallet_status'))}}
						  </div> 
						  
						  <div class="form-group">
							<label for="title">{{ __('Membership Levels') }}<span class="text-danger">&#042;</span></label>
							{{Form::select('group_offer_id',$userGroupOffer,null,array('required','class'=>'form-control selectpicker','name'=>'group_offer_id','id'=>'group_offer_id'))}}
						  </div> 
						  
						  <div class="form-group">
								<label for="mobile">{{ __('Refer Code') }}</label>
								{!! Form::text('refer_code', null, array('class'=>'form-control', 'placeholder' => __('Enter Refer Code'), 'id' => 'refer_code')) !!}
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