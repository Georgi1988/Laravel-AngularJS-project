<div class="price_v_content">
	<div class="list">
		<div class="col-xs-12 item padding0 margintop15" ng-repeat="item in items">
			<div class="col-xs-12 margintop10">
				<div class="col-xs-6 text-left">
					@lang('lang.rew_red_packet_name'): 
				</div>
				<div class="col-xs-6 text-left">
					{? item.redpacket_name ?}
				</div>
			</div>
			<div class="col-xs-12 margintop10">
				<div class="col-xs-6 text-left">
					@lang('lang.rew_apply_target'):
				</div>
				<div class="col-xs-6 text-left">
					{? item.dealer_name ?}
				</div>
			</div>
			<div class="col-xs-12 margintop10">
				<div class="col-xs-6 text-left">
					{? item.redpacket_type==1 ? "@lang('lang.rew_red_allow_count')：" : "@lang('lang.rew_red_allow_amount')：" ?}
				</div>
				<div class="col-xs-6 text-left">
					{? item.redpacket_rule ?} {? item.redpacket_type==1 ? "@lang('lang.label_card_unit') (" + item.product_name + ")" : "@lang('lang.label_cn_cunit')" ?}
				</div>
			</div>
			<div class="col-xs-12 margintop10">
				<div class="col-xs-12 text-left">
					{? item.redpacket_start_date ?} --- {? item.redpacket_end_date ?}
				</div>
			</div>
			<div class="col-xs-12 margintop10">
				<div class="col-xs-6 text-left color_blue txt_bold">
					@lang('lang.rew_amount'): {? item.redpacket_price ?} @lang('lang.label_cn_cunit')
				</div>
				<div class="col-xs-6 text-left">
					<button type="button" class="btn btn-default btn-sm" ng-click="onEdit(item)">@lang('lang.price_edit')</button>
					<button type="button" class="btn btn-default btn-sm" ng-click="onRemove(item.id)">@lang('lang.price_remove')</button>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	</div>
</div>