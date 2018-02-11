<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mProvider;

class Card extends Model
{
    // Generate password
    public static function genPassword($length = 15, $type = 'n') {
        
		$nums = '0123456789';
		$letters = 'abcdefghijklmnopqrstuvwxyz';
		$num_letters = '0123456789abcdefghijklmnopqrstuvwxyz';
		
		if($type == 'n') $char_list = &$nums;
		if($type == 'l') $char_list = &$letters;
		if($type == 'l+n') $char_list = &$num_letters;
		
		$char_count = strlen($char_list);
		
		$password = '';
        // Add random numbers to your string
        for ($p = 0; $p < $length; $p++)
            $password .= $char_list[rand(0, $char_count - 1)];

        return $password;
    }
	
	/*****************************************
	
		card generate function
			parameter $data object
				object(stdClass)#381 (8) {
					["product_id"]=> int(7)
					["service_card_type"]=>	int(1)
					["service_cards"]=> int(20)
					["send_dealer"]=> string(2) "33"
				}

	*****************************************/
	
	public static function insertCard($data){
		
		$userinfo = Session::get('total_info');
		
		$product = Product::find($data->product_id);
		
		if($userinfo['authority'] != "admin")
			return array("status" => false, "err_msg" => __('lang.err_no_permission'));
		
		$product->rule;
		if($product->rule === null)
			return array("status" => false, "err_msg" => __('lang.gen_err_norule', ['product_name' => $product->name]));
		
		
		$send_dealer = Dealer::find($data->send_dealer);
		if($send_dealer === null)
			return array("status" => false, "err_msg" => __('lang.err_no_permission'));
		
		if($send_dealer->corporation == "" || ($send_dealer->area == "" || $send_dealer->area === null) || ($send_dealer->province == "" || $send_dealer->province === null))
			return array("status" => false, "err_msg" => __('lang.gen_err_dealerinfo', ['dealer_name' => $send_dealer->name]));
		
		// Dealer info
		$dealer_area = Dictionary::getKeyWord("dic_area", $send_dealer->area);
		$dealer_province = Dictionary::getKeyWord("dic_province", $send_dealer->province);
		
		if($dealer_area === null || $dealer_province === null)
			return array("status" => false, "err_msg" => __('lang.gen_err_dealerinfo', ['dealer_name' => $send_dealer->name]));
		
		
		//$valid_period = ($product->valid_period > 0)? date("Y-m-d H:i:s", time() + 86400 * $product->valid_period * 365): null;
		$valid_period = mProvider::get_card_valid_period($product->valid_period);
		
		
		///////////////////////////////
		// Infomations for generate  //
		///////////////////////////////
		$retail_info = $send_dealer->corporation;
		$gen_year = date("Y");
		$gen_month_day = date("md");
		
			// Initail data array
		$month = array("01"=>"1", "02"=>"2", "03"=>"3", "04"=>"4", "05"=>"5", "06"=>"6", "07"=>"7", "08"=>"8", "09"=>"9", "10"=>"A", "11"=>"B", "12"=>"C");
		$day = array("01"=>"1", "02"=>"2", "03"=>"3", "04"=>"4", "05"=>"5", "06"=>"6", "07"=>"7", "08"=>"8", "09"=>"9", "10"=>"A", "11"=>"B", "12"=>"C", "13"=>"D", "14"=>"E", "15"=>"F", "16"=>"G", "17"=>"H", "18"=>"I", "19"=>"J", "20"=>"K", "21"=>"L", "22"=>"M", "23"=>"N", "24"=>"O", "25"=>"P", "26"=>"Q", "27"=>"R", "28"=>"S", "29"=>"T", "30"=>"U", "31"=>"V");
		
		
		// Card code generation part
		
		$card_code_length = $product->rule->card_code_length;
		$card_code_fields = json_decode($product->rule->length_info, true);
		
		$field_value = array();
		$part_beside_random = '';
		$random_length = 0;
		
		foreach($card_code_fields as $key => $field){

			$temp = array("key" => $key, "type" => $field['type'], "select" => $field['select'], "length" => $field['length'], "value" => "");
			
			if($field['select'] == 'auto'){
				
				if($field['type'] == "dic_retail") $temp["value"] = $retail_info;
				else if($field['type'] == "physical_card") $temp["value"] = $data->service_card_type;
				else if($field['type'] == "dic_service_type") $temp["value"] = $product->service_type;
				else if($field['type'] == "dic_province"){
					$province_item = Dictionary::getKeyWord("dic_province", $send_dealer->province);
					if($province_item === null) 
						return array("status" => false, "err_msg" => __('lang.gen_err_dealerinfo', ['dealer_name' => $send_dealer->name]));
					$temp["value"] = $province_item->value;
				}
				else if($field['type'] == "dic_area"){
					$area_item = Dictionary::getKeyWord("dic_area", $send_dealer->area);
					if($area_item === null) 
						return array("status" => false, "err_msg" => __('lang.gen_err_dealerinfo', ['dealer_name' => $send_dealer->name]));
					$temp["value"] = $area_item->value;
				}
				else if($field['type'] == "expire_date") $temp["value"] = date("ymd", strtotime($valid_period));
				else if($field['type'] == "expire_date2") $temp["value"] = date("Ym", time() + $card_code_fields['custom2']['value'] * 365 * 86400);
				else if($field['type'] == "gen_year") $temp["value"] = $gen_year;
				else if($field['type'] == "gen_date") $temp["value"] = date("ymd");
				else if($field['type'] == "gen_month_day") $temp["value"] = $gen_month_day;
				else if($field['type'] == "gen_order_00AA"){
					$gen_order_number = mProvider::get_next_genorder(CardruleGeninfo::getValueByKey($product->rule->template_id, "gen_order_00AA", $retail_info));
					$temp["value"] = $gen_order_number;
				}
				else if($field['type'] == "auto_number1"){
					$auto_number = rand(1, 9);
					$temp["value"] = $auto_number;
				}
				else if($field['type'] == "random") $random_length += $field['length'];
			}else if($field['select'] == 'manual'){
				$temp["value"] = $field['value'];
			}

			$part_beside_random .= $temp['value'];
			$field_value[] = $temp;
		}
		
		// var_dump($field_value); exit;

		/*******************************
			random number list
		*******************************/
		if($data->service_cards > 9999) 
			return array("status" => false, "err_msg" => __('lang.gen_check_cardcount'));
		
		$random_number_list = [];
		$tb_prefix = DB::getTablePrefix();
		if($product->rule->template_id == 1){ // 16bit 4, 4, 4, 4
		
			$numbers = range(1, $data->service_cards);
			shuffle($numbers);
			for($i= 0; $i < (int)$data->service_cards; $i ++) {
			   $random_number_list[] = str_pad($numbers[$i], $random_length, '0', STR_PAD_LEFT);
			}
		}
		else{
		//else if($product->rule->template_id == 2){ // 17bit 5, 4, 4, 4
			$last_number = CardruleGeninfo::getValueByKey($product->rule->template_id, "last_number", $part_beside_random);
			if($last_number == null) $last_number = 0;
			
			$numbers = range($last_number + 1, $last_number + $data->service_cards);
			shuffle($numbers);
			for($i= 0; $i < (int)$data->service_cards; $i ++) {
			   $random_number_list[] = str_pad($numbers[$i], $random_length, '0', STR_PAD_LEFT);
			}
			$last_number_tosave = $last_number + $data->service_cards;
		}
		
		//var_dump($random_number_list); exit;
		
		// card code list
		$card_code_list = [];
		for($i= 0; $i < (int)$data->service_cards; $i ++) {
			$card_code = '';
			$random_offset = 0;
			foreach($field_value as $field){
				if($field['type'] != 'random'){
					$card_code .= $field['value'];
				}else{
					$card_code .= substr($random_number_list[$i], $random_offset, $field['length']);
					$random_offset += $field['length'];
				}
			}
			$card_code_list[] = $card_code;
		}

		// var_dump($card_code_list); exit;
		
		/***************************
			Generation info write
		***************************/
		if($product->rule->template_id == 1){ // 16bit 4, 4, 4, 4
			CardruleGeninfo::setValueByKey($product->rule->template_id, "gen_order_00AA", $retail_info, $gen_order_number);
		}
		else{
		// else if($product->rule->template_id == 2){ // 17bit 5, 4, 4, 4
			CardruleGeninfo::setValueByKey($product->rule->template_id, "last_number", $part_beside_random, $last_number_tosave);
		}
		
		if($data->service_card_type == 1)
			$card_type = 1;
		else 
			$card_type = 0;

		for ($i = 0; $i < (int)$data->service_cards; $i++){				
			$Card = new Card;
			$Card->code = $card_code_list[$i];
			$Card->product_id = $data->product_id;
			$Card->passwd = Card::genPassword($product->rule->password_length, $product->rule->password_type); // modifing
			$Card->type = $card_type;
			$Card->valid_period = $valid_period;	
			$Card->dealer_id = $userinfo["dealer_id"];	
			$Card->save();
		}
		
		$stockresult = Stock::add_generate_info($data);	
		$historygeneratedata = array(
					"module_name"=>"服务卡",
					"operation_kind"=>"卡生成",
					"operation"=>$data->service_cards." 卡生成",
				);
		History::add_history($historygeneratedata);
		
		return array("status"=>true);
		
		/* $stockresult = Stock::add_generate_info($data);	
		$historygeneratedata = array(
					"module_name"=>"服务卡",
					"operation_kind"=>"卡生成",
					"operation"=>$data->service_cards." 卡生成",
				);
		History::add_history($historygeneratedata);
		
		return $data->service_cards; */
	}
	
