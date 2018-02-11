<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mail;
use dingAuth;
use App\Mail\MessageMail;

class Message extends Model
{
	/*******************************
		message save function
			parameter: message data array
				ex: 
					array(
						"type" => "1",
						"tag_dealer_id" => "11",
						"tag_user_id" => null,
						"message" => "asdfasdfasdfwqerw",
						"url" => "#!/order/view/1",
						"html_message" => "<p>first line</p><p>second line</p>",
						"table_name" => "order",
						"table_id" => "153",
					)
			return true or false
	*******************************/
	public static function save_message($data, $system_msg = false){
		
		$userinfo = Session::get('total_info');
		
		$message = new Message();
		if(!$system_msg){
			$message->src_dealer_id = $userinfo['dealer_id'];
			$message->src_user_id = $userinfo['user_id'];
		}else{
			$message->src_dealer_id = 0;
			$message->src_user_id = 0;
		}
		
		$message->type = $data['type'];
		$message->tag_dealer_id = $data['tag_dealer_id'];
		if(isset($data['tag_user_id'])) $message->tag_user_id = $data['tag_user_id'];
		$message->message = $data['message'];
		if(isset($data['url'])) $message->url = $data['url'];
		if(isset($data['html_message'])) $message->html_message = $data['html_message'];
		if(isset($data['table_name'])) $message->table_name = $data['table_name'];
		if(isset($data['table_id'])) $message->table_id = $data['table_id'];
		
		$ret_val = $message->save();
		
		// Send dingtalk notification SMS
		
		$msg_can_send = true;
		
		$userinfo = Session::get('total_info');
		$user = User::find($userinfo['user_id']);
		$username = '';
		if($user !== null) $username = $user->name;
		$dealer = Dealer::find($userinfo['dealer_id']);
		$dealer_name = '';
		if($dealer !== null) $dealer_name = $dealer->name;
		
		$access_token = dingAuth::getAccessToken();
		$c = new Providers\Dingding\DingTalkClient;
		$req = new Providers\Dingding\CorpMessageCorpconversationAsyncsendRequest;
		$req->setMsgtype("oa");
		$req->setAgentId( Config('dingding.AGENTID') );
		
		if(isset($data['tag_user_id']) && $data['tag_user_id'] != 0){
			$to_all = "false";
			$target_user = User::find($data['tag_user_id']);
			if($target_user !== null){
				$send_user_list = $target_user['dd_account'];
				//$req->setUseridList($target_user['dd_account']);
			}else{
				$msg_can_send = false;
			}
		}else{
			$to_all = "false";
			if(isset($data['tag_dealer_id']) && $data['tag_dealer_id'] != 0){
				$target_dealer = Dealer::find($data['tag_dealer_id']);
				if($target_dealer !== null){
					$send_user_list = $target_dealer->president_dingid_list_bycomma();
					//$req->setDeptIdList("50383199");
					//$req->setDeptIdList($target_dealer['dd_account']);
				}else{
					$msg_can_send = false;
				}
			}else{
				$to_all = "true";
			}
		}
		
		if($msg_can_send == true){
			if($to_all == "true"){
				//$req->setToAllUser($to_all);
				$top_dealer = Dealer::find(1);
				$req->setDeptIdList($top_dealer->dd_account);
			}else{
				if($send_user_list != ""){
					$req->setUseridList($send_user_list);
					$req->setToAllUser($to_all);
				}else{
					$msg_can_send == false;
				}
			}
		}
		
		$server_address = "http://120.27.142.210/";
		$message_url = (isset($data['url']))? $server_address."home".$data['url']: $server_address;
		
		if($msg_can_send == true){
			$req->setMsgcontent("{\"message_url\": \"".$message_url."\", \"head\": {\"bgcolor\": \"FFBBBBBB\",\"text\": \"Test\"},\"body\": {\"title\": \"系统信息\",\"form\": [],\"content\": \"".addslashes($message->message)."\",\"author\": \"".addslashes($dealer_name." - ".$username)." \"}}");
			$resp = $c->execute($req, $access_token);
		}
		
		
		
		//".$message->message."
		
		// Send mail part
		
		/* $email_addr = "";
		if($message->tag_user_id > 0){
			$user = User::find($message->tag_user_id);
		}else{
			$user = User::where([['dealer_id', '=', $message->tag_dealer_id], ['role_id', '<', 3]])->first();
		}
		if(null !== $user) $email_addr = $user->email;
		
		$message->mail_to = $email_addr;
		
		if (filter_var($email_addr, FILTER_VALIDATE_EMAIL)) {
			Mail::to($message->mail_to)
				->queue(new MessageMail($message));
			
		} */
		
		return $ret_val;
	}
	
	public static function getNewProductCnt($user_id, $dealer_id) {
		$last_product_id = User::where('id', $user_id)->first()->last_product_id;
		
		$msg = Message::selectRaw('count(*) as new_product')
			->where('id', '>', $last_product_id)
			->where('table_name', 'product')
			->where(function ($q) use ($dealer_id, $user_id) {
				$q->where('tag_dealer_id', 0)
					->orWhere('tag_dealer_id', $dealer_id)
					->orWhere('tag_user_id', $user_id)
					->orWhere('tag_user_id', 0);
			})
			->first();
		
		if ($msg) return $msg->new_product;
		else return 0;
	}
	
	public static function getNewPurchaseCnt($user_id, $dealer_id) {
		$last_purchase_id = User::where('id', $user_id)->first()->last_purchase_id;
		$msg = Message::selectRaw('count(*) as new_purchase')
			->where('id', '>', $last_purchase_id)
			->where('table_name', 'purchase')
			->where(function ($q) use ($dealer_id, $user_id) {
				$q->where('tag_dealer_id', 0)
					->orWhere('tag_dealer_id', $dealer_id)
					->orWhere('tag_user_id', $user_id)
					->orWhere('tag_user_id', 0);
			})
			->first();
		
		if ($msg) return $msg->new_purchase;
		else return 0;
	}
	
	public static function getNewOrderCnt($user_id, $dealer_id) {
		$last_order_id = User::where('id', $user_id)->first()->last_order_id;
		$msg = Message::selectRaw('count(*) as new_order')
			->where('id', '>', $last_order_id)
			->where('table_name', 'order')
			->where(function ($q) use ($dealer_id, $user_id) {
				$q->where('tag_dealer_id', 0)
					->orWhere('tag_dealer_id', $dealer_id)
					->orWhere('tag_user_id', $user_id)
					->orWhere('tag_user_id', 0);
			})
			->first();
		
		if ($msg) return $msg->new_order;
		else return 0;
	}
	
	public static function getNewPriceCnt($user_id, $dealer_id) {
		$last_price_id = User::where('id', $user_id)->first()->last_price_id;
		$msg = Message::selectRaw('count(*) as new_price')
			->where('id', '>', $last_price_id)
			->where('table_name', 'price')
			->where(function ($q) use ($dealer_id, $user_id) {
				$q->where('tag_dealer_id', 0)
					->orWhere('tag_dealer_id', $dealer_id)
					->orWhere('tag_user_id', $user_id)
					->orWhere('tag_user_id', 0);
			})
			->first();
		
		if ($msg) return $msg->new_price;
		else return 0;
	}
	
	public function src_dealer()
    {
        return $this->hasOne('App\Dealer', 'id', 'src_dealer_id');
    }
	
	public function order()
    {
        return $this->hasOne('App\Order', 'id', 'table_id');
    }
}
