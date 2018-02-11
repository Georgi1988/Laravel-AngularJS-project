	<div class="block">
		<span class="subtitle">@lang('lang.purchase')</span>
	</div>
	<div class="generalblock">
		<div class="searchlayout paddingtop15">
			<select name="categ1" class="text_sketch" ng-options="option1.description for option1 in categ1items track by option1.id" ng-model="selectedData1" ng-change="search_change()"></select>
		</div>
		<div class="searchlayout paddingtop15">
			<select name="categ1" class="text_sketch" ng-options="option2.description for option2 in categ2items track by option2.id" ng-model="selectedData2" ng-change="search_change()"></select>
		</div>
		<!--
		<div class="searchlayout">
			<select class="text_sketch">
				<option value="-- 全部产品分类 --">-- 全部产品分类 --</option>
				<option selected="" value="第三级产品分类">@lang('lang.pr_level2_classification')</option>
			</select>
		</div>
		-->
		<div class="searchlayout">
			<input type="text" name="searchword" class="width200p" placeholder="@lang('lang.st_search')" ng-model="searchword" ng-keyup="$event.keyCode == 13 && search_change()">
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30 paddingbot15">
	<div class="right">
		<a class="periodselected period multipurchase" ng-click="multiview()">@lang('lang.pur_bulk')</a>
	</div>
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>&nbsp;@lang('lang.select')</th>
					<th>@lang('lang.pr_item_name')</th>
					<th>@lang('lang.ov_product_code')</th>
					<th>@lang('lang.gen_physical_card_inventory')</th>
					<th>@lang('lang.gen_virtual_card_inventory')</th>
					<th>@lang('lang.pur_operating')</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat = "item in items track by $index">
					<td>&nbsp;
						@if ($setting['order_purchase_multi'] == '1')
							<input type="checkbox" class="checkboxitem" value="{?item.id?}" id="checkboxitem_{?item.id?}" ng-click="getid(item, $index)" ng-model="checkstatus.status[item.id]">
						@endif
						&nbsp;
					</td>
					<td>{?item.name?}</td>
					<td>{?item.code?}</td>
					<td><span class="fontcolorblue">{?item.physical_inventory?}</span></td>
					<td><span class="fontcolorred">{?item.virtual_inventory?}</span></td>
					<td>
						<a class="primarybtn purchaseaddbtn bgyellow" ng-click="purchaseCard(item)"><i class="glyphicon glyphicon-plus text-white"></i> @lang('lang.purchase')</a>
						<a class="primarybtn purchasereturnbtn " ng-class="{'btn-success':(item.physical_inventory + item.virtual_inventory) > 0, bggray:(item.physical_inventory + item.virtual_inventory) < 1}" ng-href="{? (item.physical_inventory + item.virtual_inventory > 0)? '#!/stock/return/' + item.id : '' ?}"><i class="glyphicon glyphicon-minus text-white"></i> @lang('lang.return')</a>
						<!--<a class="primarybtn purchasereturnbtn bggray" ng-click="purchaseCardReturn(item)">+ @lang('lang.return')</a>-->
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
	</div>
	<!-- dialog html -->
	<div id="multipurchase" class="message-dlg" title="@lang('lang.purchase')" style="overflow-y:scroll;height:300px">
		<div style="overflow-y:scroll;height:350px">
			<div class="block" style="border-bottom:1px dashed #29a7e1" ng-repeat="checkitem in checkitems track by $index">
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_name')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?checkitem.name?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?checkitem.code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						{?checkitem.valid_period | months_to_string ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">		<select class="edit_field card_type" name="card_type">
						<option value="1">@lang('lang.st_physical_card')</option>
						<option value="0" selected="selected">@lang('lang.st_virtual_card')</option>
						<option value="01">@lang('lang.st_virtual_sp_card')</option>
					</select>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_enter_service_cards')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						<input type="number" name="cards" class="width200p paddingleft10 cards" placeholder="5000" min="{?checkitem.min_order_val?}" max="{?checkitem.max_order_val?}" ng-pattern="/^[0-9]*$/" ng-model="multicards[$index]" ng-change="multi_total_count(checkitem, $index)" required>
						
						<p style="display:none" class="error_block vaildnumber paddingleft10">@lang('lang.field_required_s')</p>
						<p style="display:none" class="error_block vaildrange paddingleft10">@lang('lang.pur_invalid_prev1'){?checkitem.min_order_val?} @lang('lang.pur_invalid_prev2'){?checkitem.max_order_val?}@lang('lang.pur_invalid_prev3')</p>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.pur_price')：</div>
					<div class="right width50 fontcolor777 fontsize1p2 fontcolorred">{?checkitem.viewprice?} @lang('lang.label_cn_cunit')</div>
					<div class="clearboth"></div>
				</div>
			</div>
		</div>
		<div class="block textcenter">
			<button class="generalbtn ui-button" ng-click="multi_send_data()">@lang('lang.pur_btn_msg_prev') {?multi_total_price?} @lang('lang.pur_btn_msg_next')</button><span class="small_icons" ng-show="ajax_loading"><img src="./images/loading_now.gif" class="submit_small_icons"></span>
			<button class="primarybtn bggray" style="cursor:pointer" ng-click="cancel_multipurchase()">@lang('lang.cancel')</button>
		</div>
		<div class="block"></div>
	</div>
	<!-- multiadddialog html -->
	<div id="multipurchasecheck" class="message-dlg" title="@lang('lang.pur_check_addtitle')">
		<div class="block">
			<div class="textcenter fontsize1p2">@lang('lang.pur_check_success')
			</div>
		</div>	
		<div class="block textcenter">
			<a ng-click="mutliadddialogclose()" style="color:white" class="generalbtn ui-button">@lang('lang.confirm')</a>
		</div>
		<div class="block"></div>
	</div>
	<!-- adddialog html -->
	<div id="purchaseadd" class="message-dlg" title="@lang('lang.purchase')">
		<form name="purchaseAddForm" id="purchaseAddForm" ng-submit="submitForm(purchaseAddForm.$valid)" novalidate>
			<div class="block">
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_name')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.name?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						{? purchaseFormData.productData.valid_period | months_to_string ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						<!-- physical card or virtual card-->
						<select class="text_sketch paddingside20" ng-options="card_type.label for card_type in purchaseFormData.card_types.availableOptions track by card_type.val" ng-model="purchaseFormData.card_types.selectedOption">
						</select>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_enter_service_cards')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						<input type="number" name="service_cards" class="width200p paddingleft10 service_cards" placeholder="5000" ng-model="purchaseFormData.service_cards" min="{? min_order_val?}" max="{? max_order_val?}" ng-pattern="/^[0-9]*$/" required ng-change="countprice()">
						<p ng-show="purchaseAddForm.service_cards.$error.required" class="error_block paddingleft10">@lang('lang.field_required_s')</p>
						<p ng-show="purchaseAddForm.service_cards.$error.pattern" class="error_block paddingleft10">@lang('lang.rg_invalid_number')</p>
						<p ng-show="purchaseAddForm.service_cards.$error.min || purchaseAddForm.service_cards.$error.max" class="error_block paddingleft10">@lang('lang.pur_invalid_prev1'){?min_order_val?}@lang('lang.pur_invalid_prev2'){?max_order_val?}@lang('lang.pur_invalid_prev3')</p>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.pur_price')：</div>
					<div class="right width50 fontcolor777 fontsize1p2 fontcolorred">{?purchaseFormData.viewprice?} @lang('lang.label_cn_cunit')</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="block textcenter">
				<input type="submit" class="generalbtn ui-button" ng-class="purchaseAddForm.$invalid ? 'bggray-disabled' : ''" ng-disabled="purchaseAddForm.$invalid" value="@lang('lang.pur_btn_msg_prev') {?totalprice?} @lang('lang.pur_btn_msg_next')"><span class="small_icons" ng-show="ajax_loading"><img src="./images/loading_now.gif" class="submit_small_icons"></span>
			</div>
			<div class="block"></div>
		</form>	
	</div>
	<!-- purchaseadddialog confirm html -->
	<div id="purchaseaddcheck" class="message-dlg" title="@lang('lang.pur_check_addtitle')">
			<div class="block">
				<div class="paddingtopbottom7">
					<div class="textcenter fontsize1p2">
						@if(app()->getLocale() == 'en')
							{?purchaseFormData.service_cards?} {?purchaseFormData.productData.name?} @lang('lang.pur_check_add_next')
						@elseif(app()->getLocale() == 'cn')
							@lang('lang.pur_check_add_prev'){?purchaseFormData.service_cards?}@lang('lang.pur_check_add_count'){?purchaseFormData.productData.name?}@lang('lang.pur_check_add_next')
						@endif
					</div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.valid_period | months_to_string ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.card_types.selectedOption.label?}</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="block textcenter">
				<a ng-click="adddialogclose()" style="color:white" class="generalbtn ui-button">@lang('lang.confirm')</a>
			</div>
		<div class="block"></div>
	</div>
	<div id="purchasereturn" class="message-dlg" title="@lang('lang.return')">
		<form name="purchaseReturnForm" id="purchaseReturnForm" ng-submit="submitForm(purchaseReturnForm.$valid)" novalidate>
			<div class="block">
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_name')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.name?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						{?purchaseFormData.productData.valid_period | months_to_string ?}
						<!--<select class="text_sketch paddingside20 card_expiry_date" ng-options="option.label for option in purchaseFormData.card_expiry_dates.availableOptions track by option.val" ng-model="purchaseFormData.card_expiry_dates.selectedOption"></select>-->
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">		<select class="text_sketch paddingside20" ng-options="card_type.label for card_type in purchaseFormData.card_types.availableOptions track by card_type.val" ng-model="purchaseFormData.card_types.selectedOption" ng-change="maxvalue_control()"></select>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_enter_service_cards')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">
						<input type="number" name="service_cards" class="width200p paddingleft10 service_cards" placeholder="5000" ng-model="purchaseFormData.service_cards" min="1" max="{?purchaseFormData.maxvalue?}" ng-pattern="/^[0-9]*$/" ng-change="countprice()" required>
						<p ng-show="purchaseReturnForm.service_cards.$error.required" class="error_block paddingleft10">@lang('lang.field_required_s')</p>
						<p ng-show="purchaseReturnForm.service_cards.$error.pattern" class="error_block paddingleft10">@lang('lang.rg_invalid_number')</p>
						<p ng-show="(purchaseReturnForm.service_cards.$error.max && purchaseFormData.maxvalue > 0) || purchaseReturnForm.service_cards.$error.min" class="error_block paddingleft10">@lang('lang.pur_invalid_prev1')1@lang('lang.pur_invalid_prev2'){?purchaseFormData.maxvalue?}@lang('lang.pur_invalid_prev3')</p>
						<p ng-show="(purchaseFormData.maxvalue > 0)? false : true" class="error_block paddingleft10">@lang('lang.pr_no_card')</p>
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.pur_price')：</div>
					<div class="right width50 fontcolor777 fontsize1p2 fontcolorred">{?purchaseFormData.viewprice?} @lang('lang.label_cn_cunit')</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="block textcenter">
				<input type="submit" class="generalbtn ui-button bggreen" ng-class="purchaseReturnForm.$invalid ? 'bggray-disabled' : ''" ng-disabled="purchaseReturnForm.$invalid" value="@lang('lang.pur_btn_msg_prev') {?totalprice?} @lang('lang.pur_btn_msg_next')"><span class="small_icons" ng-show="ajax_loading"><img src="./images/loading_now.gif" class="submit_small_icons"></span>
			</div>
			<div class="block"></div>
		</form>	
	</div>
	<!-- purchasereturndialog confirm html -->
	<div id="purchasereturncheck" class="message-dlg" title="@lang('lang.pur_check_addtitle')">
			<div class="block">
				<div class="paddingtopbottom7">
					<div class="textcenter fontsize1p2">
						@if(app()->getLocale() == 'en')
							{?purchaseFormData.service_cards?} {?purchaseFormData.productData.name?} @lang('lang.pur_check_add_next')
						@elseif(app()->getLocale() == 'cn')
							@lang('lang.pur_check_return_prev'){?purchaseFormData.service_cards?}@lang('lang.pur_check_add_count'){?purchaseFormData.productData.name?}@lang('lang.pur_check_add_next')
						@endif
					</div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_code')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.code?}</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_service_card_expiry_date')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.productData.valid_period | months_to_string ?}
					</div>
					<div class="clearboth"></div>
				</div>
				<div class="paddingtopbottom7">
					<div class="left width50 textright fontsize1p2">@lang('lang.gen_select_the_service_card_type')：</div>
					<div class="right width50 fontcolor777 fontsize1p2">{?purchaseFormData.card_types.selectedOption.label?}</div>
					<div class="clearboth"></div>
				</div>
			</div>
			<div class="block textcenter">
				<a ng-click="returndialogclose()" style="color:white" class="generalbtn ui-button">@lang('lang.confirm')</a>
			</div>
		<div class="block"></div>
	</div>
	<script src="{{url('')}}/js/control.js"></script>