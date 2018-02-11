	<div class="block">
		<div class="left">
			<span class="subtitle">@lang('lang.pr_list')</span>

			<div class="block">
				<div class="searchlayout  paddingtop15">
					<select class="text_sketch" ng-options="item.id as item.description for item in typelist1" ng-model="search.level1_type" ng-change="search_change()">
					</select>
				</div>
				<div class="searchlayout  paddingtop15">
					<select class="text_sketch" ng-options="item.id as item.description for item in typelist2" ng-model="search.level2_type" ng-change="search_change()">
					</select>
				</div>
			</div>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30 paddingbot15">
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>@lang('lang.pr_item_name')</th>
					<th>@lang('lang.ov_product_code')</th>
					<th>@lang('lang.pr_item_kind')</th>
					<th>@lang('lang.state')</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data" ng-class="{sub_badge:item.badge == 1}" class="product_item">
					<td><a href="#!product/view/{?item.id?}"><img class="productthumb" ng-src="{?item.image_url?}" ></a></td>
					<td>{?item.name?}</td>
					<td>{?item.code?}</td>
					<td>{?item.typestr_level1?}-{?item.typestr_level2?}</td>
					<td>
						<span ng-if="item.status">@lang('lang.use_on')</span>
						<span ng-if="!item.status">@lang('lang.use_off')</span>
					</td>
					<td><a href="#!product/view/{?item.id?}" class="stockservicebtn stockservicedownload paddingside20">@lang('lang.pr_view')</a></td>
				</tr>
				<tr ng-show="no_data">
					<td colspan="6">@lang('lang.str_no_data')</td>
				</tr>
			</tbody>
		</table>
		<div class="pagenav_block" ng-show="list_data.total > 0">
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
	<div class="block"></div>
	
	<script src="{{url('')}}/js/control.js"></script>