<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Model\Setting;
use App\Model\WalletBalance;
use App\Model\User;
use App\Model\Logtest;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\AppliedCoupon;
use App\Model\UserSessionData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailVerification;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Model\UserGroupOffer;
use DateTime;
use DateTimeZone;
use Illuminate\Validation\Rules\Password;

class AuthController extends ApiController
{
	
	/**
     * Singup
     *
     * @param  [string]           name
     * @param  [string][required] email
     * @param  [string][required] mobile
     * @param  [string][required] password
     */
	public function signup(Request $request){
		$validator = Validator::make($request->all(), [
			'farm_name' => 'required',
			'no_of_cow' => 'required',
			'email' => 'email|required',
			'password' => ['required', Password::min(6)
						->mixedCase()
						->letters()
						->numbers()
						->symbols()
						->uncompromised(),
					],
			
			/* 'required|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/', */
			//'confirm_password' => 'required|same:password',
			
			'country' => 'required',
		]);
		
		if ($validator->fails()){
			return $this->sendErrors($validator->errors()->first(),
			$validator->errors()->first());
		}
		
		$user = User::where('email',$request->email)->first();
		if($user){
			return $this->sendErrors('The email id already exist!');
		}
		$password = $request->password;
		$user = User::create([
			'name' => $request->has('farm_name') ? $request->farm_name : '',
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'auto_password' => 1,
			'alert_hour' => 7,
			'show_password'=>$password,
			'no_of_cow' => $request->no_of_cow,
			'country' => $request->country,
			'email_token' => base64_encode($request->email).rand(1111,9999),
			'refer_code'=>rand(111111,999999),
			'email_verified'=>'Y',
		]);
		if($user){
			try {
				  Mail::to($user->email)->queue(new EmailVerification($user)); 

				} catch (\Exception $e) {

					 $e->getMessage();
				}
			
			// login
			if(Auth::attempt($request->only('email','password'))){
				$user = Auth::user();
				if($user->is_block != 'N' || $user->status != 'A'){
					return $this->sendErrors('Oops! Your account is not active.');
				}
				$token = $user->createToken('Mastigram')-> accessToken;
				$user->api_token = $token;
				$user->otp_count = 0;
				$user->last_login = date('Y-m-d H:i:s');
				$user->save();
				$user_data = [
					'id'=>$user->id,
					'email'=>$user->email,
					'farm_name'=>$user->name,
					'auto_password'=>$user->auto_password,
					'no_of_cow'=>$user->no_of_cow,
					'country'=>$user->country, 
				];
				return $this->sendSuccess($user,$token,'Success! Account has been created');
			}else{
				return $this->sendErrors('Something went wrong! Please try again later.');
			}
		}else{
			return $this->sendErrors('Something went wrong! Please try again later.');
		}
		
		return $this->sendErrors('Something went wrong! Please try again later.');
		
	}
	
	
	public function sendNotification(Request $request)
    {
		/* $log = Logtest::find(200);
		$log->alert_date_time = date('Y-m-d H:i:s');
		$log->save(); */
		$content = date('Y-m-d H:i:s')."\r\n";
		$fp = fopen('public/notification.txt', "wb"); 
		fwrite($fp,$content);
		fclose($fp);
		
		$SERVER_API_KEY = 'AAAAJj3isdo:APA91bFNIA9jLVa6BtQh6OSycx2enT21n94yHQQJObnD4D8qQ0JN-XDBdJTJU6YYFbW8RVZdRbg5PalHyMkNA8J1B5ahmuXKPXLRkH0BjbZLHkl4RUvEd1BpAq1pR1O6w41WIPCO7DJU';
		$current= date('Y-m-d H:i:s');
		$oneMinAgo= date('Y-m-d H:i:s', strtotime('-1 min'));
		$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
		 $notyficatins = Logtest::with('user')
			->whereNull('result_date')
			->where('alert','Y')
			->whereBetween ('alert_date_time', [$oneMinAgo,$current])
			->get(); 
		/*  print_r($notyficatins->toArray());
			die; */
        /* $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => 'Mastigram Notification',
                "body" => 'Please Log Pending Test Results',  
            ]
        ]; */
		foreach($notyficatins as $k=>$notyfication){
			if($notyfication->user){
				$data1 ['to'] = $notyfication->user->device_token;
				$data1 ['notification']['title'] = 'Mastigram Notification';
				$data1 ['notification']['body'] = 'Please Log Pending Test Results for COW# '.$notyfication->cow_no;
				$data1 ['data']['test_id'] = $notyfication->id;
				$dataString = json_encode($data1);
				$headers = [
					'Authorization: key=' . $SERVER_API_KEY,
					'Content-Type: application/json',
				];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
				$response = curl_exec($ch);
				print_r($response);
			}
		}
		
    }
	
