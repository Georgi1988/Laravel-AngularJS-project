<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

use App\Dealer;
use App\DealerDetail;
use App\User;
use App\Stock;
use App\Sale;
use App\Option;
use App\Role;

use Maatwebsite\Excel\Facades\Excel;
use DingTalkContactManager;

define('USER_ROLE_BOSS',                        1);
define('USER_ROLE_STORE_MANAGER',               2);
define('USER_ROLE_SELLER',                      3);

define('DEALER_NAME',                           0);
define('DEALER_AREA',                           1);
define('DEALER_PROVINCE',                       2);
define('DEALER_CITY',                           3);
define('DEALER_CODE',                           4);
define('DEALER_PARENT_NAME',                    5);
define('DEALER_PARENT_CODE',                    6);
define('DEALER_BOSS_NAME',                      7);
define('DEALER_BOSS_LINK',                      8);
define('DEALER_BOSS_EMAIL',                     9);

define('STORE_NAME',                            0);
define('STORE_CODE',                            1);
define('STORE_IN_PARENT_NAME',                  2);
define('STORE_IN_PARENT_CODE',                  3);
define('STORE_DEALER_KIND',                     4);
define('STORE_UPPER_DEALER_NAME',               5);
define('STORE_UPPER_DEALER_CODE',               6);
define('STORE_AREA',                            7);
define('STORE_PROVINCE',                        8);
define('STORE_CITY',                            9);
define('STORE_COUNTRY',                         10);
define('STORE_CITY_LEVEL',                      11);
define('STORE_ZONE',                            12);
define('STORE_TOWN',                            13);
define('STORE_AREA_BOSS_NAME',                  14);
define('STORE_SHOP_DEALER_NAME',                15);
define('STORE_CITY_BOSS_NAME',                  16);
define('STORE_CITY_BOSS_CODE',                  17);
define('STORE_CITY_BOSS_ADDRESS',               18);
define('STORE_BUSINESS_KIND',                   19);
define('STORE_SHOP_KIND',                       20);
define('STORE_SHOP_SHORT_KIND',                 21);
define('STORE_SHOP_PROPERTY',                   22);
define('STORE_SHOP_DIRECTION',                  23);
define('STORE_TOTAL_AREA_OF_SHOP',              24);
define('STORE_SHOP_MONTHLY_SALES',              25);
define('STORE_COMMUNICATION_ADDRESS',           26);
define('STORE_SHOP_POSTAL_CODE',                27);
define('STORE_LINK',                            28);
define('STORE_STORE_MANAGER_NAME',              29);
define('STORE_SHOP_BOSS_PHONE_NUMBER',          30);
define('STORE_STORE_MANAGER_LINK',              31);
define('STORE_STORE_MANAGER_EMAIL',             32);
define('STORE_RECEIPT_ADDRES',                  33);
define('STORE_RECEIPT_NAME',                    34);
define('STORE_RECEIPT_PHONE_NUMBER',            35);
define('STORE_RECEIPT_MOBILE_PHONE_NUMBER',     36);
define('STORE_COOPORATION_STATUS',              37);
define('STORE_APPLICATION_TIME',                38);
define('STORE_APPLY_APPROVAL_TIME',             39);
define('STORE_MODIFY_APPROVAL_TIME',            40);
define('STORE_CANCEL_COOPERATION_APPROVAL_TIME',41);
define('STORE_COMMENT',                         42);
define('STORE_COOPERATION_KIND',                43);
define('STORE_IT_MALL_WHOLE_NAME',              44);
define('STORE_IT_MALL_SHORT_NAME',              45);
define('STORE_LOCATION_KIND',                   46);
define('STORE_AREA_OF_DELL',                    47);
define('STORE_AFTER_SALES_SERVICE_POINT',       48);
define('STORE_LAST_RENOVATED_TIME',             49);
define('STORE_DELL_PAY',                        50);
define('STORE_USE_DECORATION_FUND',             51);
define('STORE_COUNTER_NUMBER',                  52);
define('STORE_SNP_CABINET_NUMBER',              53);
define('STORE_COMMITMENT_SALES',                54);
define('STORE_SHOP_LEVEL',                      55);
define('STORE_NOBODY_SHOP',                     56);
define('STORE_PLATFORM_SHOP_RATING',            57);
define('STORE_REGISTRATION_HOURS',              58);
define('STORE_REGISTRATION_APPROVAL_HOURS',     59);
define('STORE_LINE_UNDER_REPORT',               60);
define('STORE_TOWNSHIP_LEVEL',                  61);
define('STORE_SHOP_IMAGE_URL',                  62);
define('STORE_PROCESS_STATUS',                  63);
define('STORE_RETAIL_MANAGER_USER_NAME',        64);

define('USER_NAME',                             0);
define('USER_LINK',                             1);
define('USER_EMAIL',                            2);
define('USER_IN_DEALER_NAME',                   3);
define('USER_IN_DEALER_CODE',                   4);

class UserController extends Controller
{
    public $categ = 'user';
    
    private $dealer_upload_path = "uploads/dealer_data/import/";

    public function view_dealer(Request $request)
    {
        $login_info = $request->session()->get('total_info');

        $view_info = array(
            'login_dealer_id' => $login_info['dealer_id'],
            'login_dealer_level' => $login_info['level'],
            'dealer_id' => $login_info['dealer_id'],
            'user_id' => $login_info['user_id'],
        );

        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_dealer', $view_info);
    }

    public function view_employee(Request $request)
    {
        $login_info = $request->session()->get('total_info');
        $upper_dealer_id = ($login_info['up_dealer'])? $login_info['up_dealer']->id: 0;

        $view_info = array(
            'login_dealer_id' => $login_info['dealer_id'],
            'login_dealer_level' => $login_info['level'],
            'upper_dealer_id' => $upper_dealer_id,
        );

        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_employee', $view_info);
    }

/*
	public function view_dealer_detail(Request $request){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_dealer_detail');
	}
*/
    public function view_dealer_edit(Request $request)
    {
        $login_info = $request->session()->get('total_info');

        $view_info = array(
            'login_dealer_id' => $login_info['dealer_id'],
            'login_dealer_level' => $login_info['level']
        );

        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_dealer_edit', $view_info);
    }

