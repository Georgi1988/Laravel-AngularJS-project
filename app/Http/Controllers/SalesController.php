<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mProvider;

class SalesController extends Controller
{
    //
	public function index($type){
		if(null === $type) $type = "1";
		
		$view_info = array();
		$view_info['page_type'] = $type;
		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'sales', $view_info);
	}

	/********************************************
		Sales ranked by product view template
	********************************************/
	public function view_product(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'sales_product');
	}

	/********************************************
		--page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: list item info, pagination info
	********************************************/
	public function get_product_list($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		
		$site_priv = $request->session()->get('site_priv');
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		
		/* $tb_prefix = DB::getTablePrefix();
		$query = App\Card::query()
			->selectRaw('`'.$tb_prefix.'cards`.*, count(*) as `total_count`, sum(case when `'.$tb_prefix.'cards`.`status` = 1 then 1 else 0 end) as `activation_count`, sum(case when `'.$tb_prefix.'cards`.`status` = 2 then 1 else 0 end) as `register_count`, sum(case when `'.$tb_prefix.'cards`.`valid_period` < current_timestamp then 1 else 0 end) as `expired_count` ')
			->join('sales as s', 's.card_id', '=', 'cards.id');
		if($site_priv != "seller")
			$query->where('s.tag_dealer_id', '=', $login_info['dealer_id']);
		else 
			$query->where('s.seller_id', '=', $login_info['user_id']);
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('s.sale_date', '>=', $search_obj->start_date);
			$query->whereDate('s.sale_date', '<=', $search_obj->end_date);
		}
		$query->orderByDesc('total_count');
		$query->groupBy('cards.product_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum); */
		
		$tb_prefix = DB::getTablePrefix();
		$query = App\Sale::query()
			->selectRaw('*, count(*) as `total_count`');
		
		if($site_priv != "seller"){
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
		}
		else {
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
			$query->where('seller_id', '=', $login_info['user_id']);
		}
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('sale_date', '>=', $search_obj->start_date);
			$query->whereDate('sale_date', '<=', $search_obj->end_date);
		}
		$query->orderByDesc('total_count');
		$query->groupBy('product_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);

		foreach($items as $item){
			$item->product;
			if($item->product){
				$item->product->level1_info;
				$item->product->level2_info;
			} 
			
			$query_count = App\Card::query()
				->selectRaw('count(*) as `count`');
			$query_count->where('product_id', '=', $item->product->id)
				->where('dealer_id', '=', $login_info['dealer_id']);
			if($site_priv == "seller"){
				$query_count->where('user_id', '=', $login_info['user_id']);
			}
			
			$temp_activation = clone $query_count;
			$temp_activation->where('status', '=', '1');
			$temp_register = clone $query_count;
			$temp_register->where('status', '=', '2');
			$temp_expired = clone $query_count;
			$temp_expired->where('valid_period', '<', date("Y-m-d H:i:s"))
					->where('valid_period', '!=', null);
			
			$item->activation_count = $temp_activation->count();
			$item->register_count = $temp_register->count();
			$item->expired_count = $temp_expired->count();
			
		}
		
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	
	/********************************************
		Sales ranked by income view template
	********************************************/
	public function view_income(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'sales_income');
	}

	/********************************************
		Sales amount by income rating--page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: list item info, pagination info
	********************************************/
	public function get_income_list($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		
		$site_priv = $request->session()->get('site_priv');
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		
		/* $tb_prefix = DB::getTablePrefix();
		$query = App\Card::query()
			->selectRaw('
				`'.$tb_prefix.'cards`.*, 
				count(*) as `total_count`, 
				sum(`'.$tb_prefix.'s`.`sale_price` - `'.$tb_prefix.'s`.`purchase_price`) as `income`,
				sum(case when `'.$tb_prefix.'cards`.`status` = 1 then 1 else 0 end) as `activation_count`, 
				sum(case when `'.$tb_prefix.'cards`.`status` = 2 then 1 else 0 end) as `register_count`, 
				sum(case when `'.$tb_prefix.'cards`.`valid_period` < current_timestamp then 1 else 0 end) as `expired_count` ')
			->join('sales as s', 's.card_id', '=', 'cards.id');
			
		if($site_priv != "seller"){
			$query->where('s.tag_dealer_id', '=', $login_info['dealer_id']);
		}
		else {
			$query->where('s.tag_dealer_id', '=', $login_info['dealer_id']);
			$query->where('s.seller_id', '=', $login_info['user_id']);
		}
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('s.sale_date', '>=', $search_obj->start_date);
			$query->whereDate('s.sale_date', '<=', $search_obj->end_date);
		}
		$query->orderByDesc('income');
		$query->groupBy('cards.product_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);

		foreach($items as $item){
			$item->product;
			if($item->product) $item->product->level1_info;
			$best_sale = App\Sale::query()
				->selectRaw('*, count(*) as `sale_count`')
				->where([
						['tag_dealer_id', '=', $login_info['dealer_id']],
						['product_id', '=', $item['product_id']],
					])
				->orderByDesc('sale_count')
				->groupBy('src_dealer_id')
				->first();
			if(null !== $best_sale){
				$best_sell_dealer = App\Dealer::find($best_sale->src_dealer_id);
				$item->best_sell_dealer = $best_sell_dealer;
			}
		} */
		
		$tb_prefix = DB::getTablePrefix();
		$query = App\Sale::query()
			->selectRaw('
				*, count(*) as `total_count`, 
				sum(`sale_price` - `purchase_price` + `promotion_price`) as `income`');
			
		if($site_priv != "seller"){
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
		}
		else {
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
			$query->where('seller_id', '=', $login_info['user_id']);
		}
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('sale_date', '>=', $search_obj->start_date);
			$query->whereDate('sale_date', '<=', $search_obj->end_date);
		}
		$query->orderByDesc('income');
		$query->groupBy('product_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		
		foreach($items as $item){
			$item->product;
			$item->income = (int)$item->income;
			if($item->product) $item->product->level1_info;
			
			if($item->product !== null){
				$query_count = App\Card::query()
					->selectRaw('count(*) as `count`');
				$query_count->where('product_id', '=', $item->product->id)
					->where('dealer_id', '=', $login_info['dealer_id']);
				if($site_priv == "seller"){
					$query_count->where('user_id', '=', $login_info['user_id']);
				}
				
				$temp_activation = clone $query_count;
				$temp_activation->where('status', '=', '1');
				$temp_register = clone $query_count;
				$temp_register->where('status', '=', '2');
				$temp_expired = clone $query_count;
				$temp_expired->where('valid_period', '<', date("Y-m-d H:i:s"))
						->where('valid_period', '!=', null);
				
				$item->activation_count = $temp_activation->count();
				$item->register_count = $temp_register->count();
				$item->expired_count = $temp_expired->count();
			}
			
			$best_sale = App\Sale::query()
				->selectRaw('*, count(*) as `sale_count`')
				->where([
						['tag_dealer_id', '=', $login_info['dealer_id']],
						['product_id', '=', $item['product_id']],
					])
				->orderByDesc('sale_count')
				->groupBy('src_dealer_id')
				->first();
			if(null !== $best_sale){
				$best_sell_dealer = App\Dealer::find($best_sale->src_dealer_id);
				$item->best_sell_dealer = $best_sell_dealer;
			}
		}
		
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	/********************************************
		Sales ranked by sale view template
	********************************************/
	public function view_sale(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'sales_sale');
	}
	
	/********************************************
		Sales amount by sale rating--page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: list item info, pagination info
	********************************************/
	public function get_sale_list($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		
		$site_priv = $request->session()->get('site_priv');
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		
		$tb_prefix = DB::getTablePrefix();
		$query = App\Sale::query()
			->selectRaw('
				`'.$tb_prefix.'sales`.*, 
				count(*) as `sale_count`,
				sum(`'.$tb_prefix.'sales`.`sale_price` - `'.$tb_prefix.'sales`.`purchase_price` + `'.$tb_prefix.'sales`.`promotion_price`) as `income`,
				sum(`'.$tb_prefix.'sales`.`sale_price`) as `total_sale_price` ');
		
		if($site_priv != "seller"){
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
		}
		else {
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
			$query->where('seller_id', '=', $login_info['user_id']);
		}
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('sales.sale_date', '>=', $search_obj->start_date);
			$query->whereDate('sales.sale_date', '<=', $search_obj->end_date);
		}
		$query->orderByDesc('total_sale_price');
		$query->groupBy('sales.seller_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);

		foreach($items as $item){
			$item->seller;
			if($item->seller) $item->seller->dealer;
			
			$best_sale = App\Sale::query()
				->selectRaw('*, count(*) as `sale_count`')
				->where([
						['tag_dealer_id', '=', $login_info['dealer_id']],
						['seller_id', '=', $item->seller_id],
					])
				->orderByDesc('sale_count')
				->groupBy('product_id')
				->first();
			$top_saled_product = App\Product::find($best_sale->product_id);
			$item->top_saled_product = $top_saled_product;
		}
		
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	/********************************************
		Sales ranked by dealer view template
	********************************************/
	public function view_dealer(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'sales_dealer');
	}
	
	/********************************************
		Sales amount by dealer rating--page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: list item info, pagination info
	********************************************/
	public function get_dealer_list($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		
		$site_priv = $request->session()->get('site_priv');
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		
		/* $tb_prefix = DB::getTablePrefix();
		$query = App\Sale::query()
			->selectRaw('
				`'.$tb_prefix.'sales`.*, 
				`'.$tb_prefix.'d`.`name` as `dealer_name`, `'.$tb_prefix.'d`.`level` as `dealer_level`,
				sum(`'.$tb_prefix.'sales`.`sale_price` - `'.$tb_prefix.'sales`.`purchase_price`) as `income`,
				sum(`'.$tb_prefix.'sales`.`sale_price`) as `total_sale_price` ')
			->join('dealers as d', 'd.id', '=', 'sales.src_dealer_id');
		
		if($site_priv != "admin")
			$query->where('sales.tag_dealer_id', '=', $login_info['dealer_id']);
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('sales.sale_date', '>=', $search_obj->start_date);
			$query->whereDate('sales.sale_date', '<=', $search_obj->end_date);
		}
		$query->orderBy('d.level');
		$query->groupBy('sales.src_dealer_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);

		foreach($items as $item){
			$item->total_stock = App\Stock::getDealerTotalStock($item->src_dealer_id);
			$item->top_saled_product = App\Stock::getDealerTopSaledProduct($item->src_dealer_id);
		} */
		
		$tb_prefix = DB::getTablePrefix();
		$query = App\Sale::query()
			->selectRaw('
				*, 
				sum(`sale_price` - `purchase_price` + `promotion_price`) as `income`,
				sum(`sale_price`) as `total_sale_price` ');
		
		if($site_priv != "admin")
			$query->where('tag_dealer_id', '=', $login_info['dealer_id']);
		
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != "" && property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->whereDate('sale_date', '>=', $search_obj->start_date);
			$query->whereDate('sale_date', '<=', $search_obj->end_date);
		}
		$query->orderByDesc('income');
		$query->groupBy('sales.tag_dealer_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);

		foreach($items as $item){
			$item->dealer;
			$item->total_stock = App\Stock::getDealerTotalStock($item->tag_dealer_id);
			$item->top_saled_product = App\Sale::getDealerTopSaledProduct($item->tag_dealer_id);
		}
		
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
}
