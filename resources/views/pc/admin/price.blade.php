<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_item_price')</h1>
		<small><a href="#!/overview" class="subtitle">< @lang('lang.label_back')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12" ng-show="loaded">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">@lang('lang.pr_list')</h3>
		</div>
		<div class="panel-body">
			<div class="col-xs-3">
				<select class="form-control" ng-options="item.id as item.description for item in typelist1" ng-model="search.level1_type" ng-change="search_change()">
				</select>
			</div>
			<div class="col-xs-3">
				<select class="form-control" ng-options="item.id as item.description for item in typelist2" ng-model="search.level2_type" ng-change="search_change()">
				</select>
			</div>
		</div>
		<div class="clearbodiv"></div>
		<div class="seperatorline"></div>
		<div class="panel-body">
			<div class="col-md-12 text-center" ng-show="no_data">
				<p>@lang('lang.str_no_data')</p>
			</div>
			<div ng-repeat="item in list_data.data">
				<div class="col-lg-4 col-sm-6 col-xs-8">
					<div class="panel panel-warning img-panel">
						<div class="panel-heading">
							<h3 class="panel-title">{?item.name?}</h3>
						</div>
						<div class="panel-body" style="background-color: #efefef">
							<img class="img-responsive img-thumbnail pull-right" ng-src="{?item.image_url?}">
							<div>
								<ul class="list-unstyled invoice-details padding-bottom-30 padding-top-10 text-dark">
									<li><strong>@lang('lang.ov_product_code'):</strong> {?item.code?}</li><br>
									<li><strong>@lang('lang.price_wholesale_price'):</strong> {?item.purchase_price_level[0]?}（@lang('lang.label_cn_cunit')）</li><br>
								</ul>
							</div>	
							<br>
							<div class="panel-btn">
								<a ng-href="#!price/edit/{?item.id?}" type="button" class="btn btn-info btn-sm" style="margin-top:10px">@lang('lang.price_pricing')</a>
								<a ng-href="#!price/discount/edit/{?item.id?}" type="button" class="btn btn-info btn-sm" style="margin-top:10px">@lang('lang.price_promotion_text')</a>
							</div>	
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix text-center" ng-show="list_data.total > 0">
		<span class="pageinfo">@lang('lang.di') {?list_data.from?} - {?list_data.to?} @lang('lang.tiao')，@lang('lang.total') {?list_data.total?} @lang('lang.tiao')</span>
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
	<div class="block"></div>	
</div>

<script src="{{url('')}}/js/control.js"></script>
