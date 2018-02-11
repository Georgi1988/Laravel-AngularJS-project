<div class="page-title clearfix">
	<div class="pull-left">
		<h1>@lang('lang.pr_service_card_information')</h1>
		<small><a href="#!/price" class="subtitle">< @lang('lang.pr_return')</a></small>
	</div>
</div>

<div class="conter-wrapper col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{?product.name?}</h3>
		</div>
		<div class="panel-body">
			<div class="form-group col-lg-4 col-md-6">
				<div class="col-md-12">
					<img class="img-responsive img-thumbnail" style="width:100%" src="{?product.image_url?}">
				</div>	
			</div>
			<div class="col-lg-4 col-md-6">
				<label class="control-label">@lang('lang.ov_product_code')</label>
					<pre>{?product.code?}</pre>
				<label class="control-label">@lang('lang.pr_item_kind')</label>
					<pre>{?product.typestr_level1?} - {?product.typestr_level2?}</pre>
				<label class="control-label">@lang('lang.od_original_price')</label>
					<pre>{? product.price_sku ?} @lang('lang.label_cn_cunit')</pre>
			</div>
		</div>
		<div class="panel-body">
			<div role="tabpanel">
				<ul class="nav nav-tabs tabs primary-tabs" role="tablist">
					<li role="presentation" class="active" ng-click="set_type(1)">
						<a aria-controls="type1" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.price_per_dealer')</a>
					</li>
					<li role="presentation" class="" ng-click="set_type(2)">
						<a aria-controls="type2" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.price_per_dealerlevel')</a>
					</li>
					<li role="presentation" class="" ng-click="set_type(3)">
						<a aria-controls="type3" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.price_per_search')</a>
					</li>
					<li role="presentation" class="" ng-click="set_type(4)">
						<a aria-controls="type4" role="tab" data-toggle="tab" aria-expanded="true">@lang('lang.price_edit')</a>
					</li>
				</ul>
				<div class="tab-content panel-body">
					<div ng-show="type == 1">
						<button type="button" class="btn btn-default btn-sm marginbottom5" ng-click="toUpDealer(dealer_id)" ng-disabled="dealer_id==1"><span class="glyphicon glyphicon-arrow-up"></span></button>
						<button type="button" class="btn btn-primary btn-sm marginbottom5 float-right" ng-click="onSetting()">@lang('lang.setting')</button>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>
										<input type="checkbox" value="" ng-model="isCheckAll" ng-change="onCheckAll()">
										<!--<div class="checkbox">
											<label>
												<input type="checkbox" value="" ng-model="isCheckAll" ng-change="onCheckAll()">
												<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
											</label>
										</div>-->
									</th>
									<th>@lang('lang.sl_dealer_name')</th>
									<th>@lang('lang.price_dealer_level')</th>
									<th>@lang('lang.start day')</th>
									<th>@lang('lang.end day')</th>
									<th>@lang('lang.price_promotional_discount') (%)</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="(index, dealer) in dealers">
									<td>
										<input type="checkbox" value="" ng-model="isCheck[index]" ng-change="onCheck()">
										<!--<div class="checkbox">
											<label>
												<input type="checkbox" value="" ng-model="isCheck[index]" ng-change="onCheck()">
												<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
											</label>
										</div>-->
									</td>
									<td>{? dealer.name ?}</td>
									<td>{? dealer.level ?}</td>
									<td>{? dealer.promotion_start_date ?}</td>
									<td>{? dealer.promotion_end_date ?}</td>
									<td>{? dealer.promotion_price ?}</td>
									<td>
										<button type="button" class="btn btn-default btn-xs" ng-click="toDownDealer(dealer.id)">@lang('lang.price_sub_ordinate')</button>
									</td>
								</tr>
								<tr ng-if="no_data">
									<td colspan="7">@lang('lang.str_no_data')</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div ng-show="type == 2">
						<form id="leveldiscount_form" name="leveldiscount_form" ng-submit="submit_leveldiscount()" method="POST" enctype="multipart/form-data">
							<button type="submit" class="btn btn-primary btn-sm marginbottom5 float-right">@lang('lang.pr_item_save')</button>
							<div>
								<p class="alert_required" ng-show="required_leveldiscount">{? msg_type==0 ? "@lang('lang.price_levelpromotion_require')" : "@lang('lang.price_promotion_dateinput')" ?}</p>
							</div>
							<table class="table table-striped">
								<tbody>
									<tr ng-repeat="(index, dealer) in dealers">
										<td>
											{? dealer.level ?} @lang('lang.price_level_dealer')
										</td>
										<td><input type="number" class="form-control" min="1" max="100" ng-model="dealer.promotion_price" placeholder="@lang('lang.promotion')" /></td>
										<td>(@lang('lang.label_cn_cunit'))</td>
										<td><input type="text" name="searchdatestart{?index?}" class="dateselector form-control" placeholder="@lang('lang.start date')" ng-model="dealer.promotion_start_date" datepicker /></td>
										<td><input type="text" name="searchdateend{?index?}" class="dateselector form-control" placeholder="@lang('lang.end date')" ng-model="dealer.promotion_end_date" datepicker /></td>
									</tr>
								</tbody>
							</table>
						</form>
					</div>

					<div ng-show="type == 3">
						<div class="form-group form-inline">
							<div class="input-group">
								<input class="form-control" type="search" name="keyword" placeholder="@lang('lang.st_dealer_search')" ng-model="search_name" />
								<span class="input-group-btn"><button class="btn btn-default" type="button" ng-click="search()"><span class="glyphicon glyphicon-search"></span></button></span>
							</div>
							<button type="button" class="btn btn-primary float-right" ng-click="onSetting()">@lang('lang.setting')</button>
						</div>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th>
										<input type="checkbox" value="" ng-model="isCheckAll" ng-change="onCheckAll()">
										<!-- <div class="checkbox">
											<label>
												<input type="checkbox" value="" ng-model="isCheckAll" ng-change="onCheckAll()">
												<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
											</label>
										</div> -->
									</th>
									<th>@lang('lang.sl_dealer_name')</th>
									<th>@lang('lang.price_dealer_level')</th>
									<th>@lang('lang.start day')</th>
									<th>@lang('lang.end day')</th>
									<th>@lang('lang.price_promotional_discount') (%)</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="(index, dealer) in dealers">
									<td>
										<div class="checkbox">
											<label>
												<input type="checkbox" value="" ng-model="isCheck[index]" ng-change="onCheck()">
												<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
											</label>
										</div>
									</td>
									<td>{? dealer.name ?}</td>
									<td>{? dealer.level ?}</td>
									<td>{? dealer.promotion_start_date ?}</td>
									<td>{? dealer.promotion_end_date ?}</td>
									<td>{? dealer.promotion_price ?}</td>
								</tr>
								<tr class="text-center" ng-if="no_data">
									<td colspan="6">@lang('lang.str_no_data')</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div ng-show="type == 4">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>@lang('lang.sl_dealer_name')</th>
									<th>@lang('lang.start day')</th>
									<th>@lang('lang.end day')</th>
									<th>@lang('lang.price_promotional_discount') (%)</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="item in list_data.data">
									<td>{? item.dealer_id==1 ? item.level + " @lang('lang.price_level_dealer')" : item.dealer.name ?}</td>
									<td>{? item.promotion_start_date ?}</td>
									<td>{? item.promotion_end_date ?}</td>
									<td>{? item.promotion_price ?}</td>
									<td>
										<button type="button" class="btn btn-default btn-sm" ng-click="onEdit(item)">@lang('lang.price_edit')</button>
										<button type="button" class="btn btn-default btn-sm" ng-click="onRemove(item)">@lang('lang.price_remove')</button>
									</td>
								</tr>
								<tr class="text-center" ng-if="no_data">
									<td colspan="5">@lang('lang.str_no_data')</td>
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
</div>

