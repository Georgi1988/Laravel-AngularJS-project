<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use mProvider;

class History extends Model
{
    //App\History::add_history($data);
	/* $data = array(
					"module_name"=>"card",
					"operation_kind"=>"卡生成",// [卡生成
													卡注册
													卡激活
													下单
													导入
													下载
													添加信息
													删除信息
													修改信息
													审批]
					"operation"=>"10 卡生成"
				); */
				
	public static function add_history($data){
		if (mProvider::$is_mobile == true){
			$mobile_val = 1;
		}else{
			$mobile_val = 0;
		}
		
		$userinfo = Session::get('total_info');
		
		$History = new History();
		/* $History->user_id = $data["user_id"];
		$History->dealer_id = $data["dealer_id"]; */
		$History->user_id = $userinfo['user_id'];
		$History->dealer_id = $userinfo['dealer_id'];
		$History->operation_time = date("Y-m-d H:i:s");
		$History->ip_address = $_SERVER['REMOTE_ADDR'];
		$History->is_mobile = $mobile_val;
		$History->module_name = $data["module_name"];
		$History->operation_kind = $data["operation_kind"];
		$History->operation = $data["operation"];
		$History->save();
	}
	public function dealer_info()
    {
        return $this->hasOne('App\Dealer', 'id', 'dealer_id');
    }
	public function user_info()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
