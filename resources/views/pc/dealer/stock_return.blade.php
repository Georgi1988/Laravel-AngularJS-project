	<div class="block">
		<a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a>
	</div>
	<div class="generalblock paddingtopbottom10">
		@lang('lang.st_return_request')
	</div>
	<div class="row margin0">
		<div class="col-xs-4 text-right">
			<img class="img-rounded width80" ng-src="{?product.image_url?}">
		</div>
		<div class="col-xs-8">
			<div class="row paddingtop8">
				<div class="col-xs-2 text-right">
					@lang('lang.define_name')：
				</div>
				<div class="col-xs-9 nopadding icon text-left switchbox">
					{?product.name?}
				</div>
			</div>
			<div class="row paddingtop8">
				<div class="col-xs-2 text-right">
					@lang('lang.code')：
				</div>
				<div class="col-xs-3 nopadding icon text-left switchbox">
					{?product.code?}
				</div>
				<div class="col-xs-5 text-left">
					@lang('lang.st_purchase_price')：
					{? product.price_info.promotion==null ? product.price_info.purchase_price : product.price_info.purchase_price * product.price_info.promotion.promotion_price / 100 ?} 元 
					<span class="color_red" ng-show="product.price_info.promotion!=null">（<del>{?product.price_info.purchase_price?}</del>元 - {?product.price_info.promotion.promotion_price?}%）</span>
				</div>
			</div>
			<div class="row paddingtop8">
				<div class="col-xs-2 paddingtop8 text-right">
					@lang('lang.gen_mcard_type')：
				</div>
				<div class="col-xs-3 nopadding icon text-left switchbox">
					<select class="edit_field form-control" name="card_type" ng-model="card_type" required>
						<option value="1">@lang('lang.st_physical_card')</option>
						<option value="0" selected="selected">@lang('lang.st_virtual_card')</option>
					</select>
				</div>
			</div>
			<div class="row paddingtop10">
				<div class="col-xs-2 paddingtop8 text-right">
					@lang('lang.quantity')：
				</div>
				<div class="col-xs-3 nopadding">
					<input class="edit_field form-control width100 fontsize1_3" type="number" name="order_size" placeholder="@lang('lang.quantity')" ng-model="order_size" min="1" max="{? card_type==1 ? product.stock_info.size_of_physical : product.stock_info.size_of_virtual ?}" required>
				</div>
				<div class="col-xs-3 paddingtop8">
					@lang('lang.st_return_availabe') {? card_type==1 ? product.stock_info.size_of_physical : product.stock_info.size_of_virtual ?}
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		
		
		<!-- Card select part -->
		<div class=" pcard_select_panel col-xs-12 margintop15 paddingtopbottom10 bg-info border-round8" ng-show="card_type==1">
			<div class="col-xs-6 right-border-secondary">
				<div class="row sub_panel_lavel margin0 text-center">
						<h5>@lang('lang.select') @lang('lang.st_physical_card')</h3>
				</div>
				<div class="row margin0">
				
					<div class="row margin0">
						<form id="pcard_file_form" ng-submit="import_card_insert()">
							<input type="hidden" name="product_id" value="{? product.id ?}">
							<div class="col-xs-3 text-right paddingleft0">@lang('lang.card_code_s')@lang('lang.template_file')</div>
							<div class="col-xs-5 padding0 overflow-hidden">
								<!--<input type="file" class="form-control" name="pcard_file" accept=".xlsx, .xls">-->
								<div class="form-group">
									<input type="file" class="input-ghost" style="visibility:hidden; height:0" name="pcard_file" accept=".xlsx, .xls">
									<div class="input-group input-file" name="Fichier1">
										<input type="text" class="form-control" placeholder="@lang('lang.choose_file')" style="cursor: pointer;">
										<span class="input-group-addon">
											<a class="file_choose">@lang('lang.select')</a>
										</span>
									</div>
								</div>
								<script>
									$(function() {
										bs_input_file();
									});
								</script>
							</div>
							<div class="col-xs-4 text-left">
								<button type="submit" class="btn btn-info padding_3-6 font-size">
									<small>@lang('lang.import')</small>
									<span class="loading_icons" ng-show="cardtemp_loading"><img src="./images/loading_now.gif"></span>
								</button>&nbsp;
								<a href="{{url('common/download/template/physical_card')}}" class="fontcolorblue">	
									<span class="glyphicon glyphicon-download-alt"></span> @lang('lang.template_sample')
								</a>
							</div>
						</form>
					</div>
					<div class="row margin0">
						<div class="col-xs-10 col-xs-offset-1 margintop5 marginbot5 alert alert-success alert-pcard-import-valid text-left-force">
							<div class="row margin0">
								<span class="text-info txt-bold">@lang('lang.od_pcard_import_result')<span> &nbsp;&nbsp;&nbsp;&nbsp;
								<span class="text-success">@lang('lang.od_pcard_valid_cards'): <span>  {?import_result.valid_cards_quantity?}&nbsp;&nbsp;&nbsp;
								<span class="text-warning">@lang('lang.od_pcard_invalid_cards'): <span>{?import_result.total_cards_quantity - import_result.valid_cards_quantity?}
							</div>
							<div class="row margin0 width100 overflow-x-auto" ng-show="import_result.total_cards_quantity != import_result.valid_cards_quantity">
								<span class="text-danger">@lang('lang.od_pcard_invalid_cards_list')：</span>
								<span class="text-muted" ng-repeat="code in import_result.invalid_cards">
									{?code?} 
								</span>
							</div>
						</div>
						<div class="col-xs-10 col-xs-offset-1 text-left margintop5 alert alert-danger alert-pcard-import-invalid">
							@lang('lang.error_file_upload_failed')
						</div>
					</div>
					
				</div>
				<div class="row margin0 paddingtop10">
					<form ng-submit="each_card_insert()">
						<div class="row margin0">
							<div class="col-xs-3 text-right paddingleft0">@lang('lang.physical_card_code')</div>
							<div class="col-xs-5 padding0">
								<input type="text" id="each_card_code" name="each_card_code" class="form-control" required>
							</div>
							<div class="col-xs-4 text-left">
								<button type="submit" class="btn btn-info padding_3-6 font-size"><small>@lang('lang.add')</small></button>&nbsp;
								<span class="alert alert-success alert-pcard-code-valid">
									@lang('lang.valid_pcard_code_s')
								</span>
							</div>
						</div>
						<div class="row margin0 paddingtop10">
							<div class="col-xs-6 col-xs-offset-3 text-left alert alert-danger alert-pcard-code-invalid">
								@lang('lang.invalid_pcard_code')
							</div>
						</div>
					</form>
				</div>
				<div class="row margin0 paddingtop10 text-center text-muted">
					@lang('lang.selected_pcard_quantity') : <span class="text-success">{?valid_pcard_quantity?}</span>,&nbsp;&nbsp;&nbsp;
					@lang('lang.toselect_pcard_quantity') : <span class="text-danger">{?order_size - valid_pcard_quantity?}</span>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="row sub_panel_lavel margin0 text-center">
					<h5>@lang('lang.selected_physical_card')</h3>
				</div>
				<div class="row margin0 text-left">
					<ol class="list-group card_code_list" id="card_code_list">
						<li class="list-group-item" ng-repeat="(key, item) in valid_pcard_list ">
						{?item.code?} <span class="badge"><a class="text-danger" ng-click="remove_code(key)">x</a></span>
						</li>
					</ol>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>

		<div class="alert alert-success alert-return-success" role="alert">
			@lang('lang.rg_success_save')
		</div>
		<div class="alert alert-danger alert-return-danger" role="alert">
			@lang('lang.rg_fail_save')
		</div>
		
		
		<div class="col-xs-12 paddingtop10 paddingbot10 text-center">
			<button class="btn bg999" ng-class="{'bg39f':order_size&&(card_type==0||(card_type==1&&order_size==valid_pcard_quantity))}" ng-disabled="!order_size||(card_type!=0&&(card_type!=1||order_size!=valid_pcard_quantity))" onclick="angular.element(this).scope().show_confirm(this)">
				<span class="text-white fontsize1_2 padding-lf-7">@lang('lang.st_return_request')</span>
				<span class="text-white fontsize1_2 padding-lf-7" ng-show="order_size">@lang('lang.label_total') {? product.price_info.promotion==null ? product.price_info.purchase_price * order_size : (product.price_info.purchase_price * product.price_info.promotion.promotion_price / 100) * order_size ?}元</span>
			</button>
		</div>
		
	</div>				
	
	<div id="confirm_dlg" class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog width40 paddingtop50">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center">@lang('lang.st_return_notify')</h4>
				</div>
				<div class="modal-body text-center txt_bold fontsize1_4">
					{? product.price_info.promotion==null ? product.price_info.purchase_price * order_size : (product.price_info.purchase_price * product.price_info.promotion.promotion_price / 100) * order_size ?}元
				</div>
				<div class="modal-footer">
					<div class="col-xs-6 nopadding text-center">
						<button ng-click="order_return()" type="button" class="btn btn-success color_white width60">@lang('lang.confirm')</button>
					</div>
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn btn-secondary color_white width60" data-dismiss="modal">@lang('lang.cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	