<div id="discountinput" class="message-dlg" title="@lang('lang.price_promotion_text')">
	<form id="discountinput_form" name="discountinput_form" ng-submit="submit_discount()" method="POST" enctype="multipart/form-data">
		<div class="block"></div>
		<p class="alert_required" ng-show="required_discount">@lang('lang.price_promotion_dateinput')</p>
		<div class="searchlayout marginbottomtop10">
			<input type="text" name="dlgsearchdatestart" id="dlgsearchdatestart" class="searchdatestart" placeholder="@lang('lang.start date')" ng-model="dlg_promotion_start_date" required />
		</div>
		<div class="searchlayout marginbottomtop10">
			<input type="text" name="dlgsearchdateend" id="dlgsearchdateend" class="searchdateend" placeholder="@lang('lang.end date')" ng-model="dlg_promotion_end_date" required />
		</div>
		<div class="block">
			<div class="searchlayout margintop15 text-right v-align-top">
				@lang('lang.promotion'):
			</div>
			<div class="searchlayout marginbottomtop10">
				<input type="number" class="generalinput" min="1" max="100" ng-model="dlg_promotion_price" required /> (%)
			</div>
		</div>
		<div class="alert alert-success" style="display: none;">
			@lang('lang.rg_success_save')
		</div>
		<div class="alert alert-danger" style="display: none;">
			@lang('lang.rg_fail_save')
		</div>
		<div class="block textcenter">
			<button type="submit" class="importbtn ui-button" ng-disabled="ajax_loading">@lang('lang.pr_item_save')<span class="loading_icons" ng-show="ajax_loading">&nbsp;&nbsp;<img src="./images/loading_now.gif"></span></button>
			<a class="cancelbtn ui-button" ng-click="onCancel()">@lang('lang.cancel')</a>
		</div>
		<div class="block"></div>
	</form>
</div>

<script src="{{url('')}}/js/control.js"></script>
	
