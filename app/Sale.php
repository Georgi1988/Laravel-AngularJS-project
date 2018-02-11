<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Product;

class Sale extends Model
{
    // add sales info
    public static function add_sales_info($data, $priceinfo) {
		/* if ($priceinfo["promotion"]["promotion_price"])
			$promotion = $priceinfo["purchase_price"] - $priceinfo["purchase_price"] * $priceinfo["promotion"]["promotion_price"] / 100;
		else 
			$promotion = 0; */

		$userinfo = Session::get('total_info');
		
		$purchase_price_info = Sale::where('product_id', $data->product_id)
					->where('card_id', $data->card_id)
					->where('src_dealer_id', $userinfo["dealer_id"])->first();
		$purchase_price = ($purchase_price_info !== null)? $purchase_price_info->sale_price: $priceinfo["purchase_price"];
		
		$promotion = 0;
		
        $Sale = Sale::where('product_id', $data->product_id)
					->where('card_id', $data->card_id)
					->where('tag_dealer_id', $userinfo["dealer_id"])
					->update(['purchase_price' => $purchase_price, 'promotion_price' => $promotion, 'sale_price' => $priceinfo["sale_price"]]);
		if ($Sale == '0'){
			
			if($priceinfo["sale_price"] == null) return false;
			
			$Sale = new Sale;
			$Sale->product_id = $data->product_id;
			$Sale->card_id = $data->card_id;
			$Sale->purchase_price = $purchase_price;
			$Sale->promotion_price = $promotion;
			$Sale->sale_price = $priceinfo["sale_price"];
			$Sale->tag_dealer_id = $userinfo["dealer_id"];
			$Sale->src_dealer_id = 0;
			$Sale->seller_id = $userinfo["user_id"];
			$Sale->sale_date = date("Y-m-d H:i:s");
			$Sale->save();
		}			

        return $Sale;
	}
    
	// add sales info
	/*
		Parameter: 
			array(
					"status" => $order_status,
					"product_id" => $card->product_id,
					"order_code" => $order_item->order_code,
					"card_id" => $card->id,
					"tag_dealer_id" => $order_item->tag_dealer_id,
					"src_dealer_id" => $order_item->src_dealer_id,
					"seller_id" => $order_item->seller_id,
					"purchase_price" => $purchase_price,
					"sale_price" => $sale_price,
					"promotion" => $promotion,
				)
	
	*/
	
    public static function add_sales_order_info($data) {

		$userinfo = Session::get('total_info');
		
		$purchase_price_info = Sale::where('product_id', $data['product_id'])
					->where('card_id', $data['card_id'])
					->where('src_dealer_id', $data['tag_dealer_id'])->first();
		$purchase_price = ($purchase_price_info !== null)? $purchase_price_info->sale_price: $data['purchase_price'];
		
		$sales_log = Sale::where([
				['tag_dealer_id', '=', $data['tag_dealer_id']],
				['card_id', '=', $data['card_id']],
			])->first();
		if(null === $sales_log)	$sales_log = new Sale();
		
		$sales_log->status = $data['status'];
		$sales_log->product_id = $data['product_id'];
		$sales_log->order_code = $data['order_code'];
		$sales_log->card_id = $data['card_id'];
		$sales_log->tag_dealer_id = $data['tag_dealer_id'];
		$sales_log->src_dealer_id = $data['src_dealer_id'];
		$sales_log->seller_id = $userinfo["user_id"];
		$sales_log->purchase_price = $purchase_price;
		$sales_log->sale_price = $data['sale_price'];
		$sales_log->promotion_price = $data['promotion'];
		if($data['status'] == 0){		// purchase
			$sales_log->save();
		}
		else if($data['status'] == 1){	// return
			$sales_log->delete();
		}
	}
	
	/************************************************************
		Get Max Saled Product of Specific Dealer saled
		parameter: 
			$dealer_id		: dealer id
		Return: 	Product record
	************************************************************/
    public static function getDealerTopSaledProduct($dealer_id) {
		
		$stock_info = Sale::query()
			->selectRaw('product_id, count(`id`) as `size_of_saled`')
			->where('tag_dealer_id', '=', $dealer_id)
			->groupBy('product_id')
			->orderByDesc('size_of_saled')
			->first();
		
		if(null !== $stock_info){
			return Product::find($stock_info->product_id);
		}
		return NULL;
    }
	
	// Get total sale count indexed by dealer_id
    public static function getTotalSaleCountByDealer() {
        $sale_list = Sale::selectRaw('tag_dealer_id, count(*) as total_sale')->groupBy('tag_dealer_id')->get();
        $ret_ary = array();
        foreach($sale_list as $sale) {
            $ret_ary[''.$sale->tag_dealer_id] = $sale->total_sale;
        }

        return $ret_ary;
    }

