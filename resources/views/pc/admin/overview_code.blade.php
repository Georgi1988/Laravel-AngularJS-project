<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.ov_machine_code_management')</h1>
		<small><a href="#!/overview" class="subtitle">< @lang('lang.label_back')</a></small>
	</div>
	<ol class="breadcrumb pull-right">
		<a type="button" class="btn btn-danger" ng-click="delete_selected()">@lang('lang.delete_selected')</a>
		<a type="button" class="btn btn-info overviewimport">@lang('lang.ov_batch_import')</a>
	</ol>
</div>
<div class="conter-wrapper col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">@lang('lang.ov_machine_code_table')</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							<input type="checkbox" value="1" ng-model="all_checked">
						</th>
						<th>@lang('lang.ov_machine_code_number')</th>
						<th>@lang('lang.ov_import_time')</th>
						<th>@lang('lang.u_servicecard_id')</th>
						<th>@lang('lang.state')</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in list_data.data">
						<td>
							<input type="checkbox" class="checkbox_list" ng-checked="all_checked" value="{?item.id?}">
						</td>
						<td>{?item.code?}</td>
						<td>{?item.register_date?}</td>
						<td>{?item.card.code?}</td>
						<td>
							<span ng-show="item.card">@lang('lang.sl_registered')</span>
							<span ng-show="!item.card">@lang('lang.sl_unlimited')</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>	
	</div>	
	<div class="clearfix text-center" ng-show="list_data.total > 0">
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
	<div class="block"></div>	
</div>

<!-- dialog html -->
<div id="overviewimport" title="@lang('lang.ov_bulk_import_machine_code')">
	<form id="csv_file_form" ng-submit="submit_import_csv()" method="POST" enctype="multipart/form-data">
		<!--<input type="hidden" name="_token" value="<?php //echo csrf_token() ?>">-->
		<div class="block"></div>
		<div class="block width85">
			<div class="col-xs-3 paddingtop10 text-right">
				@lang('lang.ov_select_the_import_file')
			</div>
			<div class="col-xs-9">
				<div class="form-group">
					<input type="file" class="input-ghost" style="visibility:hidden; height:0" name="machine_code_file" accept=".xlsx, .xls">
					<div class="input-group input-file" name="Fichier1">
						<input type="text" class="form-control" placeholder="@lang('lang.choose_file')" style="cursor: pointer;">
						<span class="input-group-addon">
							<a class="file_choose">@lang('lang.select')</a>
						</span>
					</div>
				</div>
				<span class="alert_required" ng-show="required_file">@lang('lang.field_required')</span>
				<script>
					$(function() {
						bs_input_file();
					});
				</script>
			</div>
			<!--<label>@lang('lang.ov_select_the_import_file') : <input type="file" name="machine_code_file" accept=".xlsx, .xls" required /></label>-->
			<p class="textcenter lineheight200">@lang('lang.ov_alarm_msg')</p>
		</div>
		<div class="block textcenter">
			<button class="importbtn ui-button">@lang('lang.ov_import')</button>
			<a class="cancelbtn ui-button" ng-click="close_import_dlg()">@lang('lang.cancel')</a>
		</div>
		<div class="block"></div>
	</form>
</div>