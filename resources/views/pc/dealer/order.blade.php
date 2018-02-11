	<div class="block">
		<span class="subtitle">@lang('lang.label_order')</span>
	</div>
	<!--<div class="block">
		<div class="searchlayout paddingtop15">
			<input type="search" name="keyword" placeholder="@lang('lang.od_search_name')" onsearch="angular.element(this).scope().search_keyword(this)" />
		</div>
		<div class="clearboth"></div>
		<div class="borderbottomblue bgwhite"></div>
	</div>-->
	<div class="block">
		<div class="left ordermenu">
			<a class="inlineblock stockmenu" ng-click="search_type(1)" ng-class="{bgblue:search.type === 1,fontcolorwhite:search.type === 1,bgwhite:search.type !== 1,fontcolorblue:search.type !== 1}">
				@lang('lang.od_order_pending')
			</a><a class="inlineblock stockmenu" ng-click="search_type(2)" ng-class="{bgblue:search.type === 2,fontcolorwhite:search.type === 2,bgwhite:search.type !== 2,fontcolorblue:search.type !== 2}">
				@lang('lang.od_order_sold')
			</a><a class="inlineblock stockmenu" ng-click="search_type(3)" ng-class="{bgblue:search.type === 3,fontcolorwhite:search.type === 3,bgwhite:search.type !== 3,fontcolorblue:search.type !== 3}">
				@lang('lang.od_order_returned')
			</a><a class="inlineblock stockmenu borderblue" ng-click="search_type(4)" ng-class="{bgblue:search.type === 4,fontcolorwhite:search.type === 4,bgwhite:search.type !== 4,fontcolorblue:search.type !== 4}">
				@lang('lang.od_myorder')
			</a>
		</div>
		<div class="right searchlayout paddingtop15">
			<input type="search" name="keyword" ng-model="search.keyword" placeholder="@lang('lang.od_search_name')" onsearch="angular.element(this).scope().search_keyword(this)" />
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30"></div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.od_order_no')</th>
					<th>@lang('lang.od_product')</th>
					<th>@lang('lang.gen_mcard_type')</th>
					<th>@lang('lang.od_quantity')</th>
					<th>@lang('lang.sta_dealer_name')</th>
					<th ng-show="search.type==1">@lang('lang.od_status')</th>
					<th ng-show="search.type==2">@lang('lang.od_effective_time')</th>
					<th ng-show="search.type==3">@lang('lang.od_return_success_time')</th>
					<th ng-show="search.type==4">@lang('lang.od_status')</th>
					<th>@lang('lang.od_agree_status')</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data" ng-class="{sub_badge:item.badge == 1}">
					<td>{?item.code?}</td>
					<td>{?item.product.name?} <span class="color-gray" ng-show="item.product_count > 1">  @lang('lang.others') {?item.product_count - 1?}@lang('lang.item_count')</span></td>
					<td>
						<span ng-if="item.card_type==0&&item.card_subtype==1">@lang('lang.st_virtual_sp_card')</span>
						<span ng-if="item.card_type==0&&item.card_subtype==0">@lang('lang.st_virtual_card')</span>
						<span ng-if="item.card_type==1">@lang('lang.st_physical_card')</span>
					</td>
					<td>{?item.order_count?}</td>
					<td>{?item.src_dealer.name?}</td>
					<td ng-show="(search.type==1 || search.type==4)&&item.status==0"><strong class="fontcolornavyblue">进货</strong></td>
					<td ng-show="(search.type==1 || search.type==4)&&item.status==1"><strong class="fontcolorgreen">退货</strong></td>
					<td ng-show="search.type==2">{?item.valid_period?}</td>
					<td ng-show="search.type==3">{?item.updated_at?}</td>
					<td ng-show="item.agree==0"><strong class="fontcolornavyblue">@lang('lang.od_pending_approval')</strong></td>
					<td ng-show="item.agree==1"><strong class="fontcolorgreen">@lang('lang.od_agree')</strong></td>
					<td ng-show="item.agree==2"><strong class="fontcolorgray">@lang('lang.od_refusal')</strong></td>
					<td><a href="#!order/view/{?item.id?}" class="stockservicebtn stockservicedownload">@lang('lang.ov_details')</a></td>
				</tr>
				<tr ng-show="no_data">
					<td colspan="7">@lang('lang.str_no_data')</td>
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