    public function view_staff_detail(Request $request)
    {
        
        $login_info = $request->session()->get('total_info');
        
        $up_dealer_id = ($login_info['up_dealer'])? $login_info['up_dealer']->id: 0;
        
        $view_info = array(
            'user_id' => $login_info['user_id'],
            'dealer_id' => $login_info['dealer_id'],
            'up_dealer_id' => $up_dealer_id,
        );
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_staff_detail', $view_info);
    }
    public function view_staff_edit()
    {
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_staff_edit');
    }
    public function view_dealer_item($dealer_id = '0')
    {
        $view_info = array(
            'dealer_unblance' => $dealer_id,
        );
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_dealer_view', $view_info);
    }
    
    // Dealer data saving
    public function save_dealer_data(Request $request)
    {
        
        $login_info = $request->session()->get('total_info');
        
        $ret_array = array("status" => true, "err_msg" => "");
        
        $data = json_decode(file_get_contents("php://input"));
        
        $dealer = App\Dealer::find($data->id);
        
        if ($dealer !== null && $dealer->can_edit($login_info)) {
            $addr = array();
            if ($data->addr_area !== null && $data->addr_area != "") {
                $addr[] = $data->addr_area;
            }
            if ($data->addr_province !== null && $data->addr_province != "") {
                $addr[] = $data->addr_province;
            }
            if ($data->addr_city !== null && $data->addr_city != "") {
                $addr[] = $data->addr_city;
            }
            
            if ($dealer->level == 1) {
                $dealer->corporation = $data->corp_code;
            }
            $dealer->name = $data->name;
            $dealer->address = implode(" - ", $addr);
            $dealer->area = $data->addr_area;
            $dealer->province = $data->addr_province;
            $dealer->city = $data->addr_city;
            $dealer->link = $data->link;
            
            $status = $dealer->save();
            $err_msg = "";
            if (!$status) {
                $err_msg = __('lang.err_save_fail');
            }
            
            $ret_array = array("status" => $status, "err_msg" => $err_msg);
            //for test
            //$ret_array = array("status" => false, "err_msg" => __('lang.err_save_fail'));
        } else {
            if ($dealer === null) {
                $err_msg = __('lang.no_corresponding_data');
            } else {
                $err_msg = __('lang.no_permission_edit');
            }
            $ret_array = array("status" => false, "err_msg" => $err_msg);
        }
        
        echo json_encode($ret_array);
    }
    
    // Staff data saving
    public function save_staff_data(Request $request)
    {
        
        $login_info = $request->session()->get('total_info');
        
        $ret_array = array("status" => true, "err_msg" => "");
        
        $data = json_decode(file_get_contents("php://input"));
        
        $user = App\User::find($data->id);
        if ($user !== null && $user->can_edit($login_info)) {
            $user->name = $data->name;
            $user->email = $data->email;
            $user->link = $data->link;
            
            $status = $user->save();
            $err_msg = "";
            if (!$status) {
                $err_msg = __('lang.err_save_fail');
            }
            
            $ret_array = array("status" => $status, "err_msg" => $err_msg);
        } else {
            if ($user === null) {
                $err_msg = __('lang.no_corresponding_data');
            } else {
                $err_msg = __('lang.no_permission_edit');
            }
            $ret_array = array("status" => false, "err_msg" => $err_msg);
        }
        
        echo json_encode($ret_array);
    }

    // Get the detail of dealer
    public function getDealerDetailInfo($dealer_id, Request $request)
    {
        $dealer = Dealer::find($dealer_id);
        $login_info = $request->session()->get('total_info');

        if ($dealer === null) {
            return json_encode(array("status" => false, "err_msg" => "no dealer data"));
        }

        if ($dealer->detail_id != null) {
            $addinfo = DealerDetail::find($dealer->detail_id);
        } else {
            $addinfo = new DealerDetail();
        }

        $dealer->president();
        $dealer->can_edit = $dealer->can_edit($login_info);

        $dealer->getDealerStructureName(true);
        $dealer->getCorperation();

        $areas = App\Dictionary::where('keyword', 'dic_area')->get();
        $provinces = App\Dictionary::where('keyword', 'dic_province')->get();

        $store_types = App\StoreType::get();
        $store_kinds = App\StoreKind::get();
        $store_levels = App\StoreLevel::get();
        $store_properties = App\StoreProperty::get();

        return json_encode(array(
            'status' => true,
            'result' => array(
                'dealer' => $dealer,
                'addinfo' => $addinfo,
                'areas' => $areas,
                'provinces' => $provinces,
                'store_types' => $store_types,
                'store_kinds' => $store_kinds,
                'store_levels' => $store_levels,
                'store_properties' => $store_properties
            )
        ));
    }

