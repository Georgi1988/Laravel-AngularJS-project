<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use mProvider;

class StatisticsController extends Controller
{
    public $categ = 'statistics';
	
	public function dealer_view(){
		
		$period_time = trans('lang.week');
		
		$view_info = [
			'home_title' => trans('lang.home_title')."-".trans('lang.label_statistic'),
			'c_categ' => $this->categ,
		];
		
		return view(mProvider::$view_prefix.'statistics_dealer', $view_info);
	}
	
	public function sales_view(){
		
		$period_time = trans('lang.week');
		
		$view_info = [
			'home_title' => trans('lang.home_title')."-".trans('lang.label_statistic'),
			'c_categ' => $this->categ,
		];
		
		return view(mProvider::$view_prefix.'statistics_sales', $view_info);
	}
}