    // Get total unbalanced money indexed by dealer_id
    //public static function getTotalUnbalancedByDealer() {
	public static function getTotalPurchaseByDealer() {		
		/*$list = Sale::where('balance_state', 0)
			->selectRaw('src_dealer_id, sum(sale_price) as total_unbalance')
			->groupBy('src_dealer_id')->get();*/
		
		$list = Sale::selectRaw('src_dealer_id, sum(sale_price) as total_unbalance')
			->leftJoin('dealers as d', 'd.id', '=', 'src_dealer_id')
			->whereRaw('sale_date>dcs_d.last_settle_time')
			->groupBy('src_dealer_id')->get();
		
        $ret_ary = array();
        foreach($list as $item) {
            $ret_ary[''.$item->src_dealer_id] = $item->total_unbalance;
        }

        return $ret_ary;
    }
	
	public static function getTotalWholesaleByDealer() {		
		/*$list = Sale::where('balance_state', 0)
			->selectRaw('src_dealer_id, sum(sale_price) as total_unbalance')
			->groupBy('src_dealer_id')->get();*/
		
		$list = Sale::selectRaw('tag_dealer_id, sum(sale_price) as total_unbalance')
			->leftJoin('dealers', 'dealers.id', '=', 'tag_dealer_id')
			->whereRaw('sale_date>dcs_dealers.last_settle_time')
			->where('src_dealer_id', '<>', 0)
			->groupBy('tag_dealer_id')->get();
        $ret_ary = array();
        foreach($list as $item) {
            $ret_ary[''.$item->tag_dealer_id] = $item->total_unbalance;
        }

        return $ret_ary;
    }
	
	public static function getTotalPromotionByDealer() {		
		/*$list = Sale::where('balance_state', 0)
			->selectRaw('src_dealer_id, sum(sale_price) as total_unbalance')
			->groupBy('src_dealer_id')->get();*/
		
		$list = Sale::selectRaw('src_dealer_id, sum(promotion_price) as total_promotion')
			->leftJoin('dealers', 'dealers.id', '=', 'src_dealer_id')
			->whereRaw('sale_date>dcs_dealers.last_settle_time')
			->groupBy('src_dealer_id')->get();
        $ret_ary = array();
        foreach($list as $item) {
            $ret_ary[''.$item->src_dealer_id] = $item->total_promotion;
        }

        return $ret_ary;
    }
	
    // Get total unbalanced money indexed by dealer_id
    public static function getTotalUnbalancedByDealerID($dealer_id) {
		$unbalance = Sale::where('balance_state', 0)
			->selectRaw('src_dealer_id, sum(sale_price) as total_sale, sum(promotion_price) as promotion_price')
			->where('src_dealer_id', '=', $dealer_id)
			->first();
		$unbalance->total_sale = ($unbalance->total_sale === null)? 0: $unbalance->total_sale;
		$unbalance->promotion_price = ($unbalance->promotion_price === null)? 0: $unbalance->promotion_price;
		
		$unbalance = Sale::where('balance_state', 0)
			->selectRaw('src_dealer_id, sum(sale_price) as total_sale, sum(promotion_price) as promotion_price')
			->where('src_dealer_id', '=', $dealer_id)
			->first();
			
        $ret_ary = array();
		$ret_ary['total_sale'] = $unbalance->total_sale;
		$ret_ary['promotion_price'] = $unbalance->promotion_price;

        return $ret_ary;
    }
	
