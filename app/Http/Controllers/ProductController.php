<?php

namespace App\Http\Controllers;

use App;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use mProvider;

use App\Product;
use App\Promotion;

class ProductController extends Controller
{
	private $logo_upload_path = "uploads/products/logo/";
	
	/*******************************
		Dispaly product list page template
	*******************************/
	public function view_list(Request $request){
		//var_dump($request->session()->get('total_info'));
		$login_info = $request->session()->get('total_info');
		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product');
	}
	/*******************************
		Dispaly product activelist page template
	*******************************/
	public function view_activelist(Request $request){
		//var_dump($request->session()->get('total_info'));
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product_activelist');
	}
	
	/*******************************
		Request product list info
	*******************************/
	public function get_list($search_json, $itemcount, $pagenum, Request $request){
		$login_info = $request->session()->get('total_info');
		$priv = $request->session()->get('site_priv');
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		
		if (property_exists($search_obj, "page_type")) {
			if ($search_obj->page_type == 'product' && $pagenum == 1) {
				$user_id = $login_info['user_id'];
				App\User::setLastProductId($user_id);
			}
		}		
		
		$query = Product::query();
		if ($priv != 'admin'){
			$query->where('status', '=', 1);
		}
		if(property_exists($search_obj, "level1_type") && $search_obj->level1_type != ""){
			$query->where('level1_id', '=', $search_obj->level1_type);
		}
		if(property_exists($search_obj, "level2_type") && $search_obj->level2_type != ""){
			$query->where('level2_id', '=', $search_obj->level2_type);
		}
		/* if(property_exists($search_obj, "status") && $search_obj->status != ""){
			$query->where('status', '=', $search_obj->status);
		} */
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where(function ($query) use ($search_obj) {
				$query	->where('name', 'like', '%'.$search_obj->keyword.'%')
						->orwhere('code', 'like', '%'.$search_obj->keyword.'%');
			});
		}
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		// add level1, level2 str
		$level1_arr = App\ProductLevel::getIndexdArray(1);
		$level2_arr = App\ProductLevel::getIndexdArray(2);

		// Get current date time
		$cur_date = date("Y-m-d H:i:s");
		
		$user_id = $login_info['user_id'];
		$badge_arr = App\Badge::getBadgeAry($user_id, 'product');

		if ($priv == 'dealer') {
			
			$dealer_id = $login_info['dealer_id'];

			$price_arr = App\Price::getPriceListByProduct($dealer_id);
		}

		foreach($return_arr['list'] as $item){
			if(isset($level1_arr[''.$item->level1_id])) $item->typestr_level1 = $level1_arr[''.$item->level1_id]['description'];
			else $item->typestr_level1 = "";
			if(isset($level2_arr[''.$item->level2_id])) $item->typestr_level2 = $level2_arr[''.$item->level2_id]['description'];
			else $item->typestr_level2 = "";
			
			if (isset($badge_arr[''.$item->id])) $item->badge = $badge_arr[''.$item->id];
			else $item->badge = 0;

			if ($priv == 'dealer') {
				if(isset($price_arr[''.$item->id])) 
				{
					$item->purchase_price = $price_arr[''.$item->id]->purchase_price;
					$item->wholesale_price = $price_arr[''.$item->id]->wholesale_price;
					$item->sale_price = $price_arr[''.$item->id]->sale_price;
					$item->promotion_price = $price_arr[''.$item->id]->promotion_price;
					$item->promotion_start_date = $price_arr[''.$item->id]->promotion_start_date;
					$item->promotion_end_date = $price_arr[''.$item->id]->promotion_end_date;
				}
				else {
					$item->purchase_price = 0;
					$item->wholesale_price = 0;
					$item->sale_price = 0;
					$item->promotion_price = null;
					$item->promotion_start_date = null;
					$item->promotion_end_date = null;
				}
			} else {
				$item->purchase_price_level = json_decode($item->purchase_price_level, true);
				$item->order_limit_down_level = json_decode($item->order_limit_down_level, true);
				$item->order_limit_up_level = json_decode($item->order_limit_up_level, true);
			}
		}
		
