<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use App\RedPacketSetting;

class Dealer extends Model
{
    public function detail_info()
    {
        return $this->hasOne('App\DealerDetail', 'id', 'detail_id');
    }

    // Get dealer list by dealer_level
    public static function getDealersByLevel($level) {
        $list = Dealer::where('level', $level)->get();

        return $list;
    }
    // Get all down dealer list by dealer_id
    public static function getSubDealerListRaw($dealer_id) {
        
		$dealer = Dealer::find($dealer_id);
		if(null === $dealer) return array();
		
		$return_array = array();
		$sub_dealers = Dealer::where([
				['parent_id', '=', $dealer_id],
				['level', '=', $dealer['level'] + 1],
			])->get();
		
		if(count($sub_dealers) == 0) return array();
		
		foreach($sub_dealers as $sub_dealer){
			$return_array[] = $sub_dealer->id;
			$return_array = array_merge($return_array, Dealer::getSubDealerListRaw($sub_dealer->id));
		}
		
		return $return_array;
    }
	
    // Get next down dealer list by dealer_id
    public static function getSubDealer($dealer_id) {
        
		$userinfo = Session::get('total_info');
		
		if($dealer_id != 0){
			$dealer = Dealer::find($dealer_id);
			if(null === $dealer) return array();
			$level = $dealer['level'] + 1;
		}else{
			$level = 0;
		}
		
		
		$return_array = array();
		$query = Dealer::query();
		$query->where([
				['parent_id', '=', $dealer_id],
				['level', '=', $level],
			]);
		
		if($userinfo['level'] >= $level){
			$query->where([
				['id', '=', $userinfo['dealer_id']]
			]);
		}
		
		$sub_dealers = $query->get();
		
		return $sub_dealers;
    }
	
	
	public function is_salespoint(){
		$count = Dealer::where([
				['parent_id', '=', $this->id],
				['level', '=', $this->level + 1],
			])->count();
			
		if($count > 0) $this->calc_salespoint = false;
		else $this->calc_salespoint = true;
	}

    // Get all down dealer list by dealer_id
    public static function getDealerIDByCode($code) {

        $dealer = Dealer::where('code', '=', $code)->first();

        if(null === $dealer)
            return null;

        return $dealer->id;
    }

    /**
     * @function : getDingdingAccountByID
     * @param $id
     * @return mixed|null
     */
    public static function getDingdingAccountByID($id) {
        $dealer = Dealer::where('id', '=', $id)->first();

        if(null === $dealer)
            return null;

        return $dealer->dd_account;
    }

    /**
     * @function : getDingdingAccountByCode
     * @param $code
     * @return mixed|null
     */
    public static function getDingdingAccountByCode($code) {
        $dealer = Dealer::where('code', '=', $code)->first();

        if(null === $dealer)
            return null;

        return $dealer->dd_account;
    }

    /**
     * @function : getDealerLevelByCode
     * @param $code
     * @return mixed|null
     */
    public static function getDealerLevelByCode($code) {
        $dealer = Dealer::where('code', '=', $code)->first();

        if(null === $dealer)
            return null;

        return $dealer->level;
    }
	
	// Get charge man of dealer
	public function president()
    {
		
        /* return $this->hasOne('App\User')
            ->where('role_id', '<', 3)
            ->where('dealer_id', $this->id)
            ->first(); */
		$president = User::where('role_id', '<', 3)
            ->where('dealer_id', $this->id)
            ->first();
        return $this->hasOne($president);
    }
	
	// Get charge man of dealer
	public function president_dingid_list_bycomma()
    {
		$president_list = User::where('role_id', '<', 3)
            ->where('dealer_id', $this->id)
            ->get();
		$id_list = [];
		foreach($president_list as $president){
			$id_list[] = $president->dd_account;
		}
        return implode(",", $id_list);
    }
	
