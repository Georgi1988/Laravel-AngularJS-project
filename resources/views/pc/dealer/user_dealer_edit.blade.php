<div class="user_v_content" ng-show="loaded">
	<div class="block">
		<div class="left ">
			<a onclick="history.back(); return false;" class="subtitle">< @lang('lang.pr_return')</a>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="name_panel bgdef text-center">
		<span class="dealer_name">
			{?
				method != 'new' ? dealer.name :
				subject == 'dealer' ? "@lang('lang.label_add_dealer')" :
				"@lang('lang.label_add_store')"
			?}
		</span>
		<span class="muted">
			{{--({?--}}
			{{--dealer.level==0 ? "@lang('lang.admin_level_dealer')" :--}}
			{{--dealer.level==1 ? "@lang('lang.1st_level_dealer')" :--}}
			{{--dealer.level==2 ? "@lang('lang.2nd_level_dealer')" :--}}
			{{--dealer.level==3 ? "@lang('lang.3rd_level_dealer')" :--}}
			{{--dealer.level==4 ? "@lang('lang.4th_level_dealer')" :--}}
			{{--dealer.level==5 ? "@lang('lang.5th_level_dealer')" :--}}
			{{--dealer.level==6 ? "@lang('lang.6th_level_dealer')" :--}}
			{{--dealer.level==7 ? "@lang('lang.7th_level_dealer')" :--}}
			{{--dealer.level==8 ? "@lang('lang.8th_level_dealer')" :--}}
			{{--dealer.level==9 ? "@lang('lang.9th_level_dealer')" :--}}
			{{--dealer.level==10 ? "@lang('lang.10th_level_dealer')" :--}}
			{{--dealer.level==11 ? "@lang('lang.11th_level_dealer')" :--}}
			{{--dealer.level==12 ? "@lang('lang.12th_level_dealer')" :--}}
			{{--dealer.level==13 ? "@lang('lang.13th_level_dealer')" :--}}
			{{--dealer.level==14 ? "@lang('lang.14th_level_dealer')" :--}}
			{{--dealer.level==15 ? "@lang('lang.15th_level_dealer')" :--}}
			{{--dealer.level==16 ? "@lang('lang.16th_level_dealer')" :--}}
			{{--dealer.level==17 ? "@lang('lang.17th_level_dealer')" :--}}
			{{--dealer.level==18 ? "@lang('lang.18th_level_dealer')" :--}}
			{{--dealer.level==19 ? "@lang('lang.19th_level_dealer')" :--}}
			{{--"@lang('lang.20th_level_dealer')"--}}
			{{--?})--}}
		</span>
	</div>
	<form id="dealer_info_form" name="dealer_info_form" ng-submit="dealer_info_save()" style="font-size:12px;">
		<div class="info_panel col-xs-12 bg_white">
			<div class="row info_header margin0">
				<div class="col-xs-11 label_str">{? subject == 'dealer' ? "@lang('lang.label_dealer_information')" : "@lang('lang.label_store_information')" ?}</div>
				<div class="col-xs-1 text-center">
					<input type="submit" class="user_view_btn fontsize1_0" style="padding: 4px 12px;" value="@lang('lang.pr_item_save')">
				</div>
			</div>
			<!-- save result message -->
			<div class="alert alert-success" role="alert">
				@lang('lang.rg_success_save')
			</div>
			<div class="alert alert-danger" role="alert">
				@lang('lang.rg_error_save')
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">{? (subject == 'dealer') ? "@lang('lang.label_dealer')" : "@lang('lang.label_store')" ?} @lang('lang.define_name')</div>
				<div class="col-xs-8"><input class="form-control width100 organ_ctrl_size" type="text" name="dealer_name" ng-model="dealer.name" required></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">{? (subject == 'dealer') ? "@lang('lang.label_dealer')" : "@lang('lang.label_store')" ?} @lang('lang.no')</div>
				<div class="col-xs-8"><input class="form-control width100 organ_ctrl_size" type="text" name="dealer_code" ng-model="dealer.code" required></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.contact')</div>
				<div class="col-xs-8">
					<input class="form-control width100 organ_ctrl_size" type="text" name="dealer_link" ng-model="dealer.link" required pattern="(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})">
				</div>
			</div>
			<div class="col-xs-4 paddingtop10" ng-show="dealer.level == 1">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.corporation')</div>
				<div class="col-xs-8">
					<select name="dealer_corporation" class="form-control width100 height24 organ_ctrl_size" ng-model="dealer.corporation">
						<option ng-repeat="corporation in corporations" value="{? corporation.code ?}">{? corporation.name ?}</option>
					</select>
				</div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.label_area')</div>
				<div class="col-xs-8">
					<select name="dealer_area" class="form-control width100 height24 organ_ctrl_size" ng-model="dealer.area" required>
						<option ng-repeat="area in areas" value="{? area.description ?}">{? area.description ?}</option>
					</select>
					<p class="required_field" ng-show="form_require_area==true && (dealer.area==null || dealer.area=='')">@lang('lang.please_select')</p>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.label_province')</div>
				<div class="col-xs-8">
					<select name="dealer_province" class="form-control width100 height24 organ_ctrl_size" ng-model="dealer.province" required>
						<option ng-repeat="province in provinces" value="{? province.description ?}">{? province.description ?}</option>
					</select>
					<p class="required_field" ng-show="form_require_province==true && (dealer.province==null || dealer.province=='')">@lang('lang.please_select')</p>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.label_city')</div>
				<div class="col-xs-8"><input class="form-control width100 organ_ctrl_size" type="text" name="dealer_city" ng-model="dealer.city" required></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.person_charge')</div>
				<div class="col-xs-8">
					<input class="form-control width100 organ_ctrl_size" type="text" name="dealer_president_name" ng-model="dealer.president.name" ng-readonly="method == 'modify'" required>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.person_charge_link')</div>
				<div class="col-xs-8">
					<input class="form-control width100 organ_ctrl_size" type="text" name="dealer_president_link" ng-model="dealer.president.link" ng-readonly="method == 'modify'" pattern="(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})" required>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.person_charge_email')</div>
				<div class="col-xs-8">
					<input class="form-control width100 organ_ctrl_size" type="text" name="dealer_president_email" ng-model="dealer.president.email" ng-readonly="method == 'modify'" required>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>

		<div class="user_panel col-xs-12 bg_white paddingtop15"  ng-show="subject == 'store'">
			<div class="row info_header margin0">
				<div class="col-xs-8 label_str">@lang('lang.label_additional_information')</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_boss_phone_number')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_shop_boss_phone_number" ng-model="addinfo.shop_boss_phone_number" pattern="(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_dealer_kind')</div>
				<div class="col-xs-8">
					<select class="form-control width100 height24 organ_ctrl_size" name="addinfo_dealer_kind" ng-model="addinfo.dealer_kind">
						<option ng-repeat="store_type in store_types" value="{? store_type.value ?}">{? store_type.name ?}</option>
					</select>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_country')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_country" ng-model="addinfo.country"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_upper_dealer_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_upper_dealer_name" ng-model="addinfo.upper_dealer_name"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_upper_dealer_code')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_upper_dealer_code" ng-model="addinfo.upper_dealer_code"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_city_level')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_city_level" ng-model="addinfo.city_level"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_zone')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_zone" ng-model="addinfo.zone"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_town')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_town" ng-model="addinfo.town"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_area_boss_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_area_boss_name" ng-model="addinfo.area_boss_name"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_dealer_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_shop_dealer_name" ng-model="addinfo.shop_dealer_name"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_city_boss_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_city_boss_name" ng-model="addinfo.city_boss_name"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_city_boss_code')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_city_boss_code" ng-model="addinfo.city_boss_code"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_city_boss_address')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_city_boss_address" ng-model="addinfo.city_boss_address"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_business_kind')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_business_kind" ng-model="addinfo.business_kind"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_kind')</div>
				<div class="col-xs-8">
					<select class="form-control width100 height24 organ_ctrl_size" name="addinfo_shop_kind" ng-model="addinfo.shop_kind">
						<option ng-repeat="store_kind in store_kinds" value="{? store_kind.name ?}">{? store_kind.name ?}</option>
					</select>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_short_kind')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_shop_short_kind" ng-model="addinfo.shop_short_kind"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_property')</div>
				<div class="col-xs-8">
					<select class="form-control width100 height24 organ_ctrl_size" name="addinfo_shop_property"  ng-model="addinfo.shop_property">
						<option ng-repeat="store_property in store_properties" value="{? store_property.name ?}">{? store_property.name ?}</option>
					</select>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_direction')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_shop_direction" ng-model="addinfo.shop_direction"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_total_area_of_shop')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_total_area_of_shop" ng-model="addinfo.total_area_of_shop"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_monthly_sales')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_shop_monthly_sales" ng-model="addinfo.shop_monthly_sales"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_communication_address')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_shop_communication_address" ng-model="addinfo.shop_communication_address"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_postal_code')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_shop_postal_code" ng-model="addinfo.shop_postal_code"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_receipt_address')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_receipt_address" ng-model="addinfo.receipt_address"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_receipt_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_receipt_name" ng-model="addinfo.receipt_name"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_receipt_phone_number')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_receipt_phone_number" ng-model="addinfo.receipt_phone_number"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_receipt_mobile_phone_number')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_receipt_mobile_phone_number" ng-model="addinfo.receipt_mobile_phone_number" pattern="(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_corporation_status')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_corporation_status" ng-model="addinfo.corporation_status"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_application_time')</div>
				<div class="col-xs-8"><input type="date" class="form-control width100 organ_ctrl_size" name="addinfo_application_time" ng-model="addinfo.application_time"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_apply_for_approval_time')</div>
				<div class="col-xs-8"><input type="date" class="form-control width100 organ_ctrl_size" name="addinfo_apply_for_approval_time" ng-model="addinfo.apply_for_approval_time"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_cancel_corporation_approval_time')</div>
				<div class="col-xs-8"><input type="date" class="form-control width100 organ_ctrl_size" name="addinfo_modify_approval_time" ng-model="addinfo.modify_approval_time"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_cancel_corporation_approval_time')</div>
				<div class="col-xs-8"><input type="data" class="form-control width100 organ_ctrl_size" name="addinfo_cancel_corporation_approval_time" ng-model="addinfo.cancel_corporation_approval_time"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_comment')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_comment" ng-model="addinfo.comment"></div>
			</div>
			<div class="seperatorline"></div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_corporation_kind')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_corporation_kind" ng-model="addinfo.corporation_kind"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_it_mall_whole_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_it_mall_whole_name" ng-model="addinfo.it_mall_whole_name"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_it_mall_short_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_it_mall_short_name" ng-model="addinfo.it_mall_short_name"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_location_kind')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_location_kind" ng-model="addinfo.location_kind"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_area_of_dell')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_area_of_dell" ng-model="addinfo.area_of_dell"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_after_sales_service_point')</div>
				<div class="col-xs-8"><input type="time" class="form-control width100 organ_ctrl_size" name="addinfo_after_sales_service_point" ng-model="addinfo.after_sales_service_point"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_last_renovated_time')</div>
				<div class="col-xs-8"><input type="datetime-local" class="form-control width100 organ_ctrl_size" name="addinfo_last_renovated_time" ng-model="addinfo.last_renovated_time"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_dell_pay')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_dell_pay" ng-model="addinfo.dell_pay"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_use_decoration_fund')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_use_decoration_fund" ng-model="addinfo.use_decoration_fund"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_counter_number')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_counter_number" ng-model="addinfo.counter_number"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_snp_cabinet_number')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_snp_cabinet_number" ng-model="addinfo.snp_cabinet_number"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_commitment_sales')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_commitment_sales" ng-model="addinfo.commitment_sales"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_level')</div>
				<div class="col-xs-8">
					<select class="form-control width100 height24 organ_ctrl_size" name="addinfo_shop_level" ng-model="addinfo.shop_level">
						<option ng-repeat="store_level in store_levels" value="{? store_level.name ?}">{? store_level.name ?}</option>
					</select>
				</div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_nobody_shop')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_nobody_shop" ng-model="addinfo.nobody_shop"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_platform_shop_rating')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_platform_shop_rating" ng-model="addinfo.platform_shop_rating"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_registration_hours')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_registration_hours" ng-model="addinfo.registration_hours"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_registration_approval_hours')</div>
				<div class="col-xs-8"><input type="number" class="form-control width100 organ_ctrl_size" name="addinfo_registration_approval_hours" ng-model="addinfo.registration_approval_hours"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_line_under_report')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_line_under_report" ng-model="addinfo.line_under_report"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_township_level')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_township_level" ng-model="addinfo.township_level"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_shop_image_url')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_shop_image_url" ng-model="addinfo.shop_image_url"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_process_status')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_process_status" ng-model="addinfo.process_status"></div>
			</div>
			<div class="col-xs-4 paddingtop10">
				<div class="col-xs-4 label_col text-right nopadding organ_static_size">@lang('lang.addinfo_retail_manager_user_name')</div>
				<div class="col-xs-8"><input type="text" class="form-control width100 organ_ctrl_size" name="addinfo_retail_manager_user_name" ng-model="addinfo.retail_manager_user_name"></div>
			</div>
		</div>
	</form>
</div>

<div class="seperatorline"></div>

<div class="loading_page text-center view_loading" ng-show="!loaded">
	<img src="{{url('images/loading_now.gif')}}">
</div>

<script>
    login_dealer_level = {{$login_dealer_level}};
</script>

<script src="{{url('')}}/js/control.js"></script>
