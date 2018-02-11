<div class="price_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-12 nopadding paddingtop20 icon text-center">
			<img class="img-rounded width70" ng-src="{?product.image_url?}">
		</div>
		<div class="col-xs-12 nopadding paddingtop10 paddingbot5 expire text-center color_red">
			@lang('lang.price_promotion_period')：{? promotion===null ? "@lang('lang.discount')" + " " + "@lang('lang.not_have')" : (promotion.promotion_start_date | date:'yyyy.MM.dd').toString() + ' - ' + (promotion.promotion_end_date | date:'yyyy.MM.dd').toString() ?}
		</div>
		<div class="price_discount bgf90" ng-if="promotion!==null">{? (promotion.promotion_price / 10).toString() + "@lang('lang.ten_pro')" ?}</div>
	</div>
	<div class="col-xs-11 col-xs-offset-1 fontsize1_1 text-left">
		<p>@lang('lang.no')：{? product.code ?}</p>
		<p>@lang('lang.define_name')： {? product.name ?}</p>
		<p>@lang('lang.type')：{? product.typestr_level1 ?} - {? product.typestr_level2 ?}</p>
	</div>
	<div class="col-xs-12 bg_white nopadding fontsize1_3 text-center txt_bold paddingtop15 paddingbot15">
		
	</div>
	<div class="col-xs-10 col-xs-offset-1 fontsize1_1 padding0 paddingtop20 paddingbot15">
		<div class="row paddingbot10">
			<div class="col-xs-5 nopadding text-right">@lang('lang.price_purchase_price')：</div>
			<div class="col-xs-3 padding-lf-7" ng-if="promotion!=null">
				<del>{? price.purchase_price ?}  @lang('lang.label_cn_cunit')</del>
			</div>
			<div class="col-xs-3 padding-lf-7 txt_bold color_red">{? promotion===null ? price.purchase_price : price.purchase_price * promotion.promotion_price / 100 ?} @lang('lang.label_cn_cunit')</div>
		</div>
		
		<div class="row paddingbot10">
			<div class="col-xs-5 nopadding text-right">@lang('lang.price_shipment_price')：</div>
			<div class="col-xs-3 padding-lf-7 txt_bold color_red">{? price.wholesale_price ?} @lang('lang.label_cn_cunit')</div>
		</div>
		
		<div class="row paddingbot10">
			<div class="col-xs-5 nopadding text-right">@lang('lang.price_store_price')：</div>
			<div class="col-xs-3 padding-lf-7 txt_bold color_red">{? price.sale_price ?} @lang('lang.label_cn_cunit')</div>
		</div>
	</div>
	
</div>