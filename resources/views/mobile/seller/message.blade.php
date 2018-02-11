<div class="bg5ac8fa text-center txt_bold fontsize1_1 color_white paddingtop10 paddingbot10" ng-if="unread_message>0">
	@lang('lang.ms_seller_new_prefix')<span>{?unread_message?}</span>@lang('lang.ms_seller_new_suffix')
</div>
<div class="msg_content">
	<div class="col-xs-12 bg_white nopadding paddingtop10 marginbot20 item" ng-repeat = "item in items">
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