<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Dictionary extends Model
{
	public static function getAllArrayByKey(){
		$dict_items = Dictionary::get();
		$list = array();
		foreach($dict_items as $dict_item){
			if (!array_key_exists("".$dict_item->keyword, $list))
				$list["".$dict_item->keyword] = array();
			$list["".$dict_item->keyword][] = $dict_item;
		}
		
		return $list;
	}
	
	public static function getKeyWord($keyword, $description){
		
		$dict_item = Dictionary::where([["keyword", "=", $keyword], ["description", "=", $description]])->first();
		
		return $dict_item;
	}
}
