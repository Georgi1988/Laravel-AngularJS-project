<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    // get total promotion list
    public static function getTotalPromotion($cur_date) {
        // dealer_id = 1, level = null
        return null;
    }


    // get total promotion info item
    public static function getTotalPromotionItem($cur_date, $product_id) {
        // dealer_id = 1, level = null
        return null;
    }
    // get promotion list of dealer_level indexed by product_id
    public static function getPromotionByLevel($cur_date, $dealer_level) {
        // dealer_id = 1, level != null
        $items = Promotion::latest()
            ->where('level', $dealer_level)
            ->groupBy('product_id')
            ->having('dealer_id', '<=', 1)
            ->having('promotion_start_date', '<=', $cur_date)
            ->having('promotion_end_date', '>=', $cur_date)
            ->get();
        
        $ret_ary = array();
        foreach ($items as $item) {
            $ret_ary[''.$item->product_id] = $item;
        }
        return $ret_ary;
    }

    // get promotion info item by level
    public static function getPromotionItemByLevel($cur_date, $product_id, $dealer_level) {
        // dealer_id = 1, level != null
        $item = Promotion::latest()
            ->where('product_id', $product_id)
            ->where('level', $dealer_level)
            ->where('dealer_id', '<=', 1)
            ->where('promotion_start_date', '<=', $cur_date)
            ->where('promotion_end_date', '>=', $cur_date)
            ->first();
        
        return $item;
    }
	// get promotion info item by level
    public static function getPromotionItemByLevelForView($cur_date, $product_id, $dealer_level) {
        // dealer_id = 1, level != null
        $item = Promotion::latest()
            ->where('product_id', $product_id)
            ->where('level', $dealer_level)
            ->where('dealer_id', '<=', 1)
            ->where('promotion_end_date', '>=', $cur_date)
            ->first();
        
        return $item;
    }
    // get promotion list of dealer_id indexed by product_id
    public static function getPromotionByDealer($cur_date, $dealer_id) {
        // dealer_id > 1, level = any
        $items = Promotion::latest()
            ->where('dealer_id', $dealer_id)
            ->where('promotion_start_date', '<=', $cur_date)
            ->where('promotion_end_date', '>=', $cur_date)
            ->groupBy('product_id')
            ->get();

        $ret_ary = array();
        foreach ($items as $item) {
            $ret_ary[''.$item->product_id] = $item;
        }
        return $ret_ary;
    }

    // get promotion info item by dealer
    public static function getPromotionItemByDealer($cur_date, $product_id, $dealer_id) {
        // dealer_id > 1, level = any
        $item = Promotion::latest()
            ->where('product_id', $product_id)
            ->where('dealer_id', $dealer_id)
			->where('promotion_start_date', '<=', $cur_date)
            ->where('promotion_end_date', '>=', $cur_date)
            ->first();
			
        return $item;
    }
	
	// get promotion array indexed by dealer_id from product_id
	public static function getPromotionArrayIndexedByDealerId($cur_date, $product_id) {
		$promotions = Promotion::selectRaw('max(id) as max_id')
			->where('product_id', $product_id)
            ->where('promotion_end_date', '>=', $cur_date)
			->where('dealer_id', '>', 1)
			->groupBy('dealer_id')
			->get();
		
		$ret_ary = array();
		foreach ($promotions as $promotion) {
			$item = Promotion::find($promotion->max_id);
			$ret_ary[''.$item->dealer_id] = $item;
		}
		
		return $ret_ary;	
	}
	
	// get all promotions end_date > cur_date
	public static function get_promotion_list($product_id, $cur_date, $itemcount, $pagenum) {
		$promotions = Promotion::where('product_id', $product_id)
			->where('promotion_end_date', '>=', $cur_date)
			->paginate($itemcount, ['*'], 'p', $pagenum);
			
		foreach ($promotions as $promotion) {
			$promotion->product;
			$promotion->dealer;
		}
		
		return $promotions;
	}
	
	// promotion dealer info
	public function dealer() {
        return $this->hasOne('App\Dealer', 'id', 'dealer_id');
    }
	
	// promotion product info
	public function product() {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
