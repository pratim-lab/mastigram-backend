<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSessionData extends Model
{
    protected $table = 'user_session_datas';

    protected $guarded = [];
	
	
	public function getData($where, $key = null){
		$sessionData = UserSessionData::where($where)->first();
		
		if(!$sessionData){
			return ($key != null) ? '' : [];
		}
		
		$data = (array) json_decode($sessionData->data);
		if($key != null){
			return (isset($data[$key])) ? $data[$key] : '';
		}else{
			return $data;
		}
		
	}
	
	public function setData($where, array $arr){
		$sessionData = UserSessionData::where($where)->first();
		if($sessionData){
			$data = (array) json_decode($sessionData->data);
			$data = array_merge($data, $arr);
			$sessionData->data = json_encode($data);
			$sessionData->save();
		}else{
			$insertArr = array(
				'data' => json_encode($arr)
			);
			$insertArr = array_merge($insertArr, $where);
			$sessionData = UserSessionData::create($insertArr);
		}
		
		return $sessionData;
		
	}
	
	public function removeData($where, $key = null){
		$sessionData = UserSessionData::where($where)->first();
		if(!$sessionData) return true;
		
		$data = (array) json_decode($sessionData->data);
		if($key == null){
			$sessionData->delete();
		}else {
			if(is_array($key)){
				foreach($key as $key_item){
					if(isset($data[$key_item])){
						unset($data[$key_item]);
					}
				}
			}else if(isset($data[$key])){
				unset($data[$key]);
			}
			$sessionData->data = json_encode($data);
			$sessionData->save();
		}
		
		return true;
	}
	
	public function updateUserId($where){
		$sessionData = UserSessionData::where('session_id', $where['session_id'])->first();
		if($sessionData){
			$sessionData->user_id = $where['user_id'];
			$sessionData->save();
		}
		return $sessionData;
	}

}
