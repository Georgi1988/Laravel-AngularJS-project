	<div class="block">
		<div class="left">
			<a href="#!/stock">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="block">
		<div class="left">
			<span class="subtitle">@lang('lang.pr_item_name')</span>
			<div class="marginleft30 margin-right30 searchlayout">
				{?other_info.product.name?}
			</div>
			<div class="searchlayout">
				<input type="search" class="stock_card_code" placeholder="@lang('lang.st_search')" ng-model="search.card_code_keyword" onsearch="angular.element(this).scope().search_card_code()">
			</div>
		</div>
		<div class="right">
			<a class="periodselected period" ng-click="search_card_type(1)" ng-class="{bgwhite:search.card_type!=1,fontcolorblue:search.card_type!=1,borderblue:search.card_type!=1}" >@lang('lang.st_physical_card')</a>	
			<a class="periodselected period" ng-click="search_card_type(0)" ng-class="{bgwhite:search.card_type!=0,fontcolorblue:search.card_type!=0,borderblue:search.card_type!=0}" >@lang('lang.st_virtual_card')</a>	
		</div>
		<div class="clearboth"></div>
		<hr class="borderbottomblue bgwhite" />
	</div>
	<div class="block">
		<div class="left">
			<div class="inlineblock stockmenu" ng-click="search_pagetype(1)" ng-class="{bgblue:search.page_type==1,fontcolorwhite:search.page_type==1,bgwhite:search.page_type!=1,fontcolorblue:search.page_type!=1}">@lang('lang.st_usabled')（{?other_info.p1_count?}）</div><div class="inlineblock stockmenu" ng-click="search_pagetype(2)" ng-class="{bgblue:search.page_type==2,fontcolorwhite:search.page_type==2,bgwhite:search.page_type!=2,fontcolorblue:search.page_type!=2}">@lang('lang.st_soon_disable')（{?other_info.p2_count?}）</div><div class="inlineblock stockmenu" ng-click="search_pagetype(3)" ng-class="{bgblue:search.page_type==3,fontcolorwhite:search.page_type==3,bgwhite:search.page_type!=3,fontcolorblue:search.page_type!=3}">@lang('lang.ov_expired')（{?other_info.p3_count?}）</div><div class="inlineblock stockmenu" ng-click="search_pagetype(5)" ng-class="{bgblue:search.page_type==5,fontcolorwhite:search.page_type==5,bgwhite:search.page_type!=5,fontcolorblue:search.page_type!=5}">@lang('lang.st_already_actived')（{?other_info.p5_count?}）</div><div class="inlineblock stockmenu borderblue"  ng-click="search_pagetype(4)" ng-class="{bgblue:search.page_type==4,fontcolorwhite:search.page_type==4,bgwhite:search.page_type!=4,fontcolorblue:search.page_type!=4}">@lang('lang.od_order_sold')（{?other_info.p4_count?}）</div> 
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.u_servicecard_id')</th>
					<th>@lang('lang.pr_item_name') <a href="#"><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
					<th>@lang('lang.ov_product_code')</th>
					<th>@lang('lang.label_dealer') <a href="#"><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
					<th>@lang('lang.ov_sales_store') <a href="#"><img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
					<th>@lang('lang.state')</th>
					<th>&nbsp;</th>
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
						<span ng-show="item.expired==0&&item.status==0">@lang('lang.st_notyet_actived')</span>
						<span ng-show="item.expired==0&&item.status==1">@lang('lang.st_already_actived')</span>
						<span ng-show="item.expired==0&&item.status==2">@lang('lang.st_already_saled')</span>
						<span ng-show="item.expired==1">@lang('lang.st_already_expired')</span>
					</td>
					<td><a href="#!stock/view/{?item.id?}" class="stockservicebtn stockservicedownload">@lang('lang.ov_details')</a></td>
				</tr>
				<tr ng-show="nodata">
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
	<!-- dialog html -->
	<div id="stockcard" class="message-dlg" title="@lang('lang.ov_bulk_import_machine_code')">
		<div class="block"></div>
		<div class="block width85">
		</div>
		<form id="download_form" ng-submit="submit_stockdownload()" method="POST" enctype="multipart/form-data">
		<div class="block width85">
			<label>@lang('lang.email') : <input type="text" name="" ng-model="sendemail" required /></label>
			<p class="lineheight200"><span class="fontcolorred paddingleft50">@lang('lang.st_emailsend_note')</span></p>
		</div>
		<div class="block textcenter">
			<input type="submit" class="importbtn ui-button" value="@lang('lang.st_download_servicecard')" />
		</div>
		<div class="block"></div>
	</div>
	<script src="{{url('')}}/js/control.js"></script>