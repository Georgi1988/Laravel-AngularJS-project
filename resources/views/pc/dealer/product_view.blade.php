	<div class="block">
		<a onclick="history.back(); return false;" class="subtitle">&lt; @lang('lang.pr_return')</a>
	</div>
	<div class="generalblock paddingtopbottom10">
		@lang('lang.pr_service_card_information')
	</div>
	<div class="width97 backgroundwhite" ng-show="loaded">
		<div class="block marginleft5pro">
			<div class="left width40 textcenter">
				<img class="img_preview width80" ng-src="{?product.image_url?}" >
			</div>
			<div class="left marginleft50">
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_name')：{?product.name?}</p>
				<p class="fontcolor777 lineheight240">@lang('lang.ov_product_code')：{?product.code?}</p>
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_kind')：{?product.typestr_level1?} - {?product.typestr_level2?}</p>
				<p class="fontcolor777 lineheight240">@lang('lang.pr_item_status')： <span ng-if="product.status">@lang('lang.use_on')</span> <span ng-if="!product.status">@lang('lang.use_off')</span></p>
				<p class="fontcolor777 lineheight240">@lang('lang.valid period')： 
					<span>{? product.valid_period | months_to_string ?}</span>
				</p>
				<p class="fontcolor777 lineheight240">
					@lang('lang.pr_standard_price_s')：{?product.sale_price?} @lang('lang.label_cn_cunit')
				</p>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="block width90 marginleft5pro fontcolor777">@lang('lang.pr_description')：</div>
		<div class="block width90 marginleft5pro fontcolor777"><textarea name="product_description" style="width: 800px;height: 200px; border:none;">{?product.description?}</textarea></div>
		<div class="block"></div>
	</div>
	