	public static function active($data){	
		
		$userinfo = Session::get('total_info');
		
		// Customer register
		if($data->user_name && $data->user_phone){
			$customer_id = Customer::add_customer((object)['regit_name' => $data->user_name, 'regit_phone' => $data->user_phone]);
		}else{
			$customer_id = 0;
		}
		
		$cardcount = Card::where('code', $data->check_code)
					//->where('passwd', $data->check_pass)
					->where('dealer_id', $userinfo["dealer_id"])
					->where('status', '1')
					->count();
		if($cardcount>0){
			$result = array("status"=>2, "card_id"=>0, "product_id"=>0);
		}else{
			$card = Card::where('code', $data->check_code)
						//->where('passwd', $data->check_pass)
						->where('dealer_id', $userinfo["dealer_id"])
						//->where('id', $data->card_id)
						->update(['status' => $data->status, 'active_datetime' => date("Y-m-d H:i:s"), "customer_id" => $customer_id]);
			if($card == "1"){
				$card = Card::where('code', $data->check_code)
						//->where('passwd', $data->check_pass)
						->where('dealer_id', $userinfo["dealer_id"])
						->first();
				$data->card_id = $card->id;		
				$data->product_id = $card->product_id;		
				$stockresult = Stock::add_active_info($data);
				$card = Card::find($data->card_id);
				$card->product;
				$historyactivedata = array(
							"module_name"=>"卡",
							"operation_kind"=>"卡激活",
							"operation"=>"激活了1个卡片。",
						);
				History::add_history($historyactivedata);
				/* $cardquery = Card::where('code', $data->check_code)
							->where('passwd', $data->check_pass)
							->where('id', $data->card_id);
				$messagedata = $cardquery->first(); */
				
				$priceinfo = Price::get_price_by_dealer($data->product_id, $userinfo["dealer_id"]);
				
				//$data->card_id = $messagedata->id;
				$salesresult = Sale::add_sales_info($data, $priceinfo);
				
				$dealer = Dealer::find($userinfo["dealer_id"]);
				$dealer->president;
					
				$messageadddata = array(
							"type" => "1",
							"tag_dealer_id" => $userinfo["dealer_id"],
							"tag_user_id" => $dealer->president->id,
							"message" => "激活了（".$card->product->name."） 1张 卡片。",
							"url" => "",
							"html_message" => "<p>激活了（".$card->product->name."） 1张卡片。</p>
							<p>卡号:".$data->check_code."</p>",
							"table_name" => "card",
							"table_id" => $card->id,
						);	
				Message::save_message($messageadddata);
				$result = array("status"=>0, "card_id"=>$data->card_id, "product_id"=>$data->product_id);
			}else{
				$result = array("status"=>1, "card_id"=>0, "product_id"=>0);
			}	
		}						
		
		return $result;
	}
	
