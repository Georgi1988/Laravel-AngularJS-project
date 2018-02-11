<div class="stock_v_content" ng-show="loaded">

	<div class="alert alert-success" role="alert">
		@lang('lang.rg_success_save')
	</div>
	<div class="alert alert-danger" role="alert">
		@lang('lang.rg_fail_save')
	</div>
	
	<div class="col-xs-12 bg_white nopadding marginbot15 info">
		<div class="col-xs-12 nopadding icon text-center">
			<img class="img-rounded" ng-src="{?product.image_url?}">
		</div>
	</div>
	<div class="col-xs-11 col-xs-offset-1 text-left item">
		<p>@lang('lang.no')： {?product.code?}</p>
		<p>@lang('lang.define_name')： {?product.name?}</p>
		<p>
			@lang('lang.st_purchase_price')：{? product.price_info.promotion==null ? product.price_info.purchase_price : product.price_info.purchase_price * product.price_info.promotion.promotion_price / 100 ?} 元 
			<span class="color_red" ng-show="product.price_info.promotion!=null">（<del>{?product.price_info.purchase_price?}</del>元 - {?product.price_info.promotion.promotion_price?}%）</span>
		</p>
	</div>
	<div class="col-xs-12 bg_white nopadding fontsize1_3 paddingtop10 paddingbot10">
		<div class="col-xs-4 text-right fontsize1_1 text-left">
			@lang('lang.quantity')：
		</div>
		<div class="col-xs-8 nopadding icon text-left switchbox">
			<input class="edit_field width50 padding-lf-7" type="number" name="order_size" placeholder="@lang('lang.quantity')" ng-model="order_size" min="{?order_info.min_limit?}" max="{?order_info.max_limit?}" required validate > <span class="fontsize0_8">{?order_info.min_limit?} ~ {?order_info.max_limit?}</span>
		</div>
	</div>
	<div class="col-xs-12 nopadding fontsize1_3 paddingtop10 paddingbot10">
		<div class="col-xs-7 text-right fontsize1_1 text-left">
			@lang('lang.gen_select_the_service_card_type')：
		</div>
		<div class="col-xs-5 nopadding icon text-left switchbox">
			<select class="edit_field" name="card_type" ng-model="card_type" required>
				<option value="1">实体卡</option>
				<option value="0" selected="selected">虚拟卡</option>
			</select>
		</div>
	</div>
	<div class="col-xs-12 bg_white padding0 paddingtop20 paddingbot15">
		<div class="col-xs-4 fontsize1_2 text-right">@lang('lang.valid period')：</div>
		<div class="col-xs-8 nopadding">
			<span class="fontsize1_2 padding-lf-7">{?product.valid_period | months_to_string ?}</span>
			&nbsp;&nbsp;
			@lang('lang.st_countdown_after_agree')
		</div>
	</div>

	<div class="col-xs-12 paddingtop10 paddingbot10 text-center" ng-class="{bg5ac8fa:order_size&&card_type,bg999:!order_size||!card_type}">
		<a class="btn color_white padding0 txt_bold fontsize1_2" ng-disabled="!order_size||!card_type" onclick="angular.element(this).scope().show_confirm(this)">
			<span class="color_white fontsize1_2 padding-lf-7">@lang('lang.st_purchase_soon')</span>
			<span class="color_white fontsize1_2 padding-lf-7" ng-show="order_size">@lang('lang.label_total') {? product.price_info.promotion==null ? product.price_info.purchase_price * order_size : (product.price_info.purchase_price * product.price_info.promotion.promotion_price / 100) * order_size?}元</span>
		</a>
	</div>
	
	<div id="confirm_dlg" class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center">@lang('lang.st_purchase_notify')</h4>
				</div>
				<div class="modal-body text-center txt_bold fontsize1_4">
					{? product.price_info.promotion==null ? product.price_info.purchase_price * order_size : (product.price_info.purchase_price * product.price_info.promotion.promotion_price / 100) * order_size?}元
				</div>
				<div class="modal-footer">
					<div class="col-xs-6 nopadding text-center">
						<button ng-click="order_purchase()" type="button" class="btn bg39f color_white width60">@lang('lang.confirm')</button>
					</div>
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bg999 color_white width60" data-dismiss="modal">@lang('lang.cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>