	// Get organization structure name of current dealer
	public function getDealerStructureName($contain_self = false)
    {
		$updealer_list = Dealer::getUpDealerArray($this->id);
		$name_list = array_column($updealer_list, 'name');
		if($contain_self == true) $name_list[] = $this->name;
		$this->structure_name = implode(" -> ", $name_list);
    }
		
	// Get corporation (总代)
	public function getCorperation() {
        $this->corp_info = Dictionary::where('keyword', 'dic_retail')
            ->where('value', $this->corporation)
            ->select(['value as code', 'description as name'])->first();
        $this->corp_list = Dictionary::where('keyword', 'dic_retail')
            ->select(['value as code', 'description as name'])->get();

        if ($this->corp_info == null)
            $this->corp_info = (object)array('code' => null, 'name' => '');

        if ($this->corp_list == null)
            $this->corp_list = (object)array(array('code' => null, 'name' => ''));
	}
	
	// Get organization staff employees of current dealer
	public function getStaff()
    {
		$staffs = User::query()
			->where('dealer_id', '=', $this->id)->orderBy('role_id')->get();
		foreach($staffs as $staff){
			$staff->role;
			$staff->can_edit = $staff->can_edit2();
		}
		$this->staffs = $staffs;
    }
	
    // Get all up dealer list by dealer_id
    public static function getUpDealerArray($dealer_id) {
        
		$dealer = Dealer::find($dealer_id);
		if(null === $dealer || $dealer->level <= 0 || $dealer->parent_id <= 0) return array();
		
		$return_array = array();
		
		do {
			$dealer = Dealer::query()
				->where([
					['id', '=', $dealer->parent_id],
					['level', '=', $dealer['level'] - 1],
				])->first();
			$return_array[] = $dealer;
		} while($dealer && $dealer->level > 0 && $dealer->parent_id > 0);
		
		$return_array = array_reverse($return_array);
		
		return $return_array;
    }
	
    // Get all up dealer list by dealer_id
    public static function getUpDealerIDArray($dealer_id) {
        
		$dealer = Dealer::find($dealer_id);
		if(null === $dealer || $dealer->level <= 0 || $dealer->parent_id <= 0) return array();
		
		$return_array = array();
		
		do{
			$dealer = Dealer::query()
				->where([
					['id', '=', $dealer->parent_id],
					['level', '=', $dealer['level'] - 1],
				])->first();
			$return_array[] = $dealer->id;
		}while($dealer && $dealer->level > 0 && $dealer->parent_id > 0);
		
		$return_array = array_reverse($return_array);
		
		return $return_array;
    }
	
    // Return can edit current dealer
    public function can_edit($login_info) {
		if($login_info['authority'] == "admin") return true;
		if($this->id == $login_info['dealer_id']) return true;
		
		$dealers_up = Dealer::getUpDealerIDArray($this->id);
		if (in_array($login_info['dealer_id'], $dealers_up)) return true;
		else return false;
	}
	
	// Get child dealer array
	public static function getChildDealerWithPromotionArray($cur_date, $dealer_id, $product_id) {
		$dealers = Dealer::where('parent_id', $dealer_id)->get();
		$promotions = Promotion::getPromotionArrayIndexedByDealerId($cur_date, $product_id);
		
		foreach ($dealers as $dealer) {
			if (isset($promotions[''.$dealer->id])) {
				$dealer->promotion_price = $promotions[''.$dealer->id]->promotion_price;
				$dealer->promotion_start_date = $promotions[''.$dealer->id]->promotion_start_date;
				$dealer->promotion_end_date = $promotions[''.$dealer->id]->promotion_end_date;
			} else {
				$promotion = Promotion::getPromotionItemByLevelForView($cur_date, $product_id, $dealer->level);
				if ($promotion) {
					$dealer->promotion_price = $promotion->promotion_price;
					$dealer->promotion_start_date = $promotion->promotion_start_date;
					$dealer->promotion_end_date = $promotion->promotion_end_date;
				} else {
					$dealer->promotion_price = null;
					$dealer->promotion_start_date = null;
					$dealer->promotion_end_date = null;
				}
			}
		}
		
		return $dealers;
	}
	