    // Get the detail of dealer
    public function getDealerDetail($dealer_id, $require_member = '', Request $request)
    {
        $dealer = Dealer::find($dealer_id);

        $login_info = $request->session()->get('total_info');

        if ($dealer === null) {
            return json_encode(array("status" => false, "err_msg" => "no dealer data"));
        }

        if ($dealer->detail_id != null) {
            $dealer->detail = DealerDetail::find($dealer.detail_id);
        }

        $dealer->president();
        $dealer->can_edit = $dealer->can_edit($login_info);

        $dealer->getDealerStructureName(true);
        $dealer->getCorperation();

        $dealer->area_array = require(resource_path('china_area.php'));
        $dealer->city_list = array();

        if ($dealer->province != null && $dealer->city != null) {
            foreach ($dealer->area_array['province_city'] as $province_city) {
                if ($province_city['province_name'] == $dealer->province) {
                    $dealer->city_list = $province_city['city'];
                }
            }
        }

        if ($require_member == "require") {
            $dealer->getStaff();
        }

        $dealer->total_sale = Sale::getTotalSale($dealer_id);

        if ($dealer->total_sale == null) {
            $dealer->total_sale = 0;
        }

        $dealer->sale_month = Sale::getSaleMonth($dealer_id);

        if ($dealer->sale_month == null) {
            $dealer->sale_month = 0;
        }

        $dealer->unbalance_sale = Sale::getUnbalance($dealer_id);

        if ($dealer->unbalance_sale == null) {
            $dealer->unbalance_sale = 0;
        }

        $stock = Stock::getTotalStock($dealer_id);

        $dealer->stock = $stock->stock;

        if ($dealer->stock == null) {
            $dealer->stock = 0;
        }

        $dealer->stock_activated = $stock->stock_activated;

        if ($dealer->stock_activated == null) {
            $dealer->stock_activated = 0;
        }

        $dealer->stock_registered = $stock->stock_registered;

        if ($dealer->stock_registered == null) {
            $dealer->stock_registered = 0;
        }

        $dealer->unbalance_list = Sale::getUnbalanceList($dealer_id);

        if ($dealer->unbalance_list == null) {
            $dealer->unbalance_list = 0;
        }

        $up_dealer = Dealer::find($dealer->parent_id);

        if ($up_dealer) {
            $dealer->up_dealer = $up_dealer->name;
        } else {
            $dealer->up_dealer = '';
        }

        return json_encode(array('status' => true, 'result' => $dealer));
    }

    // Get the dealer list with their info by dealer_level, if not admin, list of down dealers
    public function getDealerListWithInfo($dealer_level, $dealer_name, $itemcount, $pagenum, Request $request)
    {
        $name = json_decode($dealer_name)->name;
        $priv = $request->session()->get('site_priv');

        $user_ary = User::getManagerNameListByDelaer('负责人');
        $stock_ary = Stock::getTotalStockByDealer();
        $sale_ary = Sale::getTotalSaleCountByDealer();

        if ($priv == 'admin') {
            // if admin, list by dealer_level, ignore dealer_id
            if ($name == '') {
                $dealer_list = Dealer::where('level', $dealer_level)->paginate($itemcount, ['*'], 'p', $pagenum);
            } else {
                $dealer_list = Dealer::where('level', $dealer_level)->where('name', $name)->paginate($itemcount, ['*'], 'p', $pagenum);
            }
            
            if ($dealer_level == '1') {
                //$unbalance_ary = Sale::getTotalUnbalancedByDealer();
				$purchase_ary = Sale::getTotalPurchaseByDealer();
				$wholesale_ary = Sale::getTotalWholesaleByDealer();
				$promotion_ary = Sale::getTotalPromotionByDealer();

                foreach ($dealer_list as $dealer) {
                    $dealer->manager_name = (isset($user_ary[''.$dealer->id])) ? $user_ary[''.$dealer->id] : '';
                    $dealer->total_stock = (isset($stock_ary[''.$dealer->id])) ? $stock_ary[''.$dealer->id] : 0;
                    $dealer->total_sale = (isset($sale_ary[''.$dealer->id])) ? $sale_ary[''.$dealer->id] : 0;
                    //$dealer->total_unbalance = (isset($unbalance_ary[''.$dealer->id])) ? $unbalance_ary[''.$dealer->id] : 0;
					if (isset($purchase_ary[''.$dealer->id]))
						$unbalance_purchase = $purchase_ary[''.$dealer->id];
					else 
						$unbalance_purchase = 0;
					
					if (isset($wholesale_ary[''.$dealer->id]))
						$unbalance_wholesale = $wholesale_ary[''.$dealer->id];
					else 
						$unbalance_wholesale = 0;
					
					if (isset($promotion_ary[''.$dealer->id]))
						$dealer->total_promotion = $promotion_ary[''.$dealer->id];
					else
						$dealer->total_promotion = 0;
					
					$dealer->total_unbalance = $unbalance_purchase - $unbalance_wholesale - $dealer->total_promotion;
                }
            } else {
                // ignore total unbalanced money
                foreach ($dealer_list as $dealer) {
                    $dealer->manager_name = (isset($user_ary[''.$dealer->id])) ? $user_ary[''.$dealer->id] : '';
                    $dealer->total_stock = (isset($stock_ary[''.$dealer->id])) ? $stock_ary[''.$dealer->id] : 0;
                    $dealer->total_sale = (isset($sale_ary[''.$dealer->id])) ? $sale_ary[''.$dealer->id] : 0;
                    $dealer->total_unbalance = 0;
                }
            }
            
            return json_encode($dealer_list);
        } else {
            $login_info = $request->session()->get('total_info');
            
            $dealer_id = $login_info['dealer_id'];

            if ($name == '') {
                $dealer_list = Dealer::where('parent_id', $dealer_id)->paginate($itemcount, ['*'], 'p', $pagenum);
            } else {
                $dealer_list = Dealer::where('parent_id', $dealer_id)->where('name', $name)->paginate($itemcount, ['*'], 'p', $pagenum);
            }

            //$unbalance_ary = Sale::getTotalUnbalancedByDealer();
			$purchase_ary = Sale::getTotalPurchaseByDealer();
			$wholesale_ary = Sale::getTotalWholesaleByDealer();
			$promotion_ary = Sale::getTotalPromotionByDealer();

            foreach ($dealer_list as $dealer) {
                $dealer->manager_name = (isset($user_ary[''.$dealer->id])) ? $user_ary[''.$dealer->id] : '';
                $dealer->total_stock = (isset($stock_ary[''.$dealer->id])) ? $stock_ary[''.$dealer->id] : 0;
                $dealer->total_sale = (isset($sale_ary[''.$dealer->id])) ? $sale_ary[''.$dealer->id] : 0;
                //$dealer->total_unbalance = (isset($unbalance_ary[''.$dealer->id])) ? $unbalance_ary[''.$dealer->id] : 0;
				if (isset($purchase_ary[''.$dealer->id]))
					$unbalance_purchase = $purchase_ary[''.$dealer->id];
				else 
					$unbalance_purchase = 0;
				
				if (isset($wholesale_ary[''.$dealer->id]))
					$unbalance_wholesale = $wholesale_ary[''.$dealer->id];
				else 
					$unbalance_wholesale = 0;
				
				if (isset($promotion_ary[''.$dealer->id]))
					$dealer->total_promotion = $promotion_ary[''.$dealer->id];
				else
					$dealer->total_promotion = 0;
				
				$dealer->total_unbalance = $unbalance_purchase - $unbalance_wholesale - $dealer->total_promotion;
            }

            return json_encode($dealer_list);
        }
    }

