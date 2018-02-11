<div class="stock_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-12 nopadding icon text-center">
			<img class="img-rounded" ng-src="{?card.product.image_url?}">
		</div>
		<div class="col-xs-12 nopadding expire text-center" ng-class="{color_red:card.expire_remain_days<0}">
			@lang('lang.valid period')：
			<span ng-show="card.valid_forever==false&&card.expire_remain_days>=0">{?card.valid_period?}</span>
			<span ng-show="card.valid_forever==false&&card.expire_remain_days<0">{?card.valid_period?}（@lang('lang.ov_expired')）</span>
			<span ng-show="card.valid_forever">@lang('lang.forever_valid_time')</span>
		</div>
	</div>
	<div class="col-xs-11 col-xs-offset-1 text-left item">
		<p>@lang('lang.no')： {?card.product.code?}</p>
		<p>@lang('lang.define_name')： {?card.product.name?}</p>
		<p>@lang('lang.type')： {?card.product.level1_info.description?} - {?card.product.level2_info.description?}</p>
	</div>
	<div class="col-xs-4 text-center txt_bold">
			@lang('lang.label_stock')： 
		</div>
		<div class="col-xs-8 text-center txt_bold">
			<p>@lang('lang.st_physical_card')： {?card.product_stock.size_of_physical?} @lang('lang.label_card_unit')</p>
			<p>@lang('lang.st_virtual_card')： {?card.product_stock.size_of_virtual?} @lang('lang.label_card_unit')</p>
		</div>
	<div class="col-xs-10 col-xs-offset-1 padding0 paddingtop20 paddingbot15">
		<p>@lang('lang.introduce'):</p>
		<p>{?card.product.description?}</p>
	</div>
	
	<div class="col-xs-12 bg5ac8fa color_white paddingtop10  paddingbot10 text-center txt_bold fontsize1_3">
		<a href="#!/generate/add/{?card.product.id?}">@lang('lang.gen_generate_card')</a>
	</div>
	
</div>