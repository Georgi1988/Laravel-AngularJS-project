<!-- <div class="subheader bg5ac8fa"> -->
<div class="subheader bg_white">
	<span class="item" ng-class="{active:search.type === 1}"><a ng-click="search_type(1)">@lang('lang.od_order_pending')</a></span>
	<span class="item" ng-class="{active:search.type === 2}"><a ng-click="search_type(2)">@lang('lang.od_order_sold')</a></span>
	<span class="item" ng-class="{active:search.type === 3}"><a ng-click="search_type(3)">@lang('lang.od_order_returned')</a></span>
	<span class="item" ng-class="{active:search.type === 5}"><a ng-click="search_type(5)">@lang('lang.all')</a></span>
</div>
<div class="order_content">
	<div class="bg_white item out_border1" ng-repeat = "item in items" ng-class="{sub_badge:item.badge == 1}">
		<a href="#!/order/view/{?item.id?}">
			<div class="col-xs-7 nopadding">
				<div class="type text-center bgf90" ng-show="(search.type==1||search.type==5)&&item.status==0">@lang('lang.short_purchase')</div>
				<div class="type text-center bg0C0" ng-show="(search.type==1||search.type==5)&&item.status==1">@lang('lang.short_return')</div>
				<div class="type text-center" ng-show="search.type!=1"></div>
				<div class="name text-left col-xs-12">{?item.product.name?} <span class="color-gray" ng-show="item.product_count > 1">  @lang('lang.others') {?item.product_count - 1?}@lang('lang.item_count')</span></div>
			</div>
			<div class="col-xs-2 nopadding paddingtop20 text-center">X {?item.order_count?}</div>
			<div class="col-xs-3 nopadding paddingtop20 text-center">￥{?prices[item.code]?}</div>
			<div class="col-xs-12 text-right text-muted text-gray">
				<span ng-if="item.card_type==0&&item.card_subtype==1">@lang('lang.st_virtual_sp_card')</span>
				<span ng-if="item.card_type==0&&item.card_subtype==0">@lang('lang.st_virtual_card')</span>
				<span ng-if="item.card_type==1">@lang('lang.st_physical_card')</span>
				&nbsp;&nbsp;
				<span class="glyphicon glyphicon-time"></span> {?item.updated_at?}
			</div>
			<div class="clearfix"></div>
		</a>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>