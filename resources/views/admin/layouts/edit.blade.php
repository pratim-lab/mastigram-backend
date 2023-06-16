@extends('layouts.admin.app')

@section('content')
<script src="{{ asset('js/admin/misc.js') }}"></script>
<script src="{{ asset('js/admin/tinymce.min.js') }}"></script>
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
					{!! Form::model($layout, ['route' => ['admin.layout.edit', base64_encode($layout->id).'?redirect='.urlencode(Request::query('redirect'))], 'id' => 'home_page_feature_categoriesAdd', 'class' => 'cmxform', 'method' => 'PUT', 'novalidate'] ) !!}
						
						<fieldset>
							<h4 class="card-title">{{ __('First Section Explore') }}</h4>
							<div class="form-group">
								<label for="first_section_title">{!! __('Title') !!}<span class="text-danger">&#042;</span></label>
								{!! Form::text('first_section_title', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter title'), 'id' => 'first_section_title')) !!}
								@if ($errors->has('first_section_title'))
									<span class="error">
										{{ $errors->first('first_section_title') }}
									</span>
								@endif
							</div>
							@php 
								$first_cat = explode(",",$layout->first_cat_type);
								$category_options = array(
									'DD'=>"Today's deals (Deal of the day)",
									'TO'=>'Top Offers',
									'PD' => 'Price Dropped',
									'CD'=> 'Crazy deals and extra savings',
									'TD' => 'Trending deals',
									'LP'=>'Lowest Ever Priced Items',
								);
							@endphp
							<label style="margin-bottom:25px" for="category_id">{{ __('Select category type') }}</label>
							@foreach($category_options as $key=>$cat)
							<div class="form-group" style="margin-left: 25px;">
								<input @if(in_array($key,$first_cat)) checked="true" @endif name="first_cat_type[]" type="checkbox" value="{{$key}}" style="width: 18px;height: 18px;margin-right: 20px;" />
								<label for="category_id">{{ $cat }}</label>
								 
							</div>	
							@endforeach

	

							<h4 class="card-title">{{ __('Second Section Explore') }}</h4>
							<div class="form-group">
								<label for="second_section_title">{!! __('Title') !!}<span class="text-danger">&#042;</span></label>
								{!! Form::text('second_section_title', null, array('required', 'class'=>'form-control', 'placeholder' => __('Enter title'), 'id' => 'second_section_title')) !!}
								@if ($errors->has('second_section_title'))
									<span class="error">
										{{ $errors->first('second_section_title') }}
									</span>
								@endif
							</div>

							@php 

							$second_cat = explode(",",$layout->second_cat_type);
							
							$category_options_s = array(
								'MMTC'=>"MMTC PAMP",
								'SILVERA'=>'Silvera'
							);
							

							@endphp
							<label style="margin-bottom:25px" for="category_id">{{ __('Select category type') }}</label>
							@foreach($category_options_s as $key=>$cat)
							<div class="form-group" style="margin-left: 25px;">
								<input @if(in_array($key, $second_cat)) checked="true" @endif name="second_cat_type[]" type="checkbox" value="{{$key}}" style="width: 18px;height: 18px;margin-right: 20px;" />
								<label for="category_id">{{ $cat }}</label>
								 
							</div>	
							@endforeach
							<input class="btn btn-primary" type="submit" value="Submit">
							<!-- <a class="btn btn-info" href="{{ route('admin.home_page_feature_category.list') }}">Cancel</a> -->
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
    $("#home_page_feature_categoriesAdd").validate({
		errorPlacement: function(label, element) {
			label.addClass('mt-2 text-danger');
			label.insertAfter(element);
		},
		highlight: function(element, errorClass) {
			$(element).parents('.form-group').addClass('has-danger')
			$(element).addClass('form-control-danger')
		}
  	});
});
</script>
@endsection
