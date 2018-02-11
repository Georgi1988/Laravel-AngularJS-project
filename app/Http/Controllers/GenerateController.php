<?php

namespace App\Http\Controllers;

use App;
use App\Card;
//use App\Price;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use mProvider;

class GenerateController extends Controller
{
    //
	public function index(){
		$setting_index_arr = App\Option::get_option(1);
		$view_data = array(
			"setting" => $setting_index_arr,
		);	
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'generate', $view_data);
	}
	public function add(){
		$setting_index_arr = App\Option::get_option(1);
		$view_data = array(
			"setting" => $setting_index_arr,
		);	
	
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'generate_add', $view_data);
	}
	public function post_add(Request $request){
		
		set_time_limit(0);
		
		$data = json_decode(file_get_contents("php://input"));
		//$pricedata = Card::Price($data);
		
		echo json_encode(Card::insertCard($data));
	}	
	
	// card rule list view page
	public function view_card_rule(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'generate_cardrule_list');
	}
	
	// card rule list ajax get request
	public function list_card_rule($search_json, $itemcount, $pagenum, Request $request){
		
		$login_info = $request->session()->get('total_info');
		$priv = $request->session()->get('site_priv');
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		
		
		$query = App\Cardrule::query();
		
		/* if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where(function ($query) use ($search_obj) {
				$query	->where('name', 'like', '%'.$search_obj->keyword.'%')
						->orwhere('code', 'like', '%'.$search_obj->keyword.'%');
			});
		} */
		
		$query->orderByDesc('id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	// card rule edit view page
	public function view_edit_card_rule(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'generate_cardrule_edit');
	}
	
	// card rule get page
	public function get_card_rule($rule_id){
		
		$rule_template = App\CardruleTemplate::getArrayByCardLength();
		$dict_list = App\Dictionary::getAllArrayByKey();
		
		$rule = null;
		if($rule_id != 0){
			$rule = App\Cardrule::find($rule_id);
			$rule->length_info_json = json_decode($rule->length_info);
		}
		
		echo json_encode(["status" => true, "data" => ["rule" => $rule, "template" => $rule_template, "dic" => $dict_list]]);
	}
	
	public function delete_card_rule($rule_id, Request $request){
		
		$priv = $request->session()->get('site_priv');
		
		if($priv != 'admin') {
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		$rule = App\Cardrule::find($rule_id);
		
		if($rule === null){
			echo json_encode(array("status" => false, "err_msg" => __('lang.no_data'))); exit;
		}else{
			$rule->delete();
			echo json_encode(array("status" => true));
		}
	}
	
	// card rule save/edit page
	public function edit_card_rule($rule_id, Request $request){
		
		$priv = $request->session()->get('site_priv');
		
		if ($priv != 'admin') {
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		$input_data = $request->input();
		
		if($rule_id == 0){
			$rule = new App\Cardrule();
		}else{
			$rule = App\Cardrule::find($rule_id);
			if(null !== $rule){
				
			}else{
				echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
			}
		}
		
		$rule->rule_name = $input_data["rule_name"];
		
		$rule_template = App\CardruleTemplate::find($input_data["rule_template_id"]);
		if(null !== $rule_template){
			
		}else{
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		$rule->template_id = $rule_template->id;
		$rule->rule_code = $rule_template->rule_code;
		$rule->card_code_length = $rule_template->card_code_length;
		$rule->length_type = $rule_template->length_type;
		$rule->length_description = $rule_template->length_description;
		
		$rule->password_length = $input_data["password_length"];
		$rule->password_type = $input_data["passwd_type"];
		
		$length_info  = json_decode($rule_template->length_info, true);
		foreach($length_info as $key => $info){
			if($info['select'] == "manual"){
				$length_info[$key]['value'] = $input_data["json_".$key];
			}
		}
		
		$rule->length_info = json_encode($length_info);
		
		$status = $rule->save();
		
		if($status){
			echo json_encode(["status" => true, "msg" => __('lang.operation_success'), "rule_id" => $rule->id]);
		}else{
			echo json_encode(["status" => false, "err_msg" => __('lang.operation_failed')]);
		}
	}
	
	// card rule list view page
	public function view_dictionary(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'generate_dictionary');
	}
	
	// card rule list view page
		// get dictionary list
	public function get_dictionary_list($search_json, $itemcount, $pagenum, Request $request){
		$query = App\Dictionary::query();
		
		$search_obj = json_decode($search_json);
		
		if(property_exists($search_obj, "keyword") && $search_obj->keyword != ""){
			$query->where('keyword', '=', $search_obj->keyword);
			
			$query->orderByDesc('id');
			$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
			$return_arr['list'] = $items;
			
			echo json_encode($return_arr);
		}
	}
	
		// delet dictionary item
	public function delete_dictionary_item($id, Request $request){
		$priv = $request->session()->get('site_priv');
		if ($priv == 'admin') {			
			$item = App\Dictionary::find($id);
			if($item === null){
				echo json_encode(["status" => false]); exit;
			}
			$item->delete();
			echo json_encode(["status" => true]);
		}
	}
	
		// get dictionary item
	public function get_dictionary_item($id, Request $request){
		$priv = $request->session()->get('site_priv');
		
		$item = App\Dictionary::find($id);
		if($item === null){
			$item = new App\Dictionary();
			$item->id = 0;
			$item->description = '';
			$item->value = '';
		}
		echo json_encode(["status" => true, "value" => $item]);
	
	}
	
		// edit dictionary item
	public function get_dictionary_edit($id, Request $request){
		$priv = $request->session()->get('site_priv');
		
		if ($priv != 'admin') {
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		$data = (array)json_decode(file_get_contents("php://input"));
		
		$item = App\Dictionary::find($id);
		if($item === null){
			$item = new App\Dictionary();
			$item->keyword = trim($data['keyword']);
		}
		
		if($item->keyword != trim($data['keyword'])){
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		$item->description = trim($data['description']);
		$item->value = trim($data['value']);
		$status = $item->save();
		
		if($status){
			echo json_encode(["status" => true, "msg" => __('lang.operation_success')]);
		}else{
			echo json_encode(["status" => false, "err_msg" => __('lang.operation_failed')]);
		}
	
	}
}
