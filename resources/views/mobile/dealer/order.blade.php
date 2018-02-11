<div class="subheader bg_white">
	@if($is_salepoint)
		<div class="col-xs-12 text-center">
			<span class="item"><a ng-click="search_type(4)">@lang('lang.od_myorder')</a></span>
		</div>
	@else
		<span class="item" ng-class="{active:search.type === 4}"><a ng-click="search_type(4)">@lang('lang.od_myorder')</a></span>
		<span class="item" ng-class="{active:search.type === 1}"><a ng-click="search_type(1)">@lang('lang.od_order_pending')</a></span>
		<span class="item" ng-class="{active:search.type === 2}"><a ng-click="search_type(2)">@lang('lang.od_order_sold')</a></span>
		<span class="item" ng-class="{active:search.type === 3}"><a ng-click="search_type(3)">@lang('lang.od_order_returned')</a></span>
	@endif
</div>
<div class="order_content">
	<div class="bg_white item out_border1" ng-repeat = "item in items" ng-class="{sub_badge:item.badge == 1}">
		<a href="#!/order/view/{?item.id?}">
			<div class="col-xs-7 nopadding">
				<div class="type text-center bgf90" ng-show="item.status==0">@lang('lang.short_purchase')</div>
				<div class="type text-center bg0C0" ng-show="item.status==1">@lang('lang.short_return')</div>
				<div class="name text-left col-xs-12">{?item.product.name?} <span class="color-gray" ng-show="item.product_count > 1">  @lang('lang.others') {?item.product_count - 1?}@lang('lang.item_count')</span></div>
			</div>
			<div class="col-xs-2 nopadding paddingtop20 text-center">X {?item.order_count?}</div>
			<div class="col-xs-3 nopadding paddingtop20 text-center">￥{?prices[item.code]?}</div>
			<div class="clearfix"></div>
			<div class="col-xs-12 text-right">
				@lang('lang.ov_status')：
				<span ng-show="item.agree==0">@lang('lang.order_unapproved')</span>
				<span ng-show="item.agree==1">@lang('lang.order_approved')</span>
				<span ng-show="item.agree==2">@lang('lang.od_refusal')</span>&nbsp;&nbsp;(
				<span ng-if="item.card_type==0&&item.card_subtype==1">@lang('lang.st_virtual_sp_card')</span>
				<span ng-if="item.card_type==0&&item.card_subtype==0">@lang('lang.st_virtual_card')</span>
				<span ng-if="item.card_type==1">@lang('lang.st_physical_card')</span>)
				&nbsp;&nbsp;
			</div>
			<div class="col-xs-12 text-right">
				<span class="glyphicon glyphicon-time text-muted"></span><span class="text-muted"> {?item.updated_at?}</span>
			</div>
			<div class="clearfix"></div>
		</a>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>