	/**************************************
		Card register function
			parameter $data object
				[
					"card_id"
					"regit_name"
					"regit_phone"
				]
			
	**************************************/
	
	public static function register($data){		
		$userinfo = Session::get('total_info');
		
		if($data->regit_name && $data->regit_phone){
			$customer_id = Customer::add_customer($data);
		}else{
			$customer_id = 0;
		}
		
		$machineresult = MachineCode::add_machinecode($data);
		if($machineresult == '1'){	
		
			$resultcard = Card::where('id', $data->card_id)
						->where('passwd', $data->check_pass)
						->update(['status' => 1, 'agree_reg' => 'r', 'register_datetime' => date("Y-m-d H:i:s"), "customer_id" => $customer_id, "machine_code" => $data->machine_code, "user_id" => $userinfo["user_id"]]);
						
			$returnvalue = $resultcard;
			if($resultcard>0){	
			
				$stockresult = Stock::add_sales_info($data);
				$historyadddata = array(
						"module_name"=>"卡",
						"operation_kind"=>"卡注册",
						"operation"=>"已登记1张。"
					);
				$card = Card::find($data->card_id);
				$card_type = ($card->type == 1) ? "实物卡" : "虚拟卡";
				$card->product;
				
				History::add_history($historyadddata);
				$dealer = Dealer::find($userinfo["dealer_id"]);
				$dealer->president;
				/* $messageadddata = array(
							"type" => "1",
							"tag_dealer_id" => $userinfo["dealer_id"],
							"tag_user_id" => $dealer->president->id,
							"message" => "已注册服务卡（".$card->product->name."） 1张 - 客户名称: ".$data->regit_name." 电话号码: ".$data->regit_phone,
							"url" => "",
							"html_message" => "<p>已登记1张</p>
							<p>用户名称: ".$data->regit_name."</p>
							<p>客户电话号码: ".$data->regit_phone."</p>",
							"table_name" => "card",
							"table_id" => $data->card_id
						);	 */
				$messageadddata = array(
							"type" => "1",
							"tag_dealer_id" => 1,
							"tag_user_id" => null,
							"message" => "注册服务卡（".$card->product->name."） 1张 - 客户名称: ".$data->regit_name." 电话号码: ".$data->regit_phone,
							"url" => "",
							"html_message" => "<p>已登记1张</p>
							<p>产品: ".$card->product->name."</p>
							<p>卡代码: ".$card->code."</p>
							<p>卡类型: ".$card_type."</p>
							<p>机器码: ".$data->machine_code."</p>
							<p>用户名称: ".$data->regit_name."</p>
							<p>客户电话号码: ".$data->regit_phone."</p>",
							"table_name" => "card",
							"table_id" => $data->card_id
						);	
				Message::save_message($messageadddata);
				return array("result"=>$machineresult, "cardcode"=>$card->code, "machinecode"=>$data->machine_code);			
			}else{
				$machineresult = 3;
				return array("result"=>$machineresult, "cardcode"=>"Password Fail", "machinecode"=>"Empty!");
			}			
		}else if($machineresult == '0'){
			return array("result"=>$machineresult, "cardcode"=>"The card has been registed!", "machinecode"=>$data->machine_code);
		}else if($machineresult == '2'){
			return array("result"=>$machineresult, "cardcode"=>"No machincode!", "machinecode"=>0);
		}				
		
	}
	