	// Get child dealer array of parent
	public static function getChildOfParentDealerWithPromotionArray($cur_date, $dealer_id, $product_id) {
		if ($dealer_id == 1) return array();
		$parent_dealer_id = Dealer::find($dealer_id)->parent_id;
		
		$dealers = Dealer::where('parent_id', $parent_dealer_id)->get();
		$promotions = Promotion::getPromotionArrayIndexedByDealerId($cur_date, $product_id);
		
		foreach ($dealers as $dealer) {
			if (isset($promotions[''.$dealer->id])) {
				$dealer->promotion_price = $promotions[''.$dealer->id]->promotion_price;
				$dealer->promotion_start_date = $promotions[''.$dealer->id]->promotion_start_date;
				$dealer->promotion_end_date = $promotions[''.$dealer->id]->promotion_end_date;
			} else {
				$promotion = Promotion::getPromotionItemByLevelForView($cur_date, $product_id, $dealer->level);
				if ($promotion) {
					$dealer->promotion_price = $promotion->promotion_price;
					$dealer->promotion_start_date = $promotion->promotion_start_date;
					$dealer->promotion_end_date = $promotion->promotion_end_date;
				} else {
					$dealer->promotion_price = null;
					$dealer->promotion_start_date = null;
					$dealer->promotion_end_date = null;
				}
			}
		}
		
		return $dealers;
	}
	
	// Get dealer with promotion array indexed by dealer_level
	public static function getPromotionArrayIndexedByLevel($cur_date, $product_id) {
		$max_level = Dealer::max('level');
		
		$ret_ary = array();
		for ($i = 1; $i <= $max_level; $i++) {
			$ret_ary[$i] = array();
			$promotion = Promotion::getPromotionItemByLevelForView($cur_date, $product_id, $i);
			$ret_ary[$i]['level'] = $i;
			/*if ($promotion) {
				$ret_ary[$i]['promotion_price'] = $promotion->promotion_price;
				$ret_ary[$i]['promotion_start_date'] = $promotion->promotion_start_date;
				$ret_ary[$i]['promotion_end_date'] = $promotion->promotion_end_date;
			} else {
				$ret_ary[$i]['promotion_price'] = null;
				$ret_ary[$i]['promotion_start_date'] = null;
				$ret_ary[$i]['promotion_end_date'] = null;
			}*/
			$ret_ary[$i]['promotion_price'] = null;
			$ret_ary[$i]['promotion_start_date'] = null;
			$ret_ary[$i]['promotion_end_date'] = null;
			
		}
		
		return $ret_ary;
	}
	
	// Get dealer with promotion array from dealer_name
	public static function getDealerFromName($cur_date, $product_id, $search_name) {
		$dealers = Dealer::where('name', 'like', '%'.$search_name.'%')->get();
		$promotions = Promotion::getPromotionArrayIndexedByDealerId($cur_date, $product_id);
		
		foreach ($dealers as $dealer) {
			if (isset($promotions[''.$dealer->id])) {
				$dealer->promotion_price = $promotions[''.$dealer->id]->promotion_price;
				$dealer->promotion_start_date = $promotions[''.$dealer->id]->promotion_start_date;
				$dealer->promotion_end_date = $promotions[''.$dealer->id]->promotion_end_date;
			} else {
				$promotion = Promotion::getPromotionItemByLevel($cur_date, $product_id, $dealer->level);
				if ($promotion) {
					$dealer->promotion_price = $promotion->promotion_price;
					$dealer->promotion_start_date = $promotion->promotion_start_date;
					$dealer->promotion_end_date = $promotion->promotion_end_date;
				} else {
					$dealer->promotion_price = null;
					$dealer->promotion_start_date = null;
					$dealer->promotion_end_date = null;
				}
			}
		}
		
		return $dealers;
	}

	public function redpacketRules() {
	    $this->hasMany('App\RedPacketSetting');
    }
}
