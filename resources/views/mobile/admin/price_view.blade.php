<div class="price_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-12 nopadding paddingtop20 icon text-center">
			<img class="img-rounded width70" ng-src="{?product.image_url?}">
		</div>
	</div>
	<div class="col-xs-11 col-xs-offset-1 fontsize1_1 text-left">
		<p>@lang('lang.no')：{? product.code ?}</p>
		<p>@lang('lang.define_name')：{? product.name ?}</p>
		<p>@lang('lang.type')：{? product.typestr_level1 ?} - {? product.typestr_level2 ?}</p>
	</div>
	<div class="col-xs-12 bg_white nopadding fontsize1_3 text-center txt_bold paddingtop15 paddingbot15">
		@lang('lang.od_original_price')： {? product.price_sku ?} @lang('lang.label_cn_cunit')
	</div>
	<div class="col-xs-10 col-xs-offset-1 fontsize1_1 padding0 paddingtop20 paddingbot15">
		<div class="row paddingbot10" ng-repeat="item in product.purchase_price_level track by $index">
			<div class="col-xs-5 nopadding text-right">{? $index + 1 ?} @lang('lang.price_level_dealer'):</div>
			<div class="col-xs-3 padding-lf-7" ng-if="product.promotions[$index + 1]!=null">
				<del>{? item ?}@lang('lang.label_cn_cunit')</del>
			</div>
			<div class="col-xs-3 padding-lf-7 txt_bold color_red" ng-if="item!=null">{? product.promotions[$index + 1]===null ? product.promotions[0]===null ? item : item * product.promotions[0].promotion_price / 100 : item * product.promotions[$index + 1].promotion_price / 100 ?}@lang('lang.label_cn_cunit')</div>
		</div>
		<div class="row text-center margintop10">
			<a ng-href="#!/generate/add/{?product.id?}" class="btn btn-primary color_white">+ @lang('lang.gen_generate_card_short')</a>
		</div>
	</div>
	
</div>