    public function getDealerInformationByID($dealer_id, $dealer_name, $itemcount, $pagenum, Request $request)
    {
        $name = ($dealer_name == 'undefined') ? '' : json_decode($dealer_name)->name;

        $user_ary = User::getManagerNameListByDelaer('负责人');
        $stock_ary = Stock::getTotalStockByDealer();
        $sale_ary = Sale::getTotalSaleCountByDealer();

        if ($name == '') {
            $dealer = Dealer::find($dealer_id);
        } else {
            $dealer = Dealer::where('name', $name)->first();
        }

        if ($dealer != null) {
            $users = User::where('dealer_id', $dealer->id)->get();
            $upper_dealer = ($dealer->parent_id != 0) ? Dealer::find($dealer->parent_id) : null;
            $lower_dealers = Dealer::where('parent_id', $dealer->id)->paginate($itemcount, ['*'], 'p', $pagenum);

            //$unbalance_ary = Sale::getTotalUnbalancedByDealer();
			$purchase_ary = Sale::getTotalPurchaseByDealer();
			$wholesale_ary = Sale::getTotalWholesaleByDealer();
			$promotion_ary = Sale::getTotalPromotionByDealer();
			//return var_dump($purchase_ary);

            foreach ($lower_dealers as $lower_dealer) {
                $lower_dealer->manager_name = (isset($user_ary[''.$lower_dealer->id])) ? $user_ary[''.$lower_dealer->id] : '';
                $lower_dealer->total_stock = (isset($stock_ary[''.$lower_dealer->id])) ? $stock_ary[''.$lower_dealer->id] : 0;
                $lower_dealer->total_sale = (isset($sale_ary[''.$lower_dealer->id])) ? $sale_ary[''.$lower_dealer->id] : 0;
                //$lower_dealer->total_unbalance = (isset($unbalance_ary[''.$lower_dealer->id])) ? $unbalance_ary[''.$lower_dealer->id] : 0;
				//$unbalance_data = Sale::getTotalUnbalancedByDealerID($lower_dealer->id);
				if (isset($purchase_ary[''.$lower_dealer->id]))
					$unbalance_purchase = $purchase_ary[''.$lower_dealer->id];
				else 
					$unbalance_purchase = 0;
				
				if (isset($wholesale_ary[''.$lower_dealer->id]))
					$unbalance_wholesale = $wholesale_ary[''.$lower_dealer->id];
				else 
					$unbalance_wholesale = 0;
				
				if (isset($promotion_ary[''.$lower_dealer->id]))
					$lower_dealer->total_promotion = $promotion_ary[''.$lower_dealer->id];
				else
					$lower_dealer->total_promotion = 0;
				
				$lower_dealer->total_unbalance = $unbalance_purchase - $unbalance_wholesale - $lower_dealer->total_promotion;
            }

            return json_encode(array(
                'status' => true,
                'result' =>array(
                    'dealer' => $dealer,
                    'users' => $users,
                    'upper_dealer' => $upper_dealer,
                    'lower_dealers' => $lower_dealers)
                )
            );
        } else {
            return json_encode(array('status' => true, 'error_message' => 'There is no such as dealer you get on database.'));
        }
    }

    // Get the detail of staff
    public function getStaffDetail($user_id)
    {
        
        $user = App\User::find($user_id);
        if ($user === null) {
            return json_encode(array("status" => false, "err_msg" => "no dealer data"));
        }
        
        $user->dealer;
        $user->role;
        
        $user->dealer->getDealerStructureName(true);
        $user->dealer->getCorperation();
        
        $user->can_edit = $user->can_edit2();

        return json_encode($user);
    }

    // Get user list with info from dealer_id
    public function getUserList($user_name, $itemcount, $pagenum, Request $request)
    {
        $name = json_decode($user_name)->name;
        $login_info = $request->session()->get('total_info');
        
        $dealer_id = $login_info['dealer_id'];

        if ($name == '') {
            $user_list = User::where('dealer_id', $dealer_id)->paginate($itemcount, ['*'], 'p', $pagenum);
        } else {
            $user_list = User::where('dealer_id', $dealer_id)->where('name', $name)->paginate($itemcount, ['*'], 'p', $pagenum);
        }

        $dealer_name = Dealer::find($dealer_id)->name;
        $sale_list = Sale::getSaleListByUser();
        $red_packet_sales = Option::where('key', 'red_packet_sales')->first()->value;
        $red_packet_price = Option::where('key', 'red_packet_price')->first()->value;

        foreach ($user_list as $user) {
            $user->role;
            /*if ($user->role) {
				$user->role = $user->role->name;
			}
			else 
				$user->role = '';*/

            $user->dealer_name = $dealer_name;
            
            if (isset($sale_list[''.$user->id])) {
                $user->sale_month = $sale_list[''.$user->id];
            } else {
                $user->sale_month = 0;
            }

            $user->red_packet_sales = $red_packet_sales;
            $user->red_packet_price = $red_packet_price;
        }

        return json_encode($user_list);
    }
    // Set the balance state of dealer
    public function setBalanceState($dealer_id, Request $request)
    {
        $login_info = $request->session()->get('total_info');
        
        $cur_dealer_id = $login_info['dealer_id'];
        $dealer = Dealer::find($dealer_id);

        /*$ret_ary = array();

        if ($cur_dealer_id == $dealer->parent_id) {
            $list = Sale::where('src_dealer_id', $dealer_id)->where('balance_state', 0)->get();

            foreach ($list as $item) {
                $item->balance_state = 1;
                $item->save();
            }

            $ret_ary['success'] = true;
        } else {
            $ret_ary['success'] = false;
        }*/
		$date = date('Y-m-d H:i:s');
		$dealer->last_settle_time = $date;
		$dealer->save();
		
		$ret_ary['success'] = true;

        return json_encode($ret_ary);
    }
    
