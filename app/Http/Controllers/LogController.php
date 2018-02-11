<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

class LogController extends Controller
{
    public $categ = 'log';
	
	// pc log view
	public function index(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'log');
	}
	
	/*******************************
		Request Log list info
	*******************************/
	public function get_list($search_json, $itemcount, $pagenum){
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		
		$query = App\History::query();
		if(property_exists($search_obj, "operate_type") && $search_obj->operate_type != ""){
			$query->where('operation_kind', '=', $search_obj->operate_type);
		}
		if(property_exists($search_obj, "start_date") && $search_obj->start_date != ""){
			$query->where('operation_time', '>=', $search_obj->start_date);
		}
		if(property_exists($search_obj, "end_date") && $search_obj->end_date != ""){
			$query->where('operation_time', '<=', $search_obj->end_date);
		}
		
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		foreach($return_arr['list'] as $item){
			$item->dealer_info;
			$item->user_info;
			$date = explode(" ",$item->operation_time);
			$item->operation_date = $date[0];
			$item->operation_hour = $date[1];
			if ($item->is_mobile == "1"){
				$item->system = "移动端APP";
			}else if ($item->is_mobile == "0"){
				$item->system = "桌面PC";
			}
		}
		
		
		echo json_encode($return_arr);
	}
	/*******************************
		Request Log list info
	*******************************/
	public function get_operatetype_list(){
		
		$operatetype_list = App\History::selectRaw('distinct(operation_kind)')->get();
		$return_arr['list'] = $operatetype_list;
		foreach($return_arr['list'] as $item){
			$item->val = $item->operation_kind;
			$item->label = $item->operation_kind;
		}	
		
		echo json_encode($operatetype_list);
	}
}
