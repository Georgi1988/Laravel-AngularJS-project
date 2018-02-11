<?php

namespace App\Http\Controllers;

use App;
use App\Order;
use Illuminate\Http\Request;
use mProvider;

class PurchaseController extends Controller
{
    //
	public function index(){
		$setting_index_arr = App\Option::get_option(1);
		$view_data = array(
			"setting" => $setting_index_arr,
		);
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'purchase', $view_data);
	}
	
	public function insert_order(Request $request){
		
		$data = json_decode(file_get_contents("php://input"));
		
		echo json_encode(Order::insertOrder($data));
	}
	public function multi_insert_order(Request $request){
		
		$data = json_decode(file_get_contents("php://input"));
		
		echo json_encode(Order::multiinsertOrder($data));
	}
	
}
