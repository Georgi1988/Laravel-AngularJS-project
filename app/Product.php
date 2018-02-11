<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RedPacketSetting;

class Product extends Model
{
	
	public function level1_info()
    {
        return $this->hasOne('App\ProductLevel', 'id', 'level1_id');
    }

    // Get product list indexed by product_id
    public static function get_product_list() {
        $list = Product::all();
        $ret_ary = array();
        foreach($list as $item) {
            $ret_ary[''.$item->id] = $item;
        }

        return $ret_ary;
    }
	
	public function level2_info()
    {
        return $this->hasOne('App\ProductLevel', 'id', 'level2_id');
    }
	
	public function rule()
    {
        return $this->hasOne('App\Cardrule', 'id', 'card_rule_id');
    }

    public static function getProductIdByName($name) {
        $product = Product::where('name', '=', $name)->first();

        if (null === $product)
            return null;

        return $product->id;
    }

    public static function getProductIdByCode($code) {
        $product = Product::where('code', '=', $code)->first();

        if (null === $product)
            return null;

        return $product->id;
    }

    public function redpacketRules() {
	    return $this->hasMany('RedPacketSetting', 'product_id', 'id');
    }
}
