<div class="prod_v_thumb text-center">
	<img class="img-rounded" ng-src="{?product.image_url?}">
</div>
<div class="prod_v_content" style="display:none">
	<div class="info">
		<div class="type col-xs-3 paddingleft8 text-right">@lang('lang.code') :</div>
		<div class="value col-xs-8 nopadding">{?product.code?}</div>
	</div>
	<div class="info">
		<div class="type col-xs-3 paddingleft8 text-right">@lang('lang.define_name') :</div>
		<div class="value col-xs-8 nopadding">{?product.name?}</div>
	</div>
	<div class="info">
		<div class="type col-xs-3 paddingleft8 text-right">@lang('lang.type') :</div>
		<div class="value col-xs-8 nopadding">{?product.typestr_level1?} - {?product.typestr_level2?}</div>
	</div>
	<div class="info">
		<div class="type col-xs-3 paddingleft8 text-right">@lang('lang.state') :</div>
		<div class="value col-xs-8 nopadding"><span ng-if="product.status">@lang('lang.use_on')</span><span ng-if="!product.status">@lang('lang.use_off')</span></div>
	</div>
	<div class="info">
		<div class="col-xs-6 nopadding">
			<div class="type col-xs-6 paddingleft8 text-right">@lang('lang.valid period') :</div>
			<div class="value col-xs-6 nopadding">
				<span>{? product.valid_period | months_to_string ?}</span>
			</div>
		</div>
		<div class="col-xs-6 nopadding">
			<div class="type col-xs-6 paddingleft0 text-right">@lang('lang.pr_standard_price_s') :</div>
			<div class="value col-xs-6 nopadding">
				<span ng-if="product.sale_price != null">{?product.sale_price?} @lang('lang.label_cn_cunit')</span>
				<span ng-if="product.sale_price == null">@lang('lang.not_setting')</span>
			</div>
		</div>
	</div>
	<div class="info">
		<div class="type col-xs-3 paddingleft8 text-right">@lang('lang.introduce') :</div>
	</div>
	<div class="info col-xs-10 col-xs-offset-1 padding0">{?product.description?}</div>
	<div class="clearfix"></div>
</div>