    // pc user dealer page [admin] dealer data import
    public function import_dealer_items(Request $request, $dealer_id)
    {
$debug = false;

        $return_arr = array("status" => true);
        
        $dealer_file = $request->file("dealer_file");       // "uploads/dealer_data/import/"

        if (null !== $dealer_file) {
            $destinationPath = $this->dealer_upload_path;
            $filename = date("YmdHis_").rand(10000, 99999).".".$dealer_file->extension();

            if ($dealer_file->move($destinationPath, $filename)) {
                $file_pull_path = $destinationPath.$filename;

                $sheets = Excel::load($file_pull_path, function ($reader) {
                    // load all sheet and record
                    $results = $reader->all();
                })->get();

                $sheetNo = 0;

                $sheetResult = array();
                $importErrors = array();
                
                foreach ($sheets as $sheet) {
                    $sheetNo++;
                    $title = $sheet->getTitle();

                    if ($title == "经销商信息") {                        // "经销商信息"
                        foreach ($sheet as $row) {
                            if ($row[DEALER_NAME] == "") {
                                break;
                            }

                            if ($row[DEALER_PARENT_CODE] == "") {
                                $parentId = App\Dealer::getDingdingAccountByID($dealer_id);
                                $level = App\Dealer::getDealerLevelByCode($dealer_id);
                            } else {
                                $parentId = App\Dealer::getDingdingAccountByCode($row[DEALER_PARENT_CODE]);
                                $level = App\Dealer::getDealerLevelByCode($row[DEALER_PARENT_CODE]);
                            }
                            
if (!$debug)
                            $result = json_decode(DingTalkContactManager::createDepartment($row[DEALER_NAME], $parentId), true);
else {
    $result["errcode"] = 0;
    $result["id"] = "4223456";
}
                                                        
                            if ($result["errcode"] != 0) {
                                $importErrors[] = '['.$title.':'.$row[DEALER_BOSS_NAME]."] ".$result["errmsg"];
                                continue;
                            }

                            // Create new Dealer
                            {
                                $dealer = new App\Dealer();
                                $dealer->code = $row[DEALER_CODE];
                                $dealer->name = $row[DEALER_NAME];
                                $dealer->customer_type_id = 0;
                                $dealer->address = $row[DEALER_AREA] . " " . $row[DEALER_PROVINCE] . " " . $row[DEALER_CITY];
                                $dealer->area = $row[DEALER_AREA];
                                $dealer->province = $row[DEALER_PROVINCE];
                                $dealer->city = $row[DEALER_CITY];
                                $dealer->link = '';
                                $dealer->dd_account = $result['id'];
                                $dealer->level = $level + 1;
                                $dealer->parent_id = App\Dealer::getDealerIdByCode($row[DEALER_PARENT_CODE]);
                                $dealer->save();
                            }

                            $departmentId = $result["id"];

if (!$debug)
                            $result = json_decode(DingTalkContactManager::createUser($row[DEALER_BOSS_NAME], "[$departmentId]", "经理", $row[DEALER_BOSS_LINK], $dealer->address, $row[DEALER_BOSS_EMAIL]), true);
else {
    $result["errcode"] = 0;
    $result["userid"] = "123456789-123456789";
}

                            if ($result["errcode"] != 0) {
                                $importErrors[] = '['.$title.':'.$row[DEALER_BOSS_NAME]."] ".$result["errmsg"];
                                continue;
                            }

                            // Create new User
                            {
                                $user = new App\User();
                                $user->name = $row[DEALER_BOSS_NAME];
                                $user->link = $row[DEALER_BOSS_LINK];
                                $user->email = $row[DEALER_BOSS_EMAIL];
                                $user->dd_account = $result["userid"];
                                $user->dealer_id = $dealer->id;
                                $user->role_id = USER_ROLE_BOSS;             // 代理商
                                $user->save();
                            }
                        }
                    } elseif ($title == "店面信息") {
                        foreach ($sheet as $row) {
                            if ($row[STORE_NAME] == "") {
                                break;
                            }

                            if ($row[STORE_IN_PARENT_CODE] == "") {
                                $parentId = App\Dealer::getDingdingAccountByID($dealer_id);
                                $level = App\Dealer::getDealerLevelByCode($dealer_id);
                            } else {
                                $parentId = App\Dealer::getDingdingAccountByCode($row[STORE_IN_PARENT_CODE]);
                                $level = App\Dealer::getDealerLevelByCode($row[STORE_IN_PARENT_CODE]);
                            }

if (!$debug)
                            $result = json_decode( DingTalkContactManager::createDepartment($row[STORE_NAME], $parentId), true);
else {
    $result["errcode"] = 0;
    $result["id"] = "4223456";
}
                            if ($result["errcode"] != 0) {
                                $importErrors[] = '['.$title.':'.$row[STORE_NAME]."] ".$result["errmsg"];
                                continue;
                            }
                             
                            $departmentId = $result["id"];

                            // Create a new dealer addional information
                            {
                                $dealerDetail = new App\DealerDetail();
                                $dealerDetail->dealer_kind = $row[STORE_DEALER_KIND];
                                $dealerDetail->upper_dealer_name = $row[STORE_UPPER_DEALER_NAME];
                                $dealerDetail->upper_dealer_code = $row[STORE_UPPER_DEALER_CODE];
                                $dealerDetail->country = $row[STORE_COUNTRY];
                                $dealerDetail->city_level = $row[STORE_CITY_LEVEL];
                                $dealerDetail->zone = $row[STORE_ZONE];
                                $dealerDetail->town = $row[STORE_TOWN];
                                $dealerDetail->area_boss_name = $row[STORE_AREA_BOSS_NAME];
                                $dealerDetail->shop_dealer_name = $row[STORE_SHOP_DEALER_NAME];
                                $dealerDetail->city_boss_name = $row[STORE_CITY_BOSS_NAME];
                                $dealerDetail->city_boss_code = $row[STORE_CITY_BOSS_CODE];
                                $dealerDetail->city_boss_address = $row[STORE_CITY_BOSS_ADDRESS];
                                $dealerDetail->business_kind = $row[STORE_BUSINESS_KIND];
                                $dealerDetail->shop_kind = $row[STORE_SHOP_KIND];
                                $dealerDetail->shop_short_kind = $row[STORE_SHOP_SHORT_KIND];
                                $dealerDetail->shop_property = $row[STORE_SHOP_PROPERTY];
                                $dealerDetail->shop_direction = $row[STORE_SHOP_DIRECTION];
                                $dealerDetail->total_area_of_shop = $row[STORE_TOTAL_AREA_OF_SHOP];
                                $dealerDetail->shop_monthly_sales = $row[STORE_SHOP_MONTHLY_SALES];
                                $dealerDetail->shop_communication_address = $row[STORE_COMMUNICATION_ADDRESS];
                                $dealerDetail->shop_postal_code = $row[STORE_SHOP_POSTAL_CODE];
                                $dealerDetail->shop_boss_phone_number = $row[STORE_SHOP_BOSS_PHONE_NUMBER];
                                $dealerDetail->receipt_address = $row[STORE_RECEIPT_ADDRES];
                                $dealerDetail->receipt_name = $row[STORE_RECEIPT_NAME];
                                $dealerDetail->receipt_phone_number = $row[STORE_RECEIPT_PHONE_NUMBER];
                                $dealerDetail->receipt_mobile_phone_number = $row[STORE_RECEIPT_MOBILE_PHONE_NUMBER];
                                $dealerDetail->cooperation_status = $row[STORE_COOPORATION_STATUS];
                                $dealerDetail->application_time = $row[STORE_APPLICATION_TIME];
                                $dealerDetail->apply_for_approval_time = $row[STORE_APPLY_APPROVAL_TIME];
                                $dealerDetail->modify_approval_time = $row[STORE_MODIFY_APPROVAL_TIME];
                                $dealerDetail->cancel_cooperation_approval_time = $row[STORE_CANCEL_COOPERATION_APPROVAL_TIME];
                                $dealerDetail->comment = $row[STORE_COMMENT];
                                $dealerDetail->cooperation_kind = $row[STORE_COOPERATION_KIND];
                                $dealerDetail->it_mall_whole_name = $row[STORE_IT_MALL_WHOLE_NAME];
                                $dealerDetail->it_mall_short_name = $row[STORE_IT_MALL_SHORT_NAME];
                                $dealerDetail->location_kind = $row[STORE_LOCATION_KIND];
                                $dealerDetail->area_of_dell = $row[STORE_AREA_OF_DELL];
                                $dealerDetail->after_sales_service_point = $row[STORE_AFTER_SALES_SERVICE_POINT];
                                $dealerDetail->last_renovated_time = $row[STORE_LAST_RENOVATED_TIME];
                                $dealerDetail->dell_pay = $row[STORE_DELL_PAY];
                                $dealerDetail->use_decoration_fund = $row[STORE_USE_DECORATION_FUND];
                                $dealerDetail->counter_number = $row[STORE_COUNTER_NUMBER];
                                $dealerDetail->snp_cabinet_number = $row[STORE_SNP_CABINET_NUMBER];
                                $dealerDetail->commitment_sales = $row[STORE_COMMITMENT_SALES];
                                $dealerDetail->shop_level = $row[STORE_SHOP_LEVEL];
                                $dealerDetail->nobody_shop = $row[STORE_NOBODY_SHOP];
                                $dealerDetail->platform_shop_rating = $row[STORE_PLATFORM_SHOP_RATING];
                                $dealerDetail->registration_hours = $row[STORE_REGISTRATION_HOURS];
                                $dealerDetail->registration_approval_hours = $row[STORE_REGISTRATION_APPROVAL_HOURS];
                                $dealerDetail->line_under_report = $row[STORE_LINE_UNDER_REPORT];
                                $dealerDetail->township_level = $row[STORE_TOWNSHIP_LEVEL];
                                $dealerDetail->shop_image_url = $row[STORE_SHOP_IMAGE_URL];
                                $dealerDetail->process_status = $row[STORE_PROCESS_STATUS];
                                $dealerDetail->retail_manager_user_name = $row[STORE_RETAIL_MANAGER_USER_NAME];
                                $dealerDetail->save();
                            }

                            // Create New Store_deatiled_information
                            {
                                $dealer = new App\Dealer();
                                $dealer->code = $row[STORE_CODE];
                                $dealer->name = $row[STORE_NAME];
                                $dealer->customer_type_id = 0;
                                $dealer->address = $row[STORE_AREA] . " " . $row[STORE_PROVINCE] . " " . $row[STORE_CITY];
                                $dealer->area = $row[STORE_AREA];
                                $dealer->province = $row[STORE_PROVINCE];
                                $dealer->city = $row[STORE_CITY];
                                $dealer->link = $row[STORE_LINK];
                                $dealer->dd_account = $result["id"];
                                $dealer->level = $level+1;
                                $dealer->parent_id = App\Dealer::getDealerIdByCode($row[STORE_IN_PARENT_CODE]);
                                $dealer->detail_id = $dealerDetail->id;
                                $dealer->save();
                            }

if (!$debug)
                            $result = json_decode( DingTalkContactManager::createUser($row[STORE_STORE_MANAGER_NAME], "[$departmentId]", "店长", $row[STORE_STORE_MANAGER_LINK], $dealer->address, $row[STORE_STORE_MANAGER_EMAIL]), true);
else {
    $result["errcode"] = 0;
    $result["userid"] = "123456789-123456789";
}
                            
                            if ($result["errcode"] != 0) {
                                $importErrors[] = '['.$title.':'.$row[STORE_NAME]."] ".$result["errmsg"];
                                continue;
                            }
                            
                            // Create New User 
                            {
                                $user = new App\User();
                                $user->name = $row[STORE_STORE_MANAGER_NAME];
                                $user->link = $row[STORE_STORE_MANAGER_LINK];
                                $user->email = $row[STORE_STORE_MANAGER_EMAIL];
                                $user->dd_account = $result["userid"];
                                $user->dealer_id = $dealer->id;
                                $user->role_id = USER_ROLE_STORE_MANAGER;                     // 店长
                                $user->save();
                            }
                        }
                    } elseif ($title == "店员信息") {
                        foreach ($sheet as $row) {
                            if ($row[USER_NAME] == "") {
                                break;
                            }

                            if ($row[USER_IN_DEALER_CODE] == "") {
                                $dealerId = App\Dealer::getDealerIdByCode($dealer_id);
                                $departmentId = App\Dealer::getDingdingAccountByCode($dealer_id);
                            } else {
                                $dealerId = App\Dealer::getDealerIdByCode($row[USER_IN_DEALER_CODE]);
                                $departmentId = App\Dealer::getDingdingAccountByCode($row[USER_IN_DEALER_CODE]);
                            }

if (!$debug)
                            $result = json_decode( DingTalkContactManager::createUser($row[USER_NAME], "[$departmentId]", "店员", $row[USER_LINK], $dealer->address, $row[USER_EMAIL]), true);
else {
    $result["errcode"] = 0;
    $result["userid"] = "123456789-123456789";
}
                            
                            if ($result["errcode"] != 0) {
                                $importErrors[] = '['.$title.':'.$row[STORE_NAME]."] ".$result["errmsg"];
                                continue;
                            }
                            
                            // Create a new seller
                            {
                                $user = new App\User();
                                $user->name = $row[USER_NAME];
                                $user->link = $row[USER_LINK];
                                $user->email = "".$row[USER_EMAIL];
                                $user->dd_account = $result["userid"];
                                $user->dealer_id = App\Dealer::getDealerIdByCode($row[USER_IN_DEALER_CODE]);
                                $user->role_id = USER_ROLE_SELLER;                         // 店员
                                $user->save();
                            }
                        }
                    }
                }

                if (sizeof($importErrors) == 0) {
                    $return_arr = array(
                        "status" => true,
                        "msg" => __('lang.import_dealer_successful')
                    );
                } else {
                    $return_arr = array(
                        "status" => false,
                        "err_msg" => __('lang.import_dealer_with_some_error'),
                        "import_errors" => $importErrors
                    );
                }
            } else {
                $return_arr = array(
                    "status" => false,
                    "err_msg" => __('lang.import_dealer_can_not_copy_import_file'),
                    "import_errors" => array()
                );
            }
        } else {
            $return_arr = array(
                "status" => false,
                "err_msg" => __('lang.import_dealer_none_import_file'),
                "import_errors" => array()
            );
        }
        
        echo json_encode($return_arr);
    }

