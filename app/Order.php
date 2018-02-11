<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
	public static function insertOrder($data){
		$userinfo = Session::get('total_info');
		
		$ordercode = date("Ymd").rand(10000000,99999999);
		
		$Order = new Order;
		
		$Order->code = $ordercode;
		$Order->product_id = $data->product_id;
		$Order->src_dealer_id = $userinfo["dealer_id"];
		$Order->tag_dealer_id = $userinfo["up_dealer"]["id"];
		if($data->service_card_type == "2"){
			$card_type = 0;
			$card_subtype = 1;
		}else{
			$card_type = $data->service_card_type;
			$card_subtype = 0;
		}
		$Order->card_type = $card_type;
		$Order->card_subtype = $card_subtype;
		//$Order->valid_period = $data->valid_period;	
		$Order->size = $data->service_cards;	
		$Order->status = $data->orderstatus;	
		$Order->save();		

		// log table
		$dealer = Dealer::find($userinfo["dealer_id"]);
		$src_dealer_name = ($dealer)? $dealer->name: "";	
		$product = Product::find($Order->product_id);
		$product_name = ($product)? $product->name: "";	

		if($Order->status == 0)
			History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交进货", "operation"=>"向上级经销商申请进货".$Order->size."张延保卡"));
		else
			History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交退货", "operation"=>"向上级经销商申请退货".$Order->size."张延保卡"));
		
		// Message table
		
		
		if($Order->status == 0) {
			Message::save_message(array(
						"type" => "2",
						"tag_dealer_id" => $userinfo["up_dealer"]["id"],
						"tag_user_id" => null,
						"message" => $src_dealer_name." 申请进货服务卡“".$product_name."”".$Order->size."张",
						"url" => "#!/order/view/".$Order->id,
						"html_message" => "",
						"table_name" => "order",
						"table_id" => $Order->id,
					));
			
			//Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
		}
		else {
			Message::save_message(array(
						"type" => "2",
						"tag_dealer_id" => $userinfo["up_dealer"]["id"],
						"tag_user_id" => null,
						"message" => $src_dealer_name." 申请退货服务卡“".$product_name."”".$Order->size."张",
						"url" => "#!/order/view/".$Order->id,
						"html_message" => "",
						"table_name" => "order",
						"table_id" => $Order->id,
					));
					
			//Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
		}
		
		return $data->service_cards;
	}
	
	// Multi Order Insert original
	public static function multiinsertOrder($data){
		$userinfo = Session::get('total_info');
		
		$total_size = 0;
		if (count($data)>0){
			for($i=0;$i<count($data);$i++){
				
				$ordercode = date("Ymd").rand(10000000,99999999);
				
				$Order = new Order;
				$Order->code = $ordercode;
				$Order->product_id = $data[$i]->id;
				$Order->src_dealer_id = $userinfo["dealer_id"];
				$Order->tag_dealer_id = $userinfo["up_dealer"]["id"];
				
				
				if($data[$i]->card_type == "2"){
					$card_type = 0;
					$card_subtype = 1;
				}else{
					$card_type = $data[$i]->card_type;
					$card_subtype = 0;
				}
				//$Order->card_type = $data[$i]->card_type;
				$Order->card_type = $card_type;
				$Order->card_subtype = $card_subtype;
				
				//$Order->valid_period = $data[$i]->valid_period;	
				$Order->size = $data[$i]->cards;	
				$Order->status = $data[$i]->orderstatus;	
				$Order->save();
				
				$total_size += $Order->size;
				
				// log table
				$dealer = Dealer::find($userinfo["dealer_id"]);
				$src_dealer_name = ($dealer)? $dealer->name: "";	
				$product = Product::find($Order->product_id);
				$product_name = ($product)? $product->name: "";	

				if($Order->status == 0)
					History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交进货", "operation"=>"向上级经销商申请进货".$Order->size."张延保卡"));
				else
					History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交退货", "operation"=>"向上级经销商申请退货".$Order->size."张延保卡"));
				
				// Message table
				$product_count = (count($data) > 1)? " 外 ".(count($data) - 1)." 件 ": ' ';
				
				if($Order->status == 0) {
					Message::save_message(array(
								"type" => "2",
								"tag_dealer_id" => $userinfo["up_dealer"]["id"],
								"tag_user_id" => null,
								"message" => $src_dealer_name." 申请进货服务卡“".$product_name."” ".$Order->size."张",
								"url" => "#!/order/view/".$Order->id,
								"html_message" => "",
								"table_name" => "order",
								"table_id" => $Order->id,
							));
					
					//Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
				}
				else {
					Message::save_message(array(
								"type" => "2",
								"tag_dealer_id" => $userinfo["up_dealer"]["id"],
								"tag_user_id" => null,
								"message" => $src_dealer_name." 申请退货服务卡“".$product_name."” ".$Order->size."张",
								"url" => "#!/order/view/".$Order->id,
								"html_message" => "",
								"table_name" => "order",
								"table_id" => $Order->id,
							));
							
					//Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
				}
			}
		}		
		
		return $data;
	}
	
	
	// Multi Order Insert original
	/* public static function multiinsertOrder($data){
		$userinfo = Session::get('total_info');
		$ordercode = date("Ymd").rand(10000000,99999999);
		
		$total_size = 0;
		if (count($data)>0){
			for($i=0;$i<count($data);$i++){
				$Order = new Order;
				
				$Order->code = $ordercode;
				$Order->product_id = $data[$i]->id;
				$Order->src_dealer_id = $userinfo["dealer_id"];
				$Order->tag_dealer_id = $userinfo["up_dealer"]["id"];
				$Order->card_type = $data[$i]->card_type;
				//$Order->valid_period = $data[$i]->valid_period;	
				$Order->size = $data[$i]->cards;	
				$Order->status = $data[$i]->orderstatus;	
				$Order->save();
				
				$total_size += $Order->size;
			}
			
			
			// log table
			$dealer = Dealer::find($userinfo["dealer_id"]);
			$src_dealer_name = ($dealer)? $dealer->name: "";	
			$product = Product::find($Order->product_id);
			$product_name = ($product)? $product->name: "";	

			if($Order->status == 0)
				History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交进货", "operation"=>"向上级经销商申请进货".$total_size."张延保卡"));
			else
				History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交退货", "operation"=>"向上级经销商申请退货".$total_size."张延保卡"));
			
			// Message table
			$product_count = (count($data) > 1)? " 外 ".(count($data) - 1)." 件 ": ' ';
			
			if($Order->status == 0) {
				Message::save_message(array(
							"type" => "2",
							"tag_dealer_id" => $userinfo["up_dealer"]["id"],
							"tag_user_id" => null,
							"message" => $src_dealer_name." 申请进货服务卡“".$product_name."”".$product_count.$total_size."张",
							"url" => "#!/order/view/".$Order->id,
							"html_message" => "",
							"table_name" => "order",
							"table_id" => $Order->id,
						));
				
				Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
			}
			else {
				Message::save_message(array(
							"type" => "2",
							"tag_dealer_id" => $userinfo["up_dealer"]["id"],
							"tag_user_id" => null,
							"message" => $src_dealer_name." 申请退货服务卡“".$product_name."”".$product_count.$total_size."张",
							"url" => "#!/order/view/".$Order->id,
							"html_message" => "",
							"table_name" => "order",
							"table_id" => $Order->id,
						));
						
				Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
			}
		}		
		
		return $data;
	} */
	
	public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
	
	public function src_dealer()
    {
        return $this->hasOne('App\Dealer', 'id', 'src_dealer_id');
    }
}