	public function resend_activation_link(Request $request){
		$validator = \Validator::make($request->all(), [
			'email' => 'required|email',
		]);
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = getErrors($validator);
			return response()->json($this->apiResponse);
		}
		$user = User::where('email',$request->email)->first();
		if($user){
		//send mail verification
			// Mail::to($user->email)->queue(new EmailVerification($user));
			$this->apiResponse['error'] = false;
			$this->apiResponse['data'] = [
				'message' => 'Check your email for an activation link'
			];
		}else{
			$this->apiResponse['errorMessage'] = 'Something went wrong! Please try again later.';
		}
		return response()->json($this->apiResponse);
		
	}
	
	/**
     * Social Login & Signup
     *
     * @param  [string][required] name
     * @param  [string][required] email
     * @param  [string][required] social_type
     * @param  [string][required] social_id
     */
	public function socialLoginSignup(Request $request){
		$validator = \Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'social_type' => 'required',
			'social_id' => 'required'
		]);
		
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = getErrors($validator);
			return response()->json($this->apiResponse);
		}

		$user = User::where('email', $request->email)
				->orWhere(function($query) use($request){
					$query->where('social_type', $request->social_type)
						->where('social_id', $request->social_id);
				})
				->first();
		
		if(!$user){
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'email_verified' => 'Y',
				'password' => Hash::make($request->social_id),
				'social_type' => $request->social_type,
				'social_id' => $request->social_id
			]);
		}
		
		
		if($user && Auth::loginUsingId($user->id)){
			
			$token = $this->generateLoginToken($user);
			$user->api_token = $token;
			$user->save();
			
			//update orders which are stored by session id
			$sessionId = $request->has('session_id') ? $request->session_id : '';
			$this->updateOrders($user->id, $sessionId);
			
			$this->apiResponse['error'] = false;
			$this->apiResponse['data'] = [
				'token' => $token,
				'has_cart' => $this->get_cart_item_details(null, true)
			];
			
		}else{
			$this->apiResponse['errorMessage'] = 'Something went wrong! Please try again later.';
		}
		
		return response()->json($this->apiResponse);
	}
	
	/**
     * Login
     *
     * @param  [string][required] email
     * @param  [string][required] password
     */
	public function login(Request $request){
		$validator = Validator::make($request->only('email','password'), [
			'email' => 'required',
			'password' => 'required'
		]);
		// dd($request->all());
		if ($validator->fails()){
			return $this->sendErrors('Something went wrong! Please try again later',$validator->errors());
		}
		// dd(Auth::attempt($request->only('email','password')));
		$email = $request->email;
		$loginByMobile = false;
		if(is_numeric($email)){
			$user = User::where('mobile', $email)->first();
			// dd($user);
			if(!$user || $user->otp != $request->password || !Auth::loginUsingId($user->id)){
				$this->apiResponse['errorMessage'] = 'OTP is incorrect';
				return response()->json($this->apiResponse);
			}
			Auth::loginUsingId($user->id);
			$loginByMobile = true;
		}elseif (Auth::attempt($request->only('email','password'))) {
			$user = Auth::user();
		}else{
			return $this->sendErrors('Invalid credentials');
			
		}
		
		// if(!$loginByMobile && $user->email_verified == 'N'){
		// 	//Auth::user()->token()->revoke();
		// 	return $this->sendErrors('Oops! Your Email is not verified. Click on the link mailed to you for verification.');
		// }else 
		if($user->is_block != 'N' || $user->status != 'A'){
			return $this->sendErrors('Oops! Your account is not active.');
		}
		
		
		$token = $user->createToken('Mastigram')-> accessToken;
		$user->api_token = $token;
		$user->otp_count = 0;
		$user->last_login = date('Y-m-d H:i:s');
		$user->save();
		
		$user_data = [
			'id'=>$user->id,
			'email'=>$user->email,
			'farm_name'=>$user->name,
			'auto_password'=>$user->auto_password,
			'no_of_cow'=>$user->no_of_cow,
			'country'=>$user->country,
		];
		return $this->sendSuccess($user,$token,'User data fetch');

	}
	
	/*
	* Login OTP Send
	*
	*/
	public function loginOtp(Request $request){
		$messages = [
            'mobile.digits' => 'Enter minimum 10 digit.',
        ];
		$validator = \Validator::make($request->only('mobile'), [
			'mobile' => 'required|numeric|digits:10',
		],$messages);
		
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = getErrors($validator);
			return response()->json($this->apiResponse);
		}
		
		$mobile = $request->mobile;
		$user = User::where(['mobile' => $mobile])->first();
		if(!$user){
			$this->apiResponse['errorMessage'] = 'No user found with this mobile';
			return response()->json($this->apiResponse);
		}
		
		/*if($user->email_verified == 'N'){
			$this->apiResponse['errorMessage'] = 'Oops! Your Email is not verified. Click on the link mailed to you for verification.';
			return response()->json($this->apiResponse);
		}else*/ if($user->is_block != 'N' || $user->status != 'A'){
			$this->apiResponse['errorMessage'] = 'Oops! Your account is not active.';
			return response()->json($this->apiResponse);
		}elseif($user->otp_count >= 3){
			//$this->apiResponse['errorMessage'] = 'Oops! You exceed maximum otp request';
			//return response()->json($this->apiResponse);
		}
		
        $authKey = "332719A8UvTIIIm2n5ee9a3c3P1";
		$code = mt_rand(100000, 999999);
        //API URL
        $url="https://api.msg91.com/api/v5/otp?authkey=$authKey&template_id=5f005e69d6fc0531cf7a6011&extra_param={%22EXP_TIME%22:%2210%22,%20%22COMPANY_NAME%22:%22Silvera%22}&mobile=$mobile&invisible=1&otp=$code";

        // init the resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch))
        {
            $this->apiResponse['errorMessage'] = 'Something went wrong! Please try again later.';
			return response()->json($this->apiResponse);
        }

        curl_close($ch);
		
		
		$user->otp = $code;
		$user->otp_count = ((int) $user->otp_count) + 1;
		$user->last_login = date('Y-m-d H:i:s');
		$user->save();
		
		$this->apiResponse['error'] = false;
		$this->apiResponse['data'] = [
			'message' => 'OTP sent is successful on '. $mobile
		];
		return response()->json($this->apiResponse);
		
	}
	
	
	/**
     * Forgot Password
     *
     * @param  [string][required] email
     */
	public function forgotPassword(Request $request){
		if(!$request->has('email')){
			return $this->sendErrors('The email field is required.');
		}else{
			$user = User::whereEmail($request->email)->first();
			if(!$user){
				return $this->sendErrors('No account found with this email');
			}else if($user->email_verified == 'N'){
				return $this->sendErrors('Your account is not verified yet please click on the verification link sent to you');
			}else if($user->status == 'I'){
				return $this->sendErrors('Your account is temporarily suspended. Contact admin for details');
			}else{
				Mail::to($user->email)->queue(new PasswordReset($user));
				
				return $this->sendSuccess([],'','Password reset code has been mailed to you.');
			}
		}
		
	}
	
	
	/**
     * Reset Password
     *
     * @param  [string][required] token
     * @param  [string][required] password
     * @param  [string][required] confirm_password
     */
	public function resetPassword(Request $request){
		if(!$request->has('otp')){
			$this->apiResponse['errorMessage'] = 'The token is required.';
			return response()->json($this->apiResponse);
		}
		
		$validator = \Validator::make($request->all(), [
			'otp' => 'required',
			'password' => 'required|min:6',
			'confirm_password' => 'required|same:password'
		]);
		
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = getErrors($validator);
			return response()->json($this->apiResponse);
		}
		
		$token = $request->otp;
        $user = User::where('email_token', $token)->first();
		if(!$user){
			$this->apiResponse['errorMessage'] = 'Invalid Otp';
			return response()->json($this->apiResponse);
		}else{
			$user->email_verified = 'Y';
            $user->status         = 'A';
            $user->email_token    = '';
			$user->password = Hash::make($request->password);
			$user->save();
			return $this->sendSuccess([],'','Your password has been changed successfully.');
		}
		
		
		
		
		
	}
	
	/**
     * Verify Email
     *
     * @param  [string][required] token
     */
	public function verifyemail($token, Request $request){
		$user = User::where('email_token',$token)->first();
        if( !empty($user)){
            $user->email_verified = 'Y';
            $user->status         = 'A';
            $user->email_token    = '';
			$user->save();
			
			$this->apiResponse['error'] = false;
			$this->apiResponse['data'] = [
				'message' => 'Email verification successful.'
			];
			
        }else{
			$this->apiResponse['errorMessage'] = 'Invalid token';
        }
		return response()->json($this->apiResponse);
	}
	
	/**
     * Verify Mobile No for new sign up
     *
     * @param  [string][required] token
     */
	 
	public function verifyMobileNumber(Request $request){
		$messages = [
            'mobile.digits' => 'Enter minimum 10 digit.',
        ];
		$validator = \Validator::make($request->only('mobile'), [
			'mobile' => 'required|numeric|digits:10',
		],$messages);
		
		if ($validator->fails()){
			$this->apiResponse['error'] = true;
			$this->apiResponse['data'] = [
				'message' => getErrors($validator)
			];
			return response()->json($this->apiResponse);
		}
		$send_otp = '';
		$new_user = '';
		$mobile = $request->mobile;
		$user = User::where([['mobile', $mobile],['email','signup@silvera-mobileuser.co.in']])->first();
		if($user){
			$send_otp = '1';
		}else{
			$user_exist = User::where([['mobile',$mobile]])->first();
			if($user_exist){
				$this->apiResponse['error'] = true;
				$this->apiResponse['data'] = [
					'message' => 'Mobile No. already exist'
				];
				return response()->json($this->apiResponse);
			}
			
			$user = User::create([
				'name' => '',
				'mobile' => $request->mobile,
				'email' => 'signup@silvera-mobileuser.co.in',
				'password' => Hash::make(rand(1111,9999)),
				'countries_id' => 99, //$request->country,
				'email_token' => base64_encode($request->mobile).rand(1111,9999),
				'refer_code'=>rand(111111,999999),
			]);
			$send_otp = '1';
			
		}
		if($send_otp == '1'){
		
        $authKey = "332719A8UvTIIIm2n5ee9a3c3P1";
		$code = mt_rand(100000, 999999);
        //API URL
        $url="https://api.msg91.com/api/v5/otp?authkey=$authKey&template_id=5f005e69d6fc0531cf7a6011&extra_param={%22EXP_TIME%22:%2210%22,%20%22COMPANY_NAME%22:%22Silvera%22}&mobile=$mobile&invisible=1&otp=$code";

        // init the resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //get response
        $output = curl_exec($ch);
        //Print error if any
        if(curl_errno($ch))
        {
			$this->apiResponse['error'] = true;
			$this->apiResponse['data'] = [
				'message' => 'Something went wrong! Please try again later.'
			];
			return response()->json($this->apiResponse);
        }
        curl_close($ch);
		
		$user->otp = $code;
		$user->otp_count = ((int) $user->otp_count) + 1;
		$user->save();
		
		$this->apiResponse['error'] = false;
		$this->apiResponse['data'] = [
			'message' => 'OTP sent is successful on '. $mobile
		];
		return response()->json($this->apiResponse);
		}
		
	}
	
	/**
     * Verify Mobile verifyMobileOtp for new sign up
     *
     * @param  [string][required] token
     */
	 
	public function verifyMobileOtp(Request $request){
		 $messages = [
            'mobileOtp' => 'Please enter otp',
        ];
		$validator = \Validator::make($request->only('mobileOtp'), [
			'mobileOtp' => 'required|numeric',
		],$messages);
		
		if ($validator->fails()){
			$this->apiResponse['error'] = true;
			$this->apiResponse['data'] = [
				'message' => getErrors($validator)
			];
			return response()->json($this->apiResponse);
		}
		$otp = $request->mobileOtp;
		$otpExist = User::where([['otp',$otp]])->first();
		if($otpExist){
			User::where([['otp',$otp]])->forceDelete();
			$this->apiResponse['error'] = false;
			$this->apiResponse['data'] = [
				'message' => 'Otp is verified successfully!'
			];
			return response()->json($this->apiResponse);
		}else{
			$this->apiResponse['error'] = true;
			$this->apiResponse['data'] = [
				'message' => 'Please enter correct Otp'
			];
			return response()->json($this->apiResponse);
		}
		 
	}
	 
	 
	
	protected function generateLoginToken($user){
		return $user->createToken('MyApp')->accessToken;
	}
	
	protected function updateOrders($userId, $sessionId){
		//if(empty($sessionId)) return false;
		$existing_orders = Order::where([['user_id', $userId],['type', 'cart']])->orderBy('created_at','DESC')->get();
		
		
		if($existing_orders->isEmpty()){
			Order::where('session_id', $sessionId)
			->update([
				'user_id' => $userId
			]);
			
		}else{
			$new_session_order = Order::where([['session_id', $sessionId],['type', 'cart']])->first();
			
			
			// update all the old order_detail table data of the same user with current one and delete applied coupon of older orders
			if(isset($new_session_order->id)){ 
				$new_session_order->update([
					'user_id' => $userId
				]);
				foreach($existing_orders as $existing_order){
					// update order_detail table with new order id
					if($existing_order->session_id <> $sessionId){
						
						
						AppliedCoupon::where('order_id', $existing_order->id)->delete();
						// change on 28-03-2021 if any order_status = OI change the type=order as abundant 
						if($existing_order->order_status == 'OI'){
							Order::where('id', $existing_order->id)
							->update([
								'type' => 'order'
							]);
						}else{
							OrderDetail::where('order_id', $existing_order->id)
							->update([
								'order_id' => $new_session_order->id
							]);
							Order::where('id', $existing_order->id)->delete();
						}					
						
						
					}
					
				}
			}else{
				return false;
			}
		}
		
		// (new UserSessionData)->updateUserId(['user_id' => $userId, 'session_id' => $sessionId]);
	}
}