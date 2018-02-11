<div class="subheader bg_white text-center">
	<div class="col-xs-6 text-center" ng-class="{'active':search.type==0}">
		<span class="item padding-lf-15" ng-click="onType(0)">@lang('lang.rew_reward_unissued')</span>
	</div>
	<div class="col-xs-6 text-center" ng-class="{'active':search.type==1}">
		<span class="item padding-lf-15" ng-click="onType(1)">@lang('lang.rew_reward_issued')</span>
	</div>
</div>
<div class="row nomargin marginbot10">
	<div class="col-xs-4 col-xs-offset-1 padding0 text-center">
		<input type="text" name="searchdatestart" id="searchdatestart" class="width70 searchdatestart" placeholder="@lang('lang.start date')" readonly ng-model="search.start_date"  ng-change="onInputDate()" />
	</div>
	<div class="col-xs-4 nopadding text-center">
		<input type="text" name="searchdateend" id="searchdateend" class="width70 searchdateend" placeholder="@lang('lang.end date')" readonly ng-model="search.end_date" ng-change="onInputDate()" />
	</div>
	<div class="col-xs-2 paddingtop5 text-left" ng-if="search.start_date != '' || search.end_date != ''">
		<a ng-click="date_srch_cancle()">
			<i class="glyphicon glyphicon-remove text-danger"></i>
		</a>
	</div>
</div>
<div class="reward_content">
	<div class="bg_white item" ng-repeat="item in items">
		<div class="col-xs-9 title">
			<p class="fontsize1_1 marginbot5">
				<i class="glyphicon glyphicon-info-sign text-info"></i> 
				{? item.dealer.name ?}
			</p>
			<p class="text-muted marginbot5">
				<i class="glyphicon glyphicon-user"></i> 
				{? item.user.name ?}
			</p>
			<p class="text-muted marginbot5">
				<i class="glyphicon glyphicon-gift text-danger"></i>
				{? item.red_packet_setting.redpacket_name ?} : 
				
				<span class="color_39f" ng-if="item.red_packet_setting.redpacket_type==0">
					{? item.red_packet_setting.redpacket_rule | floor ?}@lang('lang.label_cn_cunit')
				</span>
				<span class="color_39f" ng-if="item.red_packet_setting.redpacket_type==1">
					{? item.red_packet_setting.redpacket_rule | floor ?}@lang('lang.label_card_unit')
				</span> - 				
				<span class="text-danger">{? item.red_packet_setting.redpacket_price ?}@lang('lang.label_cn_cunit')</span>
			</p>
			<p class="color_39f text-right marginbot5">
				<!-- remain sales price/mount to receive -->
				<span ng-if="item.is_arrival==0">
					@lang('lang.rew_remain_redpacket_prefix')
					<span ng-if="item.red_packet_setting.redpacket_type==0">
						{? (item.red_packet_setting.redpacket_rule - item.sales_price) | floor ?}@lang('lang.label_cn_cunit')
					</span>
					<span ng-if="item.red_packet_setting.redpacket_type==1">
						{? (item.red_packet_setting.redpacket_rule - item.sales_count) | floor ?}@lang('lang.label_card_unit')
					</span>
					@lang('lang.rew_remain_redpacket_suffix')
					<br>
				</span>
				
				<span ng-if="item.red_packet_setting.redpacket_type==0">@lang('lang.sl_sales_total')：{? item.sales_price | floor ?}@lang('lang.label_cn_cunit')</span>
				<span ng-if="item.red_packet_setting.redpacket_type==1">@lang('lang.sl_sales_count')：{? item.sales_count ?}@lang('lang.label_card_unit')</span>
			</p>
		</div>
		<div class="col-xs-3 nopadding text-center more">
			<div ng-if="item.is_approval==0">
				<span class="display-inlineblock width90 text-muted text-left fontsize0_8">{? item.red_packet_setting.redpacket_start_date ?}~</span>
				<span class="display-inlineblock width90 text-muted text-left fontsize0_8">{? item.red_packet_setting.redpacket_end_date ?}</span>
				<article ng-if="item.is_arrival == 1">
					<a 
						class="btn display-inlineblock width80 color_white margintop10 paddingtop5 paddingbot5 bgf90" 
						ng-click="onRequireApply(item.id)"
						ng-if="item.is_proposal==0">
						@lang('lang.apply')
					</a>
					<span ng-if="item.is_approval==0&&item.is_proposal==1" class="text-bold text-danger">
						@lang('lang.aleady_apply')
					</span>
				</article>
				<article ng-if="item.is_arrival == 0">
					<span class="btn display-inlineblock width80 color_white margintop10 paddingtop5 paddingbot5 bg999">
						@lang('lang.rew_shortfall')
					</span>
				</article>
			</div>
			<div ng-if="item.is_approval" class="bg-info color_gray width90 border-radius3px">
				<span class="txt_bold text-danger">{? item.red_packet_setting.redpacket_price ?} @lang('lang.label_cn_cunit')</span><br>
				{? item.approval_at ?}<br>
				@lang('lang.aleady_send')
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
				<h4 class="modal-title">@lang('lang.sta_bonus_send')</h4>
			</div>
			<div class="modal-body">
				<p class="txt_bold">@lang('lang.rew_sales_bonus') {? sel_redpacket_price ?} @lang('lang.label_cn_cunit') @lang('lang.pur_invalid_prev2') {?sel_user_name?}({?sel_dealer_name?})， @lang('lang.rew_agree_bonus?')</p>
			</div>
			<div class="modal-footer">
				<div class="col-xs-6 nopadding text-center">
					<button type="button" class="btn bgf90 width80 color_white" ng-click="onOK()">@lang('lang.confirm')</button>
				</div>
				<div class="col-xs-6 nopadding text-center">
					<button type="button" class="btn bg999 width80 color_white" data-dismiss="modal">@lang('lang.cancel')</button>
				</div>
			</div>
		</div>
	</div>
</div>