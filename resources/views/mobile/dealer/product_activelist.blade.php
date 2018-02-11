<div class="subheader bg_white">
	<span class="item" ng-class="{'active': search.level1_type == ''}">
		<a ng-click="search_type1('')">@lang('lang.pr_item_all')</a>
	</span>
	<span class="item" ng-repeat="type1 in typelist1" ng-class="{active:search.level1_type==type1.id}"><a ng-click="search_type1(type1.id)">{?type1.description?}</a></span>
</div>
<div class="prod_content">

	<div class="col-xs-6 item" ng-repeat = "item in items">
		<a ng-href="#!/activation/view/{?item.id?}" class="display-block">
			<div class="col-xs-12 content">
				<div class="icon text-center">
					<img class="img-rounded" ng-src="{?item.image_url?}">
				</div>
				<div class="info">
					@lang('lang.no')： {?item.code?}
				</div>
				<div class="info">
					@lang('lang.define_name')： {?item.name?}
				</div>
			</div>
			<div class="clearfix"></div>
		</a>
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>