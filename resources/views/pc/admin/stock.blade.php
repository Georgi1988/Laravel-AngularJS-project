<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_item_stock')</h1>
		<small><a href="#!/stock" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="block">
				<div class="searchlayout">
					<input type="search" class="form-control stock_card_code" placeholder="@lang('lang.st_search')" ng-model="search.card_code_keyword" onsearch="angular.element(this).scope().search_card_code()">
				</div>
			</div>
			<div class="block">
				<div class="left">
					<div class="inlineblock stockmenu" ng-click="search_pagetype(1)" ng-class="{bgblue:search.page_type==1,fontcolorwhite:search.page_type==1,bgwhite:search.page_type!=1,fontcolorblue:search.page_type!=1}">@lang('lang.st_usabled')（{?other_info.p1_count?}) </div>
					<div class="inlineblock stockmenu" ng-click="search_pagetype(2)" ng-class="{bgblue:search.page_type==2,fontcolorwhite:search.page_type==2,bgwhite:search.page_type!=2,fontcolorblue:search.page_type!=2}">@lang('lang.st_soon_disable')（{?other_info.p2_count?}）</div>
					<div class="inlineblock stockmenu" ng-click="search_pagetype(3)" ng-class="{bgblue:search.page_type==3,fontcolorwhite:search.page_type==3,bgwhite:search.page_type!=3,fontcolorblue:search.page_type!=3}">@lang('lang.ov_expired')（{?other_info.p3_count?}）</div>
					<div class="inlineblock stockmenu" ng-click="search_pagetype(5)" ng-class="{bgblue:search.page_type==5,fontcolorwhite:search.page_type==5,bgwhite:search.page_type!=5,fontcolorblue:search.page_type!=5}">@lang('lang.st_already_actived')（{?other_info.p5_count?}）</div>
					<div class="inlineblock stockmenu"  ng-click="search_pagetype(4)" ng-class="{bgblue:search.page_type==4,fontcolorwhite:search.page_type==4,bgwhite:search.page_type!=4,fontcolorblue:search.page_type!=4}">@lang('lang.od_order_sold')（{?other_info.p4_count?}）</div>
				</div>
				<div class="right">
					<div class="inlineblock stockmenu" ng-click="search_card_type(1)" ng-class="{bgblue:search.card_type==1,fontcolorwhite:search.card_type==1,bgwhite:search.card_type!=1,fontcolorblue:search.card_type!=1}">@lang('lang.st_physical_card')</div>
					<div class="inlineblock stockmenu" ng-click="search_card_type(0)" ng-class="{bgblue:search.card_type==0,fontcolorwhite:search.card_type==0,bgwhite:search.card_type!=0,fontcolorblue:search.card_type!=0}">@lang('lang.st_virtual_card')</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">{?other_info.product.name?}</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>@lang('lang.u_servicecard_id')</th>
						<th>@lang('lang.pr_item_name') <a href="#"><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
						<th>@lang('lang.ov_product_code')</th>
						<th>@lang('lang.label_dealer') <a href="#"><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
						<th>@lang('lang.ov_sales_store') <a href="#"><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
						<th>@lang('lang.state')</th>
						<th>@lang('lang.label_table_action')</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in list_data.data">
						<td>{?item.code?}</td>
						<td>{?item.product.name?}</td>
						<td>{?item.product.code?}</td>
						<td>{?item.dealer.name?}</td>
						<td>{?item.dealer.name?}</td>
						<td>
							<span ng-show="item.expired==0 && item.status==0">@lang('lang.st_notyet_actived')</span>
							<span ng-show="item.expired==0 && item.status==1">@lang('lang.st_already_actived')</span>
							<span ng-show="item.expired==0 && item.status==2">@lang('lang.st_already_saled')</span>
							<span ng-show="item.expired==1">@lang('lang.st_already_expired')</span>
						</td>
						<td>
							<a type="button" href="#!stock/view/{?item.id?}" class="btn btn-info btn-xs stockservicedownload">@lang('lang.ov_details')</a>
						</td>
					</tr>
					<tr ng-show="nodata">
						<td class="text-center" colspan="7">@lang('lang.str_no_data')</td>
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