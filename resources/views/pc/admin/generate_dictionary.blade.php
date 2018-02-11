	<div class="block">
		<a class="subtitle" href="#!/product" onclick="history.back();">< @lang('lang.pr_return')</a>
		<div class="subtitle paddingtop15">
			<span ng-if="search.keyword=='dic_retail'">@lang('lang.gen_dic_corp')@lang('lang.manage')</span>
			<span ng-if="search.keyword=='dic_area'">@lang('lang.gen_dic_area')@lang('lang.manage')</span>
			<span ng-if="search.keyword=='dic_province'">@lang('lang.gen_dic_province')@lang('lang.manage')</span>
			<span ng-if="search.keyword=='dic_card_type'">@lang('lang.gen_dic_cardtype')@lang('lang.manage')</span>
			<span ng-if="search.keyword=='dic_service_type'">@lang('lang.gen_dic_servicetype')@lang('lang.manage')</span>
		</div>
		<div class="clearboth"></div>
	</div>
	<div class="seperatorline"></div>
	<div class="paddingtop30"></div>
	<div class="right">
		<a class="periodselected period" ng-click="open_edit_dialog(0)">@lang('lang.gen_add_item')</a>
	</div>
	<div class="backgroundwhite">
		<div class="block">
			<table class="table">
				<thead>
				<tr>
					<th>@lang('lang.define_name')</th>
					<th>@lang('lang.define_value')</th>
					<th>@lang('lang.pr_update_date')</th>
					<th>@lang('lang.label_table_action')</th>
				</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in list_data.data">
						<td>
							{?item.description?}
						</td>
						<td>
							{?item.value?}
						</td>
						<td>{?item.updated_at?}</td>
						<td>
							<a class="padding_3-6" ng-click="open_edit_dialog(item.id)">
								<i class="glyphicon glyphicon-edit text-info"></i>
							</a>
							<a class="padding_3-6" ng-click="item_delete(item.id)">
								<i class="glyphicon glyphicon-trash text-danger"></i>
							</a>
						</td>
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
	</div>
	<!-- dialog html -->
	<div id="item_edit_dialog" class="message-dlg" title="@lang('lang.gen_add_item')">
		<form ng-submit="save_item()" method="post" enctype="multipart/form-data">
			<input type="hidden" name="dict_id" ng-model="item.id">
			<div class="block"></div>
			<div class="col-xs-6">
				<div class="col-xs-4 text-right paddingtop10">
					<label for="item_description">@lang('lang.define_name') : </label>
				</div>
				<div class="col-xs-8">
					<!--<input type="text" name="description" id="item_description" class="form-control" ng-model="item.description" minlength="1" required >-->
					<input type="text" name="description" id="item_description" class="form-control" ng-model="item.description" >
					<span class="alert_required" ng-show="required_description">@lang('lang.field_required')</span>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="col-xs-4 text-right paddingtop10">
					<label for="item_value">@lang('lang.define_value') : </label>
				</div>
				<div class="col-xs-8">
					<!--<input type="text" name="value" id="item_value" class="form-control" ng-model="item.value" minlength="1" required  />-->
					<input type="text" name="value" id="item_value" class="form-control" ng-model="item.value" />
					<span class="alert_required" ng-show="required_value">@lang('lang.field_required')</span>
					<span class="alert_required" ng-show="required_format">@lang('lang.error_format_sample') {?value_pattern_sample?}</span>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="block textcenter">
				<button type="submit" class="generalbtn productcategeditbtn ui-button">@lang('lang.pr_item_save')<span class="loading_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
				<a class="cancelbtn ui-button" ng-click="close_edit_dialog()">@lang('lang.pr_item_cancel')</a>
			</div>
			<div class="clearfix"></div>
			<div class="alert alert-success" style="display: none;">
				@lang('lang.rg_success_save')
			</div>
			<div class="alert alert-danger" style="display: none;">
				@lang('lang.rg_fail_save')
			</div>
		</form>
		<div class="block"></div>
	</div>
	