@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('js/admin/misc.js') }}"></script>
<script src="{{ asset('js/admin/tinymce.min.js') }}"></script>
<div class="content-wrapper">
	{!! Form::model($settings, ['route' => 'admin.settings', 'id' => 'websiteSettings', 'class' => '', 'method' => 'PUT'] ) !!}
	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-body">
					@foreach (['danger', 'warning', 'success', 'info'] as $msg)
		                @if(Session::has('alert-' . $msg))
		                    <h4 class="font-weight-light alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</h4>
		                @endif
		            @endforeach
						<h4 class="card-title">{{ __('Website Settings') }}</h4>
						<fieldset>
							<div class="form-group">
								<label for="website_name">{{ __('Website Name') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('website_name', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter website name'), 'id' => 'website_name')) !!}
							</div>
							<div class="form-group">
								<label for="contact_number">{{ __('Contact Number') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('contact_number', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter contact number in which users will contact you'), 'id' => 'contact_number')) !!}
							</div>
							<div class="form-group">
								<label for="contact_email">{{ __('Contact Email') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('contact_email', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter Email ID that will be used by the users to contact you from websites contact form'), 'id' => 'contact_email')) !!}
							</div>
							<div class="form-group">
								<label for="address">{{ __('Address') }}<span class="text-danger">&#042;</span></label>
								{!! Form::textarea('address', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter your main office address'), 'id' => 'address')) !!}
							</div>
							
						<!-- 	<div class="form-group">
								<label for="bank_transfer_details">{{ __('Bank Transfer Detail') }}<span class="text-danger">&#042;</span></label>
								{!! Form::textarea('bank_transfer_details', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter Bank Transfer Detail'), 'id' => 'bank_transfer_details')) !!}
							</div> -->
							<div class="form-group">
								<label for="address">{{ __('Header Top Notify Text') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('header_top_text', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter Header Top Notify Text'), 'id' => 'header_top_text')) !!}
							</div>
							<div class="form-group">
								<label for="address">{{ __('Product Delivery Error Message') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('product_delivery_error_message', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter delivery error message'), 'id' => 'product_delivery_error_message')) !!}
							</div>
							<!-- <div class="form-group">
								<label for="address">{{ __('Current Silver Price (per gram)') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('current_silver_price', null, array('required', 'class'=>'form-control', 'oninput'=>"this.value=this.value.replace(/[^0-9,'.']/g,'');",'placeholder' => __('Enter delivery error message'), 'id' => 'current_silver_price')) !!}
							</div> -->
							<!-- <div class="form-group">
								<label for="address">{{ __('Current Gold Price (per gram)') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('current_gold_price', null, array('required', 'class'=>'form-control', 'oninput'=>"this.value=this.value.replace(/[^0-9,'.']/g,'');", 'placeholder' => __('Enter current gold price'), 'id' => 'current_gold_price')) !!}
							</div> -->
							<!-- <div class="form-group">
								<label for="address">{{ __('Buy back metal price/gm for Silvera') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('buyback_silvera_price', null, array('required', 'class'=>'form-control', 'oninput'=>"this.value=this.value.replace(/[^0-9,'.']/g,'');", 'placeholder' => __('Enter metal price'), 'id' => 'buyback_silvera_price')) !!}
							</div> -->
							<!-- <div class="form-group">
								<label for="address">{{ __('Buy back metal price/gm for MMTC Pamp') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('buyback_mmtc_price', null, array('required', 'class'=>'form-control', 'oninput'=>"this.value=this.value.replace(/[^0-9,'.']/g,'');",'placeholder' => __('Enter metal price'), 'id' => 'buyback_mmtc_price')) !!}
							</div> -->
							
							<div class="form-group">
								<label for="banner_offer">{{ __('Banner Offer Text') }}</label>
								{!! Form::text('banner_offer', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter banner offer text'), 'id' => 'banner_offer')) !!}
							</div>
							<!-- <div class="form-group">
								<label for="banner_offer">{{ __('Refer & earn point') }}</label>
								{!! Form::text('refer_point', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter refer & earn point'), 'id' => 'refer_point')) !!}
							</div>
							<div class="form-group">
								<label for="banner_offer">{{ __('Joining point') }}</label>
								{!! Form::text('joining_point', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter joining point'), 'id' => 'joining_point')) !!}
							</div> -->
							
						<!-- 	<div class="form-group">
								<label for="address">{{ __('Payment gateway charge(%)') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('payment_geteway_percentage', null, array('required', 'class'=>'form-control', 'oninput'=>"this.value=this.value.replace(/[^0-9,'.']/g,'');", 'placeholder' => __('Enter payment gateway charge'), 'id' => 'current_gold_price')) !!}
							</div> -->
							
                           <!--  <div class="form-group">
								<label for="rssfeed_url">{{ __('Website RSS Feed') }}</label>
								{!! Form::text('rssfeed_url', null, array('class'=>'form-control', 'placeholder' => __('Enter websites rss feed'), 'id' => 'rssfeed_url')) !!}
							</div> -->
							<!-- <div class="form-group">
								<label for="facebook_id">{{ __('Facebook Login ID') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('facebook_id', null, array('required', 'class'=>'form-control', 'placeholder' => __('Facebook login ID. Used in facebook authentication'), 'id' => 'facebook_id')) !!}
							</div> -->
							<!-- <div class="form-group">
								<label for="google_id">{{ __('Google Login ID') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('google_id', null, array('required', 'class'=>'form-control', 'placeholder' => __('Google login ID. Used in google authentication'), 'id' => 'google_id')) !!}
							</div> -->
							<div class="form-group">
								<label for="google_id">{{ __('WhatsApp number') }}<span class="text-danger">&#042;</span></label>
								{!! Form::text('whatapp_number', null, array('required', 'class'=>'form-control', 'placeholder' => __('WhatsApp number'), 'id' => 'whatapp_number')) !!}
							</div>
							<!-- <input class="btn btn-primary" type="submit" value="Submit"> -->
						</fieldset>
					
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card mb-3">
		        <div class="card-body">
		            <fieldset>
					<div class="form-group">
		                <label for="meta_description">
		                <small><i>Published on: <strong>{{ date("F j, Y",strtotime($settings->created_at))  }}</strong> </i></small> 
						<br><br>
						<small><i>Last Update on: <strong>{{ date("F j, Y",strtotime($settings->updated_at))  }} </strong></i></small>
						</label>
					</div>
					<input class="btn btn-primary" type="submit" value="Update setting">
		              <a class="btn btn-info" href="{{ route('admin.dashboard') }}">Back To Home</a>
					</fieldset>
				</div>
			  </div>
			  <div class="card mb-3">
		        <div class="card-body">
		            <h4 class="card-title">{{ __('Social Media link') }}</h4>
					<fieldset>
						<div class="form-group">
								<label for="facebook_link">{{ __('Website Facebook Link') }}</label>
								{!! Form::text('facebook_link', null, array('class'=>'form-control', 'placeholder' => __('Enter websites facebook link'), 'id' => 'facebook_link')) !!}
							</div>
							<!-- <div class="form-group">
								<label for="google_plus_link">{{ __('Website Google Plus Link') }}</label>
								{!! Form::text('google_plus_link', null, array('class'=>'form-control', 'placeholder' => __('Enter websites google plus link'), 'id' => 'google_plus_link')) !!}
							</div> -->
							<div class="form-group">
								<label for="twitter_link">{{ __('Website Twitter Link') }}</label>
								{!! Form::text('twitter_link', null, array('class'=>'form-control', 'placeholder' => __('Enter websites twitter link'), 'id' => 'twitter_link')) !!}
							</div>
							<!-- <div class="form-group">
								<label for="pinterest_link">{{ __('Website Pinterest Link') }}</label>
								{!! Form::text('pinterest_link', null, array('class'=>'form-control', 'placeholder' => __('Enter websites pinterest link'), 'id' => 'pinterest_link')) !!}
							</div> -->
							<div class="form-group">
								<label for="instagram_link">{{ __('Website Instagram Link') }}</label>
								{!! Form::text('instagram_link', null, array('class'=>'form-control', 'placeholder' => __('Enter websites instagram link'), 'id' => 'instagram_link')) !!}
							</div>
                            <!-- <div class="form-group">
								<label for="youtube_link">{{ __('Website Youtube Link') }}</label>
								{!! Form::text('youtube_link', null, array('class'=>'form-control', 'placeholder' => __('Enter websites youtube link'), 'id' => 'youtube_link')) !!}
							</div> -->
					</fieldset>
				</div>
			  </div>
			  <div class="card mb-3">
		        <div class="card-body">
		            <h4 class="card-title">{{ __('Currency setting') }}</h4>
					<fieldset>
						<div class="form-group">
							<label for="default_currency">{{ __('Websites Default Currency') }}<span class="text-danger">&#042;</span></label>
							{!! Form::text('default_currency', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter your websites currency'), 'id' => 'default_currency')) !!}
						</div>
						<div class="form-group">
							<label for="default_currency">{{ __('Currency api key') }}</label>
							{!! Form::text('currency_api_key', null, array('class'=>'form-control', 'placeholder' => __('Enter your currency api key'), 'id' => 'currency_api_key')) !!}
						</div>
						<div class="form-group">
							<label for="default_currency">{{ __('Currency api url') }}</label>
							{!! Form::text('currency_api_url', null, array('class'=>'form-control', 'placeholder' => __('Enter your api url'), 'id' => 'currency_api_url')) !!}
						</div>
					</fieldset>
				</div>
			</div>
			<!-- <div class="card mb-3">
		        <div class="card-body">
		            <h4 class="card-title">{{ __('Payment setting') }}</h4>
					<fieldset>
							@php
								$paymentModes = array(
									'0' => 'Test',
									'1' => 'Live'
								);
							@endphp
							<div class="form-group">
								<label for="payment_mode">{{ __(' Mode') }}<span class="text-danger">&#042;</span></label>
								{{Form::select('payment_mode', $paymentModes, null, array('required','class'=>'form-control selectpicker','name'=>'payment_mode'))}}
							</div>
						<div class="form-group">
							<label for="default_currency">{{ __('Api key') }}</label>
							{!! Form::text('currency_api_key', null, array('class'=>'form-control', 'placeholder' => __('Enter your currency api key'), 'id' => 'currency_api_key')) !!}
						</div>
						<div class="form-group">
							<label for="default_currency">{{ __('Api url') }}</label>
							{!! Form::text('currency_api_url', null, array('class'=>'form-control', 'placeholder' => __('Enter your api url'), 'id' => 'currency_api_url')) !!}
						</div>
					</fieldset>
				</div>
			</div> -->
		</div>
	</div>
	{!! Form::close() !!}
</div>
<script type="text/javascript">
 if ($("#bank_transfer_details").length) {
      tinymce.init({
          selector: '#bank_transfer_details',
          height: 150,
          theme: 'modern',
          plugins: [
              'advlist autolink lists link image charmap print preview hr anchor pagebreak',
              'searchreplace wordcount visualblocks visualchars code fullscreen',
              'insertdatetime media nonbreaking save table contextmenu directionality',
              'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
          ],
          toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
          toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
          image_advtab: true,
          /*templates: [{
                  title: 'Test template 1',
                  content: 'Test 1'
              },
              {
                  title: 'Test template 2',
                  content: 'Test 2'
              }
          ],*/
          content_css: [],
          init_instance_callback: function (editor) {
            editor.on('keydown', function (e) {
              $('#content-error').hide();
            });
          }
      });
    }

$.validator.setDefaults({
        submitHandler: function(form) {
            form.submit();
        }
});
$(function() {
    // validate the comment form when it is submitted
    $("#websiteSettings").validate({
    	rules: {
            contact_email: {
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