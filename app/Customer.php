<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    //
    public static function add_customer($data) {
		//$userinfo = Session::get('total_info');
        $affectrow = Customer::where('name', $data->regit_name)
					->where('link', $data->regit_phone)
					->update(['name' => $data->regit_name]);
		if ($affectrow == '0'){
			$Customer = new Customer;
			$Customer->name = $data->regit_name;
			$Customer->link = $data->regit_phone;
			$Customer->save();
		}			
		$row = Customer::where('name', $data->regit_name)
					->where('link', $data->regit_phone)
					->first();		
		
        return $row->id;
    }
}
