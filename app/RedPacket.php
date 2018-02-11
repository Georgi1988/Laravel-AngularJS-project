<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RedPacket extends Model
{
    // Get redpacket list of down dealers indexed by user_id from start_date, end_date
    public static function getRedpacketList($dealer_id, $start_date, $end_date, $redpacket_monthly) {
        // Get the down dealer list of dealer_id
		$down_dealer_ary = Dealer::getSubDealerListRaw($dealer_id);

        if ($redpacket_monthly == 1) {
            $list = RedPacket::where('redpacket_start_date', $start_date)
                ->where('redpacket_end_date', $end_date)
                ->whereIn('dealer_id', $down_dealer_ary)
                ->get();
        }
        else {
            $list = RedPacket::whereNull('redpacket_start_date')
                ->where('redpacket_end_date', $end_date)
                ->whereIn('dealer_id', $down_dealer_ary)
                ->get();
        }

        $ret_ary = array();
        foreach ($list as $item) {
            $ret_ary[''.$item->user_id] = $item;
        }

        return $ret_ary;
    }

    public static function getRecordByUserAndRule($user_id, $rule_id) {
        return RedPacket::findOrNew(['user_id' => $user_id, 'rule_id' => $rule_id]);
    }

    /**
     * @param $type :
     *      '0' => all, '1' => unarrived, '2' =>unproposal, '3' => proposal, '4' => unapproval, '5' => approval,
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    public static function getRedPacketByAdmin($type) {
        switch ($type) {
            case 0:
                $results = RedPacket::select('red_packet.*',
                        'users.name as user_name', 'dealers.name as dealer_name',
                        'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
                        'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                    ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
                    ->get();
                break;
            case 1:
                $results = RedPacket::select('red_packet.*',
                    'users.name as user_name', 'dealers.name as dealer_name',
                    'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
                    'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
                    ->where('is_arrival', 0)
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                    ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
                    ->get();
                break;
            case 2:
                $results = RedPacket::select('red_packet.*',
                    'users.name as user_name', 'dealers.name as dealer_name',
                    'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
                    'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
                    ->where('is_arrival', 1)
                    ->where('is_proposal', 0)
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                    ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
                    ->get();
                break;
            case 3:
                $results = RedPacket::select('red_packet.*',
                    'users.name as user_name', 'dealers.name as dealer_name',
                    'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
                    'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
                    ->where('is_arrival', 1)
                    ->where('is_proposal', 1)
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                    ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
                    ->get();
                break;
            case 4:
                $results = RedPacket::select('red_packet.*',
                    'users.name as user_name', 'dealers.name as dealer_name',
                    'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
                    'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
                    ->where('is_arrival', 1)
                    ->where('is_proposal', 1)
                    ->where('is_arrival', 0)
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                    ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
                    ->get();
                break;
            case 5:
                $results = RedPacket::select('red_packet.*',
                    'users.name as user_name', 'dealers.name as dealer_name',
                    'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
                    'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
                    ->where('is_arrival', 1)
                    ->where('is_proposal', 1)
                    ->where('is_arrival', 1)
                    ->leftJoin('users', 'users.id', '=', 'user_id')
                    ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                    ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
                    ->get();
                break;
        }

        return $results;
    }

    public static function getReadPacketByUser($id) {
        $results = RedPacket::select('red_packet.*',
            'red_packet_settings.redpacket_type', 'red_packet_settings.redpacket_start_date',
            'red_packet_settings.redpacket_end_date', 'red_packet_settings.redpacket_rule', 'red_packet_settings.redpacket_price')
            ->where('user_id', $id)
            ->leftJoin('red_packet_settings', 'red_packet_settings.id', '=','rule_id')
            ->get();
        return $results;
    }

    public static function setProposal($id) {
        $redpacket = RedPacket::find($id);
        $today = \Carbon::now();

        if ($redpacket != null) {
            $redpacket->is_proposal = 1;
            $redpacket->proposal_at = $today;
            $redpacket->save();

            return true;
        }

        return false;
    }

    public static function setApproval($id)
    {
        $redpacket = RedPacket::find($id);
        $today = \Carbon::now();

        if ($redpacket != null) {
            $redpacket->is_approval = 1;
            $redpacket->approval_at = $today;
            $redpacket->save();

            return true;
        }

        return false;
    }
	
	/**********************************************
		Red packet approval list get
			call time : stock setting add / edit
			
			paremeter: Setting redpacket_setting Eloquent Model
		
	**********************************************/
	public static function setApprovalList(RedPacketSetting $setting, $seller_id = 0){
		
		$dealer_id = $setting->dealer_id;
		$product_id = $setting->product_id;
		
		/* RedPacket::where([
			['rule_id', '=', $setting->id],
			['is_approval', '=', 0]
		])->delete(); */
		
		$tb_prefix = DB::getTablePrefix();
		
		$query = Sale::query()
			->selectRaw(' `tag_dealer_id`, seller_id, count(`id`) as `sale_count`, sum(sale_price) as `sale_sum`')
			->where([
				['src_dealer_id', '=', 0],
				['reg_success', '=', 1],
			])
			->whereRaw(' date(`created_at`) >= "'.$setting->redpacket_start_date.'" ')
			->whereRaw(' date(`created_at`) <= "'.$setting->redpacket_end_date.'" ');
		
		if($seller_id != 0 && $seller_id !== null){
			$query->where('seller_id', $seller_id);
		}
		
		if($dealer_id != 0 && $dealer_id !== null){
			$query->where('tag_dealer_id', $dealer_id);
		}
		
		if($product_id != 0 && $product_id !== null){
			$query->where('product_id', $product_id);
		}
		
		$query->groupBy('seller_id');
		
		/* if($setting->redpacket_type == 0)
			$query->having('sale_sum', '>=', $setting->redpacket_rule);
		else if($setting->redpacket_type == 1)
			$query->having('sale_count', '>=', $setting->redpacket_rule); */
		
		$redpacket_list = $query->get();
		
		//var_dump($arrival_list);
		
		foreach($redpacket_list as $redpacket_info){
			
			if($setting->redpacket_type == 0){
				if($redpacket_info->sale_sum >= $setting->redpacket_rule){
					$is_arrival = 1;
				}else{
					$is_arrival = 0;
				}
			}
			else if($setting->redpacket_type == 1){
				if($redpacket_info->sale_count >= $setting->redpacket_rule){
					$is_arrival = 1;
				}else{
					$is_arrival = 0;
				}
			}
			
			
			$redpacket = RedPacket::where([
					["user_id", "=", $redpacket_info->seller_id],
					["rule_id", "=", $setting->id],
				])->first();
			if($redpacket === null){
				$redpacket = new RedPacket();
				$redpacket->is_arrival= 0;
			} 
			
			$before_arrival = $redpacket->is_arrival;
			
			$redpacket->user_id = $redpacket_info->seller_id;
			$redpacket->dealer_id = $redpacket_info->tag_dealer_id;
			$redpacket->rule_id = $setting->id;
			$redpacket->price = $setting->redpacket_price;
			$redpacket->sales_price = $redpacket_info->sale_sum;
			$redpacket->sales_count = $redpacket_info->sale_count;			
			$redpacket->is_arrival = $is_arrival;
			$redpacket->save();
			
			if($is_arrival == 1 && $before_arrival == 0){
				
				$messageadddata = array(
						"type" => "1",
						"tag_dealer_id" => $redpacket->dealer_id,
						"tag_user_id" => $redpacket->user_id,
						"message" => "您到达奖励规则“".$redpacket->redPacketSetting->redpacket_name."”".floor($redpacket->redPacketSetting->redpacket_rule).(($redpacket->redPacketSetting->redpacket_type == '0')?"元":"张"),
						"url" => "#!/reward/office/list",
						"html_message" => "<p>您到达奖励规则“".$redpacket->redPacketSetting->redpacket_name."”".floor($redpacket->redPacketSetting->redpacket_rule).(($redpacket->redPacketSetting->redpacket_type == '0')?"元":"张")."</p>
						<p>红包奖励金额 : ".floor($redpacket->redPacketSetting->redpacket_price)."元</p>",
						"table_name" => "redpacket",
						"table_id" => $redpacket->id,
					);	
				Message::save_message($messageadddata);
			}
		}
	}
	
	
	/**********************************************
		Red packet approval list get
			call time : stock setting delete
			action: remove redpacket unapproved according redpacket setting
			parameter: redpacket_setting
	**********************************************/
	public static function removeUnapprovedList($setting){
		
		//$setting = RedPacketSetting::find($id);
		
		$dealer_id = $setting->dealer_id;
		$product_id = $setting->product_id;
		
		RedPacket::where([
			['rule_id', '=', $setting->id],
			['is_approval', '=', 0]
		])->delete();
	}
	
	/**********************************************
		Red packet user arrival check function
			call time : register time
			action: approxiate user`s sales check and insert redpacket table
			parameter: user_id
	**********************************************/
	public static function checkUser($user_id){
		
		$user = User::find($user_id);
		if($user === null) return false;
		$dealer = $user->dealer;
		
		$settings = RedPacketSetting::getAvailableSettingByDealer($dealer->id);
		
		foreach($settings as $setting){
			RedPacket::setApprovalList($setting, $user_id);
		}
	}

    // Dealer info
    public function dealer()
    {
        return $this->hasOne('App\Dealer', 'id', 'dealer_id');
    }
    // User info
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    // Redpacket rule
    public function redPacketSetting()
    {
        return $this->hasOne('App\RedPacketSetting', 'id', 'rule_id');
    }
}

