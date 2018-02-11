
<div class="stock_content">
	<div class="col-xs-12 bg_white nopadding marginbot10 item out_border1" ng-repeat="item in items">
		<div class="col-xs-6 code_item">{?item.code?}</div>
		<div class="col-xs-6 code_item">{?item.register_date?}</div>
	
		<div class="col-xs-6 code_item">{?item.card.code?}</div>
		<div class="col-xs-6 code_item">
			<span ng-show="item.card">@lang('lang.sl_registered')</span>
			<span ng-show="!item.card">@lang('lang.sl_unlimited')</span>
		</div>
	</div>
	
	<div class="col-xs-12 item text-center nopadding margin0" ng-show="busy"><img src="./images/loading.gif" style="width: 15px; height: 15px;"> @lang('lang.now_loading')...</div>
</div>

<div id="successDlg" class="reg_success_modal modal fade" role="dialog">
	<div class="modal-dialog width90">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 ng-if="success==0" class="modal-title text-center paddingtop30">{? machine_code ?} @lang('lang.success_machine_code_m')</h4>
				<h4 ng-if="success==1" class="modal-title text-center paddingtop30">{? machine_code ?} @lang('lang.exist_machine_code_m')</h4>
				<h4 ng-if="success==2" class="modal-title text-center paddingtop30">{? machine_code ?} @lang('lang.fail_machine_code_m')</h4>
			</div>
			<div class="modal-footer">
				<div class="col-xs-12 nopadding text-center">
					<button type="button" class="btn bg999 color_white width80" data-dismiss="modal">@lang('lang.close')</button>
				</div>
			</div>
		</div>
	</div>
</div>