<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>
<div class="order_v_content" style="display:none">
	<div class="info bg_white paddingbot15">
		<div class="row margin0">
			<div class="col-xs-12 nopadding text-muted">
				<div class="row margin0 paddingbot10">
					<div class="col-xs-9 paddingtop10 fontsize1_2">{?dealer.name?}</div>
					<div class="col-xs-3 type type_in text-center color_f90 txt_bold" ng-show="order_set[0].status==0">@lang('lang.purchase')</div>
					<div class="col-xs-3 type type_in text-center color_090 txt_bold" ng-show="order_set[0].status==1">@lang('lang.return')</div>
				</div>
				<div class="row margin0 paddingbot10">
					<div class="col-xs-4">
						<span ng-show='dealer.level==1'>@lang('lang.1st_level_dealer')</span>
						<span ng-show='dealer.level==2'>@lang('lang.2nd_level_dealer')</span>
						<span ng-show='dealer.level==3'>@lang('lang.3rd_level_dealer')</span>
						<span ng-show='dealer.level==4'>@lang('lang.4th_level_dealer')</span>
						<span ng-show='dealer.level==5'>@lang('lang.5th_level_dealer')</span>
						<span ng-show='dealer.level==6'>@lang('lang.6th_level_dealer')</span>
						<span ng-show='dealer.level==7'>@lang('lang.7th_level_dealer')</span>
						<span ng-show='dealer.level==8'>@lang('lang.8th_level_dealer')</span>
						<span ng-show='dealer.level==9'>@lang('lang.9th_level_dealer')</span>
						<span ng-show='dealer.level==10'>@lang('lang.10th_level_dealer')</span>
						<span ng-show='dealer.level==11'>@lang('lang.11th_level_dealer')</span>
						<span ng-show='dealer.level==12'>@lang('lang.12th_level_dealer')</span>
						<span ng-show='dealer.level==13'>@lang('lang.13th_level_dealer')</span>
						<span ng-show='dealer.level==14'>@lang('lang.14th_level_dealer')</span>
						<span ng-show='dealer.level==15'>@lang('lang.15th_level_dealer')</span>
						<span ng-show='dealer.level==16'>@lang('lang.16th_level_dealer')</span>
						<span ng-show='dealer.level==17'>@lang('lang.17th_level_dealer')</span>
						<span ng-show='dealer.level==18'>@lang('lang.18th_level_dealer')</span>
						<span ng-show='dealer.level==19'>@lang('lang.19th_level_dealer')</span>
						<span ng-show='dealer.level==20'>@lang('lang.20th_level_dealer')</span>
					</div>
					<div class="col-xs-8 text-right" ng-show="order_set[0].agree==0">{?order_set[0].created_at?}</div>
					<div class="col-xs-8 text-right" ng-show="order_set[0].agree==1">{?order_set[0].valid_period?}</div>
				</div>
			</div>
		</div>
		<div class="row margin0">
			<div class="col-xs-12">
				@lang('lang.od_order_no')：{?order_set[0].code?}
				<span ng-show="additional_info.can_agree==false">&nbsp;&nbsp;&nbsp;&nbsp;
					<span ng-show="order_set[0].agree==0">@lang('lang.order_unapproved')</span>
					<span ng-show="order_set[0].agree==1">@lang('lang.order_approved')</span>
				</span>
			</div>
		</div>
	</div>
	<div class="list">
		<!-- Product order list -->
		<div class="item paddingtop15 paddingbot10" ng-repeat="item in order_set">
			<div class="col-xs-4 padding-lf-7 text-center">
				<img class="img-rounded width90" ng-src="{?item.product.image_url?}">
			</div>
			<!--<div class="col-xs-5">
				<p class="marginbot5">{?item.product.name?}</p>
				<p class="text-muted margin0">@lang('lang.type')：{?item.product.level1_info.description?}</p>
			</div>
			<div class="col-xs-3 text-right">
				<p class="margin0">￥{?item.price_info.real_purchase_price?}</p>
				<p class="text-muted marginbot5">X {?item.size?}</p>
				<p class="txt_bold margin0">{?item.price_info.real_purchase_price * item.size?}元</p>
			</div>-->
			
			<div class="col-xs-8 nopadding">
				<div class="col-xs-12 nopadding">
					{?item.product.name?}
					（
					<span ng-if="item.card_type==1">@lang('lang.st_physical_card')</span>
					<span ng-if="item.card_type==0">@lang('lang.st_virtual_card')</span>
					）
				</div>
				<div class="col-xs-12 color_gray">
					@lang('lang.type')：{?item.product.level1_info.description?}
				</div>
				<div class="col-xs-12 color_gray">
					￥{?item.price_info.real_purchase_price?} X {?item.size?}@lang('lang.label_card_unit') : {?item.price_info.real_purchase_price * item.size?}元
				</div>
				<div class="col-xs-12 color_f90" ng-show="additional_info.can_agree==true&&order_set[0].agree==0&&item.current_stock<item.size">
					@lang('lang.st_insufficient_stock')： @lang('lang.ov_stock_cards') {?item.current_stock?} @lang('lang.label_card_unit')
				</div>
			</div>			
			<div class="clearfix"></div>
		</div>
		
		<!-- Card select part -->
		<div class="pcard_select_panel left width100 item paddingtopbottom10 border-round8" ng-show="additional_info.can_agree==true&&order_set[0].agree==0&&order_set[0].card_type==1&&order_set[0].status==0">
			<div class="row sub_panel_lavel margin0 text-center">
				<h5 class="text-info">@lang('lang.select') @lang('lang.st_physical_card')</h3>
			</div>
			<div class="col-xs-12">
				<div class="row sub_panel_lavel margin0 text-left">
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
			<div class="col-xs-12 right-border-secondary">
				<div class="row margin0">
					<div class="row margin0">
						<form id="pcard_file_form" ng-submit="import_card_insert()">
							<input type="hidden" name="product_id" value="{? order_set[0].product.id ?}">
							<div class="col-xs-12 margin0 text-left padding0">@lang('lang.card_code_s')@lang('lang.template_file')</div>
							<div class="col-xs-9 padding0 overflow-hidden">
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
							<div class="col-xs-3 padding0 text-right">
								<button type="submit" class="btn btn-info padding_3-6 font-size">
									<small>@lang('lang.import')</small>
									<span class="loading_icons" ng-show="cardtemp_loading"><img src="./images/loading_now.gif"></span>
								</button>&nbsp;
								<!--<a href="{{url('contents/import/physical_card/physical_card_import_sample.xlsx')}}" class="fontcolorblue">	
									<span class="glyphicon glyphicon-download-alt"></span> @lang('lang.template_sample')
								</a>-->
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
							<div class="col-xs-12 text-left padding0">@lang('lang.physical_card_code')</div>
							<div class="col-xs-6 padding0">
								<input type="text" id="each_card_code" name="each_card_code" class="form-control" required>
							</div>
							<div class="col-xs-6 padding0 text-right">
								<a class="btn btn-info padding_3-6 font-size" ng-click="scan_barcode()"><small><span class="glyphicon glyphicon-barcode"></span> @lang('lang.scan')</small></a>&nbsp;
								<button type="submit" class="btn btn-info padding_3-6 font-size"><small>@lang('lang.add')</small></button>&nbsp;
							</div>
						</div>
						<div class="row margin0 paddingtop10">
							<div class="col-xs-12 text-right alert alert-success alert-pcard-code-valid">
								@lang('lang.valid_pcard_code_s')
							</div>
							<div class="col-xs-12 text-right alert alert-danger alert-pcard-code-invalid">
								@lang('lang.invalid_pcard_code')
							</div>
						</div>
					</form>
				</div>
				<div class="row margin0 paddingtop10 text-center text-muted">
					@lang('lang.selected_pcard_quantity') : <span class="text-success">{?valid_pcard_quantity?}</span>,&nbsp;&nbsp;&nbsp;
					@lang('lang.toselect_pcard_quantity') : <span class="text-danger">{?order_set[0].size - valid_pcard_quantity?}</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="total paddingtop20 paddingbot20 bg_white text-right fontsize1_2 txt_bold" ng-class="{color_f90:order_set[0].status==0,color_090:order_set[0].status==1}">
			<div class="col-xs-12">@lang('lang.total')：{?additional_info.total_price?} 元</div>
			<div class="clearfix"></div>
		</div>
		
		<!-- Confirm button -->
		<div>
			<div class="col-xs-6 nopadding" ng-show="additional_info.can_agree==true">
				<div class="col-xs-12 color_white paddingtop10  paddingbot10 text-center txt_bold fontsize1_3" ng-class="{bg999:(additional_info.stock_lack || (order_set[0].card_type == 1 && order_set[0].size != valid_pcard_quantity)), bg5ac8fa:(!additional_info.stock_lack && (order_set[0].card_type !=1 || order_set[0].size == valid_pcard_quantity))}" ng-show="order_set[0].agree==0&&order_set[0].status==0">
					<a data-toggle="modal" data-target=".reg_success_modal" ng-show="!additional_info.stock_lack && (order_set[0].card_type !=1 || order_set[0].size == valid_pcard_quantity)">@lang('lang.od_order_confirm')</a>
					<a class="text-muted" ng-show="additional_info.stock_lack || (order_set[0].card_type == 1 && order_set[0].size != valid_pcard_quantity)">@lang('lang.od_order_confirm')</a>
				</div>
				<div class="col-xs-12 color_white paddingtop10  paddingbot10 text-center txt_bold fontsize1_3 bg5ac8fa" ng-show="order_set[0].agree==0&&order_set[0].status==1">
					<a data-toggle="modal" data-target=".reg_success_modal" ng-show="!additional_info.stock_lack">@lang('lang.od_order_confirm')</a>
					<a class="text-muted" ng-show="additional_info.stock_lack">@lang('lang.od_order_confirm')</a>
				</div>
			</div>
			<div class="nopadding" ng-class="{'col-xs-6':additional_info.can_agree==true,'col-xs-12':additional_info.can_agree==false}" ng-show="order_set[0].agree==0 && additional_info.can_agree==true">
				<div class="col-xs-12 color_white paddingtop10  paddingbot10 text-center txt_bold fontsize1_3" ng-class="{bg999:!order_set[0].agree==0,bgf90:order_set[0].agree==0}" ng-show="order_set[0].agree==0">
					<a data-toggle="modal" data-target=".refusal_success_modal" ng-show="order_set[0].agree==0">@lang('lang.od_refusal')</a>
					<a ng-show="order_set[0].agree!=0">@lang('lang.od_refusal')</a>
				</div>
			</div>
		</div>
		
		<div class="reg_success_modal modal fade" role="dialog">
			<div class="modal-dialog width90">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{?dealer.name?}</h4>
					</div>
					<div class="modal-body">
						<p class="txt_bold">
							<span ng-show="order_set[0].status==0">@lang('lang.od_purchase_total2')</span>
							<span ng-show="order_set[0].status==1">@lang('lang.od_return_total2')</span>
							{?additional_info.total_price?} 元， @lang('lang.od_is_it_correct')
						</p>
					</div>
					
					<div class="alert alert-success alert-save-success" role="alert">
						@lang('lang.rg_success_save')
					</div>
					<div class="alert alert-danger alert-save-fail" role="alert">
						@lang('lang.rg_fail_save')
					</div>
					
					<div class="modal-footer">
						<div class="col-xs-6 nopadding text-center">
							<button type="button" class="btn bg39f color_white" ng-click="agree_order()">@lang('lang.confirm')<span class="small_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
						</div>
						<div class="col-xs-6 nopadding text-center">
							<button type="button" ng-disabled="ajax_loading" class="btn bg999 color_white" data-dismiss="modal">@lang('lang.cancel')</button>
						</div>
					</div>
				</div>

			</div>
		</div>		
		<!-- Refusal Modal content-->
		<div class="refusal_success_modal modal fade" role="dialog">
			<div class="modal-dialog width90">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{?dealer.name?}</h4>
					</div>
					<div class="modal-body">
						<p class="txt_bold">
							<span ng-show="order_set[0].status==0">@lang('lang.od_purchase_total2')</span>
							<span ng-show="order_set[0].status==1">@lang('lang.od_return_total2')</span>
							{?additional_info.total_price?} 元， @lang('lang.od_is_it_correct')
						</p>
					</div>
					
					<div class="alert alert-success success_refused" role="alert">
						@lang('lang.rg_success_save')
					</div>
					<div class="alert alert-danger fail_refus" role="alert">
						@lang('lang.rg_fail_save')
					</div>
					
					<div class="modal-footer">
						<div class="col-xs-6 nopadding text-center">
							<button type="button" class="btn bg39f color_white" ng-click="refuse_order()">@lang('lang.od_refusal')<span class="small_icons" ng-show="ajax_loading_refus">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
						</div>
						<div class="col-xs-6 nopadding text-center">
							<button type="button" ng-disabled="ajax_loading_refus" class="btn bg999 color_white" data-dismiss="modal">@lang('lang.cancel')</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>