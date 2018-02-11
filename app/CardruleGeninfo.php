<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CardruleGeninfo extends Model
{
	// Get card gen info
	public static function getValueByKey($rule_template_id, $type, $keyword){
		$item = CardruleGeninfo::where([["rule_template_id", "=", $rule_template_id], ["type", "=", $type], ["keyword", "=", $keyword]])->first();
		if($item === null) return null;
		else return $item->value;
	}
	
	// Set card gen info
	public static function setValueByKey($rule_template_id, $type, $keyword, $value){
		$item = CardruleGeninfo::where([["rule_template_id", "=", $rule_template_id], ["type", "=", $type], ["keyword", "=", $keyword]])->first();
		if($item === null){
			$item = new CardruleGeninfo();
			$item->rule_template_id = $rule_template_id;
			$item->type = $type;
			$item->keyword = $keyword;
		}
		
		$item->value = $value;
		$item->save();
	}
}
