<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App;
use mProvider;
use App\Dealer;
use App\Product;
use App\RedPacketSetting;

class RewardSettingController extends Controller
{
    //
    public function redpacket_setting_view() {
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_setting_view');
    }

    public function redpacket_setting_add_view() {
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_setting_add_view');
    }

    public function redpacket_setting_detail_view() {
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_setting_detail_view');
    }

    public function redpacket_setting_edit_view(Request $request) {
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_setting_edit_view');
    }

    public function index($itemcount, $pagenum)
    {
        $result = RedPacketSetting::getRewardingRuleList($itemcount, $pagenum);
        return json_encode(array('list' => $result));
    }

    public function add(Request $request)
    {
        // Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));
			$redpacketsetting = RedPacketSetting::where('redpacket_name', $data->redpacket_name)->first();
			if ($redpacketsetting) {
				$ret_ary['success'] = false;
				$ret_ary['err_msg'] = __('lang.rew_double_redpacket_name');
				return json_encode($ret_ary);
			}
			$redpacketsetting = new RedPacketSetting;
			$redpacketsetting->redpacket_name = $data->redpacket_name;
			$redpacketsetting->dealer_id = $data->dealer_id;
			$redpacketsetting->product_id = $data->product_id;
			$redpacketsetting->redpacket_type = $data->redpacket_type;
			$redpacketsetting->redpacket_start_date = $data->redpacket_start_date;
			$redpacketsetting->redpacket_end_date = $data->redpacket_end_date;
			$redpacketsetting->redpacket_rule = $data->redpacket_rule;
			$redpacketsetting->redpacket_price = $data->redpacket_price;
			
			$redpacketsetting->save();
			
			App\RedPacket::setApprovalList($redpacketsetting);
			
			
			$dealer = App\Dealer::find($data->dealer_id);
			
			// log table
			App\History::add_history(array("module_name"=>"红包", "operation_kind"=>"红包设置", "operation"=>$data->redpacket_name." ".$dealer->name." 红包设置"));
			
			if ($data->redpacket_type > 0) {
				$product = App\Product::find($data->product_id);
				$msg = "红包设置<br><br>红包名称: ".$data->redpacket_name."<br>红包类型: 注册数量(".$product->name."), 达标数量: ".$data->redpacket_rule."张<br>周期时间: ".$data->redpacket_start_date." --- ".$data->redpacket_end_date."<br>奖励金额: ".$data->redpacket_price."元";
			} else {
				$msg = "红包设置<br><br>红包名称: ".$data->redpacket_name."<br>红包类型: 销售金额, 达标金额: ".$data->redpacket_rule."元<br>周期时间: ".$data->redpacket_start_date." --- ".$data->redpacket_end_date."<br>奖励金额: ".$data->redpacket_price."元";
			}
			// Message table
			App\Message::save_message(array(
				"type" => "1",
				"tag_dealer_id" => $data->dealer_id,
				"tag_user_id" => null,
				"message" => $data->redpacket_name." ".$dealer->name." 红包设置",
				"url" => "",
				"html_message" => $msg,
				"table_name" => "red_packet_setting",
				"table_id" => $redpacketsetting->id,
			));
			
			$ret_ary['success'] = true;
		}
		else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}

		return json_encode($ret_ary);
    }


    public function edit(Request $request)
    {
        // Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));
			$redpacketsetting = RedPacketSetting::where('redpacket_name', $data->redpacket_name)->where('id', '<>', $data->id)->first();
			if ($redpacketsetting) {
				$ret_ary['success'] = false;
				$ret_ary['err_msg'] = __('lang.rew_double_redpacket_name');
				return json_encode($ret_ary);
			}
			$redpacketsetting = RedPacketSetting::find($data->id);
			$redpacketsetting->redpacket_name = $data->redpacket_name;
			$redpacketsetting->dealer_id = $data->dealer_id;
			$redpacketsetting->product_id = $data->product_id;
			$redpacketsetting->redpacket_type = $data->redpacket_type;
			$redpacketsetting->redpacket_start_date = $data->redpacket_start_date;
			$redpacketsetting->redpacket_end_date = $data->redpacket_end_date;
			$redpacketsetting->redpacket_rule = $data->redpacket_rule;
			$redpacketsetting->redpacket_price = $data->redpacket_price;
			
			$redpacketsetting->save();
			
			$dealer = $redpacketsetting->dealer;
			
			App\RedPacket::setApprovalList($redpacketsetting);
			
			// log table
			App\History::add_history(array("module_name"=>"红包", "operation_kind"=>"红包编辑", "operation"=>$data->redpacket_name." ".$dealer->name." 红包编辑"));
			
			if ($data->redpacket_type > 0) {
				$product = App\Product::find($data->product_id);
				$msg = "红包编辑<br><br>红包名称: ".$data->redpacket_name."<br>红包类型: 注册数量(".$product->name."), 达标数量: ".$data->redpacket_rule."张<br>周期时间: ".$data->redpacket_start_date." --- ".$data->redpacket_end_date."<br>奖励金额: ".$data->redpacket_price."元";
			} else {
				$msg = "红包编辑<br><br>红包名称: ".$data->redpacket_name."<br>红包类型: 销售金额, 达标金额: ".$data->redpacket_rule."元<br>周期时间: ".$data->redpacket_start_date." --- ".$data->redpacket_end_date."<br>奖励金额: ".$data->redpacket_price."元";
			}
			// Message table
			App\Message::save_message(array(
				"type" => "1",
				"tag_dealer_id" => $data->dealer_id,
				"tag_user_id" => null,
				"message" => $data->redpacket_name." ".$dealer->name." 红包编辑",
				"url" => "",
				"html_message" => $msg,
				"table_name" => "red_packet_setting",
				"table_id" => $redpacketsetting->id,
			));
			
			$ret_ary['success'] = true;
		}
		else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}

		return json_encode($ret_ary);
    }
	
	public function remove($id, Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = RedPacketSetting::find($id);
			$dealer = $data->dealer;
			
			App\RedPacket::removeUnapprovedList($data);
			
			$data->delete();
			//RedPacketSetting::where('id', $id)->delete();
			
			// log table
			App\History::add_history(array("module_name"=>"红包", "operation_kind"=>"红包删除", "operation"=>$data->redpacket_name." ".$dealer->name." 红包删除"));
			if ($data->redpacket_type > 0) {
				$product = App\Product::find($data->product_id);
				$msg = "红包删除<br><br>红包名称: ".$data->redpacket_name."<br>红包类型: 注册数量(".$product->name."), 达标数量: ".$data->redpacket_rule."张<br>周期时间: ".$data->redpacket_start_date." --- ".$data->redpacket_end_date."<br>奖励金额: ".$data->redpacket_price."元";
			} else {
				$msg = "红包删除<br><br>红包名称: ".$data->redpacket_name."<br>红包类型: 销售金额, 达标金额: ".$data->redpacket_rule."元<br>周期时间: ".$data->redpacket_start_date." --- ".$data->redpacket_end_date."<br>奖励金额: ".$data->redpacket_price."元";
			}
			
			// Message table
			App\Message::save_message(array(
				"type" => "1",
				"tag_dealer_id" => $data->dealer_id,
				"tag_user_id" => null,
				"message" => $data->redpacket_name." ".$dealer->name." 红包删除",
				"url" => "",
				"html_message" => $msg,
				"table_name" => "red_packet_setting",
				"table_id" => $id,
			));
			
			$ret_ary['success'] = true;
		}
		else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}

		return json_encode($ret_ary);
	}
}
