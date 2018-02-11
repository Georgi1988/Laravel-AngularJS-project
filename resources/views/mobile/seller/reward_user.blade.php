<div class="subheader bg_white text-center">
	<span class="item">@lang('lang.rew_still_remain') {? (available.redpacket_rule - available.sale_month) >= 0 ? (available.redpacket_rule - available.sale_month) : '0' ?} @lang('lang.label_cn_cunit') @lang('lang.rew_receive_next_award')</span>
</div>
<div class="reward_content">
	<div class="bg_white item">
		<div class="col-xs-2 nopadding text-right">
			<img class="img-rounded width80" src="images/hongbao.png">
		</div>
		<div class="col-xs-7 padding-lf-7 title">
			<p class="txt_bold fontsize1_1">@lang('lang.rew_red_packet') {? available.redpacket_price ?} @lang('lang.label_cn_cunit')</p>
			<p class="text-muted">@lang('lang.complete') {? available.redpacket_rule ?}<span>@lang('lang.rew_sales_to_receive')</span></p>
		</div>
		<div class="col-xs-3 padding-lf-7 nopadding text-center more" ng-if="available.redpacket_rule <= available.sale_month">
			<a class="display-block width100 color_white margintop10 paddingtop5 paddingbot5 bgf90">@lang('lang.rew_receive')</a>
		</div>
		<div class="col-xs-3 padding-lf-7 text-center more" ng-if="available.redpacket_rule > available.sale_month">
			<a class="display-block width100 color_white margintop10 paddingtop5 paddingbot5 bg999">@lang('lang.rew_shortfall')</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="bg_white item" ng-repeat="item in items">
		<div class="col-xs-2 nopadding text-right">
			<img class="img-rounded width80" src="images/hongbao.png">
		</div>
		<div class="col-xs-7 padding-lf-7 title">
			<p class="txt_bold fontsize1_1">@lang('lang.rew_red_packet') {? item.redpacket_price ?} @lang('lang.label_cn_cunit')</p>
			<p class="text-muted">@lang('lang.complete') {? item.redpacket_rule ?}<span>@lang('lang.rew_sales_to_receive')</span></p>
		</div>
		<div class="col-xs-3 padding-lf-7 nopadding text-center more">
			<a class="display-block width100 color_white margintop10 paddingtop5 paddingbot5 bg090">@lang('lang.rew_received')</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>