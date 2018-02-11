<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductLevel extends Model
{
    /*********************************
      Get all level type.
		@param  string  $level
		return all type string
    *********************************/
	public static function getAllTypes($level){
		return ProductLevel::where('level', $level)->get();
	}
	
    /*********************************
      Get level type string.
		@param  string  $level, $id
		return type string
    *********************************/
	public static function getStrType($level, $id){
		return ProductLevel::where([['level', '=', $level], ['id', '=', $id]])->select('description')->first()['description'];
	}
	
    /*********************************
      Get level type array by indexing id.
		@param  string  $level, $id
		return type string
    *********************************/
	public static function getIndexdArray($level){
		$level_array = ProductLevel::getAllTypes($level);
		$ret_arr = array();
		foreach($level_array as $row){
			$ret_arr[''.$row[$row["primaryKey"]]] = $row;
		}
		return $ret_arr;
	}
}
