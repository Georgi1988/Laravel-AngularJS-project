<div class="price_v_content">
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-12 nopadding paddingtop20 icon text-center">
			<img class="img-rounded width70" ng-src="{?product.image_url?}">
		</div>
	</div>
	<div class="col-xs-11 col-xs-offset-1 fontsize1_1 text-left margintop5">
		<p>@lang('lang.no')：{? product.code ?}</p>
		<p>@lang('lang.define_name')：{? product.name ?}</p>
		<p>@lang('lang.type')：{? product.typestr_level1 ?} - {? product.typestr_level2 ?}</p>
		<p>@lang('lang.od_original_price')：{? product.price_sku ?} @lang('lang.label_cn_cunit')</p>
	</div>
	<div class="col-xs-12 bg_white nopadding fontsize1_3 text-center txt_bold paddingtop15 paddingbot15 marginbot15">
		<span ng-repeat="(index, dealer) in dealers">{? dealer.dealer_name ?} {? index < dealer_cnt - 1 ? ', ' : '' ?} </span>
	</div>
	<form id="discountinput" name="discountinput" ng-submit="submit_discount()" method="POST" enctype="multipart/form-data">
		<p class="marginleft18 alert_required" ng-show="required_leveldiscount">{? msg_type==0 ? "@lang('lang.price_promotion_require')" : "@lang('lang.price_promotion_dateinput')" ?}</p>
		<div class="marginleft18 margintop5 marginbot15 display-inlineblock">
			<div class="marginleft5 width140 display-inlineblock text-right">
				@lang('lang.promotion'):
			</div>
			<div class="marginleft5 width140 display-inlineblock">
				<input type="number" min="1" max="100" ng-model="promotion_price" placeholder="@lang('lang.promotion')" required /> (%)
			</div>
		</div>
		<div class="marginleft18 margintop5 display-inlineblock">
			<input class="marginleft5 width108" type="text" name="searchdatestart" placeholder="@lang('lang.start date')" ng-model="promotion_start_date"  datepicker required />
			<input class="marginleft5 width108" type="text" name="searchdateend" placeholder="@lang('lang.end date')" ng-model="promotion_end_date"  datepicker required />
		</div>
		<input type="submit" id="discount_save" style="display:none" />
	</form>
</div>