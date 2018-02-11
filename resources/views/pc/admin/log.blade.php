<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.label_system_log')</h1>
		<small><a href="#!/overview" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-primary">
		<div class="panel-body">
			<div class="col-xs-3">
				<select name="categ1" class="form-control" ng-options="type.label for type in selectlist_type.availableOptions track by type.val" ng-model="selectlist_type.selectedOption" ng-change="search_change()"></select>
			</div>	
			<div class="col-xs-3">
				<input type="text" name="searchdatestart" id="searchdatestart" class="dateselector searchdatestart form-control" placeholder="@lang('lang.start date')" ng-model="start_date" ng-change="search_change()" />
			</div>	
			<div class="col-xs-3">
				<input type="text" name="searchdateend" id="searchdateend" class="dateselector searchdatestart form-control" placeholder="@lang('lang.end date')" ng-model="end_date" ng-change="search_change()" />
			</div>	
			<a type="button" class="btn btn-default" ng-click="search_change()">@lang('lang.search')</a>

			<div class="clearboth"></div>
			<div class="seperatorline"></div>
		</div>

		<div class="panel-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>@lang('lang.l_operator')</th>
						<th>@lang('lang.l_affiliation')</th>
						<th>@lang('lang.l_operating_time')</th>
						<th>@lang('lang.l_ip')</th>
						<th>@lang('lang.l_system')</th>
						<th>@lang('lang.l_module_name')</th>
						<th>@lang('lang.l_operation_type')</th>
						<th>@lang('lang.l_operation_content')</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in items">
						<td>{?item.user_info.name?}</td>
						<td>{?item.dealer_info.name?}</td>
						<td>{?item.operation_date?}<br>{?item.operation_hour?}</td>
						<td>{?item.ip_address?}</td>
						<td>{?item.system?}</td>
						<td>{?item.module_name?}</td>
						<td>{?item.operation_kind?}</td>
						<td>{?item.operation?}</td>
					</tr>
					<tr ng-show="nodata">
						<td colspan="8">@lang('lang.str_no_data')</td>
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
	<div class="block"></div>
</div>

<script src="{{url('')}}/js/control.js"></script>