<form id="editForm" class="form-horizontal" ng-submit="form_submit()" method="POST">
	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
	
	<div class="page-title clearfix">
		<div class="pull-left">
			<h1>@lang('lang.label_system_setting')</h1>
			<small><a href="#!/message" class="subtitle">< @lang('lang.label_back')</a></small>
		</div>
		<ol class="breadcrumb pull-right">
			<input type="submit" class="btn btn-danger" value="@lang('lang.pr_item_save')">
		</ol>
	</div>

	<div class="alert alert-success" style="display: none;">
		@lang('lang.rg_success_save')
	</div>
	<div class="alert alert-danger" style="display: none;">
		@lang('lang.rg_fail_save')
	</div>

	<div class="conter-wrapper col-md-12">
		<!-- Password setting -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">@lang('lang.password_setting')</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="password_length" class="col-sm-3 control-label">@lang('lang.password_length')</label>
					<div class="col-sm-5">
						<input type="number" class="form-control" name="password_length" id="password_length" value="{?options.password_length?}" min="4">
					</div>
				</div>
			</div>
		</div>
		
		<!-- Stock setting -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">@lang('lang.set_inventory_reminder')</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="stock_less_notify_status" class="col-sm-3 control-label">@lang('lang.set_inventory_is_low')</label>
					<div class="col-sm-5">
						<input class="switch" type="checkbox" name="stock_less_notify_status" id="stock_less_notify_status" value="1" ng-checked="options.stock_less_notify_status==1">
					</div>
				</div>
				<div class="form-group">
					<label for="stock_less_notify_value" class="col-sm-3 control-label">@lang('lang.set_stock_is_low')（@lang('lang.label_card_unit')）</label>
					<div class="col-sm-5">
						<input type="number" name="stock_less_notify_value" id="stock_less_notify_value" class="form-control" value="{?options.stock_less_notify_value?}">
					</div>
				</div>
				<div class="form-group">
					<label for="stock_expire_notify_status" class="col-sm-3 control-label">@lang('lang.set_inventory_fail')</label>
					<div class="col-sm-5">
						<input class="switch" type="checkbox" name="stock_expire_notify_status" id="stock_expire_notify_status" value="1" ng-checked="options.stock_expire_notify_status==1">
					</div>
				</div>
				<div class="form-group">
					<label for="stock_expire_notify_value" class="col-sm-3 control-label">@lang('lang.set_inventory_warning_time')（@lang('lang.days')）</label>
					<div class="col-sm-5">
						<input type="number" name="stock_expire_notify_value" id="stock_expire_notify_value" class="form-control" value="{?options.stock_expire_notify_value?}">
					</div>
				</div>
			</div>
		</div>

		<!-- Password setting -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">@lang('lang.od_setting')</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="order_purchase_multi" class="col-sm-3 control-label">@lang('lang.set_allow_warning_product')</label>
					<div class="col-sm-5">
						<input class="switch" type="checkbox" name="order_purchase_multi" id="order_purchase_multi" value="1" ng-checked="options.order_purchase_multi==1">
					</div>
				</div>
				<div class="form-group">
					<label for="order_valid_period" class="col-sm-3 control-label">@lang('lang.set_order_service_card')（@lang('lang.days')）</label>
					<div class="col-sm-5">
						<input type="number" name="order_valid_period" id="order_valid_period" class="form-control" value="{?options.order_valid_period?}">
					</div>
				</div>
				<div class="form-group">
					<label for="order_single_minium" class="col-sm-3 control-label">@lang('lang.od_minval_single_purchase')</label>
					<div class="col-sm-5">
						<input type="number" name="order_single_minium" id="order_single_minium" class="form-control" value="{?options.order_single_minium?}">
					</div>
				</div>
				<div class="form-group">
					<label for="order_single_maxium" class="col-sm-3 control-label">@lang('lang.set_single_product')</label>
					<div class="col-sm-5">
						<input type="number" name="order_single_maxium" id="order_single_maxium" class="form-control" value="{?options.order_single_maxium?}">
					</div>
				</div>
			</div>
		</div>

		<!-- Password setting -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">@lang('lang.rew_reward_setting')</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="red_packet" class="col-sm-3 control-label">@lang('lang.rew_sales_award_bonus')</label>
					<div class="col-sm-5">
						<input class="switch" type="checkbox" name="red_packet" id="red_packet" value="1" ng-checked="options.red_packet==1">
					</div>
				</div>
				<div class="form-group">
					<label for="red_packet_sales" class="col-sm-3 control-label">@lang('lang.set_total_amount')</label>
					<div class="col-sm-5">
						<input type="number" class="form-control" name="red_packet_sales" id="red_packet_sales" value="{?options.red_packet_sales?}">
					</div>
				</div>
				<div class="form-group">
					<label for="red_packet_monthly" class="col-sm-3 control-label">@lang('lang.set_sales_cross')</label>
					<div class="col-sm-5">
						<input class="switch" type="checkbox" name="red_packet_monthly" id="red_packet_monthly" value="1" ng-checked="options.red_packet_monthly==1">
					</div>
				</div>
				<div class="form-group">
					<label for="red_packet_price" class="col-sm-3 control-label">@lang('lang.rew_sales_bonus_price')</label>
					<div class="col-sm-5">
						<input type="number" class="form-control" name="red_packet_price" id="red_packet_price" value="{?options.red_packet_price?}">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
