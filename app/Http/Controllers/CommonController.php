<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderShipped;
use Mail;
use mProvider;

use Maatwebsite\Excel\Facades\Excel;

class CommonController extends Controller
{
    public function templateFileDownload($template_type){
		
		$filename = '';
		$downname = '';
		
		switch($template_type){
			case 'machine_code':
				$filename = public_path('contents/import/machine_code/sample/machine_template_new.xlsx');
				$downname = '机器吗.xlsx';
				break;
			case 'dealer_import':
				$filename = public_path('contents/import/dealer/dealer_import_template.xlsx');
				$downname = '经销商导入模板.xlsx';
				break;
			case 'register_agree':
				$filename = public_path('contents/import/agree_register/register_agree_template.xlsx');
				$downname = '注册批量审核模板.xlsx';
				break;
			case 'bulk_register':
				$filename = public_path('contents/import/bulk_register/bulk_register_import_sample.xlsx');
				$downname = '批量注册模板.xlsx';
				break;
			case 'physical_card':
				$filename = public_path('contents/import/physical_card/physical_card_import_sample.xlsx');
				$downname = '实物卡选择模板.xlsx';
				break;
			case 'stock_import':
				$filename = public_path('contents/import/stock/stock_import_sample.xlsx');
				$downname = '库存服务卡导入模板.xlsx';
				break;
		}
		
		return response()->download($filename, $downname);
	}
}
