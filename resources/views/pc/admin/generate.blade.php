	<div class="block">
		<span class="subtitle">@lang('lang.gen_generate_card')</span>
	</div>
	<div class="generalblock">
		<div class="left">
			<div class="searchlayout margintop15">
				<select name="categ1" class="text_sketch" ng-options="option1.description for option1 in categ1items track by option1.id" ng-model="selectedData1" ng-change="search_change()"></select>
			</div>
			<div class="searchlayout margintop15">
				<select name="categ1" class="text_sketch" ng-options="option2.description for option2 in categ2items track by option2.id" ng-model="selectedData2" ng-change="search_change()"></select>
			</div>
			<!--
			<div class="searchlayout margintop15">
				<select class="text_sketch">
					<option value="-- 全部产品分类 --">-- 全部产品分类 --</option>
					<option selected="" value="第三级产品分类">@lang('lang.pr_level2_classification')</option>
				</select>
			</div>
			-->
		</div>
		<div class="left">
			<div class="searchlayout margintop15">
				<input type="text" name="searchword" class="width200p" placeholder="@lang('lang.st_search')" ng-model="searchword" ng-keyup="$event.keyCode == 13 && search_change()">
			</div>	
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop10 paddingbot10">
		<div class="right">
			<a class="btn btn-md btn-info" ng-href="#!/generate/card_rule">@lang('lang.gen_card_rule')</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.pr_item_name')</th>
					<th>@lang('lang.ov_product_code')</th>
					<th>@lang('lang.gen_physical_card_inventory')</th>
					<th>@lang('lang.gen_virtual_card_inventory')</th>
					<th>@lang('lang.gen_dealer_inventory')</th>
					<th>@lang('lang.label_table_action')</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat = "item in items">
					<td>{?item.name?}</td>
					<td>{?item.code?}</td>
					<td><span class="fontcolorblue">{?item.physical_inventory?}</span></td>
					<td><span class="fontcolorred">{?item.virtual_inventory?}</span></td>
					<td><span class="fontcolorred">{?item.dealer_inventory?}</span></td>
					<td>
						<a class="primarybtn bgblue purchaseaddmanagerbtn" ng-click="generateCard(item)">+ @lang('lang.label_generate')</a>
					</td>
				</tr>
				<tr ng-show="nodata">
					<td colspan="6">@lang('lang.str_no_data')</td>
				</tr>
			</tbody>
		</table>
		<div class="pagenav_block" ng-show="list_data.total > 0">
            <span class="pageinfo">@lang('lang.di') {?list_data.from?} - {?list_data.to?} @lang('lang.tiao')， @lang('lang.total') {?list_data.total?} @lang('lang.tiao')</span>
            <ul class="pagination">
                <li ng-class="{disabled:pagenation.currentPage === 1}">
                    <a ng-click="setPage(1)">&lt;&lt;</a>
                </li>
                <li ng-class="{disabled:pagenation.currentPage === 1}">
                    <a ng-click="setPage(pagenation.currentPage - 1)">&lt;</a>
                </li>
                <li ng-repeat="page in pagenation.pages" ng-class="{active:pagenation.currentPage === page}">
                    <a ng-click="setPage(page)">{?page?}</a>
                </li>                
                <li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
                    <a ng-click="setPage(pagenation.currentPage + 1)">&gt;</a>
                </li>
                <li ng-class="{disabled:pagenation.currentPage === pagenation.totalPages}">
                    <a ng-click="setPage(pagenation.totalPages)">&gt;&gt;</a>
                </li>
            </ul>
        </div>
	</div>
	<div class="block"></div>		
	<!-- dialog html -->
	<div id="purchaseaddmanager" class="message-dlg" title="@lang('lang.gen_generate_card')">
		<form name="generateAddForm" id="generateAddForm" ng-submit="submitForm(generateAddForm.$valid)" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
			<div class="block">
				<input type="hidden" id="product_id" name="product_id" value="" />
				<input type="hidden" class="service_card_name" name="service_card_name" ng-model="generateAddFormData.service_card_name" />
				<input type="hidden" class="service_card_code" name="service_card_code" ng-model="generateAddFormData.service_card_code" />
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_name')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?generateAddFormData.service_card_name?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?generateAddFormData.service_card_code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						{?generateAddFormData.valid_period | months_to_string ?}
						<!--<select class="text_sketch paddingside20 card_expiry_date" ng-options="option.label for option in generateAddFormData.card_expiry_dates.availableOptions track by option.val" ng-model="generateAddFormData.card_expiry_dates.selectedOption"></select>-->
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2" style="padding-top: 5px;">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2" style="height: 30px;">
						<select class="text_sketch form-control width50 card_expiry_date" ng-options="service_card_type.label for service_card_type in generateAddFormData.service_card_types.availableOptions track by service_card_type.val" ng-model="generateAddFormData.service_card_types.selectedOption"></select>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2" style="padding-top: 5px;">@lang('lang.gen_enter_service_cards')：</div>
					<div class="right width50 fontcolor777 fontsize1p2" style="height: 30px;">
						<input type="number" name="service_cards" class="width200p form-control width50 paddingleft10 service_cards" placeholder="" ng-model="generateAddFormData.service_cards" min="1" max="9999" ng-pattern="/^[0-9]*$/" required>
						<p ng-show="generateAddForm.service_cards.$error.required" class="error_block paddingleft10">@lang('lang.field_required_s')</p>
						<p ng-show="generateAddForm.service_cards.$error.pattern" class="error_block paddingleft10">@lang('lang.rg_invalid_number')</p>
						<p ng-show="generateAddForm.service_cards.$error.max || generateAddForm.service_cards.$error.min" class="error_block paddingleft10">@lang('lang.gen_invalid_number10000')</p>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2" style="padding-top: 5px;">@lang('lang.gen_service_card_rules')：</div>
					<div class="right width50 fontcolor777 fontsize1p2 paddingtop5" style="height: 30px;">
						<!--<select class="text_sketch form-control width50 card_rules" ng-options="card_rule.label for card_rule in generateAddFormData.card_rules.availableOptions track by card_rule.val" ng-model="generateAddFormData.card_rules.selectedOption"></select>-->
						{? generateAddFormData.card_rule.rule_name ?} ( {? generateAddFormData.card_rule.card_code_length ?}@lang('lang.bytes') - @lang('lang.gen_card_rule_fieldtype') {? generateAddFormData.card_rule.length_type ?} )
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2" style="padding-top: 5px;">@lang('lang.1st_level_dealer')：</div>
					<div class="right width50 fontcolor777 fontsize1p2" style="height: 30px;">
						<select class="form-control padding0 width70" name="send_dealer" ng-model="generateAddFormData.send_dealer" required>
							<option value=""></option>
							<option ng-repeat="dealer in dealers_1stlevel" value="{?dealer.id?}">{? dealer.name ?}</option>
						</select>
						<p ng-show="generateAddForm.send_dealer.$error.required" class="error_block paddingleft10">@lang('lang.field_required_s')</p>
					</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="block textcenter">
				<button type="submit" class="btn btn-primary" ng-class="generateAddForm.$invalid ? 'bggray-disabled' : ''" ng-disabled="generateAddForm.$invalid">
					@lang('lang.gen_generate_card')					
					<span class="loading_icons" ng-show="ajax_loading">
						<img src="./images/loading_now.gif" class="submit_small_icons">\
					</span>
				</button>
			</div>
		</form>
		<div class="block"></div>
	</div>
	<!-- dialog confirm html -->
	<div id="purchaseaddmanagercheck" class="message-dlg" title="@lang('lang.gen_check_generate')">
			<div class="block">
				<div class="paddingtopbottom7">
					<div class="textcenter fontsize1p2">
						@if(app()->getLocale() == 'en')
							{?generateAddFormData.service_cards?} {?generateAddFormData.service_card_name?} @lang('lang.gen_check_next')
						@elseif(app()->getLocale() == 'cn')
							@lang('lang.gen_check_priv'){?generateAddFormData.service_cards?}@lang('lang.gen_check_count'){?generateAddFormData.service_card_name?}@lang('lang.gen_check_next')
						@endif
					</div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?generateAddFormData.service_card_code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?generateAddFormData.valid_period | months_to_string ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?generateAddFormData.service_card_types.selectedOption.label?}</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="block textcenter">
				<a ng-click="dialogclose()" style="color:white" class="generalbtn ui-button">@lang('lang.confirm')</a>
			</div>
		<div class="block"></div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>
