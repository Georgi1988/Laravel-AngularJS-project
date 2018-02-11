<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CardruleTemplate extends Model
{
	// Get card list by card_length
	public static function getArrayByCardLength(){
		$return_array = array();
		
		$templates = CardruleTemplate::get();
		
		$listByLength = array();
		$card_length_list = array();
		
		$return_array['rules_by_id'] = array();
		
		foreach($templates as $template){
			$template->password_length_list = explode(",", $template->password_length);
			
			$return_array['rules_by_id'][$template->id] = $template;
			
			if(!in_array($template->card_code_length, $card_length_list)) {
				$card_length_list[] = $template->card_code_length;
			}
			
			if (!array_key_exists("".$template->card_code_length, $listByLength))
				$listByLength["".$template->card_code_length] = array();
			
			$listByLength["".$template->card_code_length][]= $template;
		}
		$return_array['length_list'] = $card_length_list;
		$return_array['rules_by_size'] = $listByLength;
		
		return $return_array;
	}
}
