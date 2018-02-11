<div class="user_v_content" style="display:none">
	<div class="col-xs-12 bg_white nopadding marginbot20 paddingtop20 info">
		<div class="col-xs-12 detail text-left">
			<div class="row fontsize1_2 paddingtop5 paddingbot10 margin0">
				<div class="col-xs-10 nopadding">{? dealer.name ?}</div>
				<div class="col-xs-2 nopadding"><a ng-href="#!/user/dealer/detail/{?dealer.id?}" class="btn btn-primary">@lang('lang.info')</a></div>
			</div>
			<p class="text-muted">
				{? dealer.level==1 ? '一级经销商' : dealer.level==2 ? '二级经销商' : '零售门店' ?}
			</p>
		</div>
	</div>
	<div class="col-xs-12 bg_white nopadding fontsize1_2 text-center paddingtop10 paddingbot10 marginbot20">
		<div class="col-xs-12 item_val">
			<div class="col-xs-6">@lang('lang.u_item_stock')</div>
			<div class="col-xs-6">{? dealer.stock ?} @lang('lang.label_card_unit')</div>
		</div>
		<div class="col-xs-12 item_val1">
			<div class="col-xs-6">@lang('lang.u_activation_count')</div>
			<div class="col-xs-6">{? dealer.stock_activated ?} @lang('lang.label_card_unit')</div>
		</div>
		<div class="col-xs-12 item_val">
			<div class="col-xs-6">@lang('lang.u_register_count')</div>
			<div class="col-xs-6">{? dealer.stock_registered ?} @lang('lang.label_card_unit')</div>
		</div>
		<div class="col-xs-12 item_val1">
			<div class="col-xs-6">@lang('lang.u_outstanding_price')</div>
			<div class="col-xs-6" ng-class="{'item_active': dealer.unbalance_sale > 0}">{? dealer.unbalance_sale ?} @lang('lang.label_cn_cunit')</div>
		</div>
		<div class="col-xs-12 item_val">
			<div class="col-xs-6">@lang('lang.u_total_sales')</div>
			<div class="col-xs-6">{? dealer.total_sale ?} @lang('lang.label_cn_cunit')</div>
		</div>
		<div class="col-xs-12 item_val1">
			<div class="col-xs-6">@lang('lang.u_cur_month_sales')</div>
			<div class="col-xs-6">{? dealer.sale_month ?} @lang('lang.label_cn_cunit')</div>
		</div>
	</div>
	
	<div class="col-xs-12 paddingbot20">
		<p class="txt_bold fontsize1_2">@lang('lang.u_outstanding_order')</p>
		<div class="row margin0 paddingbot10" ng-repeat="item in dealer.unbalance_list">
			<div class="col-xs-6 text-muted padding0">{? item.product_name ?}</div>
			<div class="col-xs-6">
				<div class="col-xs-12 text-muted text-right padding0">{? item.sale_count ?} @lang('lang.label_card_unit')</div>
				<div class="col-xs-12 text-right padding0">{? item.sale_sum ?} ￥</div>
			</div>
		</div>
		<!--
		<div class="row margin0 paddingbot10">
			<div class="col-xs-7 text-muted padding0">灵越笔记本一年延保卡</div>
			<div class="col-xs-2 text-muted text-right padding0">X 200</div>
			<div class="col-xs-3 text-right padding0">￥7000</div>
		</div>
		<div class="row margin0 paddingbot10">
			<div class="col-xs-7 text-muted padding0">灵越笔记本一年延保卡</div>
			<div class="col-xs-2 text-muted text-right padding0">X 200</div>
			<div class="col-xs-3 text-right padding0">￥7000</div>
		</div>
		-->
	</div>
	
	<div id="confirm_dlg" class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog width90">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{? dealer.name ?}</h4>
				</div>
				<div class="modal-body">
					<p class="text-center fontsize1_2 txt_bold">@lang('lang.u_outstanding_writeoff') {? dealer.unbalance_sale ?} @lang('lang.label_cn_cunit')？</p>
				</div>
				<div class="modal-footer">
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bgf90 color_white" ng-click="onBalance()">@lang('lang.confirm')</button>
					</div>
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bg999 color_white" data-dismiss="modal">@lang('lang.cancel')</button>
					</div>
				</div>
			</div>

		</div>
	</div>
	
	<div class="prod_v_activation bgf90 text-center">
		<a class="btn color_white padding0 txt_bold fontsize1_2" data-toggle="modal" data-target="#confirm_dlg">
			@lang('lang.u_outstanding_price'): {? dealer.unbalance_sale ?} @lang('lang.label_cn_cunit')
		</a>
	</div>
	
</div>