	public static function bulk_register($product_id, $card_id, $card_code, $machine_code, $priceinfo, $customer_id){
		
		$userinfo = Session::get('total_info');
		
		$card = Card::find($card_id);
		if($card === null) return false;
		
		$card->status = 1;
		$card->agree_reg = 'r';
		$card->active_datetime = date("Y-m-d H:i:s");
		$card->register_datetime = date("Y-m-d H:i:s");
		$card->customer_id = $customer_id;
		$card->machine_code = $machine_code;
		$card->user_id = $userinfo["user_id"];
		
		$save_result = $card->save();
		
		if($save_result){
			
			MachineCode::record_card($card->machine_code, $card->id);
			
			// Add history
			$historyactivedata = array(
						"module_name"=>"卡",
						"operation_kind"=>"批量注册",
						"operation"=>"卡号“".$card_code."” 批量激活和注册了1个卡片。",
					);
			History::add_history($historyactivedata);
			
			// Add sales
			$salesresult = Sale::add_sales_info((object)["product_id" => $product_id, "card_id" => $card_id], $priceinfo);
			
			return true;
			
		}else{
			
			return false;
		}
	}
	
	
	/*********************************
	*********************************/
	public function agree_register($status){
		
		if($status == "true" || $status == true) $status = true;
		
		$card = $this;
		
		if($card->status != 1 || $card->agree_reg != 'r') return false;
		
		$card->product;
		$card->customer;
		
		if($status == true){
			$card->status = 2;
			$message_txt = "管理员同意您的服务卡注册。(卡代码 : ".$card->code.")";
			$message_htm = "<p>".$message_txt."</p><p>卡代码 : ".$card->code."&nbsp;&nbsp;&nbsp;".(($card->customer !== null) ? "客户姓名:".$card->customer->name."&nbsp;&nbsp;&nbsp;"."客户电话:".$card->customer->link : "")."</p>";
		}else{
			$card->status = 1;
			$card->agree_reg = "d";
			$message_txt = "管理员不同意您的服务卡注册。(卡代码 : ".$card->code.")";
			$message_htm = "<p>".$message_txt."</p><p>卡代码 : ".$card->code."&nbsp;&nbsp;&nbsp;".(($card->customer !== null) ? "客户姓名:".$card->customer->name."&nbsp;&nbsp;&nbsp;"."客户电话:".$card->customer->link : "")."</p>
							<p>请重新注册服务卡！</p>";
			$mcode = MachineCode::where('code', $card->machine_code)->first();
			if($mcode !== null){
				$mcode->card_id = 0;
				$mcode->save();
			}
		}
		
		$ret_status = $card->save();
		if(!$ret_status){
			return $ret_status;
		}else{
			$message = array(
					"type" => "1",
					"tag_dealer_id" => $card->dealer_id,
					"tag_user_id" => $card->user_id,
					"message" => $message_txt,
					"url" => "",
					"html_message" => $message_htm,
					"table_name" => "register_card",
					"table_id" => $card->id,
				);
				
			@Message::save_message($message);
			
			return $ret_status;
		}
	}
	
