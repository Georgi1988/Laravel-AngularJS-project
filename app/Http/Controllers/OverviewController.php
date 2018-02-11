<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mProvider;

use Maatwebsite\Excel\Facades\Excel;

class OverviewController extends Controller
{
	private $m_code_upload_path = "uploads/machinecode_data/import/";
	
	public function view_index(Request $request){
		
		$login_info = $request->session()->get('total_info');
		
		$period_time = trans('lang.week');
		
		$view_info = [
			'home_title' => trans('lang.home_title')."-".trans('lang.label_overview'),
			'c_categ' => 'overview',
			'user_id' => $login_info['user_id'],
            'dealer_id' => $login_info['dealer_id'],
			'is_salepoint' => count($login_info['down_dealers']) == 0,
			'ov_period_lavel' => trans('lang.ov_period_lavel', ['preriod_time' => strtolower($period_time)]),
			'ov_period_card' => trans('lang.ov_period_card', ['preriod_time' => strtolower($period_time)]),
		];
		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'overview', $view_info);
	}
	
    /**********************************************
		stock info ajax request json return function--
		parameter: search_json array
		return: stock info
    **********************************************/
	public function get_stock_info($search_json, Request $request){
		
		$site_priv = $request->session()->get('site_priv');
		$login_info = $request->session()->get('total_info');
		
		$search_data = json_decode($search_json);
		
		$today_stock_info = App\Card::getCardStockInfoByDealer($login_info['dealer_id'], date("Y-m-d"), date("Y-m-d"));
		$period_stock_info = App\Card::getCardStockInfoByDealer($login_info['dealer_id'], $search_data->start_date, $search_data->end_date, $search_data->product_type1);
		$stock_info_total = App\Card::getCardStockInfoByDealer($login_info['dealer_id'], null, null);
		
		$today_stock_info->available_count = $stock_info_total->available_count;
		$today_stock_info->expired_count = $stock_info_total->expired_count;
		$today_stock_info->soon_expired_count = $stock_info_total->soon_expired_count;
		
		$period_stock_info->available_count = $stock_info_total->available_count;
		$period_stock_info->expired_count = $stock_info_total->expired_count;
		$period_stock_info->soon_expired_count = $stock_info_total->soon_expired_count;
		
		$tb_prefix = DB::getTablePrefix();
		$yesterday_sales = App\Sale::query()
			->selectRaw('*, sum(`sale_price` - `purchase_price`) as `income`')
			->whereRaw('date(`sale_date`) = "'.date("Y-m-d", time()-86400).'" and `seller_id` != 0')
			->where('seller_id', '!=', '0')
			->groupBy('seller_id')
			->orderByDesc('income')
			->first();
		$yes_top_seller = null;
		if(null !== $yesterday_sales){
			$yes_top_seller = $yesterday_sales->seller;
			if(null !== $yes_top_seller){
				$yes_top_seller->dealer;
			}
		} 
	
		echo json_encode(
			array(	"status" => true, 
					"today_stock" => $today_stock_info, 
					"period_stock" => $period_stock_info, 
					"yes_top_seller" => $yes_top_seller , 
					"product_type" => array(	'level1_type' => App\ProductLevel::getAllTypes(1),
												'level2_type' => App\ProductLevel::getAllTypes(2))
				)
		);
	}
	// pc overview[admin] code
	public function view_code_page(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'overview_code');
	}
	
	// pc overview[admin] code
	public function get_code_list($itemcount, $pagenum){
		
		if($itemcount < 1) $itemcount = 5;
		
		$m_codes = App\MachineCode::orderByDesc('id')->paginate($itemcount, ['*'], 'p', $pagenum);
		
		foreach($m_codes as $m_code){
			$m_code->card;
		}
		
		$return_arr['list'] = $m_codes;
		
		echo json_encode($return_arr);
		
	}
	
	// pc overview[admin] code delete
	public function delete_code_items(){
		$data = json_decode(file_get_contents("php://input"));
		$ret_status = App\MachineCode::whereIn('id', $data)->delete();
		echo json_encode(array("status"=>$ret_status));
	}
	
	// pc overview[admin] code import
	public function import_code_file(Request $request){
		$return_arr = array("status" => true);
		
		$machine_code_file = $request->file("machine_code_file");
		
		$total_count = 0;
		$success_count = 0;
		$duplicate_count = 0;

		if (null !== $machine_code_file) {
			$destinationPath = $this->m_code_upload_path;
			$filename = date("YmdHis_").rand(10000, 99999).".".$machine_code_file->extension();

			if ($machine_code_file->move($destinationPath, $filename)) {

                $file_pull_path = $destinationPath.$filename;

                Excel::load($file_pull_path, function($reader) {
                    // load all sheet and record
                    $results = $reader->all();

                    foreach ($results as $sheet) {
                        $title = $sheet->getTitle();

                        //if ($title == "机器号样本") {
                            foreach ($sheet as $row) {
                                $machinecode = App\MachineCode::where('code', '=', $row[0])->first();

                                if (null === $machinecode) {
                                    $machinecode = new App\MachineCode();
                                    $machinecode->code = $row[0];
                                    $machinecode->card_id = 0;

                                    $machinecode->save();
                                }
                            }
                        //}
					}
				});
			} else {
                $return_arr["status"] = false;
				$return_arr["err_msg"] = "File copy error!";
            }
		} else {
			$return_arr["status"] = false;
			$return_arr["err_msg"] = "No uploaded file!";
		}

		echo json_encode($return_arr);
	}

	public function insert_code($code, Request $request) {
		$ret_ary = array();
		$priv = $request->session()->get('site_priv');
		if ($priv == 'admin') {
			$ret = App\MachineCode::add_code($code);
			$ret_ary['success'] = $ret;
		}
		else 
			$ret_ary['success'] = 2;
		
		return json_encode($ret_ary);
	}
}
