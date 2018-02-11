<div class="subheader bg_white">
	<span class="item" ng-class="{active:search.level1_type==''}">
		<a ng-click="search_type1('')">@lang('lang.pr_item_all')</a>
	</span>
	<span class="item" ng-repeat="type1 in typelist1" ng-class="{active:search.level1_type==type1.id}"><a ng-click="search_type1(type1.id)">{?type1.description?}</a></span>
</div>

<div class="price_content">
	<div class="bg_white item" ng-repeat="item in items">
		<a ng-href="#!price/view/{?item.id?}" class="display-block">
			<div class="col-xs-5 padding-lf-7">
				<p class="text-center">
					<img class="img-rounded width90" ng-src="{?item.image_url?}">
				</p>
			</div>
			<div class="col-xs-7 nopadding text-left">
				<p class="marginbot5">@lang('lang.no')：{?item.code?}</p>
				<p class="marginbot5">@lang('lang.define_name')：{?item.name?}</p>
				<p class="marginbot10">@lang('lang.promotion_m')：{?item.promotion_price===null ? "@lang('lang.not_have')" : (item.promotion_price / 10).toString() + "@lang('lang.ten_pro')"?} <span class="pad-left5 color_red" ng-if="item.promotion_price!==null">@lang('lang.remain'){? dayDiff(parseDate(cur_date), parseDate(item.promotion_end_date.toString())) ?}<span>@lang('lang.days')</span></span></p>
			</div>
			<div class="clearfix paddingbot10"></div>
			<div class="col-xs-6">
				<p class="marginbot5">@lang('lang.price_purchase_price')：{? item.purchase_price ?}@lang('lang.label_cn_cunit')</p>
				<p class="marginbot5">@lang('lang.price_shipment_price')：{? item.wholesale_price ?}@lang('lang.label_cn_cunit')</p>
			</div>
			<div class="col-xs-6 nopadding">
				<p class="marginbot5">@lang('lang.price_store_price')：{? item.sale_price ?}@lang('lang.label_cn_cunit')</p>
			</div>
			<div class="clearfix"></div>
		</a>
	</div>	
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>