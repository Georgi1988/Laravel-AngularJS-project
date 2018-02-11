<div class="subheader bg_white">
	<span class="item" ng-class="{'active': search.level1_type == ''}">
		<a ng-click="search_type1('')">@lang('lang.pr_item_all')</a>
	</span>
	<span class="item" ng-repeat="type1 in typelist1" ng-class="{active:search.level1_type==type1.id}"><a ng-click="search_type1(type1.id)">{?type1.description?}</a></span>
</div>
<div class="reg_content">
	<div class="col-xs-12 bg_white nopadding marginbot10 item out_border1" ng-repeat = "item in items">
		<a href="#!/register/edit/{?item.product_id?}/{?item.id?}">
			<div class="col-xs-1"></div>
			<div class="col-xs-8 nopadding no">
				<div class="col-xs-10 nopadding title" style="padding-bottom:10px;">{?item.name?}</div>
				<div class="col-xs-12 nopadding" style="padding-left:15px;">
					{?item.code?}
					<span class="text-muted" ng-show="item.agree_reg=='r'"> @lang('lang.order_unapproved')</span>
					<span class="text-muted" ng-show="item.agree_reg=='d'"> @lang('lang.rg_card_cancled')</span>
				</div>
			</div>			
			<div class="col-xs-2 text-center more" style="line-height:300%">&gt;</div>
		</a>
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>