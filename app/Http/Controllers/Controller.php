<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\User;
use App\Model\Setting;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $apiResponse;
	public function __construct(){
		$this->apiResponse = [
			'error' => true,
			'errorMessage' => null,
			'data' => []
		];
	}
	
    /**
     * check input values
     *
     * @return \Illuminate\Http\Response
     */
    public function hasInput(Request $request)
    {
        if($request->has('_token')) {
            return count($request->all()) > 1;
        } else {
            return count($request->all()) > 0;
        }
    }

    /**
     * add taxonomy
     *
     * @return \Illuminate\Http\Response
     */
    public function addTaxonomy($arr = [])
    {
        if(count($arr) > 0){
            $taxonomy = new Taxonomy;
            $arr['created_by'] = Auth::guard('web')->user()->id;
            if($data = $taxonomy->create($arr)){
                return $data->id;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * update taxonomy
     *
     * @return \Illuminate\Http\Response
     */
    public function updateTaxonomy($arr = [])
    {
        if(count($arr) > 0){
            $taxonomy = Taxonomy::find($arr['id']);
            $arr['created_by'] = Auth::guard('web')->user()->id;
            if($taxonomy->update($arr)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    /**
     * Taxonomy details
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxonomyDetails($category_slug = null)
    {
        if( $category_slug != null ){
            $taxonomy = Taxonomy::where([['slug',$category_slug],['is_block','N']])->first();
            if ( $taxonomy != null ){
                return $taxonomy;
            }else{
                return false;
            }            
        }else{
            return false;
        }
    }

    /**
     * Generate SMS
     *
     * @return \Illuminate\Http\Response
     */
    public function generate_sms($mobile_no ='', $text=''){
        $url = "https://www.mysmsapp.in/api/push.json?apikey=5b868810c87b4&sender=FLINWI&mobileno=".$mobile_no.'&text='.$text;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }
    
    

    public function get_date_time() {
        $ip = '103.251.83.170';
        //$ip = '110.142.215.61';
        //$ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

        if( isset($query) && $query['status'] == 'success' ) {
            date_default_timezone_set($query['timezone']);
            return date('Y-m-d H:i:s');
        }else{
            date_default_timezone_set('Asia/Kolkata');
            return date('Y-m-d H:i:s');
        }
    }

    //Getting IP wise details and current time
    public static function get_time(){
        $ip = '103.251.83.170';
        //$ip = '110.142.215.61';
        //$ip = $_SERVER['REMOTE_ADDR'];
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));

        if( isset($query) && $query['status'] == 'success' ) {
            date_default_timezone_set($query['timezone']);
            return date('H:i');
        }else{
            date_default_timezone_set('Asia/Kolkata');
            return date('H:i');
        }
    }


    //8 digit random password generate start//
    public function randPassword($len) {
        $string = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ@#!$%&0123456789";
        for($i=0;$i<$len;$i++)
            $string.=substr($chars,rand(0,strlen($chars)),1);
        return $string;
    }
    //8 digit random password generate end//


   protected function sendSuccess($data=[],$token =null,$message=null)
    {
        $response = [
            'status' => true,
            'token'=>$token,
            'message' => $message,
        ];

        if(!empty($data)){
            $response['data'] = $data;
        }

        return response()->json($response,200);
    }

    protected function sendErrors($error, $errorMessages = [])
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['error'] = $errorMessages;
        }

        return response()->json($response,200);
    }

}
