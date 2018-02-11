<?php

namespace App\Http\Controllers;

use App;
use App\Card;
//use App\Price;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use mProvider;

use Maatwebsite\Excel\Facades\Excel;

class RegisterController extends Controller
{
	// Register Agree part
	public function view_reg_agree(){			// Seller register view page   [seller]
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'register_agree');
	}

	/*******************************
		view agree card item view page
	*******************************/
	public function view_reg_agree_item(){			// Seller register view page   [seller]
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'register_agree_view');
	}
	
	
	/*******************************
		Request card list info
	*******************************/
	public function list_card_agree($search_json, $itemcount, $pagenum, Request $request){
		
		$login_info = $request->session()->get('total_info');
		$priv = $request->session()->get('site_priv');
		
		if($itemcount < 1) $itemcount = 5;
		
		$search_obj = json_decode($search_json);
		
		// for badge
		/* if (property_exists($search_obj, "page_type")) {
			if ($search_obj->page_type == 'product' && $pagenum == 1) {
				$user_id = $login_info['user_id'];
				App\User::setLastProductId($user_id);
			}
		}*/	
		
		$query = App\Card::query();
		$query->where(function ($query){
			$query	->where('valid_period', '=', null)
					->orwhere('valid_period', '>=', date("Y-m-d H:i:s"));
		});
		if(property_exists($search_obj, "page_type") && $search_obj->page_type != ""){
			$page_type = $search_obj->page_type;
			if($page_type == 1)
				$query->where([	['status', '=', 1],
								['agree_reg', '=', 'r']]);
			else if($page_type == 2)
				$query->where('status', '=', 2);
			else if($page_type == 3)
				$query->where([	['status', '=', 1],
								['agree_reg', '=', 'd']]);
		}
		
		$query->orderByDesc('register_datetime');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		$return_arr['list'] = $items;
		
		$user_id = $login_info['user_id'];
		//$badge_arr = App\Badge::getBadgeAry($user_id, 'product');

		foreach($return_arr['list'] as $item){
			
			$item->product;
			$item->dealer;
			$item->seller;
			$item->customer;
			
			//if (isset($badge_arr[''.$item->id])) $item->badge = $badge_arr[''.$item->id];
			//else $item->badge = 0;

		}
		
		echo json_encode($return_arr);
	}
	
	// Agree or disagree card register
	public function agree_card_register($card_id, $status, Request $request){
		
		$login_info = $request->session()->get('total_info');
		if($login_info['authority'] != "admin"){
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		$card = App\Card::find($card_id);
		if($card === null || ($card->status != 1 || $card->agree_reg != 'r')){
			echo json_encode(array("status" => false, "err_msg" => __('lang.no_data'))); exit;
		}else{
			
			$bool_status = ($status == "true" || $status === true)? true: false;
			$ret_status = $card->agree_register($bool_status);
			if(!$ret_status){
				echo json_encode(array("status" => false, "err_msg" => __('lang.operation_failed'))); exit;
			}else{
				
				App\Sale::recordRegAgree($card->dealer_id, $card_id);
				
				App\RedPacket::checkUser($card->user_id);
				
				$agree_kind = ($bool_status == true)? '同意': '不同意';
				
				$historygeneratedata = array(
							"module_name"=>"注册",
							"operation_kind"=>$agree_kind,
							"operation"=>"管理员".$agree_kind."服务卡注册（卡号：".$card->code."）",
						);
				App\History::add_history($historygeneratedata);
				
				echo json_encode(array("status" => true, "msg" => __('lang.operation_success'))); exit;
			}
		}
		
	}
	
	
	// Agree or disagree card register by excel template
	public function agree_card_template(Request $request){
		
		set_time_limit(0);
		
		$login_info = $request->session()->get('total_info');
		if($login_info['authority'] != "admin"){
			echo json_encode(array("status" => false, "err_msg" => __('lang.err_no_permission'))); exit;
		}
		
		// position info in xls files
		$offset_code = 4;
		$offset_status = 5;
		$status_arr = array("批准" => true, "否决" => false);
		
		$agree_register_file = $request->file("agree_register_file");
		if (null !== $agree_register_file) {
			Excel::load($agree_register_file->path(), function($reader) use ($offset_code, $offset_status, $status_arr){
				// load all sheet and record and card check
				$status = true;
				$err_msg = array();
				$total_card = 0;
				$valid_card = 0;
		
				$user_list = array();
				
				$results = $reader->all();
				foreach ($results as $sheet) {
					$title = $sheet->getTitle();
					foreach ($sheet as $row) {
						$card_code = $row[$offset_code];
						$card_status = $status_arr[$row[$offset_status]];
						
						if($card_code !== null){
							$total_card ++;
							
							$card = App\Card::where('code', $card_code)->first();
							
							if($card === null){
								$status = false;
								$err_msg[] = $card_code."(".__('lang.ac_card_exist_title').")";
							}elseif($card->status == 1 && $card->agree_reg != "n"){
								
								$reg_status = $card->agree_register($card_status);
								
								
								if($reg_status){
									
									App\Sale::recordRegAgree($card->dealer_id, $card->id);
									$valid_card ++;
				
									if(!in_array($card->user_id, $user_list)) $user_list[] = $card->user_id;
								}else{
									$status = false;
									$err_msg[] = $card_code."(".__('lang.pr_register_fail').")";
								}
							}else{
								$status = false;
								$err_msg[] = $card_code."(".__('lang.operation_failed').")";
							}
						}
					}
				}
				
				foreach($user_list as $user_id){
					App\RedPacket::checkUser($user_id);
				}
				
				$historygeneratedata = array(
							"module_name"=>"注册",
							"operation_kind"=>"批量审批",
							"operation"=>"管理员批量审批服务卡注册",
						);
				App\History::add_history($historygeneratedata);
				
				if($status)
					$return_arr = array("status" => $status, "msg" => __('lang.operation_success'));
				else
					$return_arr = array("status" => $status, "err_msg" => __('lang.rg_sub_success', ['total_count' => $total_card, 'success_count' => $valid_card, 'fail_count' => ($total_card - $valid_card)])."<br />".implode(", ", $err_msg));
				
				echo json_encode($return_arr);
			});
		}else{
			$return_arr = array("status" => false, "err_msg" => __('lang.error_file_upload_failed'));
			echo json_encode($return_arr);
		}
	}
	
	// Card data to agree download
	public function pending_list_down(Request $request){
		
		set_time_limit(0);
		
		$login_info = $request->session()->get('total_info');
		
		if($login_info['authority'] != "admin"){
			return Redirect::to('home#!/register/card/agree/eyJwYWdlX3R5cGUiOjEsInBhZ2VudW0iOjF9');
		}
		
		$items = App\Card::where([['status', '=', 1], ['agree_reg', '=', 'r']])->orderBy('product_id')->orderByDesc('register_datetime')->get();
		
		return Excel::create('审批注册目录_'.date("Y-m-d_H_i_s"), function($excel) use ($items, $login_info) {
			$excel->sheet('Cards', function($sheet) use ($items, $login_info)
	        {
				$sheet->row(1, array(
					"编号", "产品名", "产品号码", "分类", "卡号码", "机器码", "零售门店", "店员", "客户姓名", "客户电话", "申请时间"
					// A,	B,		C,			D,		E,		F,		G,		H,		I,			J,		K
				));
			
				$i = 2;
				foreach($items as $item){
					$item->product;
					$item->dealer;
					$item->seller;
					$item->customer;
					
					$card_kind = ($item->type == 1) ? "实物卡" : "虚拟卡";
					
					$dealer_name = ($item->dealer !== null)? $item->dealer->name: "";
					$seller_name = ($item->seller !== null)? $item->seller->name: "";
					
					$sheet->row($i, array(
						$i - 1, 
						$item->product->name, 
						$item->product->code, 
						$card_kind, 
						$item->code, 
						$item->machine_code, 
						($item->dealer !== null)? $item->dealer->name: " ", 
						($item->seller !== null)? $item->seller->name: " ", 
						($item->customer !== null)? $item->customer->name: " ", 
						($item->customer !== null)? $item->customer->link: " ", 
						$item->register_datetime
					));
					$i++;
				}
				
				$sheet->setWidth(array(
					'A'     =>  8,
					'B'     =>  40,
					'C'     =>  20,
					'D'     =>  15,
					'E'     =>  30,
					'F'     =>  30,
					'G'     =>  30,
					'H'     =>  15,
					'I'     =>  15,
					'J'     =>  30,
					'K'     =>  40,
				));
				
				$sheet->setHeight(1, 25);
				$sheet->cells('A1:K1', function($cells) {
					// manipulate the range of cells
					$cells->setAlignment('center');
					$cells->setVAlignment('center');
					$cells->setFontColor('#0066DD');
				});
				$sheet->cells('C2:J'.($i-1), function($cells) {
					// manipulate the range of cells
					$cells->setAlignment('center');
				});
	        });
		})->download("xls");
	}
}
