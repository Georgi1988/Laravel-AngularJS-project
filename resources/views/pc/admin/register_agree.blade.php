<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.rg_card_register')</h1>
		<small><a href="#!/overview" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-info">
		<div class="panel-body">
			<div role="tabpanel">
				<ul class="nav nav-tabs tabs primary-tabs" role="tablist">
					<li role="presentation" class="active" ng-click="search_pagetype(1)">
						<a aria-controls="page1" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.od_order_pending')</a>
					</li>
					<li role="presentation" class="" ng-click="search_pagetype(2)">
						<a aria-controls="page2" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.rg_card_agreed')</a>
					</li>
					<li role="presentation" class="" ng-click="search_pagetype(3)">
						<a aria-controls="page3" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.rg_card_cancled')</a>
					</li>
				</ul>
				<div class="tab-content panel-body">
					<div class="col-xs-12">
						<!-- Template upload part -->
						<div class="float-left col-xs-6 padding0" ng-show="show_import_panel" style="padding-bottom:25px">
							<form id="agree_register_form" ng-submit="import_reg_agree_list()">
								<div class="col-xs-4 text-right text-info paddingtop5">@lang('lang.bulk_audit')@lang('lang.template_file')</div>
								<div class="col-xs-4 padding0 overflow-hidden">
									<div>
										<input type="file" class="input-ghost" style="visibility:hidden; height:0" id="agree_register_file" name="agree_register_file" accept=".xlsx, .xls">
										<div class="input-group input-file" name="Fichier1">
											<input type="text" class="form-control" placeholder="@lang('lang.choose_file')" style="cursor: pointer; height:30px;">
											<span class="input-group-addon">
												<a class="file_choose">@lang('lang.select')</a>
											</span>
										</div>
									</div>
									<script>
										$(function() {
											bs_input_file();
										});
									</script>
								</div>
								<div class="col-xs-4 text-center padding0">
									<button type="submit" class="btn btn-info btn-sm font-size">
										@lang('lang.import')<span class="loading_icons ajax_submit_loading" ng-show="ajaxloading_reg_agree == true">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span>
									</button>&nbsp;
									<a type="button" href="{{url('common/download/template/register_agree')}}" class="btn btn-info btn-sm">
										<span class="glyphicon glyphicon-download-alt"></span> @lang('lang.template_sample')
									</a>
								</div>
								<div class="col-xs-12 text-center">
									<span class="alert_required" ng-show="required_file">@lang('lang.field_required')</span>
								</div>			
							</form>
							<div>
								<div class="alert alert-success alert-save-success" role="alert">
									@lang('lang.rg_success_save')
								</div>
								<div class="alert alert-danger alert-save-fail max-height-200-scroll-auto" style="text-align:left;" role="alert">
									@lang('lang.rg_fail_save')
								</div>
							</div>
						</div>

						<!-- Right Button Group -->
						<div class="float-right" style="padding-bottom:25px">
							<a class="btn btn-info btn-sm" ng-href="/register/pending_list_down" ng-show="search.page_type == 1">
								<i class="glyphicon glyphicon-export text-white"></i> @lang('lang.card_export')
							</a>
							<a class="btn btn-info btn-sm" ng-click="show_import_panel = !show_import_panel" ng-show="search.page_type == 1">
								<i class="glyphicon glyphicon-import text-white"></i> @lang('lang.rg_card_review')
							</a>
						</div>
					</div>					

					<!-- Table Contents -->
					<table class="table table-striped">
						<thead>
							<tr>
								<th>@lang('lang.u_servicecard_id')</th>
								<th>@lang('lang.pr_item_name') <img src="{{url('')}}/images/sort.png" alt="sort"></a></th>
								<th>@lang('lang.label_dealer')</th>
								<th>@lang('lang.price_seller')</th>
								<th>@lang('lang.st_machine_code')</th>
								<th>@lang('lang.label_client')</th>
								<th>@lang('lang.date_time')</th>
								<th>@lang('lang.label_table_action')</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-show="list_data.total == 0">
								<td class="text-center" colspan="8">@lang('lang.str_no_data')</td>
							</tr>
							<tr ng-repeat="item in list_data.data">
								<td>{?item.code?}</td>
								<td>{?item.product.name?}</td>
								<td>{?item.dealer.name?}</td>
								<td>{?item.seller.name?}</td>
								<td>{?item.machine_code?}</td>
								<td>{?item.customer.name?} - {?item.customer.link?}</td>
								<td>{?item.register_datetime?}</td>
								<td>
									<a class="btn btn-xs btn-primary stockservicedownload" ng-href="#!/register/card/agree/view_item/{?item.id?}">
										@lang('lang.ov_details')
									</a>
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
</div>

<script src="{{url('')}}/js/control.js"></script>