<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\ContactType;
use App\Model\Contact;
use App\Model\ContactConversation;
use App\Mail\EmailContactUs;
use App\Mail\EmailAdminContactUs;
use Illuminate\Support\Facades\Mail;

class ContactsController extends \App\Http\Controllers\Controller
{
	
	/**
     * Contact Us
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] mobile
     * @param  [string] message
     */
	public function index(Request $request){
		$validator = \Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'mobile' => 'required',
			'message' => 'required',
		]);
		
		if ($validator->fails()){
			$this->apiResponse['errorMessage'] = getErrors($validator);
			return response()->json($this->apiResponse);
		}
		
		$contact_details = array(
			'contact_type' => 1, //general,
			'name' => $request->name,
			'email' => $request->email,
			'mobile' => $request->mobile,
			'is_block' => 'N',
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		
		if( $contact_data = Contact::create( $contact_details ) ) {
			$ticket_id = 'TIC'.mb_substr($request->contact_type, 0, 1, 'utf-8').$contact_data->id.mt_rand(1000, 9999);
			$contact_details['ticket_id'] = $ticket_id;
			Contact::where('id', $contact_data->id)->update(['ticket_id' => $ticket_id]);

			$conversation_details = [];
			$conversation_details['contact_id'] = $contact_data->id;
			$conversation_details['message']    = $request->message;
			$conversation_details['created_at'] = date('Y-m-d H:i:s');
			$conversation_details['updated_at'] = date('Y-m-d H:i:s');

			$contact_details['message'] = $request->message;

			if( $conversation_data = ContactConversation::create( $conversation_details ) ) {

				Mail::to($request->email)->queue(new EmailContactUs($contact_details));

				Mail::to( config('global.admin_email_id') )->queue(new EmailAdminContactUs($contact_details));

				$this->apiResponse['error'] = false;
				$this->apiResponse['data'] = [
					'message' => 'Thank you for contacting with us. We will get back to you soon.'
				];

			}else{
				$this->apiResponse['errorMessage'] = 'Sorry! There was an unexpected error. Try again!';
			}
		}else{
			$this->apiResponse['errorMessage'] = 'Sorry! There was an unexpected error. Try again!';
		}
		
		return response()->json($this->apiResponse);
	}

	
}