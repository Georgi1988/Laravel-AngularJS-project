<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderShipped;
use Mail;
use mProvider;

use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    private $stock_upload_path = "uploads/stock_data/import/";

    /**********************************************
		list view page template page
    **********************************************/
	public function view_list(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock');
	}
	
    /**********************************************
		list view page template page
    **********************************************/
	public function view_list_byproduct(){
		$emailaddress = App\User::get_email();
		$view_data = array(
			"email" => $emailaddress,
		);
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock_product', $view_data);
	}
		
    /**********************************************
		stock page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: stock list info, pagination info
    **********************************************/
	public function get_list($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		$tb_prefix = DB::getTablePrefix();
		
		$query = App\Card::query()
			->selectRaw('`'.$tb_prefix.'cards`.*')
			->join('products as p', 'p.id', '=', 'cards.product_id');
			
		
		if(property_exists($search_obj, "dealer_id") && $search_obj->dealer_id != "" && $search_obj->dealer_id != 0){
			//echo $search_obj->dealer_id;
			$query	->where('cards.dealer_id', '=', (int)$search_obj->dealer_id);
		}else{
			$query	->where('cards.dealer_id', '=', $login_info['dealer_id']);
		}
		
		if(property_exists($search_obj, "product_type1") && $search_obj->product_type1 != ""){
			$query	->where('p.level1_id', '=', $search_obj->product_type1);
		}
		if(property_exists($search_obj, "product_type2") && $search_obj->product_type2 != ""){
			$query	->where('p.level2_id', '=', $search_obj->product_type2);
		}
		if(property_exists($search_obj, "card_code_keyword") && $search_obj->card_code_keyword != ""){
			$query	->where('cards.code', 'like', '%'.$search_obj->card_code_keyword.'%');
		}
		if(property_exists($search_obj, "card_type") && $search_obj->card_type !== ""){
			$query	->where('cards.type', '=', $search_obj->card_type);
		}
		if(property_exists($search_obj, "product_id") && $search_obj->product_id !== ""){
			$query	->where('cards.product_id', '=', $search_obj->product_id);
		}else{
			
		}
		
		$product = App\Product::find($search_obj->product_id);
		
		$expire_date_value = (int)App\Option::get_option_inherit($login_info['dealer_id'], "stock_expire_notify_value");
		if($expire_date_value < 1) $expire_date_value = 1;
		
		$page_type1_where = [	['cards.status', '<', 1]];
		$page_type2_where = [	['cards.valid_period', '>=', date("Y-m-d H:i:s")],
								['cards.valid_period', '<', date("Y-m-d H:i:s", time() + $expire_date_value * 86400)]];
		$page_type3_where = [	['cards.valid_period', '<', date("Y-m-d H:i:s")]];
		$page_type4_where = [	['cards.status', '=', 2]];
		$page_type5_where = [	['cards.status', '=', 1]];
		
		$temp_query1 = clone $query;
		$page_type1_count = $temp_query1->where($page_type1_where)
			->where(function ($query) {
				$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
						->orwhere('cards.valid_period', '=', null);
			})->count();
			
		$temp_query2 = clone $query;
		$page_type2_count = $temp_query2->where($page_type2_where)->count();
		$temp_query3 = clone $query;
		$page_type3_count = $temp_query3->where($page_type3_where)->count();
		$temp_query4 = clone $query;
		$page_type4_count = $temp_query4->where($page_type4_where)->count();
		
		$temp_query5 = clone $query;
		$page_type5_count = $temp_query5->where($page_type5_where)
			->where(function ($query) {
				$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
						->orwhere('cards.valid_period', '=', null);
			})->count();
		
		if(property_exists($search_obj, "page_type") && $search_obj->page_type != ""){
			if($search_obj->page_type == 1){
				$query	->where($page_type1_where)
						->where(function ($query) {
							$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
									->orwhere('cards.valid_period', '=', null);
						});
			}
			else if($search_obj->page_type == 2){
				$query	->where($page_type2_where);
			}
			else if($search_obj->page_type == 3){
				$query	->where($page_type3_where);
			}
			else if($search_obj->page_type == 4){
				$query	->where($page_type4_where);
			}
			else if($search_obj->page_type == 5){
				$query	->where($page_type5_where)
						->where(function ($query) {
							$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
									->orwhere('cards.valid_period', '=', null);
						});
			}
		}
		
		$query->orderByDesc('cards.id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		foreach($items as $item){
			$item->product;
			$item->dealer;
			if(time() > strtotime($item->valid_period) && null !== $item->valid_period) $item->expired = 1;
			else $item->expired = 0;
		}
		
		$return_arr['list'] = $items;
		
		$return_arr['other_info'] = array(
			'product' => $product,
			"type_list" => array(
				'level1_type' => App\ProductLevel::getAllTypes(1),
				'level2_type' => App\ProductLevel::getAllTypes(2),
			),
			'p1_count' => $page_type1_count,
			'p2_count' => $page_type2_count,
			'p3_count' => $page_type3_count,
			'p4_count' => $page_type4_count,
			'p5_count' => $page_type5_count,
		);
		
		echo json_encode($return_arr);
	}
	
    /**********************************************
		stock page list items json return function--
		parameter: search_json array, itemcount on page,  pagenum
		return: stock list info, pagination info
    **********************************************/
	public function get_list_product($search_json, $itemcount, $pagenum, Request $request){
		
		if($itemcount < 1) $itemcount = 5;
		$login_info = $request->session()->get('total_info');
		$search_obj = json_decode($search_json);
		$tb_prefix = DB::getTablePrefix();
		
		$query = App\Card::query()
			->selectRaw('`'.$tb_prefix.'cards`.*, count(`'.$tb_prefix.'cards`.`id`) as `prod_count`')
			->join('products as p', 'p.id', '=', 'cards.product_id');
		
		$search_dealer_id = 0;
		if(property_exists($search_obj, "dealer_id") && $search_obj->dealer_id != "" && $search_obj->dealer_id != 0){
			$query	->where('cards.dealer_id', '=', (int)$search_obj->dealer_id);
			$search_dealer_id = (int)$search_obj->dealer_id;
		}else{
			$query	->where('cards.dealer_id', '=', $login_info['dealer_id']);
			$search_dealer_id = $login_info['dealer_id'];
		}
		
		if(property_exists($search_obj, "product_type1") && $search_obj->product_type1 != ""){
			$query	->where('p.level1_id', '=', $search_obj->product_type1);
		}
		if(property_exists($search_obj, "product_type2") && $search_obj->product_type2 != ""){
			$query	->where('p.level2_id', '=', $search_obj->product_type2);
		}
		if(property_exists($search_obj, "card_code_keyword") && $search_obj->card_code_keyword != ""){
			$query	->where('cards.code', 'like', '%'.$search_obj->card_code_keyword.'%');
		}
		if(property_exists($search_obj, "card_type") && $search_obj->card_type !== ""){
			$query	->where('cards.type', '=', $search_obj->card_type);
		}
		
		$expire_date_value = (int)App\Option::get_option_inherit($login_info['dealer_id'], "stock_expire_notify_value");
		if($expire_date_value < 1) $expire_date_value = 1;
		
		$page_type1_where = [	['cards.status', '<', 1]];
		$page_type2_where = [	['cards.valid_period', '>=', date("Y-m-d H:i:s")],
								['cards.valid_period', '<', date("Y-m-d H:i:s", time() + $expire_date_value * 86400)]];
		$page_type3_where = [	['cards.valid_period', '<', date("Y-m-d H:i:s")]];
		$page_type4_where = [	['cards.status', '=', 2]];
		$page_type5_where = [	['cards.status', '=', 1]];
		
		$temp_query1 = clone $query;
		$page_type1_count = $temp_query1->where($page_type1_where)
			->where(function ($query) {
				$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
						->orwhere('cards.valid_period', '=', null);
			})->count();
			
		$temp_query2 = clone $query;
		$page_type2_count = $temp_query2->where($page_type2_where)->count();
		$temp_query3 = clone $query;
		$page_type3_count = $temp_query3->where($page_type3_where)->count();
		$temp_query4 = clone $query;
		$page_type4_count = $temp_query4->where($page_type4_where)->count();
		
		$temp_query5 = clone $query;
		$page_type5_count = $temp_query5->where($page_type5_where)
			->where(function ($query) {
				$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
						->orwhere('cards.valid_period', '=', null);
			})->count();
		
		if(property_exists($search_obj, "page_type") && $search_obj->page_type != ""){
			if($search_obj->page_type == 1){
				$query	->where($page_type1_where)
						->where(function ($query) {
							$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
									->orwhere('cards.valid_period', '=', null);
						});
			}
			else if($search_obj->page_type == 2){
				$query	->where($page_type2_where);
			}
			else if($search_obj->page_type == 3){
				$query	->where($page_type3_where);
			}
			else if($search_obj->page_type == 4){
				$query	->where($page_type4_where);
			}
			else if($search_obj->page_type == 5){
				$query	->where($page_type5_where)
						->where(function ($query) {
							$query	->where('cards.valid_period', '>=', date("Y-m-d H:i:s"))
									->orwhere('cards.valid_period', '=', null);
						});
			}
		}
		
		$query->orderByDesc('cards.id');
		$query->groupBy('cards.product_id');
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		foreach($items as $item){
			$item->product;
			$item->dealer;
			if(time() > strtotime($item->valid_period)) $item->expired = 1;
			else $item->expired = 0;
		}
		
		$return_arr['list'] = $items;
		
		$dealer_id = $login_info['dealer_id'];
		
		$cur_dealer = App\Dealer::find($dealer_id);
		
		/* $dealers_set = array();
		$dealers_id_ary = App\Dealer::getSubDealerListRaw($dealer_id);
		array_unshift($dealers_id_ary, $dealer_id);
		foreach($dealers_id_ary as $dealer_id){
			$dealers_set[] = App\Dealer::find($dealer_id);
		} */
		
		$return_arr['other_info'] = array(
			"type_list" => array(
				//'dealers' => $dealers_set,
				'cur_dealer_id' => $dealer_id,
				'up_dealer_id' => $cur_dealer->parent_id,
				'search_dealer' => App\Dealer::find($search_dealer_id),
				'level1_type' => App\ProductLevel::getAllTypes(1),
				'level2_type' => App\ProductLevel::getAllTypes(2),
			),
			'p1_count' => $page_type1_count,
			'p2_count' => $page_type2_count,
			'p3_count' => $page_type3_count,
			'p4_count' => $page_type4_count,
			'p5_count' => $page_type5_count,
		);
		
		echo json_encode($return_arr);
	}
	
	
	/**********************************************
		Stock download to file
    **********************************************/
	public function stock_download_file($search, Request $request){
		
		set_time_limit(0);
		
		$login_info = $request->session()->get('total_info');
		
		$search_obj = json_decode(base64_decode($search));
		
		$items = App\Card::getStockCards($search_obj);
		
		//var_dump($items);
		$file_name = 'stock_info_'.date("Y-m-d_H_i_s");
		$path_name = 'stock_download/'.date("Y/m/");
		
		Excel::create($file_name, function($excel) use ($items, $login_info) {
			$excel->sheet('Cards', function($sheet) use ($items, $login_info)
	        {
				$sheet->row(1, array(
					"编号", "产品名", "产品号码", "分类", "卡号码", "卡密码"
				));
			
				$i = 2;
				foreach($items as $item){
					$item->product;
					$card_kind = ($item->type == 1) ? "实物卡" : "虚拟卡";
					$card_password = ($item->type == 1 && $login_info['level'] != 0) ? "---" : $item->passwd;
					$sheet->row($i, array(
						$i - 1, $item->product->name, $item->product->code, $card_kind, $item->code, $card_password
					));
					$i++;
				}
				
				$sheet->setWidth(array(
					'A'     =>  8,
					'B'     =>  60,
					'C'     =>  20,
					'D'     =>  15,
					'E'     =>  30,
					'F'     =>  30,
				));
				
				$sheet->setHeight(1, 25);
				$sheet->cells('A1:F1', function($cells) {
					// manipulate the range of cells
					$cells->setAlignment('center');
					$cells->setVAlignment('center');
				});
				$sheet->cells('C2:F'.$i, function($cells) {
					// manipulate the range of cells
					$cells->setAlignment('center');
				});
	        });
		//})->download("xls");
		})->store('xlsx', storage_path($path_name));
		
		$file_name = $file_name.'.xlsx';
		$excel_attach = $path_name.$file_name;
		
		$historygeneratedata = array(
					"module_name"=>"库存",
					"operation_kind"=>"下载",
					"operation"=>"库存信息文件下载",
				);
		App\History::add_history($historygeneratedata);
		
		echo json_encode(array("status" => true, "file" => $excel_attach));
	}
	
	
	public function stock_download_storage($filename){
		$filename =  base64_decode($filename);
		
		$path = storage_path($filename);
		return response()->download($path);
	}
	
	/**********************************************
		Stock download
    **********************************************/
	public function stock_download(Request $request){
		
		set_time_limit(0);
		
		$login_info = $request->session()->get('total_info');
		
		$search_obj = json_decode(file_get_contents("php://input"));
		
		$items = App\Card::getStockCards($search_obj);
		
		$file_name = date("Y-m-d_H_i_s_").$login_info['dealer_id'].'-'.rand(10000, 99999);
		$path_name = 'stock_download/'.date("Y/m/");
		
		Excel::create($file_name, function($excel) use ($items, $login_info) {
			$excel->sheet('Cards', function($sheet) use ($items, $login_info)
	        {
				$sheet->row(1, array(
					"编号", "产品名", "产品号码", "分类", "卡号码", "卡密码"
				));
			
				$i = 2;
				foreach($items as $item){
					$item->product;
					$card_kind = ($item->type == 1) ? "实物卡" : "虚拟卡";
					$card_password = ($item->type == 1 && $login_info['level'] != 0) ? "---" : $item->passwd;
					$sheet->row($i, array(
						$i - 1, $item->product->name, $item->product->code, $card_kind, $item->code, $card_password
					));
					$i++;
				}
				
				$sheet->setWidth(array(
					'A'     =>  8,
					'B'     =>  60,
					'C'     =>  20,
					'D'     =>  15,
					'E'     =>  30,
					'F'     =>  30,
				));
				
				$sheet->setHeight(1, 25);
				$sheet->cells('A1:F1', function($cells) {
					// manipulate the range of cells
					$cells->setAlignment('center');
					$cells->setVAlignment('center');
				});
				$sheet->cells('C2:F'.$i, function($cells) {
					// manipulate the range of cells
					$cells->setAlignment('center');
				});
	        });
		})->store('xls', storage_path($path_name));
		
		$file_name = $file_name.'.xls';
		
		$excel_attach = $path_name.$file_name;
		
		// Mail send feature After configure mail smtp setting, open this paragraph.
		
		Mail::send('emails.send', ['title' => "Stock Download Data", "filename" => $file_name], function ($message) use ($search_obj, $excel_attach)
        {
			$message->from('SVC_CHK@dell.onaliyun.com', 'DELL服务卡销售和管理系统');

            $message->to($search_obj->sendemail);
			//$message->sender('SVC_CHK@dell.onaliyun.com', $name = null);
			//$message->cc($search_obj->sendemail, $name = null);
			//$message->bcc($search_obj->sendemail, $name = null);
			$message->subject("Stock Download Data");
			$message->attach(storage_path($excel_attach));

        });
		
		$historygeneratedata = array(
					"module_name"=>"库存",
					"operation_kind"=>"下载",
					"operation"=>"库存信息发送到“".$search_obj->sendemail."”",
				);
		App\History::add_history($historygeneratedata);
		
		echo json_encode(array("status" => true));
		
		
		/* return Excel::create('itsolutionstuff_example', function($excel) use ($items) {
			$excel->sheet('mySheet', function($sheet) use ($items)
	        {
				$sheet->fromArray($items);
	        });
		})->download("xls"); */
	}
	
	
	
    /**********************************************
		Stock card view page template page
    **********************************************/
	public function view_item(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock_view');
	}
	
    /**********************************************
		stock get card info ajax request function
		parameter: card_id
		return: card info
    **********************************************/
	public function get_card_info($card_id, Request $request){
		
		$login_info = $request->session()->get('total_info');
		
		$card = App\Card::find($card_id);
		if(null !== $card){
			$card->valid_forever = ($card->valid_period == null);
			$card->expire_remain_days = floor( (strtotime($card->valid_period) - time()) / 86400 );
			$card->dealer;
			$card->product;
			$card->customer;
			$card->product_stock = App\Stock::getDealerStockInfo($card->product_id, $login_info['dealer_id']);
			if($card->product){
				$card->product->level1_info;
				$card->product->level2_info;
			}
			$return_arr = array("status" => true, 'card' => $card);
		}else{
			$return_arr = array("status" => false);
		}
		echo json_encode($return_arr);
	}
	
    /**********************************************
		Stock purchase order template page {mobile}
    **********************************************/
	public function view_add(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock_add');
	}
	
    /**********************************************
		Stock purchase order ajax request {mobile}
    **********************************************/
	public function order_purchase(Request $request){
		
		$login_info = $request->session()->get('total_info');
		
		$data = json_decode(file_get_contents("php://input"));
		
		
		// Case of Physical Card return
		$excel_attach = "";
		if($data->type == 1 && $data->status == 1){
			$file_name = date("Y-m-d_H_i_s_").$login_info['dealer_id'].'-'.rand(10000, 99999);
			$path_name = 'order_card_list/'.date("Y/m/");
		
			Excel::create($file_name, function($excel) use ($data, $login_info) {
				$excel->sheet('ReturnCards', function($sheet) use ($data, $login_info)
				{
					$sheet->row(1, array(
						"编号", "产品名", "产品号码", "分类", "退货卡号码"
					));
				
					$i = 2;
					$product = App\Product::find($data->product_id);
					
					foreach($data->code_list as $code => $code_info){
						$card_kind = "实物卡";
						$sheet->row($i, array(
							$i - 1, $product->name, $product->code, $card_kind, $code
						));
						$i++;
					}
					
					$sheet->setWidth(array(
						'A'     =>  8,
						'B'     =>  60,
						'C'     =>  20,
						'D'     =>  15,
						'E'     =>  30,
					));
					
					$sheet->setHeight(1, 25);
					$sheet->cells('A1:F1', function($cells) {
						// manipulate the range of cells
						$cells->setAlignment('center');
						$cells->setVAlignment('center');
					});
					$sheet->cells('C2:F'.$i, function($cells) {
						// manipulate the range of cells
						$cells->setAlignment('center');
					});
				});
			})->store('xls', storage_path($path_name));
		
			$file_name = $file_name.'.xls';
			$excel_attach = $path_name.$file_name;
		}
		
		$userinfo = $request->session()->get('total_info');
		
		$order = new App\Order();
		$order->code = date("Ymd").rand(10000000, 99999999);
		$order->product_id = $data->product_id;
		$order->size = $data->order_size;
		$order->src_dealer_id = $userinfo['dealer_id'];
		$order->tag_dealer_id = $userinfo['up_dealer']['id'];
		$order->code_list = $excel_attach;
		$order->status = $data->status;
		$order->card_type = $data->type;
		$status = $order->save();
		
		// log table
		$dealer = App\Dealer::find($userinfo["dealer_id"]);
		$src_dealer_name = ($dealer)? $dealer->name: "";	
		$product = App\Product::find($order->product_id);
		$product_name = ($product)? $product->name: "";	

		if($order->status == 0)
			App\History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交进货", "operation"=>"向上级经销商申请进货".$order->size."张延保卡"));
		else
			App\History::add_history(array("module_name"=>"订单", "operation_kind"=>"提交退货", "operation"=>"向上级经销商申请退货".$order->size."张延保卡"));
		
		// Message table
		if($order->status == 0) {
			App\Message::save_message(array(
						"type" => "2",
						"tag_dealer_id" => $userinfo["up_dealer"]["id"],
						"tag_user_id" => null,
						"message" => $src_dealer_name." 申请进货服务卡“".$product_name."”".$order->size."张",
						"url" => "#!/order/view/".$order->id,
						"html_message" => "",
						"table_name" => "order",
						"table_id" => $order->id,
					));
			//App\Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);
		}
		else {
			App\Message::save_message(array(
						"type" => "2",
						"tag_dealer_id" => $userinfo["up_dealer"]["id"],
						"tag_user_id" => null,
						"message" => $src_dealer_name." 申请退货服务卡“".$product_name."”".$order->size."张",
						"url" => "#!/order/view/".$order->id,
						"html_message" => "",
						"table_name" => "order",
						"table_id" => $order->id,
					));
			//App\Dealer::setCheckOrdered($userinfo["up_dealer"]["id"], 1);	
		}
		
		echo json_encode(array("status" => $status));
	}
	
    /**********************************************
		stock get product info ajax request function
		parameter: product_id
		return: product info
    **********************************************/
	public function get_product_info($product_id, Request $request){
		
		$userinfo = $request->session()->get('total_info');
		
		$product = App\Product::find($product_id);
		if(null !== $product){
			$product->level1_info;
			$product->level2_info;
			$product->stock_info = App\Stock::getDealerStockInfo($product->id, $userinfo['dealer_id']);
			$product->price_info = App\Price::get_price_by_dealer($product->id, $userinfo['dealer_id']);
			$order_info['min_limit'] = App\Option::get_option(1, 'order_single_minium');
			$order_info['max_limit'] = App\Option::get_option(1, 'order_single_maxium');
			$return_arr = array("status" => true, 'product' => $product, 'order_info' => $order_info);
		}else{
			//$return_arr = array("status" => false);
			$return_arr = array("status" => false, 'err_msg' => __('lang.no_corresponding_data'));
		}
		echo json_encode($return_arr);
	}
	
	
    /**********************************************
		stock get stock_get_qr_code info ajax request function
		parameter: card_id
		return: card qr code url
    **********************************************/
	public function stock_get_qr_code($card_id, Request $request){
		$card = App\Card::find($card_id);
		if($card !== null){
			$qr_code_str = base64_encode(json_encode(array("code" => $card->code, "password" => $card->passwd)));
			$code_image = 'card/qrcode_'.$card->id.'.png';
			
			if(!is_file(public_path($code_image))){
				$renderer = new \BaconQrCode\Renderer\Image\Png();
				$renderer->setHeight(256);
				$renderer->setWidth(256);
				$writer = new \BaconQrCode\Writer($renderer);
				$writer->writeFile($qr_code_str, public_path($code_image));				
			}
			
			$return_arr = array("status" => true, "img_code" => $code_image);
		}else{
			$return_arr = array("status" => false);
		}
		echo json_encode($return_arr);
	}
	
	public function stock_download_qr_code($card_id, Request $request){
		$card = App\Card::find($card_id);
		$code_image = 'card/qrcode_'.$card->id.'.png';
		return response()->download(public_path($code_image));
	}
	
	public function view_return(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock_return');
	}
	public function view_setting(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock_setting');
	}
	
	// Stock card template import function
	public function stock_card_import(Request $request) {
        $return_arr = array("status" => true);

        $card_import_file = $request->file("card_import_file");

        //var_dump($card_import_file);

        if (null !== $card_import_file) {
            $destinationPath = $this->stock_upload_path;
            $filename = date("YmdHis_").rand(10000, 99999).".".$card_import_file->extension();

            if ($card_import_file->move($destinationPath, $filename)){

                $file_pull_path = $destinationPath.$filename;
                $sheets = Excel::load($file_pull_path, function($reader) {
                    // load all sheet and record
                    $results = $reader->all();
                })->get();

                $sheetNo = 0;
                $product_status = array();
				
				$error_msg = array();

                foreach ($sheets as $sheet) {
                    $sheetNo++;
                    $productCode = $sheet->getTitle();

                    $productId = App\Product::getProductIdByCode($productCode);

                    if ($productId === null) {
                        /* $product_status[$productCode] = array(
                            'status' => false,
                            'error_message' => "This Product is not registered"); */
						$error_msg[] = __('lang.st_product_not_exist', ['product_code' => $productCode]);
						$return_arr["status"] = false;
                    } else {
                        //$card_status = array();

                        foreach ($sheet as $row) {
                            if ($row[0] == "")
                                break;

                            if (App\Card::getCardByCode($row[1]) === null) {
                                $card = new App\Card();
                                $card->type = ($row[3] == "实物卡") ? 1 : 0;
                                $card->code = $row[1];
                                $card->passwd = $row[2];
                                $card->product_id = $productId;
                                $card->status = 0;
                                $card->dealer_id = 1;
                                $card->valid_period = $row[4];
                                $card->save();
                            }
                            else {
                                //$card_status[] = "Card(".$row[1].") is already registered";
                                $return_arr["status"] = false;
								$error_msg[] = __('lang.st_card_exist', ['card_code' => $row[1]]);
                            }
                        }
                    }
                }
				
				if ($return_arr["status"] == false) {
					$return_arr["error_message"] = __('lang.st_import_some_incorrect_data');
					$return_arr["error_list"] = $error_msg;
				} else {
					$return_arr["msg"] = __('lang.import_dlg_message');
				}
            } else {
                $return_arr["status"] = false;
                $return_arr["error_message"] = __('lang.error_file_upload_failed');
            }
        } else {
            $return_arr["status"] = false;
            $return_arr["error_message"] = __('lang.error_file_upload_failed');
        }

        echo json_encode($return_arr);
	}
	
	// Bulk register view page
	public function view_bulk_register(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'stock_bulk_register');
	}
		// bulk register submit function
	public function import_bulk_file(Request $request){
		
		$userinfo = $request->session()->get('total_info');
		
		$bulk_register_file = $request->file("bulk_register_file");
		
		$product_id = $request->input("product_id");
		
		$product = App\Product::find($product_id);

		if ($product === null) {
			$return_arr = array("status" => false, "err_msg" => __('lang.no_data'));
			echo json_encode($return_arr); exit;
		}
		
		// position info in xls files
		$offset_cname = 1;
		$offset_cphone = 2;
		$offset_mcode = 3;
		$offset_cardtype = 4;
		$offset_cardcode = 5;
		$offset_cardpass = 6;
		
		if (null !== $bulk_register_file) {
			Excel::load($bulk_register_file->path(), function($reader) use($userinfo, $product_id, $product, $offset_cname, $offset_cphone, $offset_mcode, $offset_cardtype, $offset_cardcode, $offset_cardpass) {
				
				$total_card = 0;
				$valid_card = 0;
				$registered_card = 0;
				$valid_card_list = array();
				$invalid_card_list = array();
				
				// load all sheet and record and card check
				$results = $reader->all();

				foreach ($results as $sheet) {
					$title = $sheet->getTitle();

					foreach ($sheet as $row) {
						$card_type = ($row[$offset_cardtype] == "实物卡")? 1 : 0;
						$card_code = $row[$offset_cardcode];
						$card_pass = $row[$offset_cardpass];
						$machine_code = $row[$offset_mcode];

						if ($card_code !== null) {
							
							$total_card ++;
							
							$check_status = App\Card::check_card($product_id, $card_type, $card_code, $card_pass);
							
							if ($check_status === null) {
								$invalid_card_list[] = $card_code." : ".__('lang.ac_card_exist_title');
							} else if(!$check_status) {
								$invalid_card_list[] = $card_code." : ".__('lang.invalid_password');
							} else {
								if (App\MachineCode::check_machinecode($check_status, $machine_code) == 1){
									$row['db_card_id'] = $check_status;
									$valid_card_list[] = $row;
									$valid_card ++;
								} else {
									$invalid_card_list[] = $machine_code." : ".__('lang.invalid_m_code');
								}
							}
						}
					}
				}
				
				$exist_invalid_card = ($total_card == $valid_card)? false: true;
				
				if ($valid_card == 0){
					$return_arr = array(
						"status" => false, 
						"err_msg" => __('lang.error_no_valid_card'), 
						"err_type" => "no_card");
				} else if($exist_invalid_card) {
					$return_arr = array(
						"status" => false, 
						"err_msg" => __('lang.st_exist_invalid_card'), 
						"err_type" => "exist_invalid", 
						"total_cards_quantity" => $total_card, 
						"valid_cards_quantity" => $valid_card, 
						"exist_invalid_card" => $exist_invalid_card, 
						"invalid_cards" => $invalid_card_list);
				} else {
					// Bulk register action part
					$client_array = array();
					$return_status = true;

					foreach($valid_card_list as $row) {
						
						$client_name = $row[$offset_cname];
						$client_phone = $row[$offset_cphone];
						$machine_code = $row[$offset_mcode];
						$card_id = $row['db_card_id'];
						$card_type = $row[$offset_cardtype];
						$card_code = $row[$offset_cardcode];
						
						// Get customer id
						if(strlen($client_name) > 0 && strlen($client_phone) > 0){
							if(!isset($client_array[$client_name."---".$client_phone])){
								$customer_id = App\Customer::add_customer((object)['regit_name' => $client_name, 'regit_phone' => $client_phone]);
								$client_array[$client_name."---".$client_phone] = $customer_id;
							}else{
								$customer_id = $client_array[$client_name."---".$client_phone];
							}
						}else{
							$customer_id = 0;
						}
						
						// Get price info
						$priceinfo = App\Price::get_price_by_dealer($product_id, $userinfo["dealer_id"]);
						$status = App\Card::bulk_register($product_id, $card_id, $card_code, $machine_code, $priceinfo, $customer_id);
						
						if (!$status) {
							$invalid_card_list[] = $card_code." : ".__('lang.operation_failed');
						} else {
							$registered_card ++;
						}
						
						$return_status &= $status;
					}
					
					//Meassage send part
					$dealer = App\Dealer::find($userinfo["dealer_id"]);
					
					// var_dump($dealer); exit;
					// $dealer->president;
					$messageadddata = array(
								"type" => "1",
								"tag_dealer_id" => "1",
								"tag_user_id" => null,
								"message" => "批量激活和注册了（".$product->name."） ".$registered_card."张服务卡。",
								"url" => "",
								"html_message" => "<p>批量激活和注册了（".$product->name."） ".$registered_card."张卡片。</p>",
								"table_name" => "card",
							);
							
					App\Message::save_message($messageadddata);
					
					$return_arr = array("status" => $return_status);
					if ($return_status == true) {
						$return_arr['msg'] = __('lang.rg_all_success', ['total_count' => $total_card]);
					} else {
						$return_arr['err_msg'] = __('lang.rg_sub_success', ['total_count' => $total_card, 'success_count' => $valid_card, 'fail_count' => ($total_card - $valid_card)]);
						$return_arr['err_type'] = "some_failed";
						$return_arr['invalid_cards'] = $invalid_card_list;
					}
				}
				
				echo json_encode($return_arr);
			});
		} else {
			$return_arr = array("status" => false, "err_msg" => __('lang.error_file_upload_failed'));
			echo json_encode($return_arr);
		}
	}
}