		echo json_encode($return_arr);
	}
	
	/*******************************
		Request product list info
	*******************************/
	public function get_generatelist($search_json, $itemcount, $pagenum, Request $request){
		
		$priv = $request->session()->get('site_priv');
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		
		$query = Product::query();
		
		if(property_exists($search_obj, "level1_type") && $search_obj->level1_type != ""){
			$query->where('level1_id', '=', $search_obj->level1_type);
		}
		if(property_exists($search_obj, "level2_type") && $search_obj->level2_type != ""){
			$query->where('level2_id', '=', $search_obj->level2_type);
		}
		if(property_exists($search_obj, "status") && $search_obj->status != ""){
			$query->where('status', '=', $search_obj->status);
		}
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where(function ($query) use ($search_obj) {
				$query	->where('name', 'like', '%'.$search_obj->keyword.'%')
						->orwhere('code', 'like', '%'.$search_obj->keyword.'%');
			});
		}
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		// add level1, level2 str
		$level1_arr = App\ProductLevel::getIndexdArray(1);
		$level2_arr = App\ProductLevel::getIndexdArray(2);

		// Get current date time
		$cur_date = date("Y-m-d H:i:s");
		// Get total promotion of current date
		$promotion_arr = App\Promotion::getTotalPromotion($cur_date);

		if ($priv == 'dealer') {
			
			$login_info = $request->session()->get('total_info');
			$dealer_id = $login_info['dealer_id'];

			$price_arr = App\Price::getPriceListByProduct($dealer_id);
		}

		foreach($return_arr['list'] as $item){
			if(isset($level1_arr[''.$item->level1_id])) $item->typestr_level1 = $level1_arr[''.$item->level1_id]['description'];
			else $item->typestr_level1 = "";
			if(isset($level2_arr[''.$item->level2_id])) $item->typestr_level2 = $level2_arr[''.$item->level2_id]['description'];
			else $item->typestr_level2 = "";
			// add total promotion info
			if(isset($promotion_arr[''.$item->id])) $item->total_promotion = $promotion_arr[''.$item->id];
			else $item->total_promotion = null;

			if ($priv == 'dealer') {
				if(isset($price_arr[''.$item->id])) 
				{
					$item->purchase_price = $price_arr[''.$item->id]->purchase_price;
					$item->wholesale_price = $price_arr[''.$item->id]->wholesale_price;
					$item->sale_price = $price_arr[''.$item->id]->sale_price;
					$item->promotion_price = $price_arr[''.$item->id]->promotion_price;
					$item->promotion_start_date = $price_arr[''.$item->id]->promotion_start_date;
					$item->promotion_end_date = $price_arr[''.$item->id]->promotion_end_date;
				}
				else {
					$item->purchase_price = 0;
					$item->wholesale_price = 0;
					$item->sale_price = 0;
					$item->promotion_price = null;
					$item->promotion_start_date = null;
					$item->promotion_end_date = null;
				}
			} else {
				$item->purchase_price_level = json_decode($item->purchase_price_level, true);
				$item->order_limit_down_level = json_decode($item->order_limit_down_level, true);
				$item->order_limit_up_level = json_decode($item->order_limit_up_level, true);
			}
		}
		
		echo json_encode($return_arr);
	}
	
	/*******************************
		Request product list info
	*******************************/
	public function get_activelist($search_json, $itemcount, $pagenum, Request $request){
		
		$priv = $request->session()->get('site_priv');
			
		$login_info = $request->session()->get('total_info');
		$dealer_id = $login_info['dealer_id'];
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		$tb_prefix = DB::getTablePrefix();
		
		$priv = $request->session()->get('site_priv');
		
		$query = Product::query()
						->selectRaw('`'.$tb_prefix.'products`.*, '.$tb_prefix.'c.dealer_id')
						->join('cards as c', 'c.product_id', '=', 'products.id');
		if ($priv != 'admin'){
			$query->where('products.status', '=', 1);
		}
		if(property_exists($search_obj, "level1_type") && $search_obj->level1_type != ""){
			$query->where('level1_id', '=', $search_obj->level1_type);
		}
		if(property_exists($search_obj, "level2_type") && $search_obj->level2_type != ""){
			$query->where('level2_id', '=', $search_obj->level2_type);
		}
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where(function ($query) use ($search_obj) {
				$query	->where('name', 'like', '%'.$search_obj->keyword.'%')
						->orwhere('code', 'like', '%'.$search_obj->keyword.'%');
			});
		}
		$query->where('c.dealer_id', '=', $dealer_id);
		$query->orderByDesc('id');
		$query->groupBy('c.product_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		// add level1, level2 str
		$level1_arr = App\ProductLevel::getIndexdArray(1);
		$level2_arr = App\ProductLevel::getIndexdArray(2);

		// Get current date time
		$cur_date = date("Y-m-d H:i:s");
		// Get total promotion of current date
		$promotion_arr = App\Promotion::getTotalPromotion($cur_date);

		if ($priv == 'dealer') {

			$price_arr = App\Price::getPriceListByProduct($dealer_id);
		}

		foreach($return_arr['list'] as $item){				
			if(isset($level1_arr[''.$item->level1_id])) $item->typestr_level1 = $level1_arr[''.$item->level1_id]['description'];
			else $item->typestr_level1 = "";
			if(isset($level2_arr[''.$item->level2_id])) $item->typestr_level2 = $level2_arr[''.$item->level2_id]['description'];
			else $item->typestr_level2 = "";
			// add total promotion info
			if(isset($promotion_arr[''.$item->id])) $item->total_promotion = $promotion_arr[''.$item->id];
			else $item->total_promotion = null;

			if ($priv == 'dealer') {
				if(isset($price_arr[''.$item->id])) 
				{
					$item->purchase_price = $price_arr[''.$item->id]->purchase_price;
					$item->wholesale_price = $price_arr[''.$item->id]->wholesale_price;
					$item->sale_price = $price_arr[''.$item->id]->sale_price;
					$item->promotion_price = $price_arr[''.$item->id]->promotion_price;
					$item->promotion_start_date = $price_arr[''.$item->id]->promotion_start_date;
					$item->promotion_end_date = $price_arr[''.$item->id]->promotion_end_date;
				}
				else {
					$item->purchase_price = 0;
					$item->wholesale_price = 0;
					$item->sale_price = 0;
					$item->promotion_price = null;
					$item->promotion_start_date = null;
					$item->promotion_end_date = null;
				}
			} else {
				$item->purchase_price_level = json_decode($item->purchase_price_level, true);
				$item->order_limit_down_level = json_decode($item->order_limit_down_level, true);
				$item->order_limit_up_level = json_decode($item->order_limit_up_level, true);
			}
		}
		
		echo json_encode($return_arr);
	}
	
	/*******************************
		Request Card list join product info
	*******************************/
	public function get_cardlist($search_json, $itemcount, $pagenum){
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		$tb_prefix = DB::getTablePrefix();
		
		$query = App\Card::query()
			->selectRaw('`'.$tb_prefix.'cards`.*, '.$tb_prefix.'p.name')
			->join('products as p', 'p.id', '=', 'cards.product_id');
			
		$query->where('p.status', '=', 1);
		if(property_exists($search_obj, "level1_type") && $search_obj->level1_type != ""){
			$query->where('p.level1_id', '=', $search_obj->level1_type);
		}
		if(property_exists($search_obj, "level2_type") && $search_obj->level2_type != ""){
			$query->where('p.level2_id', '=', $search_obj->level2_type);
		}
		$query->where('cards.status', '=', '1');	
		$query->where('cards.agree_reg', '!=', 'r');	
		$query->orderByDesc('cards.id');
		
		
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	/*******************************
		Request product list and add inventory info
	*******************************/
	public function get_addlist($search_json, $itemcount, $pagenum){
		
		$userinfo = Session::get('total_info');
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		
		$query = Product::query();
		$query->where('purchase_price_level', '!=', null);
		
		$query->where('status', '=', 1);
		
		if(property_exists($search_obj, "level1_type") && $search_obj->level1_type != ""){
			$query->where('level1_id', '=', $search_obj->level1_type);
		}
		if(property_exists($search_obj, "level2_type") && $search_obj->level2_type != ""){
			$query->where('level2_id', '=', $search_obj->level2_type);
		}
		/* if(property_exists($search_obj, "status") && $search_obj->status != ""){
			$query->where('status', '=', $search_obj->status);
		} */
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where(function ($query) use ($search_obj) {
				$query	->where('name', 'like', '%'.$search_obj->keyword.'%')
						->orwhere('code', 'like', '%'.$search_obj->keyword.'%');
			});
			/* $query->where('name', 'like', '%'.$search_obj->keyword.'%');
			$query->orwhere('code', 'like', '%'.$search_obj->keyword.'%'); */
		}
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		// add level1, level2 str
		$level1_arr = App\ProductLevel::getIndexdArray(1);
		$level2_arr = App\ProductLevel::getIndexdArray(2);		

		$option_min = App\Option::get_option(1, "order_single_minium");
		$option_max = App\Option::get_option(1, "order_single_maxium");
		
		foreach($return_arr['list'] as $item){
			if(isset($level1_arr[''.$item->level1_id])) $item->typestr_level1 = $level1_arr[''.$item->level1_id]['description'];
			else $item->typestr_level1 = "";
			if(isset($level2_arr[''.$item->level2_id])) $item->typestr_level2 = $level2_arr[''.$item->level2_id]['description'];
			else $item->typestr_level2 = "";
			
			$item->rule;
			
			//// add inventory modifing
			$item->price = App\Price::get_price_by_dealer($item->id, $userinfo["dealer_id"]);
			$physical_inventory = App\Card::getCountInventory($item->id, $userinfo["dealer_id"], 'type', 1);
			$virtual_inventory = App\Card::getCountInventory($item->id, $userinfo["dealer_id"], 'type', 0);
			$dealer_inventory = App\Card::getCountInventory($item->id, $userinfo["dealer_id"], 'dealer_id', $userinfo["dealer_id"]);
			$item->physical_inventory = $physical_inventory;
			$item->virtual_inventory = $virtual_inventory;
			$item->dealer_inventory = $dealer_inventory;
			
			$order_limit_down_ary = json_decode($item->order_limit_down_level, true);
			$order_limit_up_ary = json_decode($item->order_limit_up_level, true);
			
			if ($userinfo['level'] - 1 >= 0) {
				if ($order_limit_down_ary[$userinfo['level'] - 1]) $min_order_val = $order_limit_down_ary[$userinfo['level'] - 1];
				else $min_order_val = $option_min;
			} else {
				$min_order_val = null;
			}
			
			if ($userinfo['level'] - 1 >= 0) {
				if ($order_limit_up_ary[$userinfo['level'] - 1]) $max_order_val = $order_limit_up_ary[$userinfo['level'] - 1];
				else $max_order_val = $option_max;
			} else {
				$max_order_val = null;
			}
			
			$item->min_order_val = $min_order_val;
			$item->max_order_val = $max_order_val;
		}
		
		
		$return_arr['dealers_1stlevel'] = App\Dealer::where('level', '=', 1)->get();
		
		echo json_encode($return_arr);
	}
	
	/*******************************
		Dispaly product item view page template
	*******************************/
	public function view_item(Request $request){
		
		//var_dump($request->session());
		$userinfo = Session::get('total_info');
		$view_info = [
			'is_salepoint' => count($userinfo['down_dealers']) == 0,
		];
		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product_view', $view_info);
	}
	
	/*******************************
		Dispaly product edit page template
	*******************************/
	public function view_edit_item(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product_edit');
	}
	
	/*******************************
		Request get product item info
	*******************************/	
	public function get_item($product_id, $type_list_require = 0, $dealer_list_require = 0, Request $request){
		
		if($product_id == 0){
			$product = new Product();
			$product->image_url = "data:image/gif;base64,R0lGODlhAgABAJEAAAAAAP///6urq////yH5BAEAAAMALAAAAAACAAEAAAIClAoAOw==";
			$product->status = 1;
		}
		else $product = Product::find($product_id);
		
		$login_info = $request->session()->get('total_info');
		
		$user_id = $login_info['user_id'];
		App\Badge::removeBadge($user_id, $product_id, 'product');
		
		$max_level = App\Dealer::max('level');
		$purchase_price_ary = array();
		
		if($product){	// Product exist	
		
			$typestr_level1 = App\ProductLevel::where([['level', '=', '1'], ['id', '=',$product->level1_id]])->select('description')->first()['description'];
			$typestr_level2 = App\ProductLevel::where([['level', '=', '2'], ['id', '=',$product->level2_id]])->select('description')->first()['description'];
			$typestr_level3 = App\ProductLevel::where([['level', '=', '3'], ['id', '=',$product->level3_id]])->select('description')->first()['description'];
			$product->typestr_level1 = $typestr_level1;
			$product->typestr_level2 = $typestr_level2;
			$product->typestr_level3 = $typestr_level3;
			// Get current date time
			$cur_date = date("Y-m-d");
			// Get total promotion of current date
			$promotion = array();
			$promotion_item = App\Promotion::getTotalPromotionItem($cur_date, $product_id);
			array_push($promotion, $promotion_item);
			// Get promotion of current date by level
			for ($level = 1; $level <= $max_level; $level++) {
				$promotion_item = App\Promotion::getPromotionItemByLevel($cur_date, $product_id, $level);
				array_push($promotion, $promotion_item);
			}
			$product->promotions = $promotion;
			$product->max_level = $max_level;
			$purchase_price_ary = json_decode($product->purchase_price_level, true);
			if ($purchase_price_ary) {
				for ($level = 0; $level < $max_level; $level++) {
					if (!isset($purchase_price_ary[$level])) {
						array_push($purchase_price_ary, null);
					}
				}
			}
			$product->purchase_price_level = $purchase_price_ary;
			
			$product->order_limit_down_level = json_decode($product->order_limit_down_level, true);
			$product->order_limit_up_level = json_decode($product->order_limit_up_level, true);
			
			$product->rule;
			
			$ret_array = array("status" => true, "value" => $product);
			
			if($type_list_require){
				$ret_array['type_list'] = array(
					'level1_type' => App\ProductLevel::getAllTypes(1),
					'level2_type' => App\ProductLevel::getAllTypes(2),
					'level3_type' => App\ProductLevel::getAllTypes(3),
					'dic' => App\Dictionary::getAllArrayByKey(),
					'rule' => App\Cardrule::get()
				);
			}
			
			if($dealer_list_require){
				$ret_array['dealers_1stlevel'] = App\Dealer::where('level', '=', 1)->get();
			}
			
			echo json_encode($ret_array);
		}else{	// Product not exist
			echo json_encode(array("status" => false));
		}
	}
	
	/*******************************
		Request get product item info
	*******************************/	
	public function get_registeritem($product_id, $card_id){
		$userinfo = Session::get('total_info');
		$type_list_require = 0;
		
		if($product_id == 0){
			$product = new Product();
			$product->image_url = "data:image/gif;base64,R0lGODlhAgABAJEAAAAAAP///6urq////yH5BAEAAAMALAAAAAACAAEAAAIClAoAOw==";
			$product->status = 1;
		}
		else $product = Product::find($product_id);
		
		$card = App\Card::find($card_id);
		$card->customer;
		
		$max_level = App\Dealer::max('level');
		
		if($product){	// Product exist	
		
			$typestr_level1 = App\ProductLevel::where([['level', '=', '1'], ['id', '=',$product->level1_id]])->select('description')->first()['description'];
			$typestr_level2 = App\ProductLevel::where([['level', '=', '2'], ['id', '=',$product->level2_id]])->select('description')->first()['description'];
			$product->typestr_level1 = $typestr_level1;
			$product->typestr_level2 = $typestr_level2;
			// Get current date time
			$cur_date = date("Y-m-d");
			// Get total promotion of current date
			$promotion = array();
			$promotion_item = App\Promotion::getTotalPromotionItem($cur_date, $product_id);
			array_push($promotion, $promotion_item);
			// Get promotion of current date by level
			for ($level = 1; $level <= $max_level; $level++) {
				$promotion_item = App\Promotion::getPromotionItemByLevel($cur_date, $product_id, $level);
				array_push($promotion, $promotion_item);
			}
			$product->promotions = $promotion;
			$product->carddata = $card;
			$product->price = App\Price::get_price_by_dealer($product_id, $userinfo["dealer_id"]);
			$ret_array = array("status" => true, "value" => $product);
			
			if($type_list_require){
				$ret_array['type_list'] = array(
					'level1_type' => App\ProductLevel::getAllTypes(1),
					'level2_type' => App\ProductLevel::getAllTypes(2)
				);
			}
			echo json_encode($ret_array);
		}else{	// Product not exist
			echo json_encode(array("status" => false));
		}
	}
	/*******************************
		Request get card item info
	*******************************/	
	public function get_carditem($card_id){
		$userinfo = Session::get('total_info');
		$type_list_require = 0;
		$card = App\Card::find($card_id);
		
		if($card){
			$product_id = $card->product_id;
			if($product_id == 0){
				$product = new Product();
				$product->image_url = "data:image/gif;base64,R0lGODlhAgABAJEAAAAAAP///6urq////yH5BAEAAAMALAAAAAACAAEAAAIClAoAOw==";
				$product->status = 1;
			}
			else $product = Product::find($product_id);
			
			$max_level = App\Dealer::max('level');
			
			if($product){	// Product exist	
			
				$typestr_level1 = App\ProductLevel::where([['level', '=', '1'], ['id', '=',$product->level1_id]])->select('description')->first()['description'];
				$typestr_level2 = App\ProductLevel::where([['level', '=', '2'], ['id', '=',$product->level2_id]])->select('description')->first()['description'];
				$product->typestr_level1 = $typestr_level1;
				$product->typestr_level2 = $typestr_level2;
				// Get current date time
				$cur_date = date("Y-m-d");
				// Get total promotion of current date
				$promotion = array();
				$promotion_item = App\Promotion::getTotalPromotionItem($cur_date, $product_id);
				array_push($promotion, $promotion_item);
				// Get promotion of current date by level
				for ($level = 1; $level <= $max_level; $level++) {
					$promotion_item = App\Promotion::getPromotionItemByLevel($cur_date, $product_id, $level);
					array_push($promotion, $promotion_item);
				}
				$product->promotions = $promotion;
				$product->carddata = $card;
				$product->price = App\Price::get_price_by_dealer($product_id, $userinfo["dealer_id"]);
				$ret_array = array("status" => true, "value" => $product);
				
				if($type_list_require){
					$ret_array['type_list'] = array(
						'level1_type' => App\ProductLevel::getAllTypes(1),
						'level2_type' => App\ProductLevel::getAllTypes(2)
					);
				}
				
				echo json_encode($ret_array);
			}else{	// Product not exist
				echo json_encode(array("status" => false));
			}
		}else{
			echo json_encode(array("status" => false));
		}
		
	}	
	/*******************************
		Process product edit action
		product_id = 0 then insert else update
	*******************************/
	public function process_edit($product_id, Request $request){
		$product_name = $request->input('product_name');
		
		$product = Product::where('name', $product_name)->where('id', '!=', $product_id)->first();
		
		if ($product) {
			echo json_encode(array("status" => false, "db_id" => $product->id, "price_set" => true, "err_msg" => __('lang.pr_save_dlg_message_exist'), "err_tag" => "input[name='product_name']"));
			return;
		}
		
		if($product_id != 0) $product = Product::find($product_id);
		else $product = new Product;
		
		// Image file upload
		$image_file = $request->file("image_file");
		if(null !== $image_file){
			$destinationPath = $this->logo_upload_path;
			$file_suffix_rand = rand(10000, 99999);
		
			$file_ext = $image_file->extension();
			
			$filename_original = date("YmdHis_").$file_suffix_rand."_original.".$image_file->extension();
			$filename_torotate = date("YmdHis_").$file_suffix_rand."_rotate.".$image_file->extension();
			$filename = date("YmdHis_").$file_suffix_rand.".".$image_file->extension();
			if($image_file->move($destinationPath, $filename_original) && strlen(trim($product->image_url)) > 0){
				//	Storage::delete($product->image_url);
				File::delete($product->image_url);
			}
			
			// fix phone image rotation
			$rotate = 0;
			
			if(strtolower($file_ext) == "jpg" || strtolower($file_ext) == "jpeg"){
			
				$exif = @exif_read_data($destinationPath.$filename_original);
				
				if(!empty($exif['Orientation'])) {
					$orientation = $exif['Orientation'];
					switch($orientation) {
						case 3:
							$rotate = 180;
							break;
						case 6:
							$rotate = -90;
							break;
						case 8:
							$rotate = 90;
							break;
					}
				}
			}
			
			if($rotate !== 0){
				
				if($rotate == 180){
					$thumb_width = $_ENV['PRODUCT_THUMB_WIDTH'];
					$thumb_height = $_ENV['PRODUCT_THUMB_HEIGHT'];
				}else{
					$thumb_width = $_ENV['PRODUCT_THUMB_HEIGHT'];
					$thumb_height = $_ENV['PRODUCT_THUMB_WIDTH'];
				}
				
				//Create Thumbnail logo image
				mProvider::generate_image_thumbnail($destinationPath.$filename_original, $destinationPath.$filename_torotate, $thumb_width, $thumb_height);
			
				// Rotate
				$source_img = imagecreatefromjpeg($destinationPath.$filename_torotate);
				$rotate_img = imagerotate($source_img, $rotate, 0);
				//and save it on your server...
				imagejpeg($rotate_img, $destinationPath.$filename);
				
			}else{
				//Create Thumbnail logo image
				mProvider::generate_image_thumbnail($destinationPath.$filename_original, $destinationPath.$filename, $_ENV['PRODUCT_THUMB_WIDTH'], $_ENV['PRODUCT_THUMB_HEIGHT']);
			}
			
			
			$product->image_url = $destinationPath.$filename;			
		}
		
		$product->level1_id = $request->input('product_level1_id');
        $product->level2_id = $request->input('product_level2_id');
        $product->level3_id = $request->input('product_level3_id');
        $product->service_type = $request->input('product_service_type');
        $product->card_rule_id = $request->input('product_card_rule');
        $product->name = $request->input('product_name');
        $product->valid_period = $request->input('product_valid_period');
        $product->code = $request->input('product_code');
        $product->status = ($request->input('product_status') == "on")? 1 : 0;
        $product->price_sku = (int)$request->input('product_price_sku');
        //$product->standard_price = (int)$request->input('product_standard_price');
        $product->description = $request->input('product_description');
		
		$db_status = $product->save();
		
		$price_set = ($product->purchase_price_level != null)? true: false;
		
		// log table
		if($product_id == 0)
			App\History::add_history(array("module_name"=>"产品", "operation_kind"=>"添加信息", "operation"=>"添加 \"".$product->name."\" 产品"));
		else
			App\History::add_history(array("module_name"=>"产品", "operation_kind"=>"修改信息", "operation"=>"修改 \"".$product->name."\" 产品"));
		
		// Message table
		if($product_id == 0) {
			App\Message::save_message(array(
						"type" => "1",
						"tag_dealer_id" => "0",
						"tag_user_id" => null,
						"message" => "添加 \"".$product->name."\" 产品",
						"url" => "#!/product/view/".$product->id,
						"html_message" => "",
						"table_name" => "product",
						"table_id" => $product->id,
					));
			
			/*$dealers = App\Dealer::where('id', '!=', 1)->get();
			foreach ($dealers as $dealer) {
				App\Dealer::setCheckProduct($dealer->id, 1);
			}*/
		}
		//if($product_id == 1) {
		else {
			App\Message::save_message(array(
						"type" => "1",
						"tag_dealer_id" => "0",
						"tag_user_id" => null,
						"message" => "修改信息 \"".$product->name."\" 产品",
						"url" => "#!/product/view/".$product->id,
						"html_message" => "",
						"table_name" => "product",
						"table_id" => $product->id,
					));
			
			/*$dealers = App\Dealer::where('id', '!=', 1)->get();
			foreach ($dealers as $dealer) {
				App\Dealer::setCheckProduct($dealer->id, 1);
			}*/
		}
		
		echo json_encode(array("status" => $db_status, "db_id" => $product->id, "price_set" => $price_set));
	}
	
	/*******************************
		View product type manage page
	*******************************/
	public function view_class(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product_class');
	}
	
	/*******************************
		Get product type info data
	*******************************/
	public function get_type_item($type_id){
		if($type_id == 0){
			$product_type = new App\ProductLevel();
		}
		else $product_type = App\ProductLevel::find($type_id);
		
		if($product_type){	// Product type exist	
			$ret_array = array("status" => true, "value" => $product_type);
			echo json_encode($ret_array);
		}else{	// Product not exist
			echo json_encode(array("status" => false));
		}
	}
	
	/*******************************
		Process product type edit request
	*******************************/
	public function process_class_edit($type_id){
		$data = json_decode(file_get_contents("php://input"));

		$db_status =  true;
		if($data->level == null || $data->level == "" || $data->description == null || $data->description == ""){
			echo json_encode(array("status" => false, "err_msg" => __('lang.error_input_data_incorrect')));
			return;
		}
		
		$duplicate_count = App\ProductLevel::where([["description", "=", $data->description], ["id", "!=", $type_id]])->count();
		if($duplicate_count > 0){
			echo json_encode(array("status" => false, "err_msg" => __('lang.error_input_data_duplicate')));
			return;
		}
		
		if($type_id == 0){
			$product_type = new App\ProductLevel();
		}else{
			$product_type = App\ProductLevel::find($type_id);
		}
		
		$product_type->level = $data->level;
		$product_type->description = $data->description;
		$db_status = $product_type->save();
		
		$err_msg = (!$db_status)? __('lang.rg_fail_save'): "";
		echo json_encode(array("status" => $db_status, "row_data" => $product_type, "err_msg" => $err_msg));
	}
	
	/*******************************
		Get product type list data
	*******************************/
	public function get_type_list(){
		echo json_encode(array(
			'level1_type' => App\ProductLevel::getAllTypes(1),
			'level2_type' => App\ProductLevel::getAllTypes(2)
		));
	}
	
	/*******************************
		Get product type page list data
	*******************************/
	public function get_type_page($search_json, $itemcount, $pagenum = 1){
		if($itemcount < 1) $itemcount = 5;
		$search_obj = json_decode($search_json);
		//var_dump($search_obj);
		
		$query = App\ProductLevel::query();
		if(property_exists($search_obj, "type_level") && $search_obj->type_level != ""){
			$query->where('level', '=', $search_obj->type_level);
		}
		$query->orderBy('level');
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	public function active(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product_active');
	}
	public function physicalactive(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'product_physicalactive');
	}
	//card active function
	public function card_active(Request $request){
		$data = json_decode(file_get_contents("php://input"));
		
		echo json_encode(App\Card::active($data));
	}
	//card register function
	public function card_register(Request $request){
		$data = json_decode(file_get_contents("php://input"));
		
		echo json_encode(App\Card::register($data));
	}
	
	public function get_all_list() {
		$product_list = App\Product::get();
		
		echo json_encode($product_list);
	}
}