    // Get total sale from dealer_id
    public static function getTotalSale($dealer_id) {
        $total_sale = Sale::where('tag_dealer_id', $dealer_id)->sum('sale_price');

        return $total_sale;
    }
    // Get total sale in this month from dealer_id
    public static function getSaleMonth($dealer_id) {
        date_default_timezone_set(date_default_timezone_get());
        $month_start = date('Y-m-d', strtotime('first day of this month'));
        $month_end = date('Y-m-d', strtotime('last day of this month'));

        $sale = Sale::where('tag_dealer_id', $dealer_id)->where('sale_date', '>=', $month_start)->where('sale_date', '<=', $month_end)->sum('sale_price');

        return $sale;
    }
    // Get unbalanced money from dealer_id
    public static function getUnbalance($dealer_id) {
        $unbalance = Sale::where('src_dealer_id', $dealer_id)->where('balance_state', 0)->sum('sale_price');

        return $unbalance;
    }
    // Get unbalanced sale list by product from dealer_id, product_name, sale_count, sale_sum
    public static function getUnbalanceList($dealer_id) {
        $sale_list = Sale::where('src_dealer_id', $dealer_id)->where('balance_state', 0)->selectRaw('product_id, count(*) as sale_count, sum(sale_price) as sale_sum')->groupBy('product_id')->get();
        $product_ary = Product::get_product_list();

        foreach($sale_list as $sale) {
            if (isset($product_ary[''.$sale->product_id])) $sale->product_name = $product_ary[''.$sale->product_id]->name;
            else $sale->product_name = null;
        }

        return $sale_list;
    }
    // Get total_sale_price of this month indexed by user_id
    public static function getSaleListByUser() {
        date_default_timezone_set(date_default_timezone_get());
        $month_start = date('Y-m-d', strtotime('first day of this month'));
        $month_end = date('Y-m-d', strtotime('last day of this month'));

        $list = Sale::where('sale_date', '>=', $month_start)->where('sale_date', '<=', $month_end)->selectRaw('seller_id, sum(sale_price) as total_sale')->groupBy('seller_id')->get();
        $ret_ary = array();
        foreach($list as $item) {
            $ret_ary[''.$item->seller_id] = $item->total_sale;
        }
        
        return $ret_ary;
    }
    // Get total_sale, sale_month of down dealers indexed by seller_id
    public static function getTotalMonthSaleListByUser($dealer_id, $start_date, $end_date, $redpacket_monthly) {
        // Get the down dealer list of dealer_id
		$down_dealer_ary = Dealer::getSubDealerListRaw($dealer_id);

        // Get the sales list to give redpacket indexed by user_id
        if ($redpacket_monthly == 1) {
            $user_list = Sale::whereIn('tag_dealer_id', $down_dealer_ary)
                ->selectRaw('seller_id, tag_dealer_id, sum(sale_price) as total_sale, sum(case when sale_date >= "' . $start_date . '" and sale_date <= "' . $end_date . '" then sale_price else 0 end) as sale_month')
                ->groupBy('seller_id')
                ->get();
        }
        else {
            $user_list = Sale::whereIn('tag_dealer_id', $down_dealer_ary)
                ->selectRaw('seller_id, tag_dealer_id, sum(sale_price) as total_sale, sum(case when sale_date <= "' . $end_date . '" then sale_price else 0 end) as sale_month')
                ->groupBy('seller_id')
                ->get();
        }

        $ret_ary = array();
        foreach ($user_list as $user) {
            $ret_ary[''.$user->seller_id] = $user;
        }

        //$ret_ary = array();
        return $ret_ary;
    }
    // Get total_sale, sale_month
    public static function getTotalMonthSale($user_id, $redpacket_monthly, $start_date, $end_date) {
        if ($redpacket_monthly == 1) {
            $user_sale = Sale::where('seller_id', $user_id)
                ->selectRaw('sum(sale_price) as total_sale, sum(case when sale_date >= "' . $start_date . '" and sale_date <= "' . $end_date . '" then sale_price else 0 end) as sale_month')
                ->first();
            
            if ($user_sale) {
                $user_sale->start_date = $start_date;
                $user_sale->end_date = $end_date;
            }
        }
        else {
            $user_sale = Sale::where('seller_id', $user_id)
                ->selectRaw('sum(sale_price) as total_sale, sum(case when sale_date <= "' . $end_date . '" then sale_price else 0 end) as sale_month')
                ->first();

            if ($user_sale) {
                $user_sale->start_date = null;
                $user_sale->end_date = $end_date;
            }
        }

        return $user_sale;
    }

    public static function getTotalSalesForReward($user_id, $product_id, $start_time, $end_time)
    {
        if ($product_id == null) {
            $total_sales = Sale::where('seller_id', $user_id)
                ->whereBetween('sale_date', [$start_time, $end_time])
                ->selectRaw('sum(sale_price) as total_sale_price, count(*) as total_sale_cards, dealer_id')
                ->first();
        } else {
            $total_sales = Sale::where('seller_id', $user_id)
                ->where('product_id', $product_id)
                ->whereBetween('sale_date', [$start_time, $end_time])
                ->selectRaw('sum(sale_price) as total_sale_price, count(*) as total_sale_cards, dealer_id')
                ->first();
        }

        return $total_sales;
    }

    public static function getTotalSalesPerUserForReward($users, $product_id, $start_time, $end_time)
    {
        if ($product_id == null) {
            $total_sales = Sale::whereIn('user_id', $users)
                ->whereBetween('sale_date', [$start_time, $end_time])
                ->groupBy(['seller_id', 'dealer_id'])
                ->selectRaw('sum(sale_price) as total_sale_price, count(*) as total_sale_cards, dealer_id')
                ->first();
        } else {
            $total_sales = Sale::whereIn('user_id', $users)
                ->where('product_id', $product_id)
                ->whereBetween('sale_date', [$start_time, $end_time])
                ->groupBy(['seller_id', 'dealer_id'])
                ->selectRaw('sum(sale_price) as total_sale_price, count(*) as total_sale_cards, dealer_id, user_id')
                ->get();
        }

        return $total_sales;
    }
	
	// Record card register agree sale info
	public static function recordRegAgree($dealer_id, $card_id){
		Sale::where([
			['tag_dealer_id', '=', $dealer_id],
			['src_dealer_id', '=', 0],
			['card_id', '=', $card_id]
		])->update(['reg_success' => 1]);
	}

    // seller user info
	public function seller()
    {
        return $this->hasOne('App\User', 'id', 'seller_id');
    }
    // tag dealer info
    public function tag_dealer() {
        return $this->hasOne('App\Dealer', 'id', 'tag_dealer_id');
    }
	
	public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
	
	public function dealer()
    {
        return $this->hasOne('App\Dealer', 'id', 'tag_dealer_id');
    }
}
