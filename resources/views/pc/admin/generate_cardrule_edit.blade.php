	<div class="block">
		<div class="col-xs-1">
			<a onclick="history.back(); return false;" class="subtitle">&lt @lang('lang.pr_return')</a>
		</div>
		<div class="col-xs-9 subtitle">
			<span ng-show="rule_id == 0">@lang('lang.gen_add_card_rule')</span>
			<span ng-show="rule_id != 0">@lang('lang.gen_edit_card_rule') : <small class="text-normal">rule1_werwe</small></span>
		</div>
	</div>
			<div class="clearfix"></div>
			<hr class="style1">
	<div class="card-rule-editpanel">
		<div class="row ">
			<div class="col-xs-12 paddingtop10 text-left rule-name">
				<div class="col-xs-2 text-right padding0 label-v1">
					@lang('lang.gen_card_rule_name')
				</div>
				<div class="col-xs-8 text-right">
					<input type="text" ng-model="card_rulename" id="card_rule_name" class="form-control">
				</div>
				<div class="col-xs-2 paddingtop10 alert_required" ng-show="required_name">
					@lang('lang.field_required_s')
				</div>
			</div>
			<div class="col-xs-12 paddingtop10 text-center rule-name">
				<div class="col-xs-2 text-right padding0 label-v1">
					@lang('lang.gen_card_rule_length')
				</div>
				<div class="col-xs-3">
					<select class="form-control" ng-model="card_length" ng-options="length for length in data.template.length_list">
					</select>
					<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_length">
						@lang('lang.field_required_s')
					</div>
				</div>
				<div class="col-xs-2 text-right padding0 label-v1">
					@lang('lang.gen_card_rule_fieldtype')
				</div>
				<div class="col-xs-3">
					<select class="form-control" ng-disabled="!card_length" ng-model="card_rule_template_id" ng-options="rule.id as rule.length_type for rule in data.template.rules_by_size[card_length]">
					</select>
					<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_fieldtype">
						@lang('lang.field_required_s')
					</div>
				</div>
			</div>
		</div>
		<hr class="style1" style="border-top: 1px solid #eeeeee;" >
		
		<!-- 16Byte 4,4,4,4 -->
		<div class="row"  ng-show="card_rule_template_id == 1">
			<form id="card_rule_form_1">
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel">
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.country') (2<span>@lang('lang.bytes')</span>) + @lang('lang.company') (2<span>@lang('lang.bytes')</span>)</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.batch')</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.st_physical_card_short')/@lang('lang.st_virtual_card_short')(1<span>@lang('lang.bytes')</span>)</span>，
							<span>@lang('lang.gen_dic_servicetype')(3<span>@lang('lang.bytes')</span>)：</span>
							<!--<span class="service_type">
								<span class="alert_required" ng-show="check_required.service_type">
									@lang('lang.field_required_s')
								</span>
								<span class="alert_required" ng-show="check_invalid.service_type">
									@lang('lang.field_wrong_fromat')
								</span>
								<select class="form-control padding0" name="json_service_type" ng-model="form1_service_type">
									<option value=""></option>
									<option ng-repeat="item in data.dic.dic_service_type" value="{?item.value?}">{?item.description?}</option>
								</select>
							</span>-->
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.random')(4<span>@lang('lang.bytes')</span>)</span>
						</span>
				</div>
				
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel paddingtop20">
					<div class="col-xs-12 padding0">
						<div class="sub_part left">
							<span class="filed_length_lavel2">@lang('lang.gen_card_rule_pwd_length')</span>
						</div>
						<div class="col-xs-2 left paddingleft0">
							<select class="form-control padding0" name="password_length" ng-model="passwd_length">
								<option></option>
								<option ng-repeat="length in data.template.rules_by_id[card_rule_template_id].password_length_list" value="{?length?}">{?length?}</option>
							</select>
							<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_pwd_length">
								@lang('lang.field_required_s')
							</div>
						</div>
						
						<div class="input-group col-xs-5 col-xs-offset-1 paddingtop10">
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="n"> @lang('lang.password_type1')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l"> @lang('lang.password_type2')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l+n"> @lang('lang.password_type3')</label>&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<!-- 17Byte 5,4,4,4 -->
		<div class="row"  ng-show="card_rule_template_id == 2">
		<!--<div class="row">-->
			<form id="card_rule_form_2">
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel">
						<span class="sub_part">
							<span class="filed_length_lavel">5<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.province') (2<span>@lang('lang.bytes')</span>) + @lang('lang.random') (3<span>@lang('lang.bytes')</span>)</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.gen_year') (4<span>@lang('lang.bytes')</span>)</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.gen_month_day') (4<span>@lang('lang.bytes')</span>)</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">4<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							
							<span>
							
								@lang('lang.custom')(1<span>@lang('lang.bytes')</span>): 
								<input type="text" class="form-control width50px inline-block" name="json_custom" ng-model="form2_custom">
								
								<span class="alert_required" ng-show="check_required.custom">
									@lang('lang.field_required_s')
								</span>
								<span class="alert_required" ng-show="check_invalid.custom">
									@lang('lang.field_wrong_fromat')
								</span>
								
							</span> + 
							<span>@lang('lang.random')(3<span>@lang('lang.bytes')</span>)</span>
						</span>
				</div>
				
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel paddingtop20">
					<div class="col-xs-12 padding0">
						<div class="sub_part left">
							<span class="filed_length_lavel2">@lang('lang.gen_card_rule_pwd_length')</span>
						</div>
						<div class="col-xs-2 left paddingleft0">
							<select class="form-control padding0" name="password_length" ng-model="passwd_length">
								<option></option>
								<option ng-repeat="length in data.template.rules_by_id[card_rule_template_id].password_length_list" value="{?length?}">{?length?}</option>
							</select>
							<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_pwd_length">
								@lang('lang.field_required_s')
							</div>
						</div>
						
						<div class="input-group col-xs-5 col-xs-offset-1 paddingtop10">
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="n"> @lang('lang.password_type1')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l"> @lang('lang.password_type2')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l+n"> @lang('lang.password_type3')</label>&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</form>
		</div>
		
		
		
		<!-- 17Byte 6, 6, 5 -->
		<div class="row"  ng-show="card_rule_template_id == 3">
		<!--<div class="row">-->
			<form id="card_rule_form_3">
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel">
						<span class="sub_part">
							<span class="filed_length_lavel">
								6<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.gen_dic_cardtype') (2<span>@lang('lang.bytes')</span>)
								<span class="select_type100">
									<span class="alert_required" ng-show="check_required.card_type">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.card_type">
										@lang('lang.field_wrong_fromat')
									</span> 
									<select class="form-control" name="json_card_type" ng-model="form3_card_type">
										<option value=""></option>
										<option ng-repeat="item in data.dic.dic_card_type" value="{?item.value?}">{?item.description?}</option>
									</select> 
								</span> + 
								@lang('lang.gen_dic_area') (4<span>@lang('lang.bytes')</span>)
							</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">6<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.expire_date') (6<span>@lang('lang.bytes')</span>)</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">5<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.random') (5<span>@lang('lang.bytes')</span>)</span>
						</span>
				</div>
				
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel paddingtop20">
					<div class="col-xs-12 padding0">
						<div class="sub_part left">
							<span class="filed_length_lavel2">@lang('lang.gen_card_rule_pwd_length')</span>
						</div>
						<div class="col-xs-2 left paddingleft0">
							<select class="form-control padding0" name="password_length" ng-model="passwd_length">
								<option></option>
								<option ng-repeat="length in data.template.rules_by_id[card_rule_template_id].password_length_list" value="{?length?}">{?length?}</option>
							</select>
							<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_pwd_length">
								@lang('lang.field_required_s')
							</div>
						</div>
						
						<div class="input-group col-xs-5 col-xs-offset-1 paddingtop10">
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="n"> @lang('lang.password_type1')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l"> @lang('lang.password_type2')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l+n"> @lang('lang.password_type3')</label>&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</form>
		</div>
		
		
		
		<!-- 18Byte 3, 8, 5, 2 -->
		<div class="row"  ng-show="card_rule_template_id == 4">
		<!--<div class="row">-->
			<form id="card_rule_form_4">
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel">
						<span class="sub_part">
							<span class="filed_length_lavel">
								3<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.custom') (3<span>@lang('lang.bytes')</span>)
								<span class="input_type100">
									<span class="alert_required" ng-show="check_required.custom1">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.custom1">
										@lang('lang.field_wrong_fromat')
									</span> 
									<input type="text" class="form-control" name="json_custom1" ng-model="form4_custom1">
								</span>
							</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">8<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.expire_date') (8<span>@lang('lang.bytes')</span>)</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">5<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.random') (5<span>@lang('lang.bytes')</span>)</span>
						</span>
						<span class="sub_part">
							<span class="filed_length_lavel">
								2<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.auto_number') (1<span>@lang('lang.bytes')</span>)
							</span> + 
							<span>
								@lang('lang.custom') (1<span>@lang('lang.bytes')</span>)
								<span class="input_type60">
									<span class="alert_required" ng-show="check_required.custom2">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.custom2">
										@lang('lang.field_wrong_fromat')
									</span> 
									<input type="text" class="form-control" name="json_custom2" ng-model="form4_custom2">
								</span>
							</span>
						</span>
				</div>
				
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel paddingtop20">
					<div class="col-xs-12 padding0">
						<div class="sub_part left">
							<span class="filed_length_lavel2">@lang('lang.gen_card_rule_pwd_length')</span>
						</div>
						<div class="col-xs-2 left paddingleft0">
							<select class="form-control padding0" name="password_length" ng-model="passwd_length">
								<option></option>
								<option ng-repeat="length in data.template.rules_by_id[card_rule_template_id].password_length_list" value="{?length?}">{?length?}</option>
							</select>
							<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_pwd_length">
								@lang('lang.field_required_s')
							</div>
						</div>
						
						<div class="input-group col-xs-5 col-xs-offset-1 paddingtop10">
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="n"> @lang('lang.password_type1')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l"> @lang('lang.password_type2')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l+n"> @lang('lang.password_type3')</label>&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</form>
		</div>
		
		
		
		<!-- 18Byte 4, 8, 4, 2 -->
		<div class="row"  ng-show="card_rule_template_id == 5">
		<!--<div class="row">-->
			<form id="card_rule_form_5">
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel">
						<span class="sub_part">
							<span class="filed_length_lavel">
								4<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.custom') (4<span>@lang('lang.bytes')</span>)
								<span class="input_type100">
									<span class="alert_required" ng-show="check_required.custom1">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.custom1">
										@lang('lang.field_wrong_fromat')
									</span> 
									<input type="text" class="form-control" name="json_custom1" ng-model="form5_custom1">
								</span>
							</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">8<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.random') (8<span>@lang('lang.bytes')</span>)</span>
						</span>
						<span class="sub_part">
							<span class="filed_length_lavel">
								4<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.custom') (4<span>@lang('lang.bytes')</span>)
								<span class="input_type100">
									<span class="alert_required" ng-show="check_required.custom2">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.custom2">
										@lang('lang.field_wrong_fromat')
									</span> 
									<input type="text" class="form-control" name="json_custom2" ng-model="form5_custom2">
								</span>
							</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">2<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>@lang('lang.random') (2<span>@lang('lang.bytes')</span>)</span>
						</span>
				</div>
				
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel paddingtop20">
					<div class="col-xs-12 padding0">
						<div class="sub_part left">
							<span class="filed_length_lavel2">@lang('lang.gen_card_rule_pwd_length')</span>
						</div>
						<div class="col-xs-2 left paddingleft0">
							<select class="form-control padding0" name="password_length" ng-model="passwd_length">
								<option></option>
								<option ng-repeat="length in data.template.rules_by_id[card_rule_template_id].password_length_list" value="{?length?}">{?length?}</option>
							</select>
							<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_pwd_length">
								@lang('lang.field_required_s')
							</div>
						</div>
						
						<div class="input-group col-xs-5 col-xs-offset-1 paddingtop10">
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="n"> @lang('lang.password_type1')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l"> @lang('lang.password_type2')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l+n"> @lang('lang.password_type3')</label>&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</form>
		</div>
		
		
		
		<!-- 18Byte 6, 6, 6 -->
		<div class="row"  ng-show="card_rule_template_id == 6">
		<!--<div class="row">-->
			<form id="card_rule_form_6">
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel">
						<span class="sub_part">
							<span class="filed_length_lavel">
								6<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.custom') (6<span>@lang('lang.bytes')</span>)
								<span class="input_type100">
									<span class="alert_required" ng-show="check_required.custom1">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.custom1">
										@lang('lang.field_wrong_fromat')
									</span> 
									<input type="text" class="form-control" name="json_custom1" ng-model="form6_custom1">
								</span>
							</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">
								6<span>@lang('lang.bytes')</span> 
								@lang('lang.subcode')
							</span>
							<span>
								@lang('lang.gen_time') (6<span>@lang('lang.bytes')</span>)
							</span>
						</span>
						<i class="glyphicon glyphicon-plus text-primary"></i>
						<span class="sub_part">
							<span class="filed_length_lavel">6<span>@lang('lang.bytes')</span> @lang('lang.subcode')</span>
							<span>
								@lang('lang.custom') (1<span>@lang('lang.bytes')</span>)
								<span class="input_type60">
									<span class="alert_required" ng-show="check_required.custom2">
										@lang('lang.field_required_s')
									</span>
									<span class="alert_required" ng-show="check_invalid.custom2">
										@lang('lang.field_wrong_fromat')
									</span> 
									<input type="text" class="form-control" name="json_custom2" ng-model="form6_custom2">
								</span>
							</span> + 
							<span>@lang('lang.random') (5<span>@lang('lang.bytes')</span>)</span>
						</span>
				</div>
				
				<div class="col-xs-10 col-xs-offset-1 text-left field_panel paddingtop20">
					<div class="col-xs-12 padding0">
						<div class="sub_part left">
							<span class="filed_length_lavel2">@lang('lang.gen_card_rule_pwd_length')</span>
						</div>
						<div class="col-xs-2 left paddingleft0">
							<select class="form-control padding0" name="password_length" ng-model="passwd_length">
								<option></option>
								<option ng-repeat="length in data.template.rules_by_id[card_rule_template_id].password_length_list" value="{?length?}">{?length?}</option>
							</select>
							<div class="col-xs-12 paddingtop10 alert_required" ng-show="required_pwd_length">
								@lang('lang.field_required_s')
							</div>
						</div>
						
						<div class="input-group col-xs-5 col-xs-offset-1 paddingtop10">
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="n"> @lang('lang.password_type1')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l"> @lang('lang.password_type2')</label>&nbsp;&nbsp;
							<label><input type="radio" ng-model="password_type" name="passwd_type" value="l+n"> @lang('lang.password_type3')</label>&nbsp;&nbsp;
						</div>
					</div>
				</div>
			</form>
		</div>
		
		
		<div class="clearfix"></div>
		<div class="row text-center paddingtop20 paddingbot10">
			<a class="btn btn-primary" ng-click="save_cardrule()" ng-disabled="ajax_save_disable">
				@lang('lang.pr_item_save')
				<span class="loading_icons" ng-show="ajax_rule_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span>
			</a>
		</div>
		<div class="clearfix"></div>
		<div class="alert alert-success alert-save-success" style="display: none;">
			@lang('lang.rg_success_save')
		</div>
		<div class="alert alert-danger alert-save-fail" style="display: none;">
			@lang('lang.rg_fail_save')
		</div>
	</div>
	