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
					<a href="#!sales/rank/product" class="inlineblock stockmenu bgblue fontcolorwhite">@lang('lang.sl_register_ranking')</a>
					<a href="#!sales/rank/income" class="inlineblock stockmenu bgwhite fontcolorblue">@lang('lang.sl_income_ranking')</a>
					<a href="#!sales/rank/dealer" class="inlineblock stockmenu bgwhite fontcolorblue borderblue">@lang('lang.sl_dealer_ranking')</a>
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
						<th>@lang('lang.pr_item_name')</th>
						<th>@lang('lang.ov_product_code')</th>
						<th>@lang('lang.sl_product_category')</th>
						<th>@lang('lang.label_order')（@lang('lang.label_card_unit')）</th>
						<th>@lang('lang.activation')</th>
						<th>@lang('lang.ov_register')</th>
						<th>@lang('lang.sl_expired')</th>
					</tr>
				</thead>
				<tbody>
					<!-- Card list by product id -->
					<tr ng-repeat="item in list_data.data">
						<td>{?item.product.name?}</td>
						<td>{?item.product.code?}</td>
						<td>{?item.product.level1_info.description?}</td>
						<td>{?item.total_count?}</td>
						<td>{?item.activation_count?}</td>
						<td>{?item.register_count?}</td>
						<td>{?item.expired_count?}</td>
					</tr>
					<tr ng-show="nodata">
						<td class="text-center" colspan="7">@lang('lang.str_no_data')</td>
					</tr>
				</tbody>
			</table>
			<div class="clearfix text-center" ng-show="list_data.total > 0">
				<span class="pageinfo">@lang('lang.di') {?list_data.from?} - {?list_data.to?} @lang('lang.tiao')， @lang('lang.total') {?list_data.total?} @lang('lang.tiao')</span>
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