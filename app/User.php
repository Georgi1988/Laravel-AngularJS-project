<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\Dealer;
use Session;

class User extends Model
{
    // Manager's name list indexed by dealer_id
    public static function getManagerNameListByDelaer($manager_str) {
        // role_id = 1,2 => manager of dealer
        /*$role_id = Role::where('name', $manager_str)->get()->first()->id;
        $usr_list = UserRole::where('role_id', $role_id)->groupBy('user_id')->get();*/
        $usrs = User::getIndexedUserArray();
        $ret_ary = array();
        foreach ($usrs as $usr) {            
            if ($usr->role_id == 1 || $usr->role_id == 2) 
                $ret_ary[''.$usr->dealer_id] = $usr->name;
        }

        return $ret_ary;
    }
	
	public static function setLastProductId($user_id) {
		// Set the badge of product value
		$user = User::find($user_id);
		Badge::updateBadge($user->id, $user->dealer_id, $user->last_product_id, 'product');
		
		$msg = Message::orderBy('id', 'desc')->first();
		if ($msg) $last_msg_id = $msg->id;
		else $last_msg_id = 0;
		
		$user->last_product_id = $last_msg_id;
		$user->save();
		
		return true;
	}
	
	public static function setLastPurchaseId($user_id) {
		// Set the badge of purchase value
		$user = User::find($user_id);
		Badge::updateBadge($user->id, $user->dealer_id, $user->last_purchase_id, 'purchase');
		
		$msg = Message::orderBy('id', 'desc')->first();
		if ($msg) $last_msg_id = $msg->id;
		else $last_msg_id = 0;
		
		$user->last_purchase_id = $last_msg_id;
		$user->save();
		
		return true;
	}
	
	public static function setLastOrderId($user_id) {
		// Set the badge of order value
		$user = User::find($user_id);
		Badge::updateBadge($user->id, $user->dealer_id, $user->last_order_id, 'order');
		
		$msg = Message::orderBy('id', 'desc')->first();
		if ($msg) $last_msg_id = $msg->id;
		else $last_msg_id = 0;
		
		$user->last_order_id = $last_msg_id;
		$user->save();
		
		return true;
	}
	
	public static function setLastPriceId($user_id) {
		// Set the badge of price value
		$user = User::find($user_id);
		Badge::updateBadge($user->id, $user->dealer_id, $user->last_price_id, 'price');
		
		$msg = Message::orderBy('id', 'desc')->first();
		if ($msg) $last_msg_id = $msg->id;
		else $last_msg_id = 0;
		
		$user->last_price_id = $last_msg_id;
		$user->save();
		
		return true;
	}

    public static function getIndexedUserArray() {
        $usr_list = User::get();
        $ret_ary = array();
        foreach ($usr_list as $usr) {
            $ret_ary[''.$usr->id] = $usr;
        }
        
        return $ret_ary;
    }
	
	public static function get_email() {
        $userinfo = Session::get('total_info');
		if($userinfo["user_id"]){
			$useremail = User::find($userinfo["user_id"]);
			$email = $useremail->email;
		}else{
			$email = "";
		}
		
		return $email;
    }

    public function role() {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }
	
    // user dealerpoint info
	public function dealer()
    {
        return $this->hasOne('App\Dealer', 'id', 'dealer_id');
    }
	
    // Return can edit current dealer
    public function can_edit($login_info) {
		if($login_info['authority'] == "admin") return true;
		else if($this->id == $login_info['user_id']) return true;
		else return false;
	}
	
    // Return can edit current dealer
    public function can_edit2() {
        $login_info = Session::get('total_info');
		if($login_info['authority'] == "admin") return true;
		else if($this->id == $login_info['user_id']) return true;
		else return false;
	}

	public static function getUserInfoByID($id) {
        $user = User::find($id);

        return $user;
    }

    public static function getDealerID($id) {
        $user = User::find($id);

        return ($user != null) ? $user->dealer_id : 0;
    }

    public static function getAllSeller() {
        $users = User::where('role_id', 3)->get();
        return $users;
    }

    public static function getSellersByDealer($dealer_id) {
        $users = User::where('dealer_id', $dealer_id)
            ->where('role_id', 3)->get();
        return $users;
    }
}
