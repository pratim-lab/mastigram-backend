@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('js/admin/misc.js') }}"></script>
<link rel="stylesheet" href="{{asset('css/admin/selectpicker/bootstrap-select.css')}}">
<script src="{{asset('js/admin/selectpicker/bootstrap-select.js')}}"></script>
<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
		                @if(Session::has('alert-' . $msg))
		                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
		                @endif
		            @endforeach
					{!! Form::model($users, ['id' => 'userAdd', 'class' => 'cmxform', 'method' => 'POST', 'novalidate'] ) !!}
						<h4 class="card-title">{{ __('Add User Address') }}</h4>
						<fieldset>
						
							<div class="form-group">
								<label for="name">{{ __('Address Type') }}<span class="text-danger">&#042;</span></label>
								<?php 
										  $address_mode_arr['work'] = 'Work';
										  $address_mode_arr['home'] = 'Home';
										  
										  ?>
								{{ Form::select('address_mode',$address_mode_arr,null,array('required','class'=>'form-control ','name'=>'address_mode','id'=>'address_mode' )) }}
								@if ($errors->has('address_mode'))
									<span class="error">
										{{ $errors->first('address_mode') }}
									</span>
								@endif
							</div>
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
								<label for="password">{{ __('Country') }}<span class="text-danger">&#042;</span></label>
								<?php 
								$country_id_arr['99'] = 'India'
								?>
									{{Form::select('country_id',$country_id_arr,null,array('required','class'=>'form-control ','id'=>'country_id' )) }}
								@if ($errors->has('country_id'))
									<span class="error">
										{{ $errors->first('country_id') }}
									</span>
								@endif
							</div>
							<div class="form-group">
								<label for="confirm_password">{{ __('State') }}<span class="text-danger">&#042;</span></label>
						{{Form::select('state_id',$state,null,array('required','class'=>'form-control  selectpicker','id'=>'state_id','data-live-search'=>'true','data-live-search-placeholder'=>"Search"  )) }}
								@if ($errors->has('state_id'))
									<span class="error">
										{{ $errors->first('state_id') }}
									</span>
								@endif
							</div>
							
							
							<div class="form-group" id="show_city">
								<label for="confirm_password">{{ __('City') }}<span class="text-danger">&#042;</span></label>
								<?php
								$city = array();
								?>
						{{Form::select('city_id',$city,null,array('required','class'=>'form-control  selectpicker','id'=>'city_id','data-live-search'=>'true','data-live-search-placeholder'=>"Search"  )) }}
								
							</div>
							
							<div class="form-group">
								<label for="pincode">{{ __('Pincode') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('pincode', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter pincode'), 'id' => 'pincode')) !!}
								@if ($errors->has('pincode'))
									<span class="error">
										{{ $errors->first('pincode') }}
									</span>
								@endif
							</div>
							
							
							<div class="form-group">
								<label for="address">{{ __('address') }}<span class="text-danger">&#042;</span></label>
								{!! Form::textarea('address', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter address'), 'id' => 'address')) !!}
								@if ($errors->has('address'))
									<span class="error">
										{{ $errors->first('address') }}
									</span>
								@endif
							</div>
							
							
							
							<input class="btn btn-primary" type="submit" value="Submit">
							<a class="btn btn-info" href="{{ request()->query('redirect') }}">Cancel</a>
						</fieldset>
					{!! Form::close() !!}
					
									
					
				</div>
				
				

		</div>
	</div>
	
	<div class="col-lg-6">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">{{ __('Saved Addresses') }}</h4>
					
									<div class="row">
									<?php


									foreach($addresses as $k=>$address){
										//print_r($package);
										?>
										<div class="col-lg-12">
											<label style="text-transform: capitalize;">
											
											{{$address['address_mode']}}
											</label>
											<p><strong>{{$address['name']}}</strong><br>
											Ph: {{$address['mobile']}}<br>
											Email: {{$address['email']}}<br>
											Address: {{$address['address']}}, {{$address['city']}}, {{$address['state']}}-{{$address['pincode']}}
											
											
											</p>
											
											
										</div>
									<?php
									}
									?>
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
	
	$('#state_id').on('change',function(){
		
		$.ajax({
		  url: "{{route('admin.user.getCityByStateId')}}",
		  type: 'post',
		  data: {
			  state_id: $(this).val(),
			  _token: '{{csrf_token()}}',
		  },
		  dataType: 'html',
		  success: function(result) {
			 $("#show_city").html(result);
			
		  }
		});
	});
	
});


</script>
@endsection