	<div class="subheader bg_white">
		<div class="col-xs-4 text-center">
			<a ng-click="search_pagetype(1)"> 
				<span class="item" ng-class="{active:search.page_type==1}">@lang('lang.od_order_pending')</span>
			</a>
		</div>
		<div class="col-xs-4 text-center">
			<a ng-click="search_pagetype(2)"> 
				<span class="item" ng-class="{active:search.page_type==2}">@lang('lang.rg_card_agreed')</span>
			</a>
		</div>
		<div class="col-xs-4 text-center">
			<a ng-click="search_pagetype(3)"> 
				<span class="item" ng-class="{active:search.page_type==3}">@lang('lang.rg_card_cancled')</span>
			</a>
		</div>
	</div>
	
	<div class="register_content paddingbot20">
	
		<div class="col-xs-12 bg_white nopadding marginbot10 item out_border1" ng-repeat="item in items">
			<a ng-href="#!/register/card/agree/view_item/{?item.id?}">
				<div class="col-xs-12 nopadding pad-right5 title">
					<i class="glyphicon glyphicon-triangle-right"></i> {?item.product.name?}
				</div>
				<div class="col-xs-10 col-xs-offset-1 text-left padding0">
					{?item.code?}
				</div>
				<div class="col-xs-10 col-xs-offset-1 text-left text-muted fontsize0_9 padding0">
					<i class="glyphicon glyphicon-tint"></i> {?item.dealer.name?} - {?item.seller.name?}
				</div>
				<div class="col-xs-6 col-xs-offset-6 text-left text-muted fontsize0_9 padding0" ng-show="item.customer">
					<i class="glyphicon glyphicon-user"></i> {?item.customer.name?} - {?item.customer.link?}
				</div>
				<div class="col-xs-6 col-xs-offset-6 text-left text-muted fontsize0_9 padding0">
					<i class="glyphicon glyphicon-time"></i> {?item.register_datetime?}
				</div>
			</a>
		</div>
			
		<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
		
	</div>