<?php
namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Badge extends Model
{
	public static function updateBadge($user_id, $dealer_id, $last_id, $table_name) {
		if ($dealer_id != 1 || $table_name != 'product') {
			$msgs = Message::where('id', '>', $last_id)
				->where('table_name', $table_name)
				->where(function ($q) use ($dealer_id, $user_id) {
					$q->where('tag_dealer_id', 0)
						->orWhere('tag_dealer_id', $dealer_id)
						->orWhere('tag_user_id', $user_id)
						->orWhere('tag_user_id', 0);
				})
				->get();
				
			foreach ($msgs as $msg) {
				if ($table_name == 'purchase')
					$real_table_name = 'order';
				else
					$real_table_name = $table_name;
				
				$badge = Badge::where('user_id', $user_id)
					->where('table_name', $real_table_name)
					->where('table_id', $msg->table_id)
					->first();
				if (!$badge) {
					$badge = new Badge();
					$badge->user_id = $user_id;
					$badge->table_name = $real_table_name;
					$badge->table_id = $msg->table_id;
					
					$badge->save();
				}
			}
		}
	}
	
	public static function removeBadge($user_id, $table_id, $table_name) {
		$badge = Badge::where('user_id', $user_id)
			->where('table_name', $table_name)
			->where('table_id', $table_id)
			->first();
		
		if ($badge) $badge->delete();
	}
	
	// Get badge array indexed by table_id
	public static function getBadgeAry($user_id, $table_name) {
		$badges = Badge::where('user_id', $user_id)
			->where('table_name', $table_name)
			->get();
			
		$ret_ary = array();
		foreach ($badges as $badge) {
			$ret_ary[''.$badge->table_id] = 1;
		}
		
		return $ret_ary;
	}
}