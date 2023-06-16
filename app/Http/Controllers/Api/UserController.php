<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\State;
use App\Model\Order;
use App\Model\Country;
use App\Model\UserAddress;
use App\Model\City;
use App\Model\Logtest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use App\Mail\EmailSendTestResult;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DateTime;
use DateTimeZone;

class UserController extends ApiController
{

	
	
	/**
     * Update User Profile
     *
     * @param  [string][required] name
     * @param  [string][required] email
     * @param  [string][required] mobile
     * @param  [int][required]    country
     */
	public function editProfile(Request $request){
		$user = Auth::user();
		
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			// 'email' => 'required|email|unique:users,email,'.$user->id,
			// 'mobile' => 'required|unique:users,mobile,'.$user->id,
			// 'country' => 'required',
		]);
		
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors());
		}
		
		$user->name = $request->name;
	    $user->mobile = $request->mobile;
		// $user->email = $request->email;
		// $user->countries_id = $request->country;
		$user->save();
		if($request->email){
			if($request->email !== Auth::user()->email){
				Auth::user()->update(['email_verified'=>'N','email'=>$request->email,'email_token'=>base64_encode($request->email).rand(1111,9999)]);
				$user = Auth::user();
				Mail::to($user->email)->queue(new EmailVerification($user));
			}else{
				//dd("same");
			}
		}

		$data = array(
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'dob' => $user->dob,
			'mobile' => $user->mobile,
			'social_name' => $user->social_type,
			'country' => '',
			'refer_code' => $user->refer_code
		);
		return $this->sendSuccess($data,'','User updated successfully.');
		
	}
	
	
	/**
     * Change Password
     *
     * @param  [string][required] current_password
     * @param  [string][required] password
     * @param  [string][required] confirm_password
     */
	public function changePassword(Request $request){
		$user = Auth::user();
		$validator = Validator::make($request->all(), [
			'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
				if (!\Hash::check($value, $user->password)) {
					return $fail(__('The current password is incorrect.'));
				}
			}],
			'password' => 'required|min:6',
			'confirm_password' => 'required|same:password'
		]);
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors());
		}
		$user->password = Hash::make($request->password);
		$user->save();
		return $this->sendSuccess([],'','Your password has been changed successfully.');
		
	}

	public function changePasswordLogin(Request $request){
		$user = Auth::user();
		$validator = Validator::make($request->all(), [
			'password' => 'required|min:6',
			'confirm_password' => 'required|same:password'
		]);
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors());
		}
		$user->password = Hash::make($request->password);
		$user->auto_password = "0";
		$user->save();
		return $this->sendSuccess([],'','Your password has been changed successfully.');
		
	}
	
	/**
     * My Address
     *
     */
	protected function addressData()
	{
		$user = Auth::user();
		$addressesObj = UserAddress::orderBy('id','DESC')->where(['user_id' => $user->id])->get();
		$addresses = [];
		foreach($addressesObj as $address){
			$addresses[] = array(
		 		'id' => $address->id,
		 		'name' => $address->name,
		 		'city' => $address->city,
		 		'state' => $address->state,
		 		'pincode' => $address->pincode,
		 		'country' => $address->country,
		 		'address' => $address->address,
		 		'mobile' => $address->mobile,
		 		'email' => $address->email,
		 		'address_mode' => $address->address_mode
		 	);
		}
		return $addresses;
	}

	public function myAddress(){
		
		return $this->sendSuccess($this->addressData(),'','address fetch');
		
	}
	
	/**
     * My Address Add
     *
     * @param  [string][required] name
     * @param  [string][required] country
     * @param  [string][required] city
     * @param  [string][required] state
     * @param  [string][required] pincode
     * @param  [string][required] address
     * @param  [int][required]    mobile
     * @param  [string][required] email
     * @param  [string][required] address_mode
     * @param  [string][required] address_type
     */
	public function myAddressAdd(Request $request){
		
		//dd($request->all());
		$validator = Validator::make($request->all(), [
			'country' => 'required',
			'name' => 'required',
			'email' => 'required|email',
			'city' => 'required',
			'state' => 'required',
			// 'pincode' => 'required',
			'mobile' => 'required',
			'address' => 'required',
			'address_mode' => 'required',
			'address_type' => 'required',
		]);
		
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = $validator->errors();
			return response()->json($this->apiResponse);
		}
		
		$user = Auth::user();
		$city_exist = City::where([['name','LIKE','%'.$request->city.'%']])->count();	
		if($city_exist){
			$userAddress = UserAddress::create(array_merge(['user_id'=>$user->id],$request->all()));
			if($userAddress){
				return $this->sendSuccess($this->addressData(),'','all address');
			}else{
				return $this->sendErrors('Something went wrong! Please try again later.');
				
			}
		}else{
			return $this->sendErrors('Sorry! We are not shipping in this area currently.');
		}
	}
	
	/**
     * My Address Edit
     *
     * @param  [string][required] name
     * @param  [string][required] country
     * @param  [string][required] city
     * @param  [string][required] state
     * @param  [string][required] pincode
     * @param  [string][required] address
     * @param  [int][required]    mobile
     * @param  [string][required] email
     * @param  [string][required] address_type
     * @param  [string][required] address_mode
     */
	public function myAddressEdit($id, Request $request){
		$user = Auth::user();
		$myAddress = UserAddress::where(['id' => $id, 'user_id' => $user->id, 'address_type' => $request->address_type])->first();
		if(!$myAddress){
			$this->apiResponse['errorMessage'] = 'Address is not found';
			return response()->json($this->apiResponse);
		}
		
		$validator = \Validator::make($request->all(), [
			'country' => 'required',
			'name' => 'required',
			'email' => 'required|email',
			'city' => 'required',
			'state' => 'required',
			'pincode' => 'required',
			'mobile' => 'required',
			'address_mode' => 'required',
			'address' => 'required'
		]);
		
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = getErrors($validator);
			return response()->json($this->apiResponse);
		}
		
		$arr = [
			'name' => $request->name,
			'country_id' => $request->country,
			'city_id' => $request->city,
			'state_id' => $request->state,
			'pincode' => $request->pincode,
			'address' => $request->address,
			'mobile' => $request->mobile,
			'email' => $request->email,
			'address_mode' => $request->address_mode,
		];
		
		if($myAddress->update($arr)){
			$this->apiResponse['error'] = false;
			$this->apiResponse['data'] = [
				'message' => 'Address updated successfully'
			];
			
		}else{
			$this->apiResponse['errorMessage'] = 'Something went wrong! Please try again later.';
		}
		
		return response()->json($this->apiResponse);
		
	}
	
	/**
     * My Profile
     *
     */
	public function myProfile(){
		$user = Auth::user();
		
		$data = array(
			'id' => $user->id,
			'farm_name' => $user->name,
			'email' => $user->email,
			'no_of_cow' => $user->no_of_cow,
			'country' => $user->country,
			'alert_hour' => $user->alert_hour
		);
		
		return $this->sendSuccess($data,'','user data');
	}
	/**
     * Change setting
     *
     */
	public function changeProfileSetting(Request $request){
		$user = Auth::user();
		$validator = \Validator::make($request->all(), [
			'alert_hour' => 'required'
		]);
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors());
		}
		$user->alert_hour = $request->alert_hour;
		$user->save();
		
		$data = array(
			'id' => $user->id,
			'farm_name' => $user->name,
			'email' => $user->email,
			'no_of_cow' => $user->no_of_cow,
			'country' => $user->country,
			'alert_hour' => $user->alert_hour
		);
		return $this->sendSuccess($data,'','Setting updated successfully.');
		
	}
	/**
     * saveDeviceToken
     *
     */
	public function saveDeviceToken(Request $request){
		$user = Auth::user();
		$validator = \Validator::make($request->all(), [
			'deviceToken' => 'required',
		]); 
		if ($validator->fails()){
			
			return $this->sendErrors('validation error',$validator->errors()); 
		}
		$user->device_token = $request->deviceToken;
		if($user->save()){
			return $this->sendSuccess([],'','Device token updated successfully.');
		}else{
			return $this->sendErrors('Somthing went wrong!'); 
		}
	}
	
	
	/**
     * Log Test
     *
     */
	
	public function logTest(Request $request){
		$user = Auth::user();
		$validator = \Validator::make($request->all(), [
			'cow_no' => 'required',
			'test_date' => 'required',
			'test_time' => 'required',
			'alert' => 'required',
			'current_time' => 'required',
		]); 
		if ($validator->fails()){
			
			return $this->sendErrors('validation error',$validator->errors()); 
		}
			$logtest = new Logtest;
			$logtest->cow_no = $request->cow_no;
			$logtest->test_date = $request->test_date;
			$logtest->test_time = $request->test_time;
			 // convert date time to utc
			$time = $request->current_time;//'2023-02-16T00:53:24+05:30';
			$current_time = date('Y-m-d H:i:s',strtotime(date($time)));
			$test_date_time = $request->test_date.' '.$request->test_time;
			$current_time_str = strtotime($current_time);
			$test_date_time = strtotime($test_date_time);
			$interval  = abs($current_time_str - $test_date_time);
			// difference between app current time and test date time
			$minutes   = round($interval / 60);
			// sub tract from user alert time hours
			$alert_hour = $user->alert_hour;
			$alert_hour_minutes = ($alert_hour * 60);
			/// UTC difference
			$utc_difference = ($alert_hour_minutes-$minutes);
			$alert_date_time = date("Y-m-d H:i:s", strtotime('+'.$utc_difference.'  mins'));
			$logtest->alert_date_time = $alert_date_time;
			$logtest->current_time = $current_time;
			$logtest->alert = $request->alert;
			$logtest->user_id = $user->id;
			$logtest->updated_at = date('Y-m-d H:i:s');
			$logtest->created_at = date('Y-m-d H:i:s');
		
		
 		if($logtest->save()){
			return $this->sendSuccess([],'','Test Log Successfully Completed!');
		}else{
			return $this->sendErrors('Something went wrong! Please try again later.');
		}
		
		
	}
	
	public function logTestResult(Request $request){ 
		$user = Auth::user();
		
		$validator = \Validator::make($request->all(), [
			'test_id' => 'required',
			'test_result' => 'required',
			/* 'treatment' => 'required', */
			/* 'product_name' => 'required', */
			/* 'withhold' => 'required', */
			'result_date' => 'required',
			'result_time' => 'required',
		]); 
		if ($validator->fails()){
			
			return $this->sendErrors('validation error',$validator->errors()); 
		}
		$logtest = Logtest::find($request->test_id);
		$logtest->test_result = $request->test_result;
		$logtest->treatment = isset($request->treatment)?$request->treatment:'';
		$logtest->product_name = isset($request->product_name)?$request->product_name:'';;
		$logtest->withhold = isset($request->withhold)?$request->withhold:'';
		$logtest->treatment_note = isset($request->treatment_note)?$request->treatment_note:'';
		$logtest->result_date = $request->result_date;
		$logtest->result_time = $request->result_time;
		$logtest->updated_at = date('Y-m-d H:i:s');
		
 		if($logtest->save()){
			return $this->sendSuccess([],'','Result Log Successfully Completed!');
		}else{
			return $this->sendErrors('Something went wrong! Please try again later.');
		}
		
		
	}
	
	public function getTestById(Request $request){
		$user = Auth::user();
		$validator = \Validator::make($request->all(), [
			'test_id' => 'required',
			
		]); 
		if ($validator->fails()){
			
			return $this->sendErrors('validation error',$validator->errors()); 
		}
		$test = Logtest::where(['id' => $request->test_id, 'user_id' => $user->id])->first();
		
		
 		if($test){
			return $this->sendSuccess($test,'','Test Log Detail');
		}else{
			return $this->sendErrors('Something went wrong! Please try again later.');
		}
		
		
	}
	
	
	public function getTestList(Request $request){
		$user = Auth::user();
		 
		$orWhere = array();
        $where[] = ['user_id','=',$user->id];
		if(isset($request->result_type) && $request->result_type <> ''){
			if($request->result_type == 'active'){
				 $where[] = ['result_date', '=', null];
			}else{
				 $where[] = ['result_date', '!=', null]; 
			}
		}
		if(isset($request->test_result ) && $request->test_result  <> ''){
			$where[] = ['test_result', '=', $request->test_result];
		}
		$whereBetween = '';
		if($request->from_date <>'' && $request->to_date<>''){
			$whereBetween = [$request->from_date, $request->to_date];
		}
		$logtest = Logtest::where($where)
			->where(function($query) use ($orWhere,$whereBetween){
				// creating "OR" queries for search
				if($whereBetween<>''){
					$query->whereBetween('test_date', $whereBetween);
				}
				foreach($orWhere as $key => $where){
					if($key == 0){
						$query->where([$where]);
					}else{
						$query->orWhere([$where]);
					}
				}
			})
			->when($request->sort && $request->direction, function($query) use ($request){
				$query->orderBy($request->sort, $request->direction);
			}, function($query){
				$query->orderBy('test_date', 'desc');
				$query->orderBy('test_time', 'desc');
			})
			->paginate(2000);
		if($logtest){
			return $this->sendSuccess($logtest,'','result fetched');
		}else{
			return $this->sendErrors('Something went wrong! Please try again later.');
		}
	}
	
	public function sendTestResultMail(Request $request){
		$validator = \Validator::make($request->all(), [
			'from_date' => 'required',
			'to_date' => 'required',
			'email' => 'required',
			
			
		]); 
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors()); 
		}
		
		$string = str_replace('\n','', $request->email);
		$string = str_replace(' ','', $string);
		$emailIds = explode(';',$string);
		
		
		$user = Auth::user();
		$where[] = ['user_id', '=', $user->id];
		   $logtest = Logtest::select('cow_no','test_date','test_time','result_date','result_time','test_result','treatment','product_name','withhold','treatment_note')
		   ->whereBetween('test_date', [$request->from_date, $request->to_date])
		   ->where($where)
		   ->get();
		   $logtest = $logtest->toArray();
		 if($logtest){
			$file_name = 'Mastigram-'.time().'.csv';
			//header('Content-Type: text/csv; charset=utf-8');  
			//header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen('public/'.$file_name, "a");  
			fputcsv($output, array('Cow No', 'Test Date', 'Test Time', 'Result Date', 'Result Time','Test Result','Treatment','Product Name','Withhold','Treatment Note'));  
			foreach($logtest as $k => $row)  
			{  
			   fputcsv($output, $row);  
			}  
			fclose($output); 
			
			try {
					$message['subject'] = 'Test Result Download';
					$message['name'] = $user->name;
					$message['message'] = 'Please Find the attachment to download. ';
					//$user->email // 
					//$user->email
					Mail::to($emailIds)
					->queue(new EmailSendTestResult($message,$file_name));
					if(file_exists(public_path($file_name))){
						unlink(public_path($file_name));
					}
				} catch (\Exception $e) {
					 $e->getMessage();
				}
			return $this->sendSuccess([],'','Email sent successfully');
		}else{
			return $this->sendErrors('Sorry! No record found.');
		
		}		  
	}
	
	
	
	public function shareTestResultMail(Request $request){
		$validator = \Validator::make($request->all(), [
			'email' => 'required',
			'testIds'=>'required',
		]); 
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors()); 
		}
		
		$string = str_replace('\n','', $request->email);
		$string = str_replace(' ','', $string);
		
		$emailIds = explode(';',$string);
		/* print"<pre>";
		print_r($emailIds);
		die; */
		$testIds = array_filter($request->testIds);
		if(!empty($testIds)){
		$user = Auth::user();
		
		$where[] = ['user_id', '=', $user->id];
		   $logtest = Logtest::select('cow_no','test_date','test_time','result_date','result_time','test_result','treatment','product_name','withhold','treatment_note')
		   ->whereIn('id', $testIds)
		   ->where($where)
		   ->get();
		   $logtest = $logtest->toArray();
		  // dd($logtest);
		 if($logtest){
			$file_name = 'Mastigram-'.time().'.csv';
			//header('Content-Type: text/csv; charset=utf-8');  
			//header('Content-Disposition: attachment; filename='.$file_name);  
			$output = fopen('public/'.$file_name, "a");  
			fputcsv($output, array('Cow No', 'Test Date', 'Test Time', 'Result Date', 'Result Time','Test Result','Treatment','Product Name','Withhold','Treatment Note'));  
			foreach($logtest as $k => $row)  
			{  
			   fputcsv($output, $row);  
			}  
			fclose($output); 
			
			try {
					$message['subject'] = 'Test Result Shared By '.$user->name;
					$message['name'] = 'User';
					$message['message'] = 'Please Find the attachment to download. ';
					//$user->email // 'krishanu.dassnagar@gmail.com'
					/* Mail::to($request->email) */
					Mail::to($emailIds)
					->queue(new EmailSendTestResult($message,$file_name));
					if(file_exists(public_path($file_name))){
						unlink(public_path($file_name));
					}
				} catch (\Exception $e) {
					 $e->getMessage();
				}
			return $this->sendSuccess([],'','Email sent successfully');
		}else{
			return $this->sendErrors('Sorry! No record found.');
		
		}
		}		
	}
	
	public function testMultipleDelete(Request $request){
		$validator = \Validator::make($request->all(), [
			'testIds'=>'required',
		]); 
		if ($validator->fails()){
			return $this->sendErrors('validation error',$validator->errors()); 
		}
		$testIds = array_filter($request->testIds);
		if(!empty($testIds)){
			$user = Auth::user();
			$where[] = ['user_id', '=', $user->id];
			$logtest = Logtest::whereIn('id', $testIds)
		   ->where($where)
		   ->delete();
		   return $this->sendSuccess([],'','Test deleted successfully!');
		}else{
			return $this->sendErrors('Something went wrong! Please try again later.');
		}
	}
	
	/**
     * Logout
     *
     */
	public function logout(Request $request){
		if (Auth::check()) {
		   $request->user()->token()->delete();
		   $user = Auth::user();
		   $user->api_token = null;
		   $user->save();
		}
		
        $this->apiResponse['error'] = false;
		$this->apiResponse['data'] = [
			'message' => 'You have successfully logged out'
		];
		return response()->json($this->apiResponse);
	}
	
	private function group_by_kk($key, $data) {
		$result = array();

		foreach($data as $val) {
			if(array_key_exists($key, $val)){
				$result[$val[$key]][] = $val;
				
				
			}
		}

		return $result;
	}
	
	
}
