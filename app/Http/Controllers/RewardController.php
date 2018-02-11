<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

use App\User;
use App\Dealer;
use App\RedPacket;
use App\RedPacketSetting;
use App\Option;
use App\Sale;

class RewardController extends Controller
{
    //
	public function view_user(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_user');
	}
	public function view_office(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_office');
	}	
	// pc reward view
	public function not(){		
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_not');
	}
	public function already(){
		return view(mProvider::$view_prefix.mProvider::$view_prefix_priv.'reward_already');

	}
	// Get redpacket list indexed by user_id
	// Return value: dealer_name, user_name, total_sale, sale_month, redpacket_price
	public function get_redpacket_list($search_json, $itemcount, $pagenum, Request $request) {
		
		$return_arr = array();
		
		$login_info = $request->session()->get('total_info');
		$dealer_id = $login_info['dealer_id'];
		$priv = $login_info['authority'];
		
		$search_obj = json_decode($search_json, true);
		
		$query = App\RedPacket::query();
		
		if($search_obj['type'] == '0'){
			if($priv != 'seller'){
				$query->where([
						['is_arrival', '=', '1'],
						['is_approval', '=', '0']
					]);
			}else{
				$query->where([
						['is_approval', '=', '0'],
						['user_id', '=', $login_info['user_id']]
					]);
			}
		}else if($search_obj['type'] == '1'){
			$query->where([
					['is_approval', '=', '1']
				]);
		}
		
		if($priv != 'admin'){
			$query->where('dealer_id', '=', $dealer_id);
		}
		
		if($search_obj['start_date'] != '' || $search_obj['end_date'] != ''){
			$query_setting = App\RedPacketSetting::query();
			if($search_obj['start_date'] != '')
				$query_setting->where('redpacket_start_date', '>=', $search_obj['start_date']);
			if($search_obj['end_date'] != '')
				$query_setting->where('redpacket_end_date', '<=', $search_obj['end_date']);
			$setting_list = $query_setting->get()->toArray();
			
			$ids = array_column($setting_list, "id");
			
			$query->whereIn('rule_id', $ids);
		}
		
		$query->orderByDesc('is_proposal');
		$query->orderByDesc('id');
		$query->orderByDesc('sales_price');
		
		$items = $query->paginate($itemcount, ['*'], 'p', $pagenum);
		
		foreach($items as $item){
			$item->user;
			$item->dealer;
			$item->redPacketSetting;
		}
		
		$return_arr['status'] = true;
		$return_arr['list'] = $items;
		
		echo json_encode($return_arr);
	}
	
	// Set redpacket status to 1
	public function set_redpacket_status($redpacket_id, Request $request) {
		// Check if admin
		$priv = $request->session()->get('site_priv');
		$ret_ary = array();
		if ($priv == 'admin') {
			
			$redpacket = RedPacket::find($redpacket_id);
			$redpacket->is_approval = 1;
			$redpacket->approval_at = date("Y-m-d H:i:s");

			$redpacket->save();
			$ret_ary['success'] = true;
			
			$redpacket->redPacketSetting;
			
			$messageadddata = array(
						"type" => "1",
						"tag_dealer_id" => $redpacket->dealer_id,
						"tag_user_id" => $redpacket->user_id,
						"message" => "已发送“".$redpacket->redPacketSetting->redpacket_name."”奖励奖".floor($redpacket->redPacketSetting->	redpacket_rule)."元给你。",
						"url" => "#!/reward/office/list",
						"html_message" => "已发送“".$redpacket->redPacketSetting->redpacket_name."”奖励奖".floor($redpacket->redPacketSetting->	redpacket_rule)."元给你。",
						"table_name" => "redpacket",
						"table_id" => $redpacket->id,
					);	
			App\Message::save_message($messageadddata);
		}
		else
			$ret_ary['success'] = false;

		return json_encode($ret_ary);
	}
	
	// Set redpacket is_proposal to 1
	public function set_redpacket_require($redpacket_id, Request $request) {
		
		
		// Check if admin
		$redpacket = RedPacket::find($redpacket_id);
		$ret_ary = array();
		
		if ($redpacket !== null) {
			
			$redpacket->is_proposal = 1;
			
			$redpacket->save();
			$ret_ary['success'] = true;
			
			$redpacket->redPacketSetting;
			$userinfo = $request->session()->get('total_info');			
			$dealer = Dealer::find($userinfo['dealer_id']);
			$user = User::find($userinfo['user_id']);
			
			$messageadddata = array(
						"type" => "1",
						"tag_dealer_id" => 1,
						"tag_user_id" => null,
						"message" => $user->name."（".$dealer->name."）需要发送奖励“".$redpacket->redPacketSetting->redpacket_name."”".floor($redpacket->redPacketSetting->	redpacket_rule)."元",
						"url" => "#!/reward/office/list",
						"html_message" => $user->name."（".$dealer->name."）需要发送奖励“".$redpacket->redPacketSetting->redpacket_name."”".floor($redpacket->redPacketSetting->	redpacket_rule)."元",
						"table_name" => "redpacket",
						"table_id" => $redpacket->id,
					);	
			App\Message::save_message($messageadddata);
		}
		else
			$ret_ary['success'] = false;

		return json_encode($ret_ary);
	}
	
