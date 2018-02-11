	<div class="block">
		<span class="subtitle">@lang('lang.label_reward')</span>
	</div>
	<div class="block">
		<div class="left">
			<a class="inlineblock stockmenu" ng-class="{'bgblue fontcolorwhite':search.type==0, 'bgwhite fontcolorblue':search.type!=0}" ng-click="onType(0)">@lang('lang.rew_reward_unissued')</a>
			<a class="inlineblock stockmenu borderblue" ng-class="{'bgblue fontcolorwhite':search.type==1, 'bgwhite fontcolorblue':search.type!=1}" ng-click="onType(1)">@lang('lang.rew_reward_issued')</a>
		</div>
		<div class="right">
			<div class="searchlayout paddingtop15">
				<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart" placeholder="@lang('lang.start date')" ng-model="search.start_date" ng-change="onInputDate()" />
			</div>
			<div class="searchlayout paddingtop15">
				<input type="text" name="searchdateend" id="searchdateend" class="searchdateend" placeholder="@lang('lang.end date')" ng-model="search.end_date" ng-change="onInputDate()" />
			</div>
			<div style="height: 25px; width: 25px; padding-top: 20px;" ng-if="search.start_date != '' || search.end_date != ''">
				<a ng-click="date_srch_cancle()">
					<i class="glyphicon glyphicon-remove text-danger"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="block backgroundwhite paddingtop30">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.rew_red_packet_name')</th>
					<th>@lang('lang.rew_red_packet_period')</th>
					<th>@lang('lang.rew_red_packet_rule')</th>
					<th>@lang('lang.price_seller')</th>
					<th>@lang('lang.u_retail_stores')</th>
					<th>@lang('lang.rew_sales_label')</th>
					<th>@lang('lang.rew_sales_bonus_price')</th>
					<th ng-if="search.type==0"></th>
					<th ng-if="search.type==1">@lang('lang.rew_time')</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data">
					<td>{? item.red_packet_setting.redpacket_name ?}</td>
					<td>{? item.red_packet_setting.redpacket_start_date + ' ~ ' + item.red_packet_setting.redpacket_end_date ?}</td>
					<td>
						{? item.red_packet_setting.redpacket_rule ?}
						<span ng-if="item.red_packet_setting.redpacket_type==0">@lang('lang.label_cn_cunit')</span>
						<span ng-if="item.red_packet_setting.redpacket_type==1">@lang('lang.label_card_unit')</span>
					</td>
					<td>
						{? item.user.name ?}
					</td>
					<td>{? item.dealer.name ?}</td>
					<td>
						<span ng-if="item.red_packet_setting.redpacket_type==0">{? item.sales_price | floor ?}@lang('lang.label_cn_cunit')</span>
						<span ng-if="item.red_packet_setting.redpacket_type==1">{? item.sales_count ?}@lang('lang.label_card_unit')</span>
					</td>
					<td><span class="fontcolorred">{? item.red_packet_setting.redpacket_price ?}@lang('lang.label_cn_cunit')</span></td>
					<td ng-if="search.type==0">
						<a class="stockservicebtn stockservicedownload bgyellow" 
							ng-click="onRequireApply(item.id)"
							ng-if="item.is_proposal==0">
							@lang('lang.apply')
						</a>
						<span ng-if="item.is_approval==0&&item.is_proposal==1" class="text-bold text-danger">
							@lang('lang.aleady_apply')
						</span>
					</td>
					<td ng-if="search.type==1">
						{? item.approval_at ?}
					</td>
				</tr>
				<tr ng-show="no_data">
					<td colspan="9">@lang('lang.str_no_data')</td>
				</tr>
			</tbody>
		</table>
		<div class="pagenav_block" ng-show="list_data.total > 0">
			<span class="pageinfo">@lang('lang.di'){?list_data.from?}-{?list_data.to?}@lang('lang.tiao')， @lang('lang.total') {?list_data.total?}@lang('lang.tiao')</span>
			<ul class="pagination">
				<li ng-class="{disabled:pagenation.currentPage === 1}">
                    <a ng-click="setPage(1)">&lt;&lt;</a>
                </li>
                <li ng-class="{disabled:pagenation.currentPage === 1}">
                    <a ng-click="setPage(pagenation.currentPage - 1)">&lt;</a>
                </li>
                <li ng-repeat="page in pagenation.pages" ng-class="{active:pagenation.currentPage === page}">
                    <a ng-click="setPage(page)">{?page?}</a>
                </li>                
                <li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
                    <a ng-click="setPage(pagenation.currentPage + 1)">&gt;</a>
                </li>
                <li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
                    <a ng-click="setPage(pagenation.totalPages)">&gt;&gt;</a>
                </li>
			</ul>
		</div>
	</div>
	<div class="block"></div>
	<!-- dialog html -->
	<div id="redpacket_set" class="message-dlg" title="@lang('lang.sta_bonus_send')">
		<div class="block"></div>
		<div class="block width85">
			<p class="textcenter fontcolor777 fontsize1p1 lineheight240">@lang('lang.rew_sales_bonus') {? sel_redpacket_price ?} @lang('lang.label_cn_cunit') @lang('lang.pur_invalid_prev2') {?sel_user_name?}({?sel_dealer_name?})， @lang('lang.rew_agree_bonus?')</p>
		</div>
		<div class="block textcenter">
			<button class="generalbtn productcategeditbtn ui-button" ng-click="onOK()">@lang('lang.confirm')</button>
			<button class="cancelbtn ui-button" ng-click="onCancel()">@lang('lang.cancel')</button>
		</div>
		<div class="block"></div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>