    public function modifyOrCreateDealer($method, $subject, $dealer_id, Request $request)
    {
$debug = false;

        $data = json_decode(file_get_contents("php://input"));
        $dealer_info = $data->dealer_info;

        if ($subject == 'store') {
            $add_info = $data->add_info;
        }

        if ($method == 'new') {
            $parent_dealer = App\Dealer::find($dealer_id);

if (!$debug)
            $result = json_decode(DingTalkContactManager::createDepartment($dealer_info->name, $parent_dealer->dd_account), true);
else {
            $result["errcode"] = 0;
            $result["id"] = "4223456";
}

            if ($result["errcode"] != 0) {
                return json_encode(array(
                        'status' => false,
                        'err_msg' => $result["errmsg"])
                );
            }

            $departmentId = $result["id"];
        }

        $dealer = ($method == 'new') ? new App\Dealer() : App\Dealer::findOrNew($dealer_id);

        if ($subject == 'store') {
            $dealerDetail = ($method == 'new') ? new App\DealerDetail() : App\DealerDetail::findOrNew($dealer->detail_id);

            $dealerDetail->dealer_kind = $add_info->dealer_kind;
            $dealerDetail->upper_dealer_name = $add_info->upper_dealer_name;
            $dealerDetail->upper_dealer_code = $add_info->upper_dealer_code;
            $dealerDetail->country = $add_info->country;
            $dealerDetail->city_level = $add_info->city_level;
            $dealerDetail->zone = $add_info->zone;
            $dealerDetail->town = $add_info->town;
            $dealerDetail->area_boss_name = $add_info->area_boss_name;
            $dealerDetail->shop_dealer_name = $add_info->shop_dealer_name;
            $dealerDetail->city_boss_name = $add_info->city_boss_name;
            $dealerDetail->city_boss_code = $add_info->city_boss_code;
            $dealerDetail->city_boss_address = $add_info->city_boss_address;
            $dealerDetail->business_kind = $add_info->business_kind;
            $dealerDetail->shop_kind = $add_info->shop_kind;
            $dealerDetail->shop_short_kind = $add_info->shop_short_kind;
            $dealerDetail->shop_property = $add_info->shop_property;
            $dealerDetail->shop_direction = $add_info->shop_direction;
            $dealerDetail->total_area_of_shop = $add_info->total_area_of_shop;
            $dealerDetail->shop_monthly_sales = $add_info->shop_monthly_sales;
            $dealerDetail->shop_communication_address = $add_info->shop_communication_address;
            $dealerDetail->shop_postal_code = $add_info->shop_postal_code;
            $dealerDetail->shop_boss_phone_number = $add_info->shop_boss_phone_number;
            $dealerDetail->receipt_address = $add_info->receipt_address;
            $dealerDetail->receipt_name = $add_info->receipt_name;
            $dealerDetail->receipt_phone_number = $add_info->receipt_phone_number;
            $dealerDetail->receipt_mobile_phone_number = $add_info->receipt_mobile_phone_number;
            $dealerDetail->cooperation_status = $add_info->cooperation_status;
            $dealerDetail->application_time = $add_info->application_time;
            $dealerDetail->apply_for_approval_time = $add_info->apply_for_approval_time;
            $dealerDetail->modify_approval_time = $add_info->modify_approval_time;
            $dealerDetail->cancel_cooperation_approval_time = $add_info->cancel_cooperation_approval_time;
            $dealerDetail->comment = $add_info->comment;
            $dealerDetail->cooperation_kind = $add_info->cooperation_kind;
            $dealerDetail->it_mall_whole_name = $add_info->it_mall_whole_name;
            $dealerDetail->it_mall_short_name = $add_info->it_mall_short_name;
            $dealerDetail->location_kind = $add_info->location_kind;
            $dealerDetail->area_of_dell = $add_info->area_of_dell;
            $dealerDetail->after_sales_service_point = $add_info->after_sales_service_point;
            $dealerDetail->last_renovated_time = $add_info->last_renovated_time;
            $dealerDetail->dell_pay = $add_info->dell_pay;
            $dealerDetail->use_decoration_fund = $add_info->use_decoration_fund;
            $dealerDetail->counter_number = $add_info->counter_number;
            $dealerDetail->snp_cabinet_number = $add_info->snp_cabinet_number;
            $dealerDetail->commitment_sales = $add_info->commitment_sales;
            $dealerDetail->shop_level = $add_info->shop_level;
            $dealerDetail->nobody_shop = $add_info->nobody_shop;
            $dealerDetail->platform_shop_rating = $add_info->platform_shop_rating;
            $dealerDetail->registration_hours = $add_info->registration_hours;
            $dealerDetail->registration_approval_hours = $add_info->registration_approval_hours;
            $dealerDetail->line_under_report = $add_info->line_under_report;
            $dealerDetail->township_level = $add_info->township_level;
            $dealerDetail->shop_image_url = $add_info->shop_image_url;
            $dealerDetail->process_status = $add_info->process_status;
            $dealerDetail->retail_manager_user_name = $add_info->retail_manager_user_name;
            $dealerDetail->save();

            $dealer->detail_id = $dealerDetail->id;
        }

        ////////////////////////////////////////////////////////////////////
        ///
        $dealer->code = $dealer_info->code;
        $dealer->name = $dealer_info->name;
        $dealer->customer_type_id = 0;
        $dealer->address = $dealer_info->area . "-" . $dealer_info->province . "-" . $dealer_info->city;
        $dealer->area = $dealer_info->area;
        $dealer->province = $dealer_info->province;
        $dealer->city = $dealer_info->city;
        $dealer->link = $dealer_info->link;

        if ($method == 'new') {
            $dealer->level = $parent_dealer->level + 1;
            $dealer->parent_id = $parent_dealer->id;
            $dealer->dd_account = $departmentId;
        }

        if ($dealer->level == 1) {
            $dealer->corporation = $dealer_info->corporation;
        }

        $dealer->save();

        if ($method == 'new') {
if (!$debug)
            $result = json_decode(DingTalkContactManager::createUser($dealer_info->persident->name, "[$departmentId]", "经理", $dealer_info->persident->link, $dealer->address, $dealer_info->persident->email), true);
else {
            $result["errcode"] = 0;
            $result["userid"] = "123456789-123456789";
}

            if ($result["errcode"] != 0) {
                DingTalkContactManager::deleteDepartment($departmentId);

                return json_encode(array(
                        'status' => false,
                        'err_msg' => $result["errmsg"])
                );
            }

            $user = new App\User();

            $user->name = $dealer_info->president->name;
            $user->link = $dealer_info->president->link;
            $user->email = $dealer_info->president->email;

            if ($method == 'new') {
                $user->dd_account = $result["userid"];
            }

            $user->dealer_id = $dealer->id;
            $user->role_id = ($subject == 'dealer') ? USER_ROLE_BOSS : USER_ROLE_STORE_MANAGER; 
            $user->save();
        }

        return json_encode(array(
            'status' => true,
        ));
    }

