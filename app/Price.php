<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Promotion;
use App\Product;

class Price extends Model
{
	// Get purchase_price, wholesale_price, sale_price list indexed by product_id
	public static function getPriceListByProduct($dealer_id) {
		$products = Product::all();
		$dealer = Dealer::find($dealer_id);

        // Get the dealer_level and up_dealer_id
        if ($dealer) {
            $dealer_level = $dealer->level;
            $up_dealer_id = $dealer->parent_id;
        }
        else {
            $dealer_level = 0;
            $up_dealer_id = 1;
        }
		
		// Get current date time
		$cur_date = date("Y-m-d");
		// Get the total promotion list indexed by product_id
		$total_promotion_ary = Promotion::getTotalPromotion($cur_date);
		$level_promotion_ary = Promotion::getPromotionByLevel($cur_date, $dealer_level);
		$dealer_promotion_ary = Promotion::getPromotionByDealer($cur_date, $dealer_id);

		$ret_ary = array();
		foreach ($products as $product) {
			// Get wholesale_price, sale_price
			$purchase_price_levels = json_decode($product->purchase_price_level, true);
			
			if (isset($purchase_price_levels[$dealer_level])) {
				$product->wholesale_price = $purchase_price_levels[$dealer_level];
			} else {
				$product->wholesale_price = null;
			}
			$product->sale_price = $product->sale_price;			

			// Get the purchase_price
			if ($dealer_level == 0)
				$product->purchase_price = $product->price_sku;
			else {
				if (isset($purchase_price_levels[$dealer_level - 1])) {
					$product->purchase_price = $purchase_price_levels[$dealer_level - 1];
				} else {
					$product->purchase_price = null;
				}
			}
			
			// Get the promotion_price, promotion_start_date, promotion_end_date
			if (isset($dealer_promotion_ary[''.$product->id])) {
				$product->promotion_price = $dealer_promotion_ary[''.$product->id]->promotion_price;
				$product->promotion_start_date = $dealer_promotion_ary[''.$product->id]->promotion_start_date;
				$product->promotion_end_date = $dealer_promotion_ary[''.$product->id]->promotion_end_date;
			}
			else {
				if (isset($level_promotion_ary[''.$product->id])) {
					$product->promotion_price = $level_promotion_ary[''.$product->id]->promotion_price;
					$product->promotion_start_date = $level_promotion_ary[''.$product->id]->promotion_start_date;
					$product->promotion_end_date = $level_promotion_ary[''.$product->id]->promotion_end_date;
				}
				else {
					if (isset($total_promotion_ary[''.$product->id])) {
						$product->promotion_price = $total_promotion_ary[''.$product->id]->promotion_price;
						$product->promotion_start_date = $total_promotion_ary[''.$product->id]->promotion_start_date;
						$product->promotion_end_date = $total_promotion_ary[''.$product->id]->promotion_end_date;
					}
					else {
						$product->promotion_price = null;
						$product->promotion_start_date = null;
						$product->promotion_end_date = null;
					}
				}
			}

			$ret_ary[''.$product->id] = $product;
		}

		return $ret_ary;
	}

    // Get the purchase_price, wholesale_price, sale_price, promotion of product by dealer
    public static function get_price_by_dealer($product_id, $dealer_id) {
        $product = Product::find($product_id);
		if(null === $product) return null;
		
        $dealer = Dealer::find($dealer_id);

        // Get the dealer_level and up_dealer_id
        if ($dealer) {
            $dealer_level = $dealer->level;
            $up_dealer_id = $dealer->parent_id;
        }
        else {
            $dealer_level = 0;
            $up_dealer_id = 0;
        }

		$ret_ary = array();
        // Get wholesale_price, sale_price
		$purchase_price_levels = json_decode($product->purchase_price_level, true);
		if (isset($purchase_price_levels[$dealer_level])) {
			$ret_ary['wholesale_price'] = $purchase_price_levels[$dealer_level];
		} else {
			$ret_ary['wholesale_price'] = null;
		}
		$ret_ary['sale_price'] = $product->sale_price;	

        // Get the purchase_price
		if ($dealer_level == 0)
			$ret_ary['purchase_price'] = $product->price_sku;
		else {
			if (isset($purchase_price_levels[$dealer_level - 1])) {
				$ret_ary['purchase_price'] = $purchase_price_levels[$dealer_level - 1];
			} else {
				$ret_ary['purchase_price'] = null;
			}
		}

		// Get current date time
		$cur_date = date("Y-m-d");
        // Get the promotion array
		$promotion = array();
		$item = Promotion::getPromotionItemByDealer($cur_date, $product_id, $dealer_id);
		if ($item) {
			$promotion['promotion_price'] = $item->promotion_price;
			$promotion['promotion_start_date'] = $item->promotion_start_date;
			$promotion['promotion_end_date'] = $item->promotion_end_date;
		}
		else {
			$item = Promotion::getPromotionItemByLevel($cur_date, $product_id, $dealer_level);
			if ($item) {
				$promotion['promotion_price'] = $item->promotion_price;
				$promotion['promotion_start_date'] = $item->promotion_start_date;
				$promotion['promotion_end_date'] = $item->promotion_end_date;
			}
			else {
				$item = Promotion::getTotalPromotionItem($cur_date, $product_id);
				if ($item) {
					$promotion['promotion_price'] = $item->promotion_price;
					$promotion['promotion_start_date'] = $item->promotion_start_date;
					$promotion['promotion_end_date'] = $item->promotion_end_date;
				}
				else {
					$promotion = null;
				}
			}
		}
		$ret_ary['promotion'] = $promotion;
		// if(null === $promotion) $ret_ary['promotion'] = array('promotion_price' => 100);
		
        return $ret_ary;
    }
}
