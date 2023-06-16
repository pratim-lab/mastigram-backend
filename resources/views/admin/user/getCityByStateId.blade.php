
<label for="confirm_password">{{ __('City') }}<span class="text-danger">&#042;</span></label>
{{Form::select('city_id',$cities,null,array('required','class'=>'form-control','id'=>'city_id', )) }}