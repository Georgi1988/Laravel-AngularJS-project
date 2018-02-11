<div class="stock_v_content">
	<form id="editForm" ng-submit="form_submit()" method="POST">
		<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
		
		<div class="alert alert-success" role="alert">
			@lang('lang.rg_success_save')
		</div>
		<div class="alert alert-danger" role="alert">
			@lang('lang.rg_fail_save')
		</div>
		
		<div class="col-xs-12 bg_white nopadding margintop30 setting_item">
			<div class="col-xs-9 fontsize1_1 text-left">
				@lang('lang.od_allow_multiple_purchase')
			</div>
			<div class="col-xs-3 nopadding icon text-center switchbox">
				<input class="switch" type="checkbox" name="my-checkbox" checked>
			</div>
		</div>
		<div class="col-xs-12 bg_white nopadding margintop20 setting_item">
			<div class="col-xs-8 fontsize1_1 text-left">
				@lang('lang.od_minval_single_purchase')
			</div>
			<div class="col-xs-4 nopadding icon text-center switchbox">
				<input class="edit_field width80 pad-left5" type="text" name="" value="30">
			</div>
		</div>
	</form>
</div>