<div class="user_v_content" ng-show="loaded">
	<div class="block">
		<div class="left ">
			<a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="name_panel bgdef">
		<span class="dealer_name">{? dealer.name ?}</span> <span class="muted" ng-show="dealer.level > 0">（{? dealer.structure_name ?}）</span>
	</div>
	<div class="info_panel col-xs-6 bg_white">
		<div class="row info_header margin0">
			<div class="col-xs-9 label_str">@lang('lang.info')</div>
			<div class="col-xs-3 text-center">
				<a class="user_view_btn fontsize1_0" ng-href="#!/user/dealer/edit/{?dealer.id?}" class="edit_btn fontsize0_9">@lang('lang.pr_item_edit')</a>
			</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.corporation')</div>
			<div class="col-xs-9">{? dealer.corp_info.name ?}</div>
		</div>
		<div class="row margin0 paddingtop10" ng-show="dealer.level != 0">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.level')</div>
			<div class="col-xs-9">
				{?
					dealer.level==1 ? "@lang('lang.1st_level_dealer')" :
					dealer.level==2 ? "@lang('lang.2nd_level_dealer')" :
					dealer.level==3 ? "@lang('lang.3rd_level_dealer')" :
					dealer.level==4 ? "@lang('lang.4th_level_dealer')" :
					dealer.level==5 ? "@lang('lang.5th_level_dealer')" :
					dealer.level==6 ? "@lang('lang.6th_level_dealer')" :
					dealer.level==7 ? "@lang('lang.7th_level_dealer')" :
					dealer.level==8 ? "@lang('lang.8th_level_dealer')" :
					dealer.level==9 ? "@lang('lang.9th_level_dealer')" :
					dealer.level==10 ? "@lang('lang.10th_level_dealer')" :
					dealer.level==11 ? "@lang('lang.11th_level_dealer')" :
					dealer.level==12 ? "@lang('lang.12th_level_dealer')" :
					dealer.level==13 ? "@lang('lang.13th_level_dealer')" :
					dealer.level==14 ? "@lang('lang.14th_level_dealer')" :
					dealer.level==15 ? "@lang('lang.15th_level_dealer')" :
					dealer.level==16 ? "@lang('lang.16th_level_dealer')" :
					dealer.level==17 ? "@lang('lang.17th_level_dealer')" :
					dealer.level==18 ? "@lang('lang.18th_level_dealer')" :
					dealer.level==19 ? "@lang('lang.19th_level_dealer')" :
					"@lang('lang.20th_level_dealer')"
				?}
			</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.address')</div>
			<div class="col-xs-8 col-xs-offset-1">{? dealer.address ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.contact')</div>
			<div class="col-xs-8 col-xs-offset-1">{? dealer.link ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.person_charge')</div>
			<div class="col-xs-8 col-xs-offset-1">{? dealer.president.name ?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.person_charge_link')</div>
			<div class="col-xs-8 col-xs-offset-1"><i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{?dealer.president.link?}</div>
		</div>
		<div class="row margin0 paddingtop10">
			<div class="col-xs-3 label_col text-right nopadding">@lang('lang.dingding_account')</div>
			<div class="col-xs-8 col-xs-offset-1">{? dealer.dd_account ?}</div>
		</div>
	</div>
	
	<div class="row user_panel col-xs-6 bg_white">
		<div class="row info_header margin0">
			<div class="col-xs-9 label_str">@lang('lang.label_staff')</div>
		</div>
		<div class="row user_info margin0 paddingtop10" ng-repeat="staff in dealer.staffs">
			<div class="info col-xs-3 col-xs-offset-1 padding-lf-8">
				{? staff.name ?}
			</div>
			<div class="info col-xs-2 text-center nopadding">
				<span class="text-muted">{? staff.role.name ?}</span>
			</div>
			<div class="info col-xs-4 text-center nopadding">
				<i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{?staff.link?}
			</div>
			<div class="info col-xs-1 text-center nopadding">
				<a href="#!/user/staff/detail/{?staff.id?}" class="user_view_btn">@lang('lang.ov_details')</a>
			</div>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
</div>
	
<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>