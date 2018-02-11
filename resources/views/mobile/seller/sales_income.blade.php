<div class="subheader bg_white">
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/product"> 
			<span class="item">@lang('lang.sl_my_sale_amount')</span>
		</a>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/income">
			<span class="item active">@lang('lang.sl_my_income')</span>
		</a>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/sale">
			<span class="item">@lang('lang.sl_seller_ranking')</span>
		</a>
	</div>
</div>

<div class="sales_content">

	<div class="bg_white item out_border1" ng-repeat = "item in items">
		<div class="col-xs-5">
			<p class="text-center">
				<img class="img-rounded width95" ng-src="{?item.product.image_url?}">
			</p>
			<p class="margin0">@lang('lang.no')：{?item.product.code?}</p>
		</div>
		<div class="col-xs-7 nopadding text-left">
			<p class="txt_bold marginbot5">@lang('lang.define_name')：{?item.product.name?}</p>
			<p class="text-muted">@lang('lang.type'): {?item.product.level1_info.description?}</p>
			<p class="txt_bold color_39f margintop20">@lang('lang.income')： {?item.income?} 元</p>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>