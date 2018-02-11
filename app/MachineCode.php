<?php

namespace App;

use Session;
use Illuminate\Database\Eloquent\Model;
use mProvider;

class MachineCode extends Model
{
	//
    public static function add_machinecode($data){
		$userinfo = Session::get('total_info');
		$machinecodedata = MachineCode::where('code', $data->machine_code)
			->first();
		if($machinecodedata == null){
			$MachineCode = 2;
		}else{
			if($machinecodedata->card_id == 0 || $machinecodedata->card_id == $data->card_id){
				
				MachineCode::where('card_id', $data->card_id)
					->update(['card_id' => 0]);
				
				$MachineCode = MachineCode::where('code', $data->machine_code)
					->update(['card_id' => $data->card_id]);
			}else{
				$MachineCode = 0;
			}
		}					
       
		/* if ($MachineCode == '0'){
			$MachineCode = new MachineCode;
			$MachineCode->code = $data->machine_code;
			$MachineCode->card_id = $data->card_id;
			$MachineCode->register_date = date("Y-m-d H:i:s");
			$MachineCode->save();
		}*/

        return $MachineCode;
	}
	
	/***********************************
		Return value;  0: other card, 1: availabel, 2: no machine code
	***********************************/
    public static function check_machinecode($card_id, $machine_code){
		$userinfo = Session::get('total_info');
		$machinecodedata = MachineCode::where('code', $machine_code)
										->first();
		if($machinecodedata == null){
			$MachineCode = 2;
		}else{
			if($machinecodedata->card_id == 0 || $machinecodedata->card_id == $card_id){
				$MachineCode = 1;
			}else{
				$MachineCode = 0;
			}
		}

        return $MachineCode;
	}

	public static function add_code($code) {
		$machine_code = MachineCode::where('code', $code)->first();

		if ($machine_code) {
			return 1;
		}
		else {
			$machine_code = new MachineCode;
			$machine_code->code = $code;
			$machine_code->save();

			return 0;
		}
	}

	public static function record_card($code, $card_id) {
		$machine_code = MachineCode::where('code', $code)->first();

		if ($machine_code) {
			
			$machine_code->card_id = $card_id;
			$machine_code->save();

			return 1;
		}
		else {
			return 0;
		}
	}
	
	public function card()
    {
        return $this->hasOne('App\Card', 'id', 'card_id');
    }

}