	// Get redpacket option if monthly or not
	public function get_redpacket_option() {
		$redpacket_monthly = Option::where('key', 'red_packet_monthly')->first()->value;
		$ret_ary = array();
		$ret_ary['monthly'] = $redpacket_monthly;

		return json_encode($ret_ary);
	}
	// Get redpacket list from user_id
	// Return value: total_sale, sale_month, redpacket_rule, redpacket_price, start_date, end_date
	public function get_user_redpacket($itemcount, $pagenum, Request $request) {
		$login_info = $request->session()->get('total_info');
		$user_id = $login_info['user_id'];

		// For only test
		// $user_id = 2;

		$redpacket_monthly = Option::where('key', 'red_packet_monthly')->first()->value;
		$redpacket_rule = Option::where('key', 'red_packet_sales')->first()->value;
		$redpacket_price = Option::where('key', 'red_packet_price')->first()->value;

		if ($redpacket_monthly) {
			$start_date = date('Y-m-d', strtotime('first day of this month'));
        	$end_date = date('Y-m-d', strtotime('last day of this month'));
		}
		else {
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d');
		}
		$user_sale = Sale::getTotalMonthSale($user_id, $redpacket_monthly, $start_date, $end_date);
		if ($user_sale) {
			$user_sale->redpacket_rule = $redpacket_rule;
			$user_sale->redpacket_price = $redpacket_price;
		}
		else {
			$user_sale = array();
			$user_sale['redpacket_rule'] = $redpacket_rule;
			$user_sale['redpacket_price'] = $redpacket_price;
			$user_sale['sale_month'] = 0;
		}

		$redpacket_ary = RedPacket::where('user_id', $user_id)
			->where('status', 1)
			->paginate($itemcount, ['*'], 'p', $pagenum);

		$ret_ary = array();

		$ret_ary['available'] = $user_sale;
		$ret_ary['list'] = $redpacket_ary;

		return json_encode($ret_ary);
	}

    /**
     * @param $type :
     *      '0' => all, '1' => unarrived, '2' => proposal, '3' =>unproposal, '4' => approval, '5' => unapproval
     * @return string
     */
    public static function getRedPacketByAdmin($type) {
        $results = RedPacket::getRedPacketByAdmin($type);
        return json_encode(array('status' => true, 'data' => $results));
    }

    public static function getReadPacketByUser($id) {
        $results = RedPacket::getRedPacketByUser($id);
        return json_encode(array('status' => true, 'data' => $results));
    }

    /**
     * @param int $user_id
     * @param int $rule
     * @createdBy   Sacred Zeus
     */
    static function updateRewardByUserAndRule($user_id, $rule)
    {
        $result = Sale::getTotalSalesForReward($user_id, $rule->product_id, $rule->redpacket_start_time, $rule->redpacket_end_time);
        $red_packet = RedPacket::getRecordByUserAndRule($user_id, $rule->rule_id);

        if ((($rule->redpacket_type == 1) && ($result['total_sale_price'] >= $rule->redpacket_rule)) ||
            (($rule->redpacket_type == 0) && ($result['total_sale_cards'] >= $rule->redpacket_rule)))
        {
            $red_packet->user_id = $user_id;
            $red_packet->dealer_id = $result['$dealer_id'];
            $red_packet->rule_id = $rule->rule_id;
            $red_packet->price = $result['total_sale_price'];
            $red_packet->count = $result['total_sale_cards'];
            $red_packet->is_arrival = 1;
            $red_packet->save();
        } else {
            $red_packet->delete();
        }
    }

	public static function updateRewardByUser($user_id) {
        $userInfo = User::getUserInfoByID($user_id);
        $dealer_id = $userInfo->dealer_id;

        $applicable_rules = RedPacketSetting::getRuleByDealerOnToday($dealer_id);

        foreach ($applicable_rules as $rule)
           updateRewardByUserAndRule($user_id, $rule);
    }

    public static function updateRewardByNewRule($rule_id) {
        $rule = RedPacketSetting::getRuleByID($rule_id);

        if ($rule->dealer_id == null) {
            $users = User::getAllSeller();
        } else {
            $users = User::getSellersByDealer($rule->dealer_id);
        }

        $results = Sale::getTotalSalesPerUserForReward($users, $rule->product_id, $rule->redpacket_start_time, $rule->redpacket_end_time);

        foreach ($results as $result) {
            $red_packet = RedPacket::getRecordByUserAndRule($result->user_id, $rule->rule_id);

            if ((($rule->redpacket_type == 1) && ($result['total_sale_price'] >= $rule->redpacket_rule)) ||
                (($rule->redpacket_type == 0) && ($result['total_sale_cards'] >= $rule->redpacket_rule)))
            {
                $red_packet->user_id = $result['user_id'];
                $red_packet->dealer_id = $result['dealer_id'];
                $red_packet->rule_id = $rule->rule_id;
                $red_packet->price = $result['total_sale_price'];
                $red_packet->count = $result['total_sale_cards'];
                $red_packet->is_arrival = 1;
                $red_packet->save();
            } else {
                $red_packet->delete();
            }
        }

        return json_encode(array('status' => true));
    }

    public static function updateRewardByDeleteRule($rule_id) {
	    RedPacket::where('rule_id', $rule_id)->delete();

        return json_encode(array('status' => true));
    }

    public static function updateRewardByUpdateRule($rule_id) {
        self::updateRewardByDeleteRule($rule_id);
        self::updateRewardByNewRule($rule_id);

        return json_encode(array('status' => true));
    }

    public static function setProposal($id) {
        if (RedPacket::setProposal($id))
            return json_encode(array('status' => true));
        else
            return json_encode(array('status' => false, 'error_message' => 'Database Error'));
    }

    public static function setApproval($id) {
        if (RedPacket::setApproval($id))
            return json_encode(array('status' => true));
        else
            return json_encode(array('status' => false, 'error_message' => 'Database Error'));
    }
}
