<div class="subheader bg_white">
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/product"> 
			<span class="item">@lang('lang.sl_my_sale_amount')</span>
		</a>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/income">
			<span class="item">@lang('lang.sl_my_income')</span>
		</a>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/sale">
			<span class="item active">@lang('lang.sl_seller_ranking')</span>
		</a>
	</div>
</div>

<div class="sales_content">
	<!-- user list -->
	<div class="bg_white item out_border1" ng-repeat = "item in items">
		<div class="col-xs-3">
			<p class="text-center">
				<img class="img-rounded width95" ng-src="{?item.top_saled_product.image_url?}">
			</p>
		</div>
		<div class="col-xs-9 nopadding text-left">
			<p class="marginbot5">{?item.seller.name?}</p>
			<p class="text-muted">{?item.seller.dealer.name?}</p>
			<p class="txt_bold text-right color_39f margintop10 width95">@lang('lang.sl_sales_total')：{?item.total_sale_price?} 元</p>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>