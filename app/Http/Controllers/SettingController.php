<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

class SettingController extends Controller
{
    public $categ = 'setting';
	
	
	
	// pc setting view
	public function view_setting_page(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'setting');
	}
	
	// pc setting save
	public function save_setting(Request $request){
		
		$ret_status = true;
		
		$dealer_id = $request->session()->get('total_info')['dealer_id'];
		
		// Stock setting
		
		$password_length = $request->input('password_length');
		if(isset($password_length)){
			
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'password_length', $password_length);
		}
		
		$stock_less_notify_value = $request->input('stock_less_notify_value');
		if(isset($stock_less_notify_value)){
			
			$stock_less_notify_status = mProvider::set_val($request->input('stock_less_notify_status'), 0);
			
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'stock_less_notify_status', $stock_less_notify_status);
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'stock_less_notify_value', $stock_less_notify_value);
		}
		
		$stock_expire_notify_value = $request->input('stock_expire_notify_value');
		if(isset($stock_expire_notify_value)){
			
			$stock_expire_notify_status = mProvider::set_val($request->input('stock_expire_notify_status'), 0);
			
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'stock_expire_notify_status', $stock_expire_notify_status);
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'stock_expire_notify_value', $stock_expire_notify_value);
		}
		
		// Order setting
		$order_valid_period = $request->input('order_valid_period');
		$order_single_minium = $request->input('order_single_minium');
		$order_single_maxium = $request->input('order_single_maxium');
		if(isset($order_single_minium)){
			
			$order_purchase_multi = mProvider::set_val($request->input('order_purchase_multi'), 0);
			if($order_purchase_multi != null)
				$ret_status = $ret_status & App\Option::save_option($dealer_id, 'order_purchase_multi', $order_purchase_multi);
			if($order_valid_period != null)
				$ret_status = $ret_status & App\Option::save_option($dealer_id, 'order_valid_period', $order_valid_period);
			if($order_single_minium != null)
				$ret_status = $ret_status & App\Option::save_option($dealer_id, 'order_single_minium', $order_single_minium);
			if($order_single_maxium != null)
				$ret_status = $ret_status & App\Option::save_option($dealer_id, 'order_single_maxium', $order_single_maxium);
		}
		
		// Red packet setting
		$red_packet_sales = $request->input('red_packet_sales');
		$red_packet_price = $request->input('red_packet_price');
		if(isset($red_packet_price)){
			
			$red_packet = mProvider::set_val($request->input('red_packet'), 0);
			$red_packet_monthly = mProvider::set_val($request->input('red_packet_monthly'), 0);
			
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'red_packet', $red_packet);
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'red_packet_monthly', $red_packet_monthly);
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'red_packet_sales', $red_packet_sales);
			$ret_status = $ret_status & App\Option::save_option($dealer_id, 'red_packet_price', $red_packet_price);
		}
		echo json_encode(array("status" => $ret_status));
	}
	
	// pc setting get
	public function get_setting(Request $request){
		
		$dealer_id = $request->session()->get('total_info')['dealer_id'];
		
		$setting_index_arr = App\Option::get_option($dealer_id);
		echo json_encode($setting_index_arr);
	}
	
}
