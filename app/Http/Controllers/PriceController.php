<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

use App\Product;
use App\ProductLevel;
use App\Price;
use App\User;
use App\Stock;
use App\Dealer;
use App\Promotion;

class PriceController extends Controller
{
	public function index(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price');
	}
	public function view(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_view');
	}
	public function edit(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_edit');
	}
	public function edit_detail(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_edit_detail');
	}
	public function discount_select(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_discount_select');
	}
	public function discount_input(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_discount_input');
	}
	public function discount_edit(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_discount_edit');
	}
	public function view_reg_list(){			// Seller register list page   [seller]
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'register');
	}	
	public function view_reg_edit(){			// Seller register view page   [seller]
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'register_edit');
	}
	// pc price view
	public function discount_set(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'price_discount_set');
	}
	// Save level price to the product table
	public function save_level_price(Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));

			$product = Product::find($data->product_id);
			/*if ($product == null) 
				$product = new Product;*/

			if ($data->price_sku)
				$product->price_sku = $data->price_sku;
			
			if ($data->purchase_price_level)
				$product->purchase_price_level = json_encode($data->purchase_price_level);

			if ($data->sale_price)
				$product->sale_price = $data->sale_price;
			
			$product->order_limit_down_level = json_encode($data->order_limit_down_level);
			
			$product->order_limit_up_level = json_encode($data->order_limit_up_level);

			$product->save();
			
			
			// log table
			App\History::add_history(array("module_name"=>"价格", "operation_kind"=>"修改信息", "operation"=>"修改价格 \"".$product->name."\" 产品价格"));
			
			// Message table
			App\Message::save_message(array(
						"type" => "1",
						"tag_dealer_id" => "0",
						"tag_user_id" => null,
						"message" => "修改信息 \"".$product->name."\" 产品",
						"url" => "#!/price/view/".$product->id,
						"html_message" => "",
						"table_name" => "price",
						"table_id" => $product->id,
					));

			$ret_ary['success'] = true;
		}
		else 
			$ret_ary['success'] = false;

		return json_encode($ret_ary);
	}

	// Get the dealer_name, dealer_manager, dealer_stock, dealer_promotion by dealer_id divided by dealer_level
	public function get_dealer_manager_stock($product_id_list) { //$product_id_list: {'list' : [product_id1, product_id2, ...]}
		$manager_list = App\User::getManagerNameListByDelaer('负责人');
		
		$products = json_decode($product_id_list);
		$product_list = $products->list;
		$stock_ary = array();
		foreach ($product_list as $product_id) {
			$stock_ary[''.$product_id] = App\Stock::getStockByDealer($product_id);
		}
		
		$dealer_levels = array();
		for ($i = 0; $i < 3; $i++) {
			$dealer_levels[$i] = array();
			$dealer_levels[$i]['dealers'] = App\Dealer::getDealersByLevel($i + 1);
			// Get the manager name of the dealer
			foreach ($dealer_levels[$i]['dealers'] as $dealer) {
				if (isset($manager_list[''.$dealer->id]))
					$dealer->manager_name = $manager_list[''.$dealer->id];
				else
					$dealer->manager_name = '';
				// Get the sum of the produts' stock by dealer
				$dealer->stock = 0;
				foreach ($product_list as $product_id) {
					if (isset($stock_ary[''.$product_id][''.$dealer->id]))
						$dealer->stock += $stock_ary[''.$product_id][''.$dealer->id];
				}
			}
		}
		
		echo json_encode($dealer_levels);
	}

	// Get the purchase_price, wholesale_price, sale_price, promotion of product by dealer
	public function get_price_dealer($product_id, Request $request) {
		$login_info = $request->session()->get('total_info');
		
		$dealer_id = $login_info['dealer_id'];
		$up_dealer_id = $login_info['up_dealer']['id'];
		$dealer_level = $login_info['level'];

		$product = Product::find($product_id);
		$typestr_level1 = App\ProductLevel::where([['level', '=', '1'], ['id', '=', $product->level1_id]])->select('description')->first()['description'];
		$typestr_level2 = App\ProductLevel::where([['level', '=', '2'], ['id', '=', $product->level2_id]])->select('description')->first()['description'];
		$product->typestr_level1 = $typestr_level1;
		$product->typestr_level2 = $typestr_level2;
		
		$price_ary = App\Price::get_price_by_dealer($product_id, $dealer_id);
		$ret_ary = array();
		
		$ret_ary['wholesale_price'] = $price_ary['wholesale_price'];
		$ret_ary['sale_price'] = $price_ary['sale_price'];
		$ret_ary['purchase_price'] = $price_ary['purchase_price'];
		
		$ret_ary['promotion'] = $price_ary['promotion'];
		$ret_ary['product'] = $product;

		return json_encode($ret_ary);
	}

	// Set the promotion of product by level request
	public function set_level_promotion(Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));
			$product = App\Product::find($data->product_id);
			$level = 1;
			foreach ($data->promotions as $index => $promotion_price) {
				if ($promotion_price) {
					$promotion = App\Promotion::where('product_id', $data->product_id)
						->where('dealer_id', 1)
						->where('level', $level)
						->where(function ($q) use ($data, $index) {
							$q->where(function ($q) use ($data, $index) {
								$q->where('promotion_start_date', '<=', $data->promotion_start_dates[$index])
								->where('promotion_end_date', '>=', $data->promotion_start_dates[$index]);
							})
							->orWhere(function ($q) use ($data, $index) {
								$q->where('promotion_start_date', '<=', $data->promotion_end_dates[$index])
								->where('promotion_end_date', '>=', $data->promotion_end_dates[$index]);
							})
							->orWhere(function ($q) use ($data, $index) {
								$q->where('promotion_start_date', '>=', $data->promotion_start_dates[$index])
								->where('promotion_end_date', '<=', $data->promotion_end_dates[$index]);
							});
						})->first();
					
					if ($promotion) {
						$ret_ary['success'] = false;
						$ret_ary['err_msg'] = __('lang.price_promotion_exist');
						
						return json_encode($ret_ary);
					}
				}
				$level++;
			}
			$level = 1;
			foreach ($data->promotions as $index => $promotion_price) {
				if ($promotion_price) {
					$promotion = new Promotion;
					$promotion->product_id = $data->product_id;
					$promotion->dealer_id = 1;
					$promotion->level = $level;
					$promotion->promotion_price = $promotion_price;
					$promotion->promotion_start_date = $data->promotion_start_dates[$index];
					$promotion->promotion_end_date = $data->promotion_end_dates[$index];
					$promotion->promotion_network = 0;
					$promotion->save();
					// log table
					App\History::add_history(array("module_name"=>"价格", "operation_kind"=>"促销设置", "operation"=>$product->name." ".$level."级经销商 促销设置"));
					
					$dealers = App\Dealer::where('level', $level)->get();
					foreach ($dealers as $dealer) {
						// Message table
						App\Message::save_message(array(
							"type" => "1",
							"tag_dealer_id" => $dealer->id,
							"tag_user_id" => null,
							"message" => $product->name." ".$level."级经销商 促销设置",
							"url" => "#!/price/view/".$product->id,
							"html_message" => "",
							"table_name" => "promotion",
							"table_id" => $promotion->id,
						));
					}
				}
				$level++;
			}
			$ret_ary['success'] = true;
		}
		else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}

		return json_encode($ret_ary);
	}
	// Set the promotion of product by dealer_id request
	public function set_dealer_promotion(Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));
			$product = App\Product::find($data->product_id);
			foreach ($data->dealers as $dealer_id) {
				$promotion = App\Promotion::where('product_id', $data->product_id)
					->where('dealer_id', $dealer_id)
					->where('level', null)
					->where(function ($q) use ($data) {
						$q->where(function ($q) use ($data) {
							$q->where('promotion_start_date', '<=', $data->promotion_start_date)
							->where('promotion_end_date', '>=', $data->promotion_start_date);
						})
						->orWhere(function ($q) use ($data) {
							$q->where('promotion_start_date', '<=', $data->promotion_end_date)
							->where('promotion_end_date', '>=', $data->promotion_end_date);
						})
						->orWhere(function ($q) use ($data) {
							$q->where('promotion_start_date', '>=', $data->promotion_start_date)
							->where('promotion_end_date', '<=', $data->promotion_end_date);
						});
					})->first();
				
				if ($promotion) {
					$ret_ary['success'] = false;
					$ret_ary['err_msg'] = __('lang.price_promotion_exist');
					
					return json_encode($ret_ary);
				}
			}
			foreach ($data->dealers as $dealer_id) {
				$dealer = App\Dealer::find($dealer_id);
				$promotion = new Promotion;
				$promotion->product_id = $data->product_id;
				$promotion->dealer_id = $dealer_id;
				$promotion->level = null;
				$promotion->promotion_price = $data->promotion_price;
				$promotion->promotion_start_date = $data->promotion_start_date;
				$promotion->promotion_end_date = $data->promotion_end_date;
				$promotion->promotion_network = 0;
				$promotion->save();
				
				// log table
				App\History::add_history(array("module_name"=>"价格", "operation_kind"=>"促销设置", "operation"=>$product->name." ".$dealer->name." 促销设置"));
				
				// Message table
				App\Message::save_message(array(
					"type" => "1",
					"tag_dealer_id" => $dealer_id,
					"tag_user_id" => null,
					"message" => $product->name." ".$dealer->name." 促销设置.",
					"url" => "#!/price/view/".$product->id,
					"html_message" => "",
					"table_name" => "promotion",
					"table_id" => $promotion->id,
				));
			}

			$ret_ary['success'] = true;
		}
		else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}

		return json_encode($ret_ary);
	}
	
	// Get promotion list of product
	public function get_promotion_list($product_id, $itemcount, $pagenum) {
		// Get current date time
		$cur_date = date("Y-m-d");
		$promotions = App\Promotion::get_promotion_list($product_id, $cur_date, $itemcount, $pagenum);
		
		return json_encode($promotions);
	}
	
	// Edit promotion
	public function edit_promotion(Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));
			$promotion = App\Promotion::where('product_id', $data->product_id)
				->where('dealer_id', $data->dealer_id)
				->where('level', $data->level)
				->where('id', '<>', $data->id)
				->where(function ($q) use ($data) {
					$q->where(function ($q) use ($data) {
						$q->where('promotion_start_date', '<=', $data->promotion_start_date)
						->where('promotion_end_date', '>=', $data->promotion_start_date);
					})
					->orWhere(function ($q) use ($data) {
						$q->where('promotion_start_date', '<=', $data->promotion_end_date)
						->where('promotion_end_date', '>=', $data->promotion_end_date);
					})
					->orWhere(function ($q) use ($data) {
						$q->where('promotion_start_date', '>=', $data->promotion_start_date)
						->where('promotion_end_date', '<=', $data->promotion_end_date);
					});
				})->first();
			
			if ($promotion) {
				$ret_ary['success'] = false;
				$ret_ary['err_msg'] = __('lang.price_promotion_exist');
				
				return json_encode($ret_ary);
			}
			
			$promotion = App\Promotion::find($data->id);
			$promotion->promotion_price = $data->promotion_price;
			$promotion->promotion_start_date = $data->promotion_start_date;
			$promotion->promotion_end_date = $data->promotion_end_date;
			
			$promotion->save();
			
			$product = $promotion->product;
			if ($promotion->level) {
				$dealer_name = $promotion->level.'级经销商';
				$dealers = App\Dealer::where('level', $promotion->level)->get();
				foreach ($dealers as $dealer) {
					// Message table
					App\Message::save_message(array(
						"type" => "1",
						"tag_dealer_id" => $dealer->id,
						"tag_user_id" => null,
						"message" => $product->name." ".$promotion->level."级经销商 促销编辑",
						"url" => "#!/price/view/".$product->id,
						"html_message" => "",
						"table_name" => "promotion",
						"table_id" => $promotion->id,
					));
				}
			} else {
				$dealer_name = $promotion->dealer->name;
				// Message table
				App\Message::save_message(array(
					"type" => "1",
					"tag_dealer_id" => $promotion->dealer_id,
					"tag_user_id" => null,
					"message" => $product->name." ".$dealer_name." 促销编辑.",
					"url" => "#!/price/view/".$product->id,
					"html_message" => "",
					"table_name" => "promotion",
					"table_id" => $promotion->id,
				));
			}
			
			// log table
			App\History::add_history(array("module_name"=>"价格", "operation_kind"=>"促销编辑", "operation"=>$product->name." ".$dealer_name." 促销编辑"));
			
			$ret_ary['success'] = true;
		} else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}
		
		return json_encode($ret_ary);
	}
	// Remove promotion
	public function remove_promotion(Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			$data = json_decode(file_get_contents("php://input"));
			App\Promotion::where('id', $data->id)->delete();
			
			$product = App\Product::find($data->product_id);
			if ($data->level) {
				$dealer_name = $data->level.'级经销商';
				$dealers = App\Dealer::where('level', $data->level)->get();
				foreach ($dealers as $dealer) {
					// Message table
					App\Message::save_message(array(
						"type" => "1",
						"tag_dealer_id" => $dealer->id,
						"tag_user_id" => null,
						"message" => $product->name." ".$data->level."级经销商 促销删除",
						"url" => "#!/price/view/".$product->id,
						"html_message" => "",
						"table_name" => "promotion",
						"table_id" => $data->id,
					));
				}
			} else {
				$dealer = App\Dealer::find($data->dealer_id);
				$dealer_name = $dealer->name;
				// Message table
				App\Message::save_message(array(
					"type" => "1",
					"tag_dealer_id" => $data->dealer_id,
					"tag_user_id" => null,
					"message" => $product->name." ".$dealer_name." 促销删除.",
					"url" => "#!/price/view/".$product->id,
					"html_message" => "",
					"table_name" => "promotion",
					"table_id" => $data->id,
				));
			}
						
			// log table
			App\History::add_history(array("module_name"=>"价格", "operation_kind"=>"促销删除", "operation"=>$product->name." ".$dealer_name." 促销删除"));
			
			$ret_ary['success'] = true;
		} else {
			$ret_ary['success'] = false;
			$ret_ary['err_msg'] = __('lang.price_promotion_errmsg');
		}
		
		return json_encode($ret_ary);
	}
	
	// Get dealer_list with promotion
	public function get_downdealerwithpromotion($product_id, $dealer_id) {
		// Get current date time
		$cur_date = date("Y-m-d");
		
		$dealers = App\Dealer::getChildDealerWithPromotionArray($cur_date, $dealer_id, $product_id);
		
		return json_encode($dealers);
	}
	
	// Get dealer_list with promotion
	public function get_updealerwithpromotion($product_id, $dealer_id) {
		// Get current date time
		$cur_date = date("Y-m-d");
		
		$dealers = App\Dealer::getChildOfParentDealerWithPromotionArray($cur_date, $dealer_id, $product_id);
		
		return json_encode($dealers);
	}
	
	// Get dealer_level list with promotion
	public function get_levelpromotion($product_id) {
		// Get current date time
		$cur_date = date("Y-m-d");
		
		$dealers = App\Dealer::getPromotionArrayIndexedByLevel($cur_date, $product_id);
		
		return json_encode($dealers);
	}
	
	// Get dealer list with promotion from search_name
	public function get_dealerpromotion($product_id, $search_name) {
		// Get current date time
		$cur_date = date("Y-m-d");
		
		$dealers = App\Dealer::getDealerFromName($cur_date, $product_id, $search_name);
		
		return json_encode($dealers);
	}
}
