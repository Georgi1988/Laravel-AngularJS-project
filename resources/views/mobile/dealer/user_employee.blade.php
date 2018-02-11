<div class="user_v_content page_wrapper" style="display: none;">
	<div class="name_panel bgdef">
		<div class="row fontsize1_5 margin0 text-center paddingtop20 padding-lf-8 color_39f">
			{? dealer.name ?}
		</div>
	</div>

	<div class="item_my" style="padding-bottom: 10px;">
		<div class="btn-group float-right" role="group">
			<a type="button" style="font-size: 12px; margin-right: 10px;" class="btn btn-primary" ng-click="onChangeDealer(upper_dealer.id);" ng-if="upper_dealer_id != dealer.id">@lang('lang.label_up_dealer_information')</a>
			<a type="button" style="font-size: 12px; margin-right: 10px;" class="btn btn-primary" ng-click="onChangeDealer(login_dealer_id);" ng-if="upper_dealer_id == dealer.id">@lang('lang.label_self_dealer_information')</a>
		</div>
	</div>

	<div class="clearfix paddingbot10"></div>

	<div class="info_panel bg_white" style="font-size: 12px;">
		<div class="item_my" style="padding: 10px 10px 5px 10px;">
			<div class="row info_header margin0" style="background-color: #eaffc5;">
				<div class="col-xs-9 label_sdiv" style="padding-top: 8px; font-size: 14px;">@lang('lang.label_dealer_information')</div>
				<div class="col-xs-3 text-right nopadding">
					<a class="col-xs-12 btn btn-primary" style="font-size: 12px;" ng-show="login_dealer_id == dealer.id" ng-href="#!/user/dealer/edit/modify/{? (dealer.detail_id == null ? 'dealer' : 'store' )?}/{?dealer.id?}">
						@lang('lang.pr_item_edit')</a>
				</div>
			</div>
		</div>

		<div class="bg_white item out_border1 row" style="padding: 5px 10px; margin: 0px 10px;" ng-show="dealer.corp_info.name != null">
			<div class="col-xs-5 text-right">@lang('lang.corporation')</div>
			<div class="col-xs-6 col-xs-offset-1">{? dealer.corp_info.name ?}</div>
		</div>
		<div class="bg_white item out_border1 row" style="padding: 5px 10px; margin: 0px 10px;" ng-show="dealer.level != 0">
			<div class="col-xs-5 text-right">@lang('lang.level')</div>
			<div class="col-xs-6 col-xs-offset-1">
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
		<div class="bg_white item out_border1 row" style="padding: 5px 10px; margin: 0px 10px;">
			<div class="col-xs-5 text-right">@lang('lang.address')</div>
			<div class="col-xs-6 col-xs-offset-1">{? dealer.address ?}</div>
		</div>
		<div class="bg_white item out_border1 row" style="padding: 5px 10px; margin: 0px 10px;">
			<div class="col-xs-5 text-right">@lang('lang.contact')</div>
			<div class="col-xs-6 col-xs-offset-1">{? dealer.link ?}</div>
		</div>
		<div class="bg_white item out_border1 row" style="padding: 5px 10px; margin: 0px 10px;">
			<div class="col-xs-5 text-right">@lang('lang.person_charge')</div>
			<div class="col-xs-6 col-xs-offset-1">{? dealer.president.name ?}</div>
		</div>
		<div class="bg_white item out_border1 row" style="padding: 5px 10px; margin: 0px 10px;">
			<div class="col-xs-5 text-right">@lang('lang.dingding_account')</div>
			<div class="col-xs-6 col-xs-offset-1">{? dealer.dd_account ?}</div>
		</div>
	</div>

	<div class="info_panel bg_white" style="font-size: 12px;">
		<div class="item_my" style="padding: 10px 10px 5px 10px;">
			<div class="row info_header margin0" style="background-color: #eaffc5;">
				<div class="col-xs-9 label_sdiv" style="padding-top: 8px; font-size: 14px;">@lang('lang.label_staff')</div>
			</div>
		</div>
		<div class="bg_white item out_border1 row" ng-repeat="user in users" style="padding: 5px 10px; margin: 0px 10px;">
			<div class="col-xs-4 nopadding text-center">
				{? user.name ?}
			</div>
			<div class="col-xs-2 nopadding text-center">
				{? user.role.name ?}
			</div>
			<div class="col-xs-4 nopadding text-center">
				<i class="glyphicon glyphicon-phone" aria-hidden="true"></i>{?user.link?}
			</div>
			<div class="col-xs-2 nopadding text-center" ng-if="login_dealer_id == dealer.id">
				<a href="#!/user/staff/detail/{?user.id?}" class="user_view_btn">@lang('lang.ov_details')</a>
			</div>
		</div>
	</div>

	<div class="info_panel bg_white" style="font-size: 12px;" ng-show="dealer.detail_id == null && upper_dealer_id != dealer.id">
		<div class="item_my" style="padding: 10px 10px 5px 10px;">
			<div class="row info_header margin0" style="background-color: #eaffc5;">
				<div class="col-xs-7 label_sdiv" style="padding-top: 8px; font-size: 14px;">@lang('lang.label_dealer_information')</div>
				<div class="col-xs-5 text-right nopadding">
					<a class="col-xs-12 btn btn-primary" style="font-size: 12px;" ng-click="onChangeDealer(upper_dealer.id);" ng-show="upper_dealer != null && upper_dealer.level >= login_dealer_level">
						@lang('lang.label_up_dealer_information')</a>
				</div>
			</div>
		</div>

		<div class="bg_white item out_border1" ng-repeat="lower_dealer in lower_dealers" style="padding: 5px 10px; margin:5px 10px;">
			<div class="col-xs-4 nopadding">{? lower_dealer.name ?}</div>
			<div class="col-xs-6 nopadding">
				<div class="col-xs-12 nopadding">
					<div class="col-xs-5 nopadding text-right">@lang('lang.label_stock')</div>
					<div class="col-xs-7 nopadding text-center">{? lower_dealer.total_stock ?}</div>
				</div>
				<div class="col-xs-12 nopadding">
					<div class="col-xs-5 nopadding text-right">@lang('lang.sl_total_sale_amount')</div>
					<div class="col-xs-7 nopadding text-center">{? lower_dealer.total_sale ?}</div>
				</div>
				<div class="col-xs-12 nopadding" ng-if="login_dealer_id == 1">
					<div class="col-xs-5 nopadding text-right">@lang('lang.u_monthly_settlement_amount')</div>
					<div class="col-xs-7 nopadding text-center">{? lower_dealer.total_unbalance ?}</div>
				</div>
			</div>
			<div class="col-xs-2 nopadding text-center">
				<a  class="user_view_btn" ng-click="onChangeDealer(lower_dealer.id);">@lang('lang.info')</a>
				<div class="paddingtop15" ng-if="login_dealer_id == 1">
					<a class="user_view_btn" ng-class="{'bgyellow': lower_dealer.total_unbalance != 0}" ng-click="onBalance(lower_dealer.id)" ng-show="lower_dealer.total_unbalance != 0">
						{? "@lang('lang.u_unsettlement')" ?}
					</a>
					<a class="user_view_btn" ng-class="{'bggray': lower_dealer.total_unbalance == 0}" ng-show="lower_dealer.total_unbalance == 0">
						{? "@lang('lang.u_settled')" ?}
					</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	</div>

	<div class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog width90">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center paddingtop30">@lang('lang.u_import_dealerdata')</h4>
				</div>
				<div class="modal-footer">
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bg39f color_white width80">@lang('lang.u_btn_import')</button>
					</div>
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bg999 color_white width80" data-dismiss="modal">@lang('lang.cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
        login_dealer_id = '{{$login_dealer_id}}';
        login_dealer_level = '{{$login_dealer_level}}';
        upper_dealer_id = '{{$upper_dealer_id}}';
	</script>
</div>