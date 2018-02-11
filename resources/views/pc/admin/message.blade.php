<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.label_message')</h1>
	</div>
	<ol class="breadcrumb pull-right">
		<a type="button" class="btn btn-warning" ng-click="delete_selected()">@lang('lang.ms_delete_message')</a>
	</ol>
</div>

<div class="conter-wrapper col-md-12" ng-show="loaded">
	<div class="panel panel-info">
		<div class="panel-body">
			<div class="col-xs-3">
				<select class="form-control" ng-model="search.type" ng-change="search_change()">
					<option selected="" value="">-- @lang('lang.ms_label_all')--</option>
					<option value="1">@lang('lang.ms_label_notification')</option>
					<option value="2">@lang('lang.ms_label_inspection')</option>
					<option value="3">@lang('lang.ms_tab_order')</option>
				</select>
			</div>
			<div class="col-xs-3">
				<input type="search" name="" class="form-control" ng-model="search.keyword" placeholder="@lang('lang.ms_search_keyword')" onsearch="angular.element(this).scope().search_change()">
			</div>
		</div>
		<div class="clearbodiv"></div>
		<div class="seperatorline"></div>
		<div class="panel-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>
							<input type="checkbox" value="1" ng-model="all_checked">
						</th>
						<th>@lang('lang.ms_message_type')</th>
						<th>@lang('lang.ms_message_content')</th>
						<th>@lang('lang.ms_message_time')</th>
						<th>@lang('lang.ms_message_operation')</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="item in list_data.data">
						<td>
							<input type="checkbox" value="{?item.id?}" ng-checked="all_checked">
						</td>
						<td>
							<span ng-if="item.type==1">@lang('lang.ms_label_notification')</span>
							<span ng-if="item.type==2">@lang('lang.ms_label_inspection')</span>
							<span ng-if="item.type==3">@lang('lang.ms_tab_order')</span>
						</td>
						<td>{?item.message?}</td>
						<td>{?item.created_at?}</td>
						<td>
							<a type="button" class="btn btn-info btn-xs" ng-if="item.url==''" ng-click="view_message(item.html_message)">@lang('lang.ms_details')</a>
							<a type="button" class="btn btn-info btn-xs" ng-if="item.url!=''" ng-href="{?item.url?}">@lang('lang.ms_details')</a>
						</td>
					</tr>
					<tr ng-show="no_data">
						<td colspan="4">@lang('lang.str_no_data')</td>
					</tr>
				</tbody>
			</table>
			<div class="clearfix text-center" ng-show="list_data.total > 0">
				<span class="pageinfo">@lang('lang.di'){?list_data.from?}-{?list_data.to?}@lang('lang.tiao')， @lang('lang.total') {?list_data.total?}@lang('lang.tiao')</span>
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

<!-- dialog html -->
<div id="messageinfo" class="message-dlg" title="@lang('lang.msg_notify_detail')">
	<div class="block"></div>
	<div class="block width85 message_content">
		
	</div>
	<div class="block textcenter width85">
		<button class="importbtn ui-button dlg_close" ng-click="close_dlg()">@lang('lang.close')</button>
	</div>
	<div class="block"></div>
</div>