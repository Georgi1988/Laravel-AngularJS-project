	<div class="block">
		<div class="left">
			<span class="subtitle">@lang('lang.label_sale_amount')</span>
		</div>
		<div class="clearboth"></div>
		<div class="borderbottomblue bgwhite"></div>
	</div>
	<div class="block">
		<div class="left ordermenu">
			<a href="#!sales/rank/product" class="inlineblock stockmenu bgwhite fontcolorblue">@lang('lang.sl_register_ranking')</a><a href="#!sales/rank/income" class="inlineblock stockmenu bgwhite fontcolorblue">@lang('lang.sl_income_ranking')</a><a href="#!sales/rank/sale" class="inlineblock stockmenu bgblue fontcolorwhite borderblue">@lang('lang.sl_seller_ranking')</a>
		</div>
		<div class="right paddingtop15">
			<div class="searchlayout">
				<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart width120p" placeholder="@lang('lang.start date')" ng-model="search.start_date" ng-change="search_date()" readonly />
			</div>
			<div class="searchlayout">
				<input type="text" name="searchdateend" id="searchdateend" class="searchdateend width120p" placeholder="@lang('lang.end date')" ng-model="search.end_date" ng-change="search_date()" readonly />
			</div>
			<div class="left marginleft30">
				<a class="period weekpicker" ng-class="{periodselected:search.type==1}">@lang('lang.week')</a>
				<a class="period monthpicker" ng-class="{periodselected:search.type==2}">@lang('lang.month')</a>
				<a class="period quaterpicker" ng-class="{periodselected:search.type==3}">@lang('lang.season')</a>
				<a class="period yearpicker" ng-class="{periodselected:search.type==4}">@lang('lang.year')</a>
			</div>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30"></div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.sl_salesperson_name')</th>
					<th>@lang('lang.sl_owned_stores')</th>
					<th>@lang('lang.sl_sales_total')（@lang('lang.label_cn_cunit')）</th>
					<th>@lang('lang.sl_volume')（@lang('lang.label_card_unit')）</th>
					<th>@lang('lang.sl_selling_best')</th>
				</tr>
			</thead>
			<tbody>
				<!-- Seller list -->
				<tr ng-repeat="item in list_data.data">
					<td>{?item.seller.name?}</td>
					<td>{?item.seller.dealer.name?}</td>
					<td>{?item.total_sale_price?}</td>
					<td>{?item.sale_count?}</td>
					<td>{?item.top_saled_product.name?}</td>
				</tr>
				<tr ng-show="nodata">
					<td colspan="5">@lang('lang.str_no_data')</td>
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