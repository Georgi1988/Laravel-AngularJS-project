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
			<div class="col-xs-8 fontsize1_1 text-left">
				@lang('lang.st_stock_shortage_warning')
			</div>
			<div class="col-xs-4 nopadding icon text-center switchbox">
				<input class="switch" type="checkbox" name="stock_less_notify_status" value="1" ng-checked="options.stock_less_notify_status==1">
			</div>
		</div>
		<div class="col-xs-12 bg_white nopadding margintop20 setting_item">
			<div class="col-xs-8 fontsize1_1 text-left">
				@lang('lang.st_stock_shortage_warning_count')
			</div>
			<div class="col-xs-4 nopadding icon text-center">
				<input class="edit_field width80 pad-left5" type="number" name="stock_less_notify_value" value="{?options.stock_less_notify_value?}">
			</div>
		</div>
		<div class="col-xs-12 bg_white nopadding margintop30 setting_item">
			<div class="col-xs-8 fontsize1_1 text-left">
				@lang('lang.st_stock_expire_warning')
			</div>
			<div class="col-xs-4 nopadding icon text-center switchbox">
				<input class="switch" type="checkbox" name="stock_expire_notify_status" value="1" ng-checked="options.stock_expire_notify_status==1">
			</div>
		</div>
		<div class="col-xs-12 bg_white nopadding margintop20 setting_item">
			<div class="col-xs-8 fontsize1_1 text-left">
				@lang('lang.st_stock_expire_warning_count')
			</div>
			<div class="col-xs-4 nopadding icon text-center">
				<input class="edit_field width80 pad-left5" type="number" name="stock_expire_notify_value" value="{?options.stock_expire_notify_value?}">
			</div>
		</div>
		<p>&nbsp;</p>
	</form>
</div>