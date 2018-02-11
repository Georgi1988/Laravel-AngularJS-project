<div class="subheader bg_white">
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/product"> 
			<span class="item">@lang('lang.sl_register_ranking')</span>
		</a>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/income"> 
			<span class="item">@lang('lang.sl_income_ranking')</span>
		</a>
	</div>
	<div class="col-xs-4 text-center">
		<a href="#!/sales/rank/dealer"> 
			<span class="item active">@lang('lang.sl_dealer_ranking')</span>
		</a>
	</div>
</div>

<div class="sales_content">	
	<!-- dealer list -->
	<div class="bg_white item out_border1" ng-repeat = "item in items">
		<div class="col-xs-3">
			<p class="text-center">
				<img class="img-rounded width95" ng-src="{?item.top_saled_product.image_url?}">
			</p>
		</div>
		<div class="col-xs-9 nopadding text-left">
			<p class="marginbot5">{?item.dealer.name?}</p>
			<p class="text-muted">
				<span ng-show='item.dealer.level==1'>@lang('lang.1st_level_dealer')</span>
				<span ng-show='item.dealer.level==2'>@lang('lang.2nd_level_dealer')</span>
				<span ng-show='item.dealer.level==3'>@lang('lang.3rd_level_dealer')</span>
				<span ng-show='item.dealer.level==4'>@lang('lang.4th_level_dealer')</span>
				<span ng-show='item.dealer.level==5'>@lang('lang.5th_level_dealer')</span>
				<span ng-show='item.dealer.level==6'>@lang('lang.6th_level_dealer')</span>
				<span ng-show='item.dealer.level==7'>@lang('lang.7th_level_dealer')</span>
				<span ng-show='item.dealer.level==8'>@lang('lang.8th_level_dealer')</span>
				<span ng-show='item.dealer.level==9'>@lang('lang.9th_level_dealer')</span>
				<span ng-show='item.dealer.level==10'>@lang('lang.10th_level_dealer')</span>
				<span ng-show='item.dealer.level==11'>@lang('lang.11th_level_dealer')</span>
				<span ng-show='item.dealer.level==12'>@lang('lang.12th_level_dealer')</span>
				<span ng-show='item.dealer.level==13'>@lang('lang.13th_level_dealer')</span>
				<span ng-show='item.dealer.level==14'>@lang('lang.14th_level_dealer')</span>
				<span ng-show='item.dealer.level==15'>@lang('lang.15th_level_dealer')</span>
				<span ng-show='item.dealer.level==16'>@lang('lang.16th_level_dealer')</span>
				<span ng-show='item.dealer.level==17'>@lang('lang.17th_level_dealer')</span>
				<span ng-show='item.dealer.level==18'>@lang('lang.18th_level_dealer')</span>
				<span ng-show='item.dealer.level==19'>@lang('lang.19th_level_dealer')</span>
				<span ng-show='item.dealer.level==20'>@lang('lang.20th_level_dealer')</span>
			</p>
		</div>
		<div class="col-xs-12 text-right">
			<p class="txt_bold text-right color_39f">
				@lang('lang.sl_sales_total')：{?item.total_sale_price | floor ?} 元&nbsp;&nbsp;&nbsp;
				@lang('lang.label_stock')：{?item.total_stock?} @lang('lang.label_card_unit')
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>