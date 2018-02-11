<form id="editForm" ng-submit="form_submit()" method="POST">
	<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
	<div class="block">
		<div class="left">
			<a href="#!/message" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="right">
			<input type="submit" class="periodselected period bgyellow settingbtn" value="@lang('lang.pr_item_save')">
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="alert alert-success" style="display: none;">
		@lang('lang.rg_success_save')
	</div>
	<div class="alert alert-danger" style="display: none;">
		@lang('lang.rg_fail_save')
	</div>
	<!-- Stock setting -->
	<div class="width97 backgroundwhite margintop15">
		<div class="generalblock bgblue paddingtopbottom10"><span class="paddingleft20 fontcolorwhite fontsize1p1">@lang('lang.set_inventory_reminder')</span></div>		
		<div class="block">
			<div class="marginauto width95">
				<div class="left width50">
					<div class="paddingtopbottom10">
						<div class="left width50 fontcolor777 lineheight40p">
							@lang('lang.set_inventory_is_low')
						</div>
						<div class="left fontcolor777 paddingleft10">
							<input class="switch" type="checkbox" name="stock_less_notify_status" value="1" ng-checked="options.stock_less_notify_status==1">
						</div>
						<div class="clearboth"></div>
					</div>
				</div>
				<div class="left width50">
					<div class="paddingtopbottom10">
						<div class="left width60 fontcolor777 lineheight40p">	@lang('lang.set_stock_is_low')（@lang('lang.label_card_unit')）
						</div>
						<div class="left fontcolor777 paddingleft10">
							<div class="searchlayout padding0">
								<input type="number" name="stock_less_notify_value" class="width80p" value="{?options.stock_less_notify_value?}">
							</div>
						</div>
						<div class="clearboth"></div>
					</div>
				</div>
				<div class="clearboth"></div>
			</div>
			<div class="borderbottomblue margintopbottom10"></div>			
			<div class="marginauto width95">
				<div class="left width50">
					<div class="paddingtopbottom10">
						<div class="left width50 fontcolor777 lineheight40p">
							@lang('lang.set_inventory_fail')
						</div>
						<div class="left fontcolor777 paddingleft10">
							<input class="switch" type="checkbox" name="stock_expire_notify_status" value="1" ng-checked="options.stock_expire_notify_status==1">
						</div>
						<div class="clearboth"></div>					
					</div>
				</div>
				<div class="left width50">
					<div class="paddingtopbottom10">
						<div class="left width60 fontcolor777 lineheight40p">
							@lang('lang.set_inventory_warning_time')（@lang('lang.days')）
						</div>
						<div class="left fontcolor777 paddingleft10">
							<div class="searchlayout padding0">
								<input type="number" name="stock_expire_notify_value" class="width80p" value="{?options.stock_expire_notify_value?}">
							</div>
						</div>
						<div class="clearboth"></div>
					</div>
				</div>
				<div class="clearboth"></div>
			</div>
		</div>		
	</div>
	
</form>