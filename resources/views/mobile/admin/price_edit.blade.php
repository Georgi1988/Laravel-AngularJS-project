<div class="price_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding paddingtop20 paddingbot20 marginbot15 info">
		<div class="col-xs-6 nopadding icon text-center">
			<img class="img-rounded width60" ng-src="{?product.image_url?}">
		</div>
		<div class="col-xs-6 padding0 detail text-left">
			<p class="marginbot5">@lang('lang.no')：{? product.code ?}</p>
			<p class="marginbot5">@lang('lang.define_name')：{? product.name ?}</p>
		</div>
	</div>
	<form id="editForm" ng-submit="form_submit(this)" method="post">
		<div class="col-xs-12 nopadding fontsize1_2 marginbot15">
			<div class="col-xs-6 text-center paddingtop5 txt_bold">@lang('lang.price_base')：</div>
			<div class="col-xs-6 nopadding">
				<input id="price_sku" type="number" class="edit_field width50" name="price_sku" ng-model="product.price_sku" min="1" ng-pattern="/^[0-9]*$/" required="true" /> (@lang('lang.label_cn_cunit'))
				<p class="alert_required" ng-show="required_price_sku">@lang('lang.field_required')</p>
			</div>
		</div>
		<div class="col-xs-12 bg_white nopadding paddingtop30 paddingbot20">
			<div class="row nopadding fontsize1_2 paddingtop15" ng-repeat="item in product.purchase_price_level track by $index">
				<div class="col-xs-11 nopadding text-center marginleft10 marginbot15">
					{? $index + 1 ?} @lang('lang.price_level_dealer')
				</div>
				<div class="col-xs-6 paddingtop5 text-center marginbot15">
					@lang('lang.pur_purchase_price'):
				</div>
				<div class="col-xs-6 nopadding text-left marginbot15">
					<input id="purchase_price_level{?$index?}" type="number" class="edit_field width50" ng-model="product.purchase_price_level[$index]" min="1" ng-pattern="/^[0-9]*$/" required="true" /> (@lang('lang.label_cn_cunit'))
					<p class="alert_required" ng-show="required_purchase_price_level[$index]">@lang('lang.field_required')</p>
				</div>
				<div class="col-xs-11 nopadding text-center marginbot15">
					@lang('lang.price_order_limit'):
				</div>
				<div class="col-xs-11 nopadding text-center marginbot15 marginleft18">
					<input id="limit_down_{?$index?}" type="number" name="limit_down_{?$index?}" class="edit_field width28" ng-model="product.order_limit_down_level[$index]" ng-pattern="/^[0-9]*$/" required="true" /> --- <input id="limit_up_{?$index?}" type="number" name="limit_up_{?$index?}" class="edit_field width28" ng-model="product.order_limit_up_level[$index]" min="{? product.order_limit_down_level[$index] + 1 ?}" ng-pattern="/^[0-9]*$/" required="true" /> (@lang('lang.gen_check_count'))
					<p class="alert_required" ng-show="required_limit_down_{?$index?}">@lang('lang.field_required')</p>
				</div>
			</div>
			<div class="row nopadding fontsize1_2 paddingtop15">
				<div class="col-xs-11 nopadding text-center marginleft10 marginbot15">
					@lang('lang.price_seller')
				</div>
				<div class="col-xs-6 paddingtop5 text-center marginbot15">
					@lang('lang.price_sell'):
				</div>
				<div class="col-xs-6 nopadding text-left marginbot15">
					<input id="sale_price" type="number" class="edit_field width50" ng-model="product.sale_price" min="1" ng-pattern="/^[0-9]*$/" required="true" /> (@lang('lang.label_cn_cunit'))
					<p class="alert_required" ng-show="required_sale_price">@lang('lang.field_required')</p>
				</div>
			</div>
		</div>
		<div class="submit_button">
			<input type="submit" id="save_submit_button" value="save">
		</div>
	</div>
	<!--<a ng-click="onSave()">save</a>-->
	
	<div class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content ">
				<div class="modal-body  text-center">
					<p class="message">您已成功完成注册</p>
					<button type="button" class="btn bg39f color_white">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>