    public function newUser(Request $request)
    {
        return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'user_staff_new');
    }

    public function createNewUser($dealer_id, Request $request)
    {
        $debug_mode = 'no';

        $user_info = json_decode(file_get_contents("php://input"));
        $departmentId = App\Dealer::getDingdingAccountByID($dealer_id);
        $role = App\Role::find($user_info->role_id);

        if ($debug_mode == 'no') {
                $result = json_decode(DingTalkContactManager::createUser($user_info->name, "[$departmentId]", $role->name, $user_info->link, '', $user_info->email), true);
        } else {
                $result = array("errcode" => 0, "userid" =>"2143354364576580");
        }

        if ($result["errcode"] == 0) {
            $user = new App\User();

            $user->name = $user_info->name;
            $user->link = $user_info->link;
            $user->email = $user_info->email;
            $user->role_id = $user_info->role_id;
            $user->dd_account = $result["userid"];

            $user->dealer_id = $dealer_id;
            $user->save();
        } else {
            return json_encode(array(
            'status' => false,
            'err_msg' => $result["errmsg"])
            );
        }

        return json_encode(array(
            'status' => true
        ));
    }

    public function userGetRoles()
    {
        $roles = App\Role::get();

        return json_encode(array(
            'status' => true,
            'roles' => $roles
        ));
    }
	
	public function get_dealer_architecture($dealer_id, Request $request){
		
		$login_info = $request->session()->get('total_info');
		
		
		$upper_list = App\Dealer::getUpDealerArray($dealer_id);
		
		$dealer = App\Dealer::find($dealer_id);
		if($dealer !== null) $upper_list[] = $dealer;
		
		foreach($upper_list as $item){
			if($item['level'] >= $login_info['level']){
				$item->can_list_view = true;
			}else{
				$item->can_list_view = false;
			}
		}
		
		$sub_list = App\Dealer::getSubDealer($dealer_id);
		foreach($sub_list as $item){
			$item->is_salespoint();
		}
		
		$return_arr = array(
				"status" => true, 
				"data" => array(
					"upper_list" => $upper_list,
					"sub_list" => $sub_list
				)
			);
			
		echo json_encode($return_arr);
	}
}
