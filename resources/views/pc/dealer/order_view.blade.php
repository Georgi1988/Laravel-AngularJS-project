	<div class="block">
		<a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a>
	</div>
	
	<div class="subtitle paddingtop15">
		@lang('lang.od_detail')
	</div>
	<div class="backgroundwhite" style="font-size: 13px;" ng-show="loaded">
		<div class="col-sm-12">
			<div class="col-sm-3 paddingtopbottom10">
				<div class="col-sm-5 textright fontcolor777">
					@lang('lang.od_number'):
				</div>
				<div class="col-sm-7  fontcolor777">
					{?order_set[0].code?}
				</div>
				<div class="clearboth"></div>
				<div class="col-sm-5 textright fontcolor777">
					@lang('lang.od_order_date'):
				</div>
				<div class="col-sm-7 fontcolor777">
					{?order_set[0].created_at?}
				</div>
				<div class="clearboth"></div>
			</div>
			<div class="col-sm-3 paddingtopbottom10" ng-show="order_set[0].agree">
				<div class="col-sm-5 textright fontcolor777">
					@lang('lang.label_dealer'):
				</div>
				<div class="col-sm-7 fontcolor777">
					{?dealer.name?}
				</div>
				<div class="clearboth"></div>
				<div class="col-sm-5 textright fontcolor777">
					@lang('lang.od_order_type'):
				</div>
				<div class="col-sm-7 fontcolor777" ng-show="order_set[0].status==0">
					@lang('lang.purchase')
				</div>
				<div class="col-sm-7 fontcolor777" ng-show="order_set[0].status==1">
					@lang('lang.return')
				</div>
				<div class="clearboth"></div>
			</div>
			<div class="col-sm-3 paddingtopbottom10">
				<div class="col-sm-5 textright fontcolor777">
					@lang('lang.u_office_level'):
				</div>
				<div class="col-sm-7 fontcolor777">
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
				<div class="clearboth"></div>
				<div class="col-sm-5 textright fontcolor777">
					@lang('lang.od_effective_time1'):
				</div>
				<div class="col-sm-7 fontcolor777">
					{?order_set[0].valid_period?}
				</div>
				<div class="clearboth"></div>
			</div>
			<div class="col-sm-3 paddingtopbottom10">
				<div class="col-sm-6 textright fontcolor777">
					<div ng-class="{fontcolorblue: order_set[0].status==0,fontcolorgreen:order_set[0].status==1}">
						<span ng-show="order_set[0].status==0">@lang('lang.purchase')</span>
						<span ng-show="order_set[0].status==1">@lang('lang.return')</span>
						@lang('lang.label_total')：
					</div>
				</div>
				<div class="col-sm-6 fontcolor777">
					{?total_count?} @lang('lang.label_card_unit')
				</div>
				<div class="clearboth"></div>
				<div class="col-sm-6 textright fontcolor777">
					<div ng-class="{fontcolorgreen:order_set[0].agree==0&&order_set[0].status==1,fontcolorred:order_set[0].agree==1||order_set[0].status==0}">
						@lang('lang.od_total_price')：
					</div>
				</div>
				<div class="col-sm-6 fontcolor777">
					{?additional_info.total_price?} 元
				</div>
			</div>
		</div>
		<div class="block borderbottomblue order_product_set">
			<table class="table">
				<thead>
				<tr>
					<th>@lang('lang.pr_item_name')</th>
					<th>@lang('lang.st_physical_card') / @lang('lang.st_virtual_card')</th>
					<th>@lang('lang.unit_price')</th>
					<th>@lang('lang.quantity')</th>
					<th>@lang('lang.pur_purchase_price')</th>
					<th>@lang('lang.note')</th>
					{{--<th>@lang('lang.pr_item_name')</th>--}}
				</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in order_set" style="height: 30px;">
						<td>
							{?item.product.name?}
						</td>
						<td>
								<span ng-if="item.card_type==1">@lang('lang.st_physical_card')</span>
								<span ng-if="item.card_type==0">@lang('lang.st_virtual_card')</span>
						</td>
						<td>
							<div ng-class="{fontcolorred:item.agree==0}">{?item.price_info.real_purchase_price?} 元</div>
						</td>
						<td>
							{?item.size?}
						</td>
						<td>
							{?item.price_info.real_purchase_price * item.size?}
						</td>
						<td>
							<div class="left width95 fontcolorred" ng-show="order_set[0].agree==0&&item.current_stock<item.size">
								@lang('lang.st_insufficient_stock')： @lang('lang.ov_stock_cards') {?item.current_stock?} @lang('lang.label_card_unit')
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<!-- Card select part -->
		<div class="pcard_select_panel left width100 item paddingtopbottom10 bg-info border-round8" ng-show="additional_info.can_agree==true&&order_set[0].agree==0&&order_set[0].card_type==1&&order_set[0].status==0">
			<div class="col-xs-6 right-border-secondary">
				<div class="row sub_panel_lavel margin0 text-center">
						<h5>@lang('lang.select') @lang('lang.st_physical_card')</h3>
				</div>
				<div class="row margin0">
				
					<div class="row margin0">
						<form id="pcard_file_form" ng-submit="import_card_insert()">
							<input type="hidden" name="product_id" value="{? order_set[0].product.id ?}">
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
								<span class="alert_required" ng-show="required_file">@lang('lang.field_required')</span>
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
					@lang('lang.toselect_pcard_quantity') : <span class="text-danger">{?order_set[0].size - valid_pcard_quantity?}</span>
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

		<div ng-show="additional_info.can_agree==true">
			<div class="block textcenter" ng-show="order_set[0].agree==0&&order_set[0].status==0">
				<button ng-click="agree_order()" class="btn basicbtn" ng-disabled="additional_info.stock_lack || (order_set[0].card_type == 1 && order_set[0].size != valid_pcard_quantity)">@lang('lang.ms_purchase_agree')<span class="loading_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
				<a ng-click="refuse_order();" class="cancelbtn">@lang('lang.od_refusal')</a>
			</div>	
			<div class="block textcenter" ng-show="order_set[0].agree==0&&order_set[0].status==1">
				<button ng-click="agree_order()" class="btn basicbtn bggreen" ng-disabled="additional_info.stock_lack">@lang('lang.od_agree_return')<span class="loading_icons" ng-show="ajax_loading_refus">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
				<a ng-click="refuse_order();" class="cancelbtn">@lang('lang.od_refusal')</a>
			</div>	
			<div class="block" ng-show="order_set[0].agree==0">
				<p class="textcenter fontcolor777" style="text-align: center;">注：超过30天未审核订单将自动作废。</p>
			</div>
		</div>
		
		
		<div class="alert alert-success alert-save-success" style="display: none;">
			@lang('lang.rg_success_save')
		</div>
		<div class="alert alert-danger alert-save-fail" style="display: none;">
			@lang('lang.rg_fail_save')
		</div>
		<div class="success_refused" style="display: none;">
			@lang('lang.rg_success_refused')
		</div>
		<div class="fail_refus" style="display: none;">
			@lang('lang.rg_fail_refus')
		</div>
	
		<div class="block"></div>
	</div>