<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

class MessageController extends Controller
{
    //
	public function index(Request $request){
		$request->session()->put('dcs_msg_reset', true);
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'message');
	}
	
	public function get_list($search_json, $itemcount, $pagenum, Request $request){
		
		$priv = $request->session()->get('site_priv');
		
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		
		$query = App\Message::query();
		
		if($priv != "seller"){
			$query->where('src_dealer_id', '!=', $login_info['dealer_id']);
			$query->where(function ($query) use ($login_info) {
				$query	->where('tag_dealer_id', '=', $login_info['dealer_id'])
						->orwhere('tag_dealer_id', '=', 0);
			});
		}else{
			$query->where(function ($query) use ($login_info) {
				$query	->where('tag_user_id', '=', $login_info['user_id'])
						->orwhere('tag_user_id', '=', 0);
			});
		}
		
		$temp_query = clone $query;
		
		if(property_exists($search_obj, "type") && $search_obj->type != ""){
			$query->where('type', '=', $search_obj->type);
		}
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where('message', 'like', '%'.$search_obj->keyword.'%');
		}
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		
		foreach($items as $item){
			if($item->type == 2) $item->order;
			if($item->url == '') $item->mobile_url = '#!/message/view/'.$item->id;
			else $item->mobile_url = $item->url;
		}
		
		$return_arr['list'] = $items;
		
		// Message last id store to user table
		$message = App\Message::orderByDesc('id')->first();
		$last_message_id = (null === $message)? 0: $message->id;
		
		$request->session()->put('dcs_msg_reset', true);
		
		$user = App\User::find($login_info['user_id']);
		
		$unread_message = $temp_query->selectRaw('count(*) as `unread_message`')
				->where('id', '>', $user->last_message_id)->first()['unread_message'];
				
		$return_arr['unread_message'] = $unread_message;
		$return_arr['last_message_id'] = $user->last_message_id;
		
		if(null !== $user){
			$user->last_message_id = $last_message_id;
			$user->save();
		}
		
		echo json_encode($return_arr);
	}
	
	public function check_new(Request $request){
		$priv = $request->session()->get('site_priv');
		$login_info = $request->session()->get('total_info');
		
		$user = App\User::find($login_info['user_id']);
		$dealer_id = $login_info['dealer_id'];
		$user_id = $login_info['user_id'];
		if(null != $user){
			$user_last_msg_id = ($user)? $user->last_message_id: 0;
			
			$query = App\Message::query();
			if($priv != "seller"){
				$query->where('src_dealer_id', '!=', $login_info['dealer_id']);
				$query->where(function ($query) use ($login_info) {
					$query	->where('tag_dealer_id', '=', $login_info['dealer_id'])
							->orwhere('tag_dealer_id', '=', 0);
				});
			}else{
				$query->where(function ($query) use ($login_info) {
					$query	->where('tag_user_id', '=', $login_info['user_id'])
							->orwhere('tag_user_id', '=', 0);
				});
			}
			$last_msg = $query->selectRaw('count(*) as `unread_message`, max(`id`) as `last_id`')
					->where('id', '>', $user_last_msg_id)->first();
			$unread_message = $last_msg['unread_message'];
			$last_id = $last_msg['last_id'];
			if(null !== $user && $unread_message > 0){
				$user->last_message_id = $last_id;
				$user->save();
			}
			
			$msg_check_reset = false;
			if($request->session()->get('dcs_msg_reset') == true){
				$msg_check_reset = true;
				$request->session()->put('dcs_msg_reset', false);
			}
		}else{
			$unread_message = 0;
			$msg_check_reset = false;
		}
		
		if ($priv != 'seller') {
			if ($priv == 'admin') {
				$new_product = 0;
				$new_purchase = 0;
			} else {
				$new_product = App\Message::getNewProductCnt($user_id, $dealer_id);
				$new_purchase = App\Message::getNewPurchaseCnt($user_id, $dealer_id);
			}
			$new_order = App\Message::getNewOrderCnt($user_id, $dealer_id);
			$new_price = App\Message::getNewPriceCnt($user_id, $dealer_id);
		} else {
			$new_product = 0;
			$new_purchase = 0;
			$new_order = 0;
			$new_price = 0;
		}
		
		echo json_encode(array("count" => $unread_message,
			"msg_check_reset" => $msg_check_reset,
			"new_product" => $new_product,
			"new_purchase" => $new_purchase,
			"new_order" => $new_order,
			"new_price" => $new_price
		));
	}
	
	public function view_item_page(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'message_view');
	}
	
	public function get_item($message_id){
		$message = App\Message::find($message_id);
		$ret_status = true;
		if(null === $message) $ret_status = false;
		echo json_encode(array("status" => $ret_status, "value" => $message));
	}
	
	public function delete_items(){
		$data = json_decode(file_get_contents("php://input"));
		$ret_status = App\Message::whereIn('id', $data)->delete();
		echo json_encode(array("status"=>$ret_status));
	}
}
