<div class="subheader bg_white">
	<span class="item" ng-class="{'active': activeMenu == ''}">
		<a ng-click="view_by_categ('')">@lang('lang.pr_item_all')</a>
	</span>
	<span class="item" ng-class="{'active': activeMenu === categitem.id}" ng-repeat = "categitem in categitems"><a ng-click="view_by_categ(categitem.id)">{?categitem.description?}</a></span>
</div>
<div class="in_content">
	<div class="list">
		<div class="col-xs-12 item padding0 marginbot15 out_border1" ng-repeat = "item in items track by $index">
			<div class="col-xs-2 nopadding paddingtop25 check text-center">
				@if ($setting['order_purchase_multi'] == '1')
				<input type="checkbox" id="radio-2-{?item.id?}" name="check_list" ng-model="isRadio[$index]" class="regular-radio big-radio" ng-click="checkdata(item, $index)" />
				<label for="radio-2-{?item.id?}"></label>
				@endif
			</div>
			<div class="col-xs-4 nopadding">
				<div class="icon text-center">
					<img class="img-rounded width90" ng-src="{?item.image_url?}">
				</div>
				<p class="paddingtop5 margin0">
					@lang('lang.define_name')：{?item.name?}
				</p>
			</div>
			<div class="col-xs-6 nopadding">
				<div class="col-xs-12 nopadding">
					<div class="col-xs-6 nopadding paddingtop5 text-center">
						@lang('lang.pur_purchase_price')<br>
						{?item.viewprice?} @lang('lang.label_cn_cunit')
					</div>
					<div class="col-xs-6 nopadding paddingtop5 text-center">
						<input type="number" name="size_{?item.id?}" class="cards edit_field width90 fontsize1_2" placeholder="" ng-min="(item.min_order_val-1)" ng-max="item.max_order_val" @if ($setting['order_purchase_multi'] == '1') ng-change="getData($index, item);" ng-model="cardcount[$index]" readonly @endif>
						@if ($setting['order_purchase_multi'] == '1')
							<input type="hidden" class="tempcards" value="0" />
						@endif
					</div>	
					<p class="col-xs-12 numtooltip" style="font-size:0.85em;color:#a94442;display:none">@lang('lang.pur_invalid_prev1'){?item.min_order_val?}@lang('lang.pur_invalid_prev2'){?item.max_order_val?}@lang('lang.pur_invalid_prev3')</p>
				</div>
				<div class="col-xs-12 nopadding">
					<div class="col-xs-6 nopadding paddingtop10 text-center">
						@lang('lang.gen_mcard_type')
					</div>
					<div class="col-xs-6 nopadding paddingtop10 text-center">
							<select class="edit_field card_types" name="card_type" @if ($setting['order_purchase_multi'] == '1') ng-blur="getData($index, item);" disabled @endif>
								<option value="1">@lang('lang.st_physical_card')</option>
								<option value="0" selected="selected">@lang('lang.st_virtual_card')</option>
								<option value="2">@lang('lang.st_virtual_sp_card')</option>
							</select>
					</div>
				</div>
				<div class="col-xs-12 paddingtop20 text-center">
				@if ($setting['order_purchase_multi'] != '1')
					<a ng-click="insertitem(item, $index)" type="button" class="btn bg39f color_white width60">@lang('lang.confirm')</span></a>
				@endif
				</div>
			</div>
		</div>
		<div class="nodata" ng-show="nodata">@lang('lang.str_no_data')</div>
		<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
		
		
		<div class="clearfix"></div>
	</div>
	
	<div id="confirm_dlg" class="reg_success_modal modal fade" role="dialog">
		<div class="modal-dialog width90">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center">@lang('lang.confirm')</h4>
				</div>
				<div class="modal-body text-center txt_bold fontsize1_4">
					{?totalprice?}元
				</div>
				<div class="alert alert_small alert-success" role="alert">
					@lang('lang.rg_success_save')
				</div>
				<div class="alert alert_small alert-danger" role="alert">
					@lang('lang.rg_fail_save')
				</div>
				<div class="modal-footer">
					<div class="col-xs-6 nopadding text-center">
						<a ng-click="multi_insert(sendData)" type="button" class="btn bg39f color_white width60">@lang('lang.confirm')<span ng-show="ajax_loading">&nbsp;<img class="loading_img" src="{{url('')}}/images/loading.gif"></span></a>
					</div>
					<div class="col-xs-6 nopadding text-center">
						<button type="button" class="btn bg999 color_white width60" data-dismiss="modal" ng-disabled="ajax_loading">@lang('lang.cancel')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="successconfirm_dlg" class="modal fade" role="dialog">
		<div class="modal-dialog width90">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center">@lang('lang.pur_continue_work')</h4>
					<div class="modal-body text-center txt_bold fontsize1_4">
						{?totalprice?}元
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-xs-12 nopadding text-center">
						<button type="button" class="confirm btn bg39f color_white" data-dismiss="modal">@lang('lang.confirm')</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="in_purchase bg5ac8fa text-center" ng-show="buttonview" ng-class="buttonview ? 'bg5ac8fa' : 'bggray-disabled'">
		<a data-toggle="modal" data-target=".reg_success_modal" >@lang('lang.st_purchase_soon')  @lang('lang.total') {?totalprice?} @lang('lang.label_cn_cunit')</a>
	</div>
		
	<script>
		//$(".reg_success_modal").modal({backdrop: 'static', keyboard: true});
	</script>
	
</div>