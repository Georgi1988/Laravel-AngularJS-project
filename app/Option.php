<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    // option save function	
	static function save_option($dealer_id, $key, $val){		
		$option = Option::where([['dealer_id', '=', $dealer_id], ['key', '=', $key]])->first();
		if(null === $option){
			$option = new Option();
			$option->dealer_id = $dealer_id;
			$option->key = $key;
		}
		$option->value = $val;
		return $option->save();
	}
	
    // option get function	
	static function get_option($dealer_id, $key = null){		
		if(isset($key)){
			return Option::where([['dealer_id', '=', $dealer_id], ['key', '=', $key]])->first()['value'];
		}
		else{
			$retarr =  array();
			
			$options = Option::where([['dealer_id', '=', $dealer_id]])->get();
			foreach($options as $option){
				$retarr[$option->key] = $option->value;
			}
			
			return $retarr;
		}
	}
	
	// option get function	
	static function get_option_inherit($dealer_id, $key){
		$option = Option::where([['dealer_id', '=', $dealer_id], ['key', '=', $key]])->first();
		$dealer = Dealer::find($dealer_id);
		if(null == $option && null != $dealer && $dealer->level != 0){
			if($dealer->parent_id == 0) return '';
			else return Option::get_option_inherit($dealer->parent_id, $key);
		}
		else if(null !== $option){
			return $option['value'];
		} 
		else{
			return '';
		} 
	}
	
}
