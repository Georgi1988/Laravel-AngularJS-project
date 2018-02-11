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
			</div>
			<div class="clearfix paddingbot10"></div>
			<div class="col-xs-6">
				<p class="marginbot5 color_39f txt_bold">@lang('lang.od_original_price')：{?item.price_sku?}@lang('lang.label_cn_cunit')</p>
			</div>
			<div class="col-xs-6">
				<p class="marginbot5">@lang('lang.1st_level_dealer')：{? item.purchase_price_level[0] ?}@lang('lang.label_cn_cunit')</p>
			</div>
			<div class="clearfix"></div>
		</a>
	</div>	
	<div class="nodata" ng-show="no_data">@lang('lang.str_no_data')</div>
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>