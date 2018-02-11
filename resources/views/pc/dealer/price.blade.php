	<div class="block">
		<span class="subtitle">@lang('lang.pr_item_price')</span>
	</div>
	<div class="block">
		<div class="paddingtop15">
			<div class="searchlayout">
				<select class="text_sketch" ng-options="item.id as item.description for item in typelist1" ng-model="search.level1_type" ng-change="search_change()">
				</select>
			</div>
			<div class="searchlayout">
				<select class="text_sketch" ng-options="item.id as item.description for item in typelist2" ng-model="search.level2_type" ng-change="search_change()">
				</select>
			</div>
			<div class="clearboth"></div>
		</div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30 paddingbot15">
	</div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>@lang('lang.pr_item_name')</th>
					<th>@lang('lang.ov_product_code')</th>
					<th>@lang('lang.price_wholesale_price')（@lang('lang.label_cn_cunit')）</th>
					<th>@lang('lang.price_promotional_discount')</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data">
					<td>
						<a ng-href="#!price/view/{?item.id?}">
							<img class="productthumb" ng-src="{?item.image_url?}">
						</a>
					</td>
					<td>{?item.name?}</td>
					<td>{?item.code?}</td>
					<td>{?item.wholesale_price?}</td>
					<td>{?item.promotion_price===null ? '无' : (item.promotion_price).toString() + '%'?}</td>
				</tr>
				<tr ng-if="no_data">
					<td colspan="5">@lang('lang.str_no_data')</td>
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