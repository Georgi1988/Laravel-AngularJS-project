<div ng-controller="generateAddController" style="display:none" class="generateadd">
	<form name="generateAddForm" id="generateAddForm" ng-submit="submitForm(generateAddForm.$valid)" ng-controller="generateAddController" novalidate>
		<div class="prod_v_thumb text-center">
			<img class="img-rounded" ng-src="{?generateAddFormData.image_url?}">
		</div>
		<div class="col-xs-12 prod_v_content paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding text-right">@lang('lang.no')</div>
				<div class="value col-xs-8">{?generateAddFormData.service_card_code?}</div>
			</div>
			<div class="info">
				<div class="type col-xs-3 nopadding text-right">@lang('lang.define_name')</div>
				<div class="value col-xs-8">{?generateAddFormData.service_card_name?}</div>
			</div>
			<div class="info">
				<div class="type col-xs-3 nopadding text-right">@lang('lang.type')</div>
				<div class="value col-xs-8">{?generateAddFormData.product_typestr_level1?} - {?generateAddFormData.product_typestr_level2?} {?generateAddFormData.product_typestr_level3 | prev_dash ?}</div>
			</div>
		</div>
		<div class="col-xs-12 prod_v_content bg_white paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding paddingtop5 text-right">@lang('lang.gen_mcard_type')</div>
				<div class="value col-xs-8">
					<select class="edit_field card_expiry_date" ng-options="service_card_type.label for service_card_type in generateAddFormData.service_card_types.availableOptions track by service_card_type.val" ng-model="generateAddFormData.service_card_types.selectedOption" disabled></select>
				</div>
			</div>
		</div>
		<div class="col-xs-12 prod_v_content paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding paddingtop5 text-right">@lang('lang.quantity')</div>
				<div class="value col-xs-8 ">
					<input type="number" name="service_cards" class="edit_field service_cards" min="1" max="9999" ng-model="generateAddFormData.service_cards" ng-change="revalue()" required>
					 <p ng-show="generateAddForm.service_cards.$error.required" class="error_block">@lang('lang.field_required_s')</p>
					 <p ng-show="generateAddForm.service_cards.$error.pattern" class="error_block">@lang('lang.rg_invalid_number')</p>
						<p ng-show="generateAddForm.service_cards.$error.max || generateAddForm.service_cards.$error.min" class="error_block">@lang('lang.gen_invalid_number10000')</p>
				</div>
			</div>
		</div>
		<div class="col-xs-12 prod_v_content bg_white paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding paddingtop5 text-right">@lang('lang.1st_level_dealer')</div>
				<div class="value col-xs-8">
					<select class="form-control" name="send_dealer" ng-model="generateAddFormData.send_dealer" required>
						<option value=""></option>
						<option ng-repeat="dealer in generateAddFormData.dealers_1stlevel" value="{?dealer.id?}">{? dealer.name ?}</option>
					</select>
					<p ng-show="generateAddForm.send_dealer.$error.required" class="error_block paddingleft10">@lang('lang.field_required_s')</p>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
		<div class="col-xs-12 prod_v_content paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding text-right">@lang('lang.valid period')</div>
				<div class="value col-xs-8 ">{?generateAddFormData.valid_period | months_to_string ?}
				</div>
			</div>
		</div>
		<div class="col-xs-12 prod_v_content bg_white paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding text-right">@lang('lang.rule')</div>
				<div class="value col-xs-9">
					<!--<select class="edit_field card_rules" ng-options="card_rule.label for card_rule in generateAddFormData.card_rules.availableOptions track by card_rule.val" ng-model="generateAddFormData.card_rules.selectedOption"></select>-->
					{? generateAddFormData.card_rule.rule_name ?} ( {? generateAddFormData.card_rule.card_code_length ?}@lang('lang.bytes') - @lang('lang.gen_card_rule_fieldtype') {? generateAddFormData.card_rule.length_type ?} )
				</div>
			</div>
			<div class="info">
				<div class="type col-xs-3 nopadding text-right">@lang('lang.gen_card_rule_pwd_length')</div>
				<div class="value col-xs-8">
					{? generateAddFormData.card_rule.password_length ?}<span>@lang('lang.bytes')</span> 
						(
							<span ng-show="generateAddFormData.card_rule.password_type == 'n'">@lang('lang.password_type1')</span>
							<span ng-show="generateAddFormData.card_rule.password_type == 'l'">@lang('lang.password_type2')</span>
							<span ng-show="generateAddFormData.card_rule.password_type == 'l+n'">@lang('lang.password_type3')</span>
						)
				</div>
			</div>
		</div>
		<!--<div class="col-xs-12 prod_v_content paddingbot15">
			<div class="info">
				<div class="type col-xs-3 nopadding">@lang('lang.gen_card_no_example')：</div>
				<div class="value col-xs-8 nopadding">10102 + 0010 + 1234567</div>
			</div>
			<div class="info">
				<div class="type col-xs-3"></div>
				<div class="value col-xs-8 nopadding fontsize0_9 color_blue">
					@lang('lang.gen_card_part_id')&nbsp;&nbsp;&nbsp;&nbsp;@lang('lang.gen_card_part_area')&nbsp;&nbsp;&nbsp;&nbsp;@lang('lang.gen_card_part_random')
				</div>
			</div>
			<div class="info">
				<div class="type col-xs-3 nopadding">@lang('lang.gen_pwd_example')：</div>
				<div class="value col-xs-8 nopadding">2h7s9w4b</div>
			</div>
		</div>-->
		<div class="prod_v_activation bg5ac8fa text-center" style="padding:0;margin:0;position:relative">
			<input type="submit" style="width:100%;padding:10px 0px" class="" ng-class="generateAddForm.$invalid ? 'bggray-disabled' : 'bg5ac8fa'" ng-disabled="generateAddForm.$invalid" value="@lang('lang.gen_btn_generate')">
			<span class="absolute_icons" ng-show="ajax_loading"><img src="./images/loading_now.gif" class="submit_small_icons"></span>
		</div>
		
		<div id="gen_result_dlg" class="reg_success_modal modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-body text-center margintop20">
						<p>
						@if(app()->getLocale() == 'en')
							{?generateAddFormData.service_cards?} {?generateAddFormData.service_card_name?} @lang('lang.gen_check_next')
						@elseif(app()->getLocale() == 'cn')
							@lang('lang.gen_check_priv'){?generateAddFormData.service_cards?}@lang('lang.gen_check_count'){?generateAddFormData.service_card_name?}@lang('lang.gen_check_next')
						@endif
						</p>
						<p>@lang('lang.gen_service_card_code')：{?generateAddFormData.service_card_code?}
						</p>
						<p>@lang('lang.gen_service_card_expiry_date')：{?generateAddFormData.valid_period | months_to_string ?}
						</p>
						<p>@lang('lang.gen_select_the_service_card_type')：{?generateAddFormData.service_card_types.selectedOption.label?}
						</p>
					</div>
					<div class="modal-footer">
						<div class="col-xs-12 nopadding text-center">
							<button type="button" class="confirm btn bg39f color_white" data-dismiss="modal">@lang('lang.confirm')</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>	
</div>	

<script>
	//$("#gen_result_dlg").modal({backdrop: 'static', keyboard: false});
</script>