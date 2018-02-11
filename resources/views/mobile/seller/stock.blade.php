<div class="subheader bg_white">
	<span class="item">
		@lang('lang.pr_item_name')：{?other_info.product.name?}
	</span>
</div>
<div class="stock_content">
	<div class="col-xs-12 bg_white nopadding marginbot10 item out_border1" ng-repeat="item in items">
		<div class="col-xs-3 nopadding pad-right5 title" ng-class="{color_red:item.expired==1}">@lang('lang.ov_product_code')</div>
		<div class="col-xs-5 nopadding quantity" ng-class="{color_red:item.expired==1}">
			{?item.product.code?}
		</div>
		<div class="col-xs-4 nopadding text-right">
			<span ng-if="item.valid_period !== null">{?item.valid_period?}</span>
			<span ng-if="item.valid_period == null">@lang('lang.forever_valid_time')</span>
		</div>
		<div class="col-xs-12 border-top-1-DDD margintop5 marginbot5"></div>
		<div class="col-xs-7 nopadding">
			@lang('lang.code'): {?item.code?}
		</div>
		<!--<div class="col-xs-5 text-right nopadding" ng-show="!item.type">-->
		<div class="col-xs-5 text-right nopadding">
			<a ng-href="#!/activation/active/{?item.id?}" ng-if="item.status == 0 && !item.expired" class="btn btn-primary">@lang('lang.activation')</a>
		</div>
		<!--<div class="col-xs-5 text-right nopadding" ng-show="item.type">
			<a ng-click="get_qr_code(item.id)" class="btn btn-primary" ng-disabled="item.expired">@lang('lang.qr_code')</a>
		</div>-->
		<!--<div class="col-xs-5 nopadding">
			@lang('lang.password'): <span id="real_password_{?item.id?}" dd-val="{?item.passwd?}">-------------</span>&nbsp;<a ng-click="show_password(item.id)"><img src="{{url('')}}/images/pw_show.png" style="height: 15px;" ></a>
		</div>-->
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
	
	<div class="qr_code_modal modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<div class="row text-center">
						<img id="qr_code_image" style="width: 250px; height: 250px;" />
					</div>
				</div>
				<div class="modal-footer">
					<!--<div class="col-xs-6 nopadding text-center">
						<button type="button" ng-click="download_qr_code()" class="btn bg39f color_white downloadbtn">@lang('lang.download')</button>
					</div>-->
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bg999 color_white cancelbtn" data-dismiss="modal">@lang('lang.close')</button>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>