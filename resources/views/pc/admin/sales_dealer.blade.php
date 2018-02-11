<div class="page-title clearfix">
<div class="pull-left">
	<h1>@lang('lang.label_sale_amount')</h1>
</div>
</div>

<div class="conter-wrapper col-md-12">
<div class="panel panel-primary">
	<div class="panel-body">
		<div class="block">
			<div class="left ordermenu">
				<a href="#!sales/rank/product" class="inlineblock stockmenu bgwhite fontcolorblue borderblue">@lang('lang.sl_register_ranking')</a>
				<a href="#!sales/rank/income" class="inlineblock stockmenu bgwhite fontcolorblue">@lang('lang.sl_income_ranking')</a>
				<a href="#!sales/rank/dealer" class="inlineblock stockmenu bgblue fontcolorwhite">@lang('lang.sl_dealer_ranking')</a>
			</div>
			<div class="right">
				<div class="left searchlayout paddingtop15">
					<input type="text" name="searchdatestart" id="searchdatestart" class="searchdatestart width120p" placeholder="@lang('lang.start date')" ng-model="search.start_date" ng-change="search_date()" readonly />
				</div>
				<div class="left searchlayout paddingtop15">
					<input type="text" name="searchdateend" id="searchdateend" class="searchdateend width120p" placeholder="@lang('lang.end date')" ng-model="search.end_date" ng-change="search_date()" readonly />
				</div>
				<div class="left marginleft30 paddingtop13">
					<a type="button" class="btn btn-info btn-sm weekpicker" ng-class="{periodselected:search.type==1}">@lang('lang.week')</a>
					<a type="button" class="btn btn-info btn-sm  monthpicker" ng-class="{periodselected:search.type==2}">@lang('lang.month')</a>
					<a type="button" class="btn btn-info btn-sm  quaterpicker" ng-class="{periodselected:search.type==3}">@lang('lang.season')</a>
					<a type="button" class="btn btn-info btn-sm  yearpicker" ng-class="{periodselected:search.type==4}">@lang('lang.year')</a>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
	</div>

	<div class="clearboth"></div>
	<div class="seperatorline"></div>
	
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
					<tr>
						<th>@lang('lang.sl_dealer_name')</th>
						<th>@lang('lang.u_office_level')</th>
						<th>@lang('lang.sl_sales_total')（@lang('lang.label_cn_cunit')）</th>
						<th>@lang('lang.label_stock')（@lang('lang.label_card_unit')）</th>
						<th>@lang('lang.sl_selling_best')</th>
					</tr>
				</thead>
				<tbody>
					<!-- Card list by product id -->
					<tr ng-repeat="item in list_data.data">
						<td>{?item.dealer.name?}</td>
						<td>
							<span ng-show='item.dealer.level==1'>@lang('lang.1st_level_dealer')</span>
							<span ng-show='item.dealer.level==2'>@lang('lang.2nd_level_dealer')</span>
							<span ng-show='item.dealer.level==3'>@lang('lang.3rd_level_dealer')</span>
							<span ng-show='item.dealer.level==4'>@lang('lang.4th_level_dealer')</span>
							<span ng-show='item.dealer.level==5'>@lang('lang.5th_level_dealer')</span>
							<span ng-show='item.dealer.level==6'>@lang('lang.6th_level_dealer')</span>
							<span ng-show='item.dealer.level==7'>@lang('lang.7th_level_dealer')</span>
							<span ng-show='item.dealer.level==8'>@lang('lang.8th_level_dealer')</span>
							<span ng-show='item.dealer.level==9'>@lang('lang.9th_level_dealer')</span>
							<span ng-show='item.dealer.level==10'>@lang('lang.10th_level_dealer')</span>
							<span ng-show='item.dealer.level==11'>@lang('lang.11th_level_dealer')</span>
							<span ng-show='item.dealer.level==12'>@lang('lang.12th_level_dealer')</span>
							<span ng-show='item.dealer.level==13'>@lang('lang.13th_level_dealer')</span>
							<span ng-show='item.dealer.level==14'>@lang('lang.14th_level_dealer')</span>
							<span ng-show='item.dealer.level==15'>@lang('lang.15th_level_dealer')</span>
							<span ng-show='item.dealer.level==16'>@lang('lang.16th_level_dealer')</span>
							<span ng-show='item.dealer.level==17'>@lang('lang.17th_level_dealer')</span>
							<span ng-show='item.dealer.level==18'>@lang('lang.18th_level_dealer')</span>
							<span ng-show='item.dealer.level==19'>@lang('lang.19th_level_dealer')</span>
							<span ng-show='item.dealer.level==20'>@lang('lang.20th_level_dealer')</span>
						</td>
						<td>{?item.total_sale_price | floor?}</td>
						<td>{?item.total_stock?}</td>
						<td>{?item.top_saled_product.name?}</td>
					</tr>
					<tr ng-show="nodata">
						<td class="text-center" colspan="5">@lang('lang.str_no_data')</td>
					</tr>
				</tbody>
			</table>
			<div class="clearfix text-center" ng-show="list_data.total > 0">
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
	</div>
</div>
	
<script src="{{url('')}}/js/control.js"></script>