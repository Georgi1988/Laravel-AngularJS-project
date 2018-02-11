<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Dealer;


class RedPacketSetting extends Model
{
	// Record arrival user redpacket 
	public static function setRedpacketUserid($userid){
		
	}
	
    // Get redpacket list of down dealers indexed by user_id from start_date, end_date
    public static function getRuleList($dealer_id, $start_date, $end_date) {
        // Get the down dealer list of dealer_id
        $down_dealer_ary = Dealer::getSubDealerListRaw($dealer_id);

        $list = RedPacketSetting::where('redpacket_start_date', '>=', $start_date)
                ->where('redpacket_end_date', '<=', $end_date)
                ->whereIn('dealer_id', $down_dealer_ary)
                ->get();

        return json_encode($list, true);
    }

    // Get redpacket list of down dealers
    public static function getRuleListByDealer($dealer_id) {
        // Get the down dealer list of dealer_id
        $down_dealer_ary = Dealer::getSubDealerListRaw($dealer_id);
        $list = RedPacketSetting::whereIn('dealer_id', $down_dealer_ary)->get();

        return json_encode($list, true);
    }

    // Get redpacket list of down dealers indexed by user_id from start_date, end_date
    public static function getRuleListByProduct($dealer_id, $start_date, $end_date) {
        // Get the down dealer list of dealer_id
        $down_dealer_ary = Dealer::getSubDealerListRaw($dealer_id);

        $list = RedPacketSetting::where('redpacket_start_date', '>=', $start_date)
            ->where('redpacket_end_date', '<=', $end_date)
            ->whereIn('dealer_id', $down_dealer_ary)
            ->get();

        return json_encode($list, true);
    }

    // Get redpacket list of down dealers indexed by user_id from start_date, end_date
    public static function getRuleById($id) {
        return RedPacketSetting::select('red_packet_settings.*',
                    'dealers.id as dealer_id', 'dealers.name as dealer_name',
                    'products.id as product_id', 'products.name as product_name', 'products.image_url as image_url')
            ->where('id', '=', $id)
            ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
            ->leftJoin('products', 'products.id', '=', 'product_id')
            ->first();
    }

    public static function getRuleByDealerOnToday($dealer_id) {
        $today = \Carbon::now();

        $list = RedPacketSetting::whereBetween($today, ['redpacket_start_date', 'redpacket_end_date'])
            ->where('dealer_id', $dealer_id)->orWhereNull('dealer_id')
            ->get();

        return $list;
    }

    public static function getRuleByDealer($dealer_id) {
        $list = RedPacketSetting::where('dealer_id', $dealer_id)->orWhereNull('dealer_id')
            ->get();

        return $list;
    }

    public static function getRewardingRuleList($itemcount, $pagenum) {
        return RedPacketSetting::select('red_packet_settings.*', 'dealers.name as dealer_name', 'products.name as product_name', 'products.image_url as image_url')
                ->leftJoin('dealers', 'dealers.id', '=','dealer_id')
                ->leftJoin('products', 'products.id', '=', 'product_id')
				->latest()
                ->paginate($itemcount, ['*'], 'p', $pagenum);
    }
	
	// get redpacket setting lit of a dealer today date
	public static function getAvailableSettingByDealer($dealer_id){
		
		$today = date("Y-m-d");
		
        $query = RedPacketSetting::query();
		$query->where([
				['redpacket_start_date', '<=', $today],
				['redpacket_end_date', '>=', $today],
			]);
		$query->where(function ($query) use ($dealer_id) {
				$query	->where('dealer_id', '=', $dealer_id)
						->orwhere('dealer_id', '=', 0)
						->orwhere('dealer_id', '=', null);
			});
		$list = $query->get();

        return $list;
	}

    // Dealer info
    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id', 'id');
    }

    // Product info
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
