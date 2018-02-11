<?php

namespace App\Http\Controllers;

use App;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mProvider;

use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    private $order_upload_path = "uploads/order_data/import/";

    //
	public function index($type = '1', Request $request){
		$login_info = $request->session()->get('total_info');
		$view_info = array(
			'is_salepoint' => count($login_info['down_dealers']) == 0,
			"page_type" => $type,
		);
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order', $view_info);
	}
	public function view_item($order_id = '0'){
		$view_info = array(
			"order_type" => $order_id,
		);
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_view', $view_info);
	}
	public function view_setting(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_setting');
	}
	
	
    /*
		--page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: list item info, pagination info
	*/
	public function get_list($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		$user_id = $login_info['user_id'];
		$dealer_id = $login_info['dealer_id'];
		
		if ($pagenum == 1) {
			if ($search_obj->type == 1) {
				// Modify the check_ordered of dealer_id
				//App\Dealer::setCheckOrdered($dealer_id, 0);
				App\User::setLastOrderId($user_id);
			}
			if ($search_obj->type == 4) {
				// Modify the check_order of dealer_id
				//App\Dealer::setCheckOrder($dealer_id, 0);
				App\User::setLastPurchaseId($user_id);
			}
		}
		
		$tb_prefix = DB::getTablePrefix();
		$query = Order::query()
			->selectRaw('`'.$tb_prefix.'orders`.*, sum(`'.$tb_prefix.'orders`.`size`) as `order_count`, count(`'.$tb_prefix.'orders`.`id`) as `product_count` ')
			->join('products as p', 'p.id', '=', 'orders.product_id');
		if(property_exists($search_obj, "type") && $search_obj->type != ""){
			if($search_obj->type == 1){
				$query->where('orders.tag_dealer_id', '=', $login_info['dealer_id']);
				$query->where('orders.agree', '=', '0');
				$query->where('orders.agree', '=', '0');
			}
			else if($search_obj->type == 2){
				$query->where('orders.tag_dealer_id', '=', $login_info['dealer_id']);
				$query->where('orders.agree', '=', '1');
				$query->where('orders.status', '=', '0');
			}
			else if($search_obj->type == 3){
				$query->where('orders.tag_dealer_id', '=', $login_info['dealer_id']);
				$query->where('orders.agree', '=', '1');
				$query->where('orders.status', '=', '1');
			}
			else if($search_obj->type == 4){
				$query->where('orders.src_dealer_id', '=', $login_info['dealer_id']);
			}
			else if($search_obj->type == 5){
				if($login_info['authority'] != "admin") $query->where(1, '=', 0);
			}
		}
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where(function ($query) use ($search_obj) {
				$query	->where('p.name', 'like', '%'.$search_obj->keyword.'%')
						->orwhere('p.code', 'like', '%'.$search_obj->keyword.'%');
			});
		}
		$query->orderByDesc('orders.id');
		$query->groupBy('orders.code');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		
		$badge_arr = App\Badge::getBadgeAry($user_id, 'order');

		$total_price_list = array();
		foreach($items as $item){
		
			$item->product;
			$item->src_dealer;
			
			if (isset($badge_arr[''.$item->id])) $item->badge = $badge_arr[''.$item->id];
			else $item->badge = 0;
			
			$total_price_list[$item->code] = $this->get_order_price($item->code);
		}
		
		//var_dump(count($items));
		$return_arr['list'] = $items;
		$return_arr['price_list'] = $total_price_list;
		
		echo json_encode($return_arr);
	}
	
	private function get_order_price($order_code){
		// calculate order total price
		$order_item_list = Order::where('code', $order_code)->get();
		$total_price = 0;
		foreach($order_item_list as $item){
			$price_info = App\Price::get_price_by_dealer($item->product_id, $item->src_dealer_id);
			$promotion_rate = (isset($price_info['promotion']['promotion_price']))? $price_info['promotion']['promotion_price']/100 : 1;
			$total_price = $total_price + ($item->size * $price_info['purchase_price']) * $promotion_rate;
		}
		
		return $total_price;
	} 
	
    /*
		--page items get info json return function--
		parameter: order_id
		return: order_list, dealer info
	*/
	public function get_item_by_id($order_id, Request $request){
		
		$login_info = $request->session()->get('total_info');
		
		$user_id = $login_info['user_id'];
		App\Badge::removeBadge($user_id, $order_id, 'order');
		
		$order = Order::find($order_id);
		if(null !== $order){
			$this->get_item_by_code($order->code, $request);
		}else{
			echo json_encode(array("status" => false));
		}
	}
	
	public function get_item_by_code($order_code, Request $request){
		
		$login_info = $request->session()->get('total_info');
		
		$order_set = Order::where('code', $order_code)->get();
		
		if(null !== $order_set){
			$src_dealer_id = $order_set[0]->src_dealer_id;
			$dealer = App\Dealer::find($src_dealer_id);

			$stock_lack = false;
			
			foreach($order_set as $order_item){
				
				// product info
				$order_item->product;
				$order_item->product->level1_info;
				
				// price info
				$price_info = App\Price::get_price_by_dealer($order_item->product_id, $order_item->src_dealer_id);
				if(null === $price_info['promotion']['promotion_price']) $price_info['promotion']['promotion_price'] = 100;
				if(!isset($price_info['purchase_price'])) $price_info['purchase_price'] = 0;
				
				$price_info['real_purchase_price'] = $price_info['purchase_price'] * $price_info['promotion']['promotion_price'] / 100;
				$order_item->price_info = $price_info;
				
				// purchase stock check
				if($order_set[0]->agree == 0){
					if($order_set[0]->status == 0) $stock_dealer_id = $order_item['tag_dealer_id'];
					else if($order_set[0]->status == 1) $stock_dealer_id = $order_item['src_dealer_id'];
					$stock_count = App\Card::where([
						['dealer_id', '=', $stock_dealer_id],
						['product_id', '=', $order_item['product_id']],
						['type', '=', $order_item['card_type']],
						['status', '=', 0],
					])->count();
					$order_item->current_stock = $stock_count;
					if($order_item->size > $order_item->current_stock) $stock_lack = true;
				}
			}
			
			if($login_info['authority'] == "admin"){
				if($order_set[0]->card_type == 0) $stock_lack = false;
			} 
			
			echo json_encode(
				array(
					"status" => true, 
					"order_set" => $order_set, 
					"dealer" => $dealer, 
					"additional_info" => array(
						"total_price" => $this->get_order_price($order_code),
						"stock_lack" => $stock_lack,
						"can_agree" => ($login_info['dealer_id'] == $order_set[0]->tag_dealer_id),
					),
				)
			);
		}else{
			echo json_encode(array("status" => false));
		} 
	}
	
    /*
		order agree function
		parameter: order_code
		return: agree status
	*/
	public function agree_item($order_code, Request $request){
		
		set_time_limit(0);
		
		$userinfo = $request->session()->get('total_info');
		
		$pcard_code_list = array_keys($request->input('code_list'));
		
		$order_set = Order::where([['code', '=', $order_code], ['tag_dealer_id', '=', $userinfo['dealer_id']]])->get();
		
		if(count($order_set) == 0){
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		if($order_set[0]->agree != 0){
			echo json_encode(array("status" => 0)); exit;
		}
		
		$order_status = $order_set[0]->status; // 0: purchase, 1: return
		$return_status = true;
		
		$total_size = 0;

		// Check physical card list
		foreach($order_set as $order_item){
			// case of physical card purchase
			if($order_item->card_type == 1 && $order_item->status == 0){
				if($order_item->size 
					!= App\Card::check_pcard_count($order_item->tag_dealer_id, $order_item->product_id, $pcard_code_list)){
					echo json_encode(array("status" => false, "err_msg" => __('lang.od_pcard_quantity_lack'))); exit;
				}
			}
			// case of physical card return
			if($order_item->card_type == 1 && $order_item->status == 1){
				
				$check_status = true;
				
				$excel_file = storage_path($order_item->code_list);
				if(!is_file($excel_file)){
					$check_status = false;
				}else{
					// load first sheet and record
					$pcard_code_list = array();
					
					$results = Excel::load($excel_file, function($reader){})->get();
					$sheet = $results[0];

					foreach ($sheet as $row) {
						if($row[4] != null && $row[4] != "") 
							$pcard_code_list[] = $row[4];
					}

					if($order_item->size != App\Card::check_pcard_count($order_item->src_dealer_id, $order_item->product_id, $pcard_code_list)){
						$check_status = false;
						echo json_encode(array("status" => false, "err_msg" => __('lang.od_pcard_quantity_return_lack'))); exit;
					}
				}
			}
		}
		
		// Order agree [Card operation]
		foreach($order_set as $order_item){
			
			// Card valid time setting
			$order_item->product;
			
			$valid_period = mProvider::get_card_valid_period($order_item->product->valid_period);
			
			// tag dealer price info
			$price_info = App\Price::get_price_by_dealer($order_item->product_id, $order_item->tag_dealer_id);
			if(null === $price_info['promotion']['promotion_price']) $price_info['promotion']['promotion_price'] = 100;
			$purchase_price = $price_info['purchase_price'] * $price_info['promotion']['promotion_price'] / 100;
			
			// src dealer price info
			$price_info = App\Price::get_price_by_dealer($order_item->product_id, $order_item->src_dealer_id);
			if(null === $price_info['promotion']['promotion_price']) $price_info['promotion']['promotion_price'] = 100;
			$sale_price = $price_info['purchase_price'] * $price_info['promotion']['promotion_price'] / 100;
			$promotion = 0;
			if ($price_info["promotion"]["promotion_price"])
				$promotion = $price_info["purchase_price"] - $price_info["purchase_price"] * $price_info["promotion"]["promotion_price"] / 100;
			
			if($order_status == 0){		// purchase
				$card_tag_dealer = $order_item->tag_dealer_id;
				$card_src_dealer = $order_item->src_dealer_id;
			}
			else if($order_status == 1){	// return
				$card_tag_dealer = $order_item->src_dealer_id;
				$card_src_dealer = $order_item->tag_dealer_id;
			} 
			
			// Case virtual card and user is admin, when stock is less than order quantities, generate card
			if($userinfo['authority'] == "admin" && $order_item->card_type == 0){
				$card_count = $cards = App\Card::where([
						['dealer_id', '=', $card_tag_dealer],
						['product_id', '=', $order_item['product_id']],
						['status', '=', 0],
						['type', '=', $order_item['card_type']],
					])->count();
				
				if($order_item['card_type'] == 1)
					$service_card_type = 1;
				else if($order_item['card_type'] == 0 && $order_item['card_subtype'] == 1)
					$service_card_type = 3;
				else
					$service_card_type = 2;
			
				if($order_item->size > $card_count){
					$gen_status_array = App\Card::insertCard((object)['product_id' => $order_item['product_id'], 'service_card_type' => $service_card_type, 'service_cards' => ($order_item->size - $card_count), 'send_dealer' => $order_item->src_dealer_id]);
					if($gen_status_array['status'] == false){
						echo json_encode($gen_status_array); exit;
					}
				}
			}
			
			// card move
			if($order_item->card_type == 1){
				// If physical card
				$cards = App\Card::where([
						["dealer_id", "=", $card_tag_dealer],  
						['product_id', '=', $order_item['product_id']],
						['status', '=', 0],
						["type", "=", 1]
					])->whereIn('code', $pcard_code_list)->get();
				
			}else{
				// If virtual card
				$cards = App\Card::where([
						['dealer_id', '=', $card_tag_dealer],
						['product_id', '=', $order_item['product_id']],
						['status', '=', 0],
						['type', '=', $order_item['card_type']],
					])->take($order_item->size)->get();
			}
			
			$product_count = count($cards);
			
			//var_dump($card_src_dealer);
			
			foreach($cards as $card){
				
				$card->dealer_id = $card_src_dealer;
				//$card->valid_period = $valid_period;
				$return_status = $return_status & $card->save();
				
				// sales log
				
				App\Sale::add_sales_order_info(array(
							"status" => $order_status,
							"product_id" => $card->product_id,
							"order_code" => $order_item->code,
							"card_id" => $card->id,
							"tag_dealer_id" => $order_item->tag_dealer_id,
							"src_dealer_id" => $order_item->src_dealer_id,
							"seller_id" => $order_item->seller_id,
							"purchase_price" => $purchase_price,
							"sale_price" => $sale_price,
							"promotion" => $promotion,
						)
					);
				
				/* $sales_log = App\Sale::where([
						['tag_dealer_id', '=', $order_item->tag_dealer_id,],
						['card_id', '=', $card->id],
					])->first();
				if(null === $sales_log)	$sales_log = new App\Sale();
				
				$sales_log->status = $order_status;
				$sales_log->product_id = $card->product_id;
				$sales_log->card_id = $card->id;
				$sales_log->tag_dealer_id = $order_item->tag_dealer_id;
				$sales_log->src_dealer_id = $order_item->src_dealer_id;
				$sales_log->seller_id = $userinfo["user_id"];
				$sales_log->purchase_price = $purchase_price;
				$sales_log->sale_price = $sale_price;
				if($order_status == 0){		// purchase
					$sales_log->save();
				}
				else if($order_status == 1){	// return
					$sales_log->delete();
				} */
			}
			
			if($return_status){
				$order_item->agree = 1;
				$order_item->save();
			}
			
			
			$total_size += count($cards);
			
			// Stock info update			
			App\Stock::change_sale_stock($order_item->tag_dealer_id, $order_item->src_dealer_id, $order_item->product_id, $order_status, $order_item->size);
			
		}
		
		// log table
		$dealer = App\Dealer::find($userinfo["dealer_id"]);
		$src_dealer_name = ($dealer)? $dealer->name: "";	
		$product = App\Product::find($order_set[0]->product_id);
		$product_name = ($product)? $product->name: "";
		$product_name = (count($order_set) > 1)? $product_name." 外 ".(count($order_set) - 1)."件" : $product_name;

		if($order_status == 0)
			App\History::add_history(array("module_name"=>"订单", "operation_kind"=>"批准进货", "operation"=>"您的订单已生效，“".$product_name."”".$total_size."张已进入库存。"));
		else
			App\History::add_history(array("module_name"=>"订单", "operation_kind"=>"批准退货", "operation"=>"您的订单已生效，“".$product_name."”".$total_size."张已退货离库存。"));
		
		// Message table
		if($order_status == 0) {
			App\Message::save_message(array(
						"type" => "3",
						"tag_dealer_id" => $order_item->src_dealer_id,
						"tag_user_id" => null,
						"message" => "您的订单已生效，“".$product_name."”".$total_size."张已进入库存。",
						"url" => "",
						"html_message" => "<p>您的订单已生效，“".$product_name."”".$total_size."张已进入库存。</p>
											<p>服务卡：".$product_name."</p>
											<p>订单数量：".$total_size."张</p>",
						"table_name" => "purchase",
						"table_id" => $order_set[0]->id,
					));
			//App\Dealer::setCheckOrder($order_item->src_dealer_id, 1);
		}
		else {
			App\Message::save_message(array(
						"type" => "3",
						"tag_dealer_id" => $order_item->src_dealer_id,
						"tag_user_id" => null,
						"message" => $src_dealer_name." 申请退货服务卡“".$product_name."”".$total_size."张",
						"url" => "",
						"html_message" => "<p>您的订单已生效，“".$product_name."”".$total_size."张已退货离库存。</p>",
						"table_name" => "purchase",
						"table_id" => $order_set[0]->id,
					));
			//App\Dealer::setCheckOrder($order_item->src_dealer_id, 1);
		}

		echo json_encode(array("status" => $return_status));
	}
	/*
		order agree function
		parameter: order_code
		return: agree status
	*/
	public function refuse_item($order_code, Request $request){
		
		$userinfo = $request->session()->get('total_info');
		
		$order_set = Order::where('code', $order_code)->get();
		
		if($order_set[0]->agree != 0){
			echo json_encode(array("status" => 0));
		}
		
		$order_status = $order_set[0]->status; // 0: purchase, 1: return
		$return_status = true;
		
		$total_size = 0;
		
		foreach($order_set as $order_item){
			$order_item->agree = 2;
			$order_item->save();
			
			$total_size += (int)$order_item->size;
			
		}
		
		// log table
		$dealer = App\Dealer::find($userinfo["dealer_id"]);
		$src_dealer_name = ($dealer)? $dealer->name: "";	
		$product = App\Product::find($order_set[0]->product_id);
		$product_name = ($product)? $product->name: "";
		$product_name = (count($order_set) > 1)? $product_name." 外 ".(count($order_set) - 1)."件" : $product_name;

		if($order_status == 0)
			App\History::add_history(array("module_name"=>"订单", "operation_kind"=>"拒绝订货", "operation"=>"拒绝订货，“".$product_name."”".$total_size."张。"));
		else
			App\History::add_history(array("module_name"=>"订单", "operation_kind"=>"拒绝返还", "operation"=>"拒绝返还，“".$product_name."”".$total_size."张。"));
		
		// Message table
		if($order_status == 0) {
			App\Message::save_message(array(
						"type" => "3",
						"tag_dealer_id" => $order_item->src_dealer_id,
						"tag_user_id" => null,
						"message" => "拒绝订货，“".$product_name."”".$total_size."张。",
						"url" => "",
						"html_message" => "<p>拒绝订货，“".$product_name."”".$total_size."张。</p>
											<p>服务卡：".$product_name."</p>
											<p>订单数量：".$total_size."张</p>",
						"table_name" => "order",
						"table_id" => $order_set[0]->id,
					));
			//App\Dealer::setCheckOrder($order_item->src_dealer_id, 1);
		}
		else {
			App\Message::save_message(array(
						"type" => "3",
						"tag_dealer_id" => $order_item->src_dealer_id,
						"tag_user_id" => null,
						"message" => $src_dealer_name."拒绝返还, “".$product_name."”".$total_size."张",
						"url" => "",
						"html_message" => "<p>拒绝返还，“".$product_name."”".$total_size."张。</p>",
						"table_name" => "order",
						"table_id" => $order_set[0]->id,
					));
			//App\Dealer::setCheckOrder($order_item->src_dealer_id, 1);
		}

		echo json_encode(array("status" => $return_status));
	}
	//fileupload
	public function fileupload(Request $request){

    	$return_arr = array("status" => true);

		$dealer_file = $request->file("orderimport_file");		// "uploads/dealer_data/import/"

		if(null !== $dealer_file){
            $destinationPath = $this->order_upload_path;
            $filename = date("YmdHis_").rand(10000, 99999).".".$dealer_file->extension();

            if($dealer_file->move($destinationPath, $filename)){
                $file_pull_path = $destinationPath.$filename;

                Excel::load($file_pull_path, function($reader) {
                    // load all sheet and record
                    $results = $reader->all();

                    $sheetNo = 0;

                    foreach ($results as $sheet) {
                        $sheetNo++;
                        $title = $sheet->getTitle();

                        if ($title == "经销商订单") {                        // "经销商订单"
                            foreach ($sheet as $row) {
                                if ($row[0] == "")
                                    break;

                                $order = new APP\Order();
                                $order->code = $row[0];
                                $order->product_id = App\Product::getProductIdByName($row[8]);
                                $order->size = $row[9];
                                $order->src_dealer_id = App\Dealer::getDealerIDByCode($row[3]);
                                $order->tag_dealer_id = App\Dealer::getDealerIDByCode($row[6]);
                                $order->status = null;
                                $order->agree = 1;
                                $order->card_type = 1;
                                $order->valid_period = $row[2];
                                $order->application_date = $row[1];
                                $order->ratification_date = $row[2];
                                $order->save();
                            }
                        }
                    }
                });
            } else {
                $return_arr["status"] = false;
            }
        } else {
            $return_arr["status"] = false;
        }

        return json_encode($return_arr);
	}
	//export
	public function export(Request $request){		
		$data = json_decode(file_get_contents("php://input"));	
		
		echo json_encode(array("status" => "ok"));
	}
	
	// Check each physical card code validation
	public function check_each_pcard(){
		
		$data = json_decode(file_get_contents("php://input"), true);
		
		$ret_status = App\Card::check_pcard_code($data['product_id'], $data['card_code']);
		
		echo json_encode(array("status" => $ret_status));
	}
	
	public function check_file_pcard(Request $request){
		
		$pcard_code_file = $request->file("pcard_file");
		$product_id = $request->input("product_id");
		
		$card_code_infile_position = 3;
		
		if (null !== $pcard_code_file) {
			Excel::load($pcard_code_file->path(), function($reader) use($product_id, $card_code_infile_position) {
				
				$total_card = 0;
				$valid_card = 0;
				$valid_card_list = array();
				$invalid_card_list = array();
				
				// load all sheet and record
				$results = $reader->all();
				foreach ($results as $sheet) {
					$title = $sheet->getTitle();
					foreach ($sheet as $row) {
						$code = $row[$card_code_infile_position];
						
						if($code !== null){
							$total_card ++;
							$check_status = App\Card::check_pcard_code($product_id, $code);
							
							if(!$check_status){
								$invalid_card_list[] = $code;
							}else{
								$valid_card_list[] = $code;
								$valid_card ++;
							}
						}
					}
				}
				
				
				if($valid_card == 0){
					$return_arr = array("status" => false, "err_msg" => __('lang.error_no_valid_card'));
				}else{
					$exist_invalid_card = ($total_card == $valid_card)? false: true;
					$invalid_cards = $invalid_card_list;
					
					$return_arr = array("status" => true, "valid_code_list" => $valid_card_list, "total_cards_quantity" => $total_card, "valid_cards_quantity" => $valid_card, "exist_invalid_card" => $exist_invalid_card, "invalid_cards" => $invalid_cards);
				}
				
				echo json_encode($return_arr);
			});
		}else{
			$return_arr = array("status" => false, "err_msg" => __('lang.error_file_upload_failed'));
			echo json_encode($return_arr);
		}
	}
	
	/* public function create(Request $request){
		
		$input = $request->all();
		
		$product = App\Product::where('id', '=', $input['product_id'])->first();
		
		$order = new App\Order;
		$order->product_id = $input['product_id'];
		$order->order_date = date("Y-m-d H:i:s");
		$order->order_price = $product->promotion_price;
		$order->order_price_history = $product->promotion_price."/".$input['order_count']."/".($product->promotion_price * $input['order_count']);
		$order->applicant_kind = ($input['type'] == 0)? "Act": "Return";
		$order->order_quantity = $input['order_count'];
		
		$return_status = $order->save();
		
		echo json_encode(array("status" => $return_status));
	} */
	
	
	// pc order view
	/* public function pending(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_pending');
	}
	public function pending_info(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_pending_info');
	}
	public function sale(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_sale');
	}
	public function sale_info(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_sale_info');
	}
	public function view_return(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_return');
	}
	public function return_info(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_return_info');
	}
	public function myorder(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_myorder');
	}
	public function myorder_info(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'order_myorder_info');
	} */
	
}
