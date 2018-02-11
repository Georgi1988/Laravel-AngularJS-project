<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_classification_management')</h1>
		<small><a href="#!/product" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
	<ol class="breadcrumb pull-right">
		<a type="button" class="btn btn-info" ng-click="open_edit_dialog(0)">@lang('lang.pr_type_add')</a>
	</ol>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">@lang('lang.pr_type_table')</h3>
		</div>
		<div class="panel-body">
			<div role="tabpanel">
				<ul class="nav nav-tabs tabs primary-tabs" role="tablist">
					<li role="presentation" class="active" ng-click="search_level(1)">
						<a aria-controls="level1" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.pr_class1_classification')</a>
					</li>
					<li role="presentation" class="" ng-click="search_level(2)">
						<a aria-controls="level2" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.pr_class2_classification')</a>
					</li>
					<li role="presentation" class="" ng-click="search_level(3)">
						<a aria-controls="level3" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.pr_class3_classification')</a>
					</li>
				</ul>
				<div class="tab-content panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>@lang('lang.pr_catalog_level')</th>
								<th>@lang('lang.pr_catalog_name')</th>
								<th>@lang('lang.pr_update_date')</th>
								<th>@lang('lang.label_table_action')</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="item in list_data.data">
								<td>
									<span ng-show="item.level=='1'">@lang('lang.pr_class1_classification')：</span>
									<span ng-show="item.level=='2'">@lang('lang.pr_class2_classification')：</span>
									<span ng-show="item.level=='3'">@lang('lang.pr_class3_classification')：</span>
								</td>
								<td>
									<span class="productcateginfoedit inlineblock">{?item.description?} </span>
								</td>
								<td>{?item.updated_at?}</td>
								<td>
									<a class="btn btn-xs" ng-click="open_edit_dialog(item.id)"><img src="{{url('')}}/images/order.png" style="width:20px" alt="productcategedit" /></a>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="clearfix text-center" ng-show="list_data.total > 0">
						<span class="pageinfo">@lang('lang.di') {?list_data.from?} - {?list_data.to?} @lang('lang.tiao')，@lang('lang.total') {?list_data.total?} @lang('lang.tiao')</span>
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
		</div>	
	</div>
	<div class="block"></div>	
</div>

<!-- dialog html -->
<div id="productcategedit" class="message-dlg" title="@lang('lang.pr_name')">
	<form ng-submit="save_class()" method="post" enctype="multipart/form-data">
		<div class="block"></div>
		<div class="block width85">
			<label>
				@lang('lang.pr_type_level') : 
				<select  name="level" ng-model="item_info_edit.level" ng-options="item.id as item.description for item in type_level" ng-disabled="item_info_edit.id" required >
					<option value="" ng-selected="selected"></option>
				</select>
			</label>
		</div>
		<div class="block width85">
			<label>@lang('lang.pr_name') : <input type="text" name="description" ng-model="item_info_edit.description" minlength="1" required  /></label>
		</div>
		<div class="alert alert-success" style="display: none;">
			@lang('lang.rg_success_save')
		</div>
		<div class="alert alert-danger" style="display: none;">
			@lang('lang.rg_fail_save')
		</div>
		<div class="block textcenter">
			<button type="submit" class="generalbtn productcategeditbtn ui-button">@lang('lang.pr_item_save')<span class="loading_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
			<a class="cancelbtn ui-button" ng-click="close_edit_dialog()">@lang('lang.pr_item_cancel')</a>
		</div>
	</form>
	<div class="block"></div>
</div>

<script src="{{url('')}}/js/control.js"></script>