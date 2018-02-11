<div class="subheader bg_white">
	<span class="item" ng-class="{active:search.type==0}"><a ng-click="search_type(0)">@lang('lang.ms_tab_all')</a></span>
	<span class="item" ng-class="{active:search.type==1}"><a ng-click="search_type(1)">@lang('lang.ms_tab_system')</a></span>
	<span class="item" ng-class="{active:search.type==2}"><a ng-click="search_type(2)">@lang('lang.ms_tab_audit')</a></span>
	<span class="item" ng-class="{active:search.type==3}"><a ng-click="search_type(3)">@lang('lang.ms_tab_order')</a></span>
</div>
<div class="msg_content">
	<div class="col-xs-12 bg_white nopadding marginbot20 item" ng-repeat = "item in items">
		<a class="display-block" ng-href="{?item.mobile_url?}">
			<div class="info color_white" ng-if="item.type==2" ng-class="{bgf90:item.order.status==0,bg0C0:item.order.status==1}">
				<span ng-if="item.order.status==0">@lang('lang.short_purchase')</span>
				<span ng-if="item.order.status==1">@lang('lang.short_return')</span>
			</div>
			<div class="info color_white" ng-if="item.type!=2"></div>
			<div class="col-xs-12 message ">{?item.message?}</div>
			<div class="col-xs-12 text-right text-muted text-gray"><span class="glyphicon glyphicon-time"></span> {?item.created_at?}</div>
			<div class="clearfix"></div>
		</a>
	</div>
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>