	/*********************************
      Get all level type.
		@param  string  $level
		return all type string
    *********************************/
	public static function getCountInventory($product_id, $dealer_id, $fieldname, $value){
		return Card::where([$fieldname=>$value, 'product_id'=>$product_id, 'dealer_id'=>$dealer_id])->count();
	}
	
	
	public static function getCardStockInfoByDealer($dealer_id, $start_date = null, $end_date = null, $product_type1 = ''){
		$tb_prefix = DB::getTablePrefix();
		$expire_notify_value = Option::get_option_inherit($dealer_id, "stock_expire_notify_value");
		
		$sub_dealers = Dealer::getSubDealerListRaw($dealer_id);
		$sub_dealers[] = $dealer_id;
		
		$query = Card::query()
				->selectRaw('	sum(case when `'.$tb_prefix.'cards`.`status` = 0 and (`'.$tb_prefix.'cards`.`valid_period` >= current_timestamp or `'.$tb_prefix.'cards`.`valid_period` IS NULL)  then 1 else 0 end) as `available_count`, 
								sum(case when `'.$tb_prefix.'cards`.`status` = 1 then 1 else 0 end) as `activation_count`, 
								sum(case when `'.$tb_prefix.'cards`.`status` = 2 then 1 else 0 end) as `register_count`,
								sum(case when `'.$tb_prefix.'cards`.`valid_period` < current_timestamp then 1 else 0 end) as `expired_count`,
								sum(case when `'.$tb_prefix.'cards`.`valid_period` < "'.date("Y-m-d H:i:s", time() - 86400 * $expire_notify_value).'" then 1 else 0 end) as `soon_expired_count`')
				->join('products as p', 'p.id', '=', 'cards.product_id')
				//->whereIn('cards.dealer_id', $sub_dealers);
				->where('cards.dealer_id', '=', $dealer_id);
		
		if($start_date !== null){
			$query->whereRaw(' date(`'.$tb_prefix.'cards`.`created_at`) >= "'.$start_date.'" ');
		}
		if($end_date !== null){
			$query->whereRaw(' date(`'.$tb_prefix.'cards`.`created_at`) <= "'.$end_date.'" ');
		}
		if($product_type1 != ''){
			$query->where('p.level1_id', '=', $product_type1);
		}
		
		return $query->first();
	}
	
	public static function getStockCards($search_obj){
		
		$login_info = Session::get('total_info');
		
		$tb_prefix = DB::getTablePrefix();
		
		$query = Card::query()
			->selectRaw('`'.$tb_prefix.'cards`.*')
			->join('products as p', 'p.id', '=', 'cards.product_id');
			
		$query->where('cards.dealer_id', '=', $login_info['dealer_id']);
		
		if(property_exists($search_obj, "product_id") && $search_obj->product_id != ""){
			$query	->where('cards.product_id', '=', $search_obj->product_id);
		}
		if(property_exists($search_obj, "product_type1") && $search_obj->product_type1 != ""){
			$query	->where('p.level1_id', '=', $search_obj->product_type1);
		}
		if(property_exists($search_obj, "product_type2") && $search_obj->product_type2 != ""){
			$query	->where('p.level2_id', '=', $search_obj->product_type2);
		}
		if(property_exists($search_obj, "card_code_keyword") && $search_obj->card_code_keyword != ""){
			$query	->where('cards.code', 'like', '%'.$search_obj->card_code_keyword.'%');
		}
		if(property_exists($search_obj, "card_type") && $search_obj->card_type !== ""){
			$query	->where('cards.type', '=', $search_obj->card_type);
		}
		
		$expire_date_value = (int)Option::get_option_inherit($login_info['dealer_id'], "stock_expire_notify_value");
		if($expire_date_value < 1) $expire_date_value = 1;
		
		$page_type1_where = [	['cards.status', '<', 1]];
		$page_type2_where = [	['cards.valid_period', '>=', date("Y-m-d H:i:s")],
								['cards.valid_period', '<', date("Y-m-d H:i:s", time() + $expire_date_value * 86400)]];
		$page_type3_where = [	['cards.valid_period', '<', date("Y-m-d H:i:s")]];
		$page_type4_where = [	['cards.status', '=', 2]];
		$page_type5_where = [	['cards.status', '=', 1]];
		
		if(property_exists($search_obj, "page_type") && $search_obj->page_type != ""){
			if($search_obj->page_type == 1){
				$query	->where($page_type1_where)
						->where(function ($query) {
							$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
									->orwhere('cards.valid_period', '=', null);
						});
			}
			else if($search_obj->page_type == 2){
				$query	->where($page_type2_where);
			}
			else if($search_obj->page_type == 3){
				$query	->where($page_type3_where);
			}
			else if($search_obj->page_type == 4){
				$query	->where($page_type4_where);
			}
			else if($search_obj->page_type == 5){
				$query	->where($page_type5_where)
						->where(function ($query) {
							$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
									->orwhere('cards.valid_period', '=', null);
						});
			}
		}
		
		$query->orderByDesc('cards.id');
		$query->limit(20000);
		$items = $query->get();
		foreach($items as $item){
			$item->product;
		}
		
		return $items;
	}
	
	/************************************
	Check physical card code exists
 		parameter: $product_id, $code
		return: true or false
	************************************/
	public static function check_pcard_code($product_id, $code){
		
		$userinfo = Session::get('total_info');
		
		$card = Card::where([
				["product_id", "=", $product_id], 
				["code", "=", $code], 
				["dealer_id", "=", $userinfo["dealer_id"]], 
				['status', '=', 0],
				["type", "=", 1]
			])->first();
		
		return ($card !== null)? true : false;
	}
	
	/************************************
	Check card code & password & ownership
 		parameter: $product_id, $type, $code, $pass
		return: null(no card) or false(password incorrect) or card id (correct)
	************************************/
	public static function check_card($product_id, $type, $code, $pass){
		
		$userinfo = Session::get('total_info');
		
		$card = Card::where([
				["product_id", "=", $product_id], 
				["code", "=", $code], 
				["dealer_id", "=", $userinfo["dealer_id"]], 
				['status', '=', 0],
				["type", "=", $type]
			])->where(function ($query) {
				$query	->where('valid_period', '>=', date("Y-m-d H:i:s"))
						->orwhere('valid_period', '=', null);
			})->first();
			
		return ($card === null)? null : (($card->passwd == $pass)? $card->id: false);
	}
	
	/************************************
	Check physical card code exists quantity
 		parameter: $product_id, $code
		return: true or false
	************************************/
	public static function check_pcard_count($dealer_id, $product_id, $codelist){
		
		$card_count = Card::where([
				["product_id", "=", $product_id], 
				["dealer_id", "=", $dealer_id],  
				['status', '=', 0],
				["type", "=", 1]
			])->whereIn('code', $codelist)->count();
		
		return $card_count;
	}

    public static function getCardByCode($code) {
        $card = Card::where('code', '=', $code)->first();

        return $card;
    }

	public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
	
	public function dealer()
    {
        return $this->hasOne('App\Dealer', 'id', 'dealer_id');
    }
	
	public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'customer_id');
    }
	
	public function seller()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
	
}
