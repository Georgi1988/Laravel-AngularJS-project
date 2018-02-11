<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    // Get stock size by dealer_id
    public static function getStockByDealer($product_id) {
        /* $stock_list = Stock::where('product_id', $product_id)->get();
        $ret_ary = array();
        foreach ($stock_list as $stock) {
            $ret_ary[''.$stock->dealer_id] = $stock->size_in_store;
        }

        return $ret_ary; */
		
		$stock_infos = Card::query()
			->selectRaw('dealer_id, count(*) as `stock_count`')
			->where('status', '=', 0)
			->where('product_id', '=', $product_id)
			->where(function ($query) {
					$query	->where('valid_period', '>', date("Y-m-d H:i:s"))
						->orwhere('valid_period', '=', null);
				})
			->groupBy('dealer_id')->get();
		
		$ret_ary = array();
		foreach($stock_infos as $stock_info){
			$ret_ary[''.$stock_info->dealer_id] = $stock_info->stock_count;
		}
		
		return $ret_ary;
    }
	
	// Get total stock of products indexed by dealer_id
    public static function getTotalStockByDealer() {
		
		
        /* $stock_list = Stock::selectRaw('dealer_id, sum(size_in_store) as total_stock')->groupBy('dealer_id')->get();
        $ret_ary = array();
        foreach ($stock_list as $stock) {
            $ret_ary[''.$stock->dealer_id] = $stock->total_stock;
        }
        return $ret_ary; */
		
		$stock_infos = Card::query()
			->selectRaw('dealer_id, count(*) as `stock_count`')
			->where('status', '=', 0)
			->where(function ($query) {
					$query	->where('valid_period', '>', date("Y-m-d H:i:s"))
						->orwhere('valid_period', '=', null);
				})
			->groupBy('dealer_id')->get();
		
		$ret_ary = array();
		foreach($stock_infos as $stock_info){
			$ret_ary[''.$stock_info->dealer_id] = $stock_info->stock_count;
		}
        return $ret_ary;

    }
	
	// add sales info
    public static function add_sales_info($data) {
		$userinfo = Session::get('total_info');
        $stock = Stock::where('product_id', $data->product_id)
					->where('dealer_id', $userinfo["dealer_id"])
					->update(['size_of_registered' => DB::raw('size_of_registered + 1')]);
		if ($stock == '0'){
			$Stock = new Stock;
			$Stock->product_id = $data->product_id;
			$Stock->dealer_id = $userinfo["dealer_id"] ; 
			$Stock->size_of_registered = 1;
			$Stock->save();
		}			

        return $stock;
    }
	// add active info
    public static function add_active_info($data) {
		$userinfo = Session::get('total_info');
        $stock = Stock::where('product_id', $data->product_id)
					->where('dealer_id', $userinfo["dealer_id"])
					->update(['size_of_activated' => DB::raw('size_of_activated + 1')]);
		if ($stock == '0'){
			$Stock = new Stock;
			$Stock->product_id = $data->product_id;
			$Stock->dealer_id = $userinfo["dealer_id"] ; 
			$Stock->size_of_activated = 1;
			$Stock->save();
		}			

        return $stock;
    }
	// add generate info
    public static function add_generate_info($data) {
		$userinfo = Session::get('total_info');
		$dealer_id = 1;
        $stock = Stock::where('product_id', $data->product_id)
					->where('dealer_id', $userinfo["dealer_id"])
					->update(['size_in_store' => DB::raw('size_in_store + '.(int)$data->service_cards.'')]);
		if ($stock == '0'){
			$Stock = new Stock;
			$Stock->product_id = $data->product_id;
			$Stock->dealer_id = $userinfo["dealer_id"]; 
			$Stock->size_in_store = $data->service_cards;
			$Stock->save();
		}			

        return $stock;
    }
    
    // Get total stock, stock_activated, stock_registered from dealer_id
    public static function getTotalStock($dealer_id) {
        /* $total_stock = Stock::where('dealer_id', $dealer_id)
            ->selectRaw('sum(size_in_store) as stock, sum(size_of_activated) as stock_activated, sum(size_of_registered) as stock_registered')
            ->first();

        return $total_stock; */
		
		$stock_infos = Card::query()
			->selectRaw('status, count(*) as `stock_count`')
			->where('dealer_id', '=', $dealer_id)
			->where(function ($query) {
					$query	->where('valid_period', '>', date("Y-m-d H:i:s"))
						->orwhere('valid_period', '=', null);
				})
			->groupBy('status')->get();
		
		$ret_ary = array("stock" => 0, "stock_activated" => 0, "stock_registered" => 0);
		foreach($stock_infos as $stock_info){
			if($stock_info->status == 0) $ret_ary['stock'] = $stock_info->stock_count;
			if($stock_info->status == 1) $ret_ary['stock_activated'] = $stock_info->stock_count;
			if($stock_info->status == 2) $ret_ary['stock_registered'] = $stock_info->stock_count;
		}
        return (object) $ret_ary;
    }
	
	/************************************************************
		Get Stock info of Specific Product  Dealer have
		parameter: 
			$product_id		: product id
			$dealer_id		: dealer id
		Return: 	Stock table 1 record
	************************************************************/
    public static function getDealerStockInfo($product_id, $dealer_id) {
		
		/* $product_dealer_stock = Stock::where([
				['dealer_id', '=', $dealer_id],
				['product_id', '=', $product_id],
			]
		)->first();
		
		if(null === $product_dealer_stock){
			$product_dealer_stock = new Stock();
			$product_dealer_stock->dealer_id = $dealer_id;
			$product_dealer_stock->product_id = $product_id;
		}
		
        return $product_dealer_stock; */
		
		$expire_date_value = (int)Option::get_option_inherit($dealer_id, "stock_expire_notify_value");
		$stock_info = Card::query()
			->selectRaw('
				sum(case when (`valid_period` > current_timestamp or `valid_period` is NULL) and `status` = 0 then 1 else 0 end) as `size_in_store`, 
				sum(case when (`valid_period` > current_timestamp or `valid_period` is NULL) and `status` = 0 and `type` = 0 then 1 else 0 end) as `size_of_virtual`,
				sum(case when (`valid_period` > current_timestamp or `valid_period` is NULL) and `status` = 0 and `type` = 1 then 1 else 0 end) as `size_of_physical`,
				sum(case when (`valid_period` > current_timestamp or `valid_period` is NULL) and `status` = 1 then 1 else 0 end) as `size_of_activated`, 
				sum(case when (`valid_period` > current_timestamp or `valid_period` is NULL) and `status` = 2 then 1 else 0 end) as `size_of_registered`, 
				sum(case when `valid_period` < current_timestamp and `valid_period` is not NULL then 1 else 0 end) as `size_of_empire30`, 
				sum(case when `status` != 0 then 1 else 0 end) as `size_of_saled`, 
				sum(case when `valid_period` < "'.date("Y-m-d H:i:s", time() + 86400 * $expire_date_value).'" and `valid_period` is not NULL then 1 else 0 end) as `size_of_just_empire`')
			->where('product_id', '=', $product_id)
			->where('dealer_id', '=', $dealer_id)->first();
		
        return $stock_info;
    }
	
	/************************************************************
		Get Total Stock of Specific Dealer have
		parameter: 
			$dealer_id		: dealer id
		Return: 	total stock counts
	************************************************************/
    public static function getDealerTotalStock($dealer_id) {
		
		/* $tb_prefix = DB::getTablePrefix();
		$query = Stock::query()
			->selectRaw('sum(`'.$tb_prefix.'stocks`.`size_in_store`) as `total_stock`')
			->where([
				['dealer_id', '=', $dealer_id]
				]
			);
		$stock = $query->first();
		
        return $stock->total_stock; */
		
		$stock_info = Card::query()
			->selectRaw('count(`id`) as `total_stock`')
			->where('dealer_id', '=', $dealer_id)
			->where(function ($query) {
				$query->where('valid_period', '>', date("Y-m-d H:i:s"))
				->orwhere('valid_period', '=', null);
			})
			->where('status', '=', 0)
			->first();
		return $stock_info->total_stock;
    }
	
	/************************************************************
		stock change when up dealer sells cards to down dealer
		parameter: 
			$tag_dealer_id	: sell dealer 
			$src_dealer_id	: buy dealer
			$product_id		: sell product id
			$sale_status	: 0- purchase, 1- return
			$size			: amount
		Return: 	True- success, False- fail
	************************************************************/
	public static function change_sale_stock($tag_dealer_id, $src_dealer_id, $product_id, $sale_status, $size){
		
		$ret_val = true;
		
		$tag_dealer_stock = Stock::where([
				['dealer_id', '=', $tag_dealer_id],
				['product_id', '=', $product_id],
			]
		)->first();
		if(null === $tag_dealer_stock){
			$tag_dealer_stock = new Stock();
			$tag_dealer_stock->dealer_id = $tag_dealer_id;
			$tag_dealer_stock->product_id = $product_id;
		}
		
		$src_dealer_stock = Stock::where([
				['dealer_id', '=', $src_dealer_id],
				['product_id', '=', $product_id],
			]
		)->first();
		if(null === $src_dealer_stock){
			$src_dealer_stock = new Stock();
			$src_dealer_stock->dealer_id = $src_dealer_id;
			$src_dealer_stock->product_id = $product_id;
		}
		
		$real_sale_size = ($sale_status == 0)? $size: 0 - $size;
		
		$tag_dealer_stock->size_in_store -= $real_sale_size;
		$tag_dealer_stock->size_of_saled += $real_sale_size;
		$src_dealer_stock->size_in_store += $real_sale_size;
		
		$ret_val = $ret_val & $tag_dealer_stock->save();
		$ret_val = $ret_val & $src_dealer_stock->save();
		
		return $ret_val;
	}
	
	public static function checkDaily($dealer_id, $last_check_date){
		
		$tb_prefix = DB::getTablePrefix();
		
		$stock_alert = false;
		$stock_expired = true;
		$stock_less = false;
		$stock_expire_soon = false;
		
		$stock_less_notify_status = Option::get_option_inherit($dealer_id, "stock_less_notify_status");
		$stock_less_notify_value = Option::get_option_inherit($dealer_id, "stock_less_notify_value");
		
		$stock_expire_notify_status = Option::get_option_inherit($dealer_id, "stock_expire_notify_status");
		$stock_expire_notify_value = Option::get_option_inherit($dealer_id, "stock_expire_notify_value");
		
		$message_txt = [];
		$message_html = '';

		$today_start_time = date("Y-m-d")." 00:00:00";
		$expire_soon_limit = date("Y-m-d H:i:s", strtotime($today_start_time) + 86400 * $stock_expire_notify_value);
		
		
		// Check expired cards
		if(true){
			$expired_info = Card::query()
				->selectRaw('`product_id`, count(`id`) as cnt')
				->where('dealer_id', '=', $dealer_id)
				//->where('status', '<', 1)
				->where('valid_period', '<', $today_start_time)
				->where('valid_period', '>=', strtotime($last_check_date))
				->groupBy('product_id')
				->get();
			
			$total_expired_count = 0;
			$total_expired_list = array();
			foreach($expired_info as $expire_info){
				$total_expired_count += $expire_info->cnt;
				$product_name = "";
				$product = Product::find($expire_info->product_id);
				if($product !== null){
					$product_name = $product->name;
				}
				$total_expired_list[] = "产品 “".$product_name."” : ".$expire_info->cnt."张";
			}
			
			if($total_expired_count > 0){
				$stock_alert = true;
				$stock_expired = true;
				
				$message_txt[] .= '您的'.$total_expired_count.'张服务卡已经过期';
				$message_html .= '
					<p>您的'.$total_expired_count.'张服务卡已经过期</p>
					<p>'.implode("，", $total_expired_list).'</p>
					<p>&nbsp;</p>';
			}
		}
		
		// Stock quantity less check
		if($stock_less_notify_status == 1){
			$total_stock = Stock::getTotalStock($dealer_id);
			if($stock_less_notify_value > $total_stock->stock){
				$stock_alert = true;
				$stock_less = true;
				$message_txt[] = '您当前库存的服务卡数两小于'.$stock_less_notify_value.'个';
				$message_html .= '
					<p>您当前库存的服务卡数两小于'.$stock_less_notify_value.'张。 </p>
					<p><span class="text-muted">您可以在设置页面中设置库存不足通知数量。</span></p>
					<p>&nbsp;</p>';
			}
		}
		
		// Check cards will soon expire
		if($stock_expire_notify_status == 1){
			
			$soon_expire_info = Card::query()
				->selectRaw('`product_id`, count(`id`) as cnt')
				->where('dealer_id', '=', $dealer_id)
				//->where('status', '<', 1)
				->where('valid_period', '>=', $today_start_time)
				->where('valid_period', '<', $expire_soon_limit)
				->groupBy('product_id')
				->get();
			
			$total_expire_count = 0;
			$total_expire_list = array();
			foreach($soon_expire_info as $expire_info){
				$total_expire_count += $expire_info->cnt;
				$product_name = "";
				$product = Product::find($expire_info->product_id);
				if($product !== null){
					$product_name = $product->name;
				}
				$total_expire_list[] = "产品 “".$product_name."” : ".$expire_info->cnt."张";
			}
			
			if($total_expire_count > 0){
				$stock_alert = true;
				$stock_expire_soon = true;
				
				$message_txt[] .= '您的'.$total_expire_count.'张服务卡'.$stock_expire_notify_value.'天内就会过期';
				$message_html .= '
					<p>你的'.$total_expire_count.'张服务卡'.$stock_expire_notify_value.'天内就会过期</p>
					<p>'.implode("，", $total_expire_list).'</p>
					<p>&nbsp;</p>';
			}
			
		}
		
		if($stock_alert == true){
			
			$message = implode("，", $message_txt);
			
			Message::save_message(array(
					"type" => "1",
					"tag_dealer_id" => $dealer_id,
					"tag_user_id" => null,
					"message" => $message,
					"url" => "",
					"html_message" => $message_html,
					"table_name" => "stock",
					"table_id" => 0,
				), true);
		}
		
		Dealer::where('id', '=', $dealer_id)->update(['stock_check_date' => date("Y-m-d")]);
		
	}
}
