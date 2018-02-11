<div class="subheader bg_white text-center">
	<div class="col-xs-6 text-center">
		<span class="item padding-lf-15" ng-class="{'active':status==0}" ng-click="onType(0)">@lang('lang.rew_reward_unissued')</span>
	</div>
	<div class="col-xs-6 text-center">
		<span class="item padding-lf-15" ng-class="{'active':status==1}" ng-click="onType(1)">@lang('lang.rew_reward_issued')</span>
	</div>
</div>
<div class="row marginbot10">
	<div class="col-xs-6 text-center" ng-show="isMonthly==1">
		<input type="text" name="searchdatestart" id="searchdatestart" class="width60 searchdatestart width120p" placeholder="@lang('lang.start date')" readonly ng-model="start_date" ng-change="onInputDate()" />
	</div>
	<div class="col-xs-6 text-center">
		<input type="text" name="searchdateend" id="searchdateend" class="width60 searchdateend width120p" placeholder="@lang('lang.end date')" readonly ng-model="end_date" ng-change="onInputDate()" />
	</div>
</div>
<div class="reward_content" ng-if="status==0">
	<div class="bg_white item" ng-repeat="item in items">
		<div class="col-xs-2 nopadding text-right">
			<img class="img-rounded width80" src="images/hongbao.png">
		</div>
		<div class="col-xs-7 title">
			<p class="fontsize1_1 marginbot5">{? item.dealer_name ?}</p>
			<p class="text-muted marginbot5">{? item.user_name ?}</p>
			<p class="txt_bold color_39f margin0">@lang('lang.sl_sales_total')：{? item.total_sale ?} @lang('lang.label_cn_cunit')</p>
		</div>
		<div class="col-xs-3 nopadding text-center more">
			<a class="display-block width100 color_white margintop10 paddingtop5 paddingbot5 bgf90">{? item.redpacket_price ?} @lang('lang.label_cn_cunit')</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>

<div class="reward_content" ng-if="status==1">
	<div class="bg_white item" ng-repeat="item in items">
		<div class="col-xs-2 nopadding text-right">
			<img class="img-rounded width80" src="images/hongbao.png">
		</div>
		<div class="col-xs-7 title">
			<p class="fontsize1_1 marginbot5">{? item.dealer_name ?}</p>
			<p class="text-muted marginbot5">{? item.user_name ?}</p>
			<p class="txt_bold color_39f margin0">@lang('lang.sl_sales_total')：{? item.total_sale ?} @lang('lang.label_cn_cunit')</p>
		</div>
		<div class="col-xs-3 nopadding text-center more">
			<a class="display-block width100 color_white margintop10 paddingtop5 paddingbot5 txt_bold color_39f">{? item.redpacket_price ?} @lang('lang.label_cn_cunit')</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>
