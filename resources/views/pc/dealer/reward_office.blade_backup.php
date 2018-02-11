	<div class="block">
		<div class="left">
			<span class="subtitle">@lang('lang.label_reward')</span>
		</div>
		<div class="right">
		</div>
		<div class="clearboth"></div>
		<div class="borderbottomblue bgwhite"></div>
	</div>
	<div class="codeblock">
		<div class="searchlayout paddingtop15" ng-show="isMonthly==1">
			<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart" placeholder="@lang('lang.start date')" ng-model="start_date" ng-change="onInputDate()" />
		</div>
		<div class="searchlayout paddingtop15">
			<input type="text" name="searchdateend" id="searchdateend" class="searchdateend" placeholder="@lang('lang.end date')" ng-model="end_date" ng-change="onInputDate()" />
		</div>
	</div>
	<div class="block">
		<div class="ordermenu">
			<a class="inlineblock stockmenu" ng-class="{'bgblue fontcolorwhite':status==0, 'bgwhite fontcolorblue':status!=0}" ng-click="onType(0)">@lang('lang.rew_reward_unissued')</a>
			<a class="inlineblock stockmenu borderblue" ng-class="{'bgblue fontcolorwhite':status==1, 'bgwhite fontcolorblue':status!=1}" ng-click="onType(1)">@lang('lang.rew_reward_issued')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30"></div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.sl_dealer_name')</th>
					<th>@lang('lang.name')</th>
					<th>@lang('lang.sl_sales_total')（@lang('lang.label_cn_cunit')）</th>
					<th>@lang('lang.rew_monthly_sales')（@lang('lang.label_cn_cunit')）</th>
					<th>@lang('lang.rew_amount')（@lang('lang.label_cn_cunit')）</th>
					<th ng-if="status==0">@lang('lang.rew_sales_total_amount')</th>
					<th ng-if="status==1">@lang('lang.rew_time')</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data">
					<td>{? item.dealer_name ?}</td>
					<td>{? item.user_name ?}</td>
					<td>{? item.total_sale ?}</td>
					<td>{? item.sale_month ?}</td>
					<td><span class="fontcolorred">{? item.redpacket_price ?}</span></td>
					<td ng-if="status==0">{? item.redpacket_rule ?}</td>
					<td ng-if="status==1">{? item.redpacket_date ?}<br>{? item.redpacket_time ?}</td>
				</tr>
				<tr ng-show="no_data">
					<td colspan="6">@lang('lang.str_no_data')</td>
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
	
	<script src="{{url('')}}/js/control.js"></script>