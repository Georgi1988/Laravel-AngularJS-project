	<div class="block">
		<span class="subtitle">@lang('lang.label_order')</span>
	</div>
	<!--<div class="block">
		<div class="searchlayout paddingtop15">
			<input type="search" name="keyword" placeholder="@lang('lang.od_search_name')" onsearch="angular.element(this).scope().search_keyword(this)" />
		</div>
		<div class="clearboth"></div>
		<div class="borderbottomblue bgwhite"></div>
	</div>-->
	<div class="block">
		<div class="left ordermenu">
			<a class="inlineblock stockmenu" ng-click="search_type(1)" ng-class="{bgblue:search.type === 1,fontcolorwhite:search.type === 1,bgwhite:search.type !== 1,fontcolorblue:search.type !== 1}">
				@lang('lang.od_order_pending')
			</a><a class="inlineblock stockmenu" ng-click="search_type(2)" ng-class="{bgblue:search.type === 2,fontcolorwhite:search.type === 2,bgwhite:search.type !== 2,fontcolorblue:search.type !== 2}">
				@lang('lang.od_order_sold')
			</a><a class="inlineblock stockmenu borderblue" ng-click="search_type(3)" ng-class="{bgblue:search.type === 3,fontcolorwhite:search.type === 3,bgwhite:search.type !== 3,fontcolorblue:search.type !== 3}">
				@lang('lang.od_order_returned')
			</a><a class="inlineblock stockmenu borderblue" ng-click="search_type(5)" ng-class="{bgblue:search.type === 5,fontcolorwhite:search.type === 5,bgwhite:search.type !== 5,fontcolorblue:search.type !== 5}">
				@lang('lang.all')
			</a>
		</div>
		<div class="right searchlayout paddingtop15">
			<input type="search" name="keyword" placeholder="@lang('lang.od_search_name')" onsearch="angular.element(this).scope().search_keyword(this)" />
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="paddingtop30"></div>
	<!--<div class="seperatorline"></div>
	<div class="paddingtop30"></div>
	<div class="block">
		<div class="right">
			<a class="periodselected period" ng-click="order_export()">@lang('lang.od_export')</a>
			<a class="periodselected period" ng-click="order_import()">@lang('lang.od_import')</a>
		</div>
		<div class="clearboth"></div>
	</div>-->
	<div class="block backgroundwhite">
		<table class="table">
			<thead>
				<tr>
					<th>@lang('lang.od_order_no')</th>
					<th>@lang('lang.od_product')</th>
					<th>@lang('lang.gen_mcard_type')</th>
					<th>@lang('lang.od_quantity')</th>
					<th>@lang('lang.sta_dealer_name')</th>
					<th ng-show="search.type==1">@lang('lang.od_status')</th>
					<th ng-show="search.type==2">@lang('lang.od_effective_time')</th>
					<th ng-show="search.type==3">@lang('lang.od_return_success_time')</th>
					<th>@lang('lang.od_agree_status')</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list_data.data" ng-class="{sub_badge:item.badge == 1}">
					<td>{?item.code?}</td>
					<td>{?item.product.name?} <span class="color-gray" ng-show="item.product_count > 1">  @lang('lang.others') {?item.product_count - 1?}@lang('lang.item_count')</span></td>
					<td>
						<span ng-if="item.card_type==0&&item.card_subtype==1">@lang('lang.st_virtual_sp_card')</span>
						<span ng-if="item.card_type==0&&item.card_subtype==0">@lang('lang.st_virtual_card')</span>
						<span ng-if="item.card_type==1">@lang('lang.st_physical_card')</span>
					</td>
					<td>{?item.order_count?}</td>
					<td>{?item.src_dealer.name?}</td>
					<td ng-show="search.type==1&&item.status==0"><strong class="fontcolornavyblue">@lang('lang.od_purchased')</strong></td>
					<td ng-show="search.type==1&&item.status==1"><strong class="fontcolorgreen">@lang('lang.sta_return_order')</strong></td>
					<td ng-show="search.type==2">{?item.valid_period?}</td>
					<td ng-show="search.type==3">{?item.updated_at?}</td>
					<td ng-show="item.agree==0"><strong class="fontcolornavyblue">@lang('lang.od_pending_approval')</strong></td>
					<td ng-show="item.agree==1"><strong class="fontcolorgreen">@lang('lang.od_agree')</strong></td>
					<td ng-show="item.agree==2"><strong class="fontcolorgray">@lang('lang.od_refusal')</strong></td>
					<td><a href="#!order/view/{?item.id?}" class="stockservicebtn stockservicedownload">@lang('lang.ov_details')</a></td>
				</tr>
				<tr ng-show="no_data">
					<td colspan="7">@lang('lang.str_no_data')</td>
				</tr>
			</tbody>
		</table>
		<div class="pagenav_block" ng-show="list_data.total > 0">
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
	<div class="block"></div>
	<!-- import dialog html -->
	<div id="orderimport" title="@lang('lang.od_import_title')">
		<form id="orderimport_form" name="orderimport_form" ng-submit="submit_import()" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="_token" class="csrf_token" value="<?php echo csrf_token() ?>">
			<div class="block"></div>
			<div class="block width85">
				<div class="col-xs-3 paddingtop10 text-right">
					@lang('lang.ov_select_the_import_file')
				</div>
				<div class="col-xs-9">
					<div class="form-group">
						<input type="file" class="input-ghost" style="visibility:hidden; height:0" name="orderimport_file"  accept=".xls, .xlsx">
						<div class="input-group input-file" name="Fichier1">
							<input type="text" class="form-control" placeholder="@lang('lang.choose_file')" style="cursor: pointer;">
							<span class="input-group-addon">
								<a class="file_choose">@lang('lang.select')</a>
							</span>
						</div>
					</div>
				</div>
				<span class="alert_required" ng-show="required_file">@lang('lang.field_required')</span>
				<script>
					$(function() {
						bs_input_file();
					});
				</script>
				<!--<label>
					@lang('lang.ov_select_the_import_file') : 
					<input type="file" name="orderimport_file" accept=".xls, .xlsx" required />
				</label>-->
				<p class="textcenter lineheight200">@lang('lang.od_import_msg')</p>
			</div>
			<div class="block textcenter">
				<input type="submit" class="importbtn ui-button" value="@lang('lang.ov_import')">
				<a class="cancelbtn ui-button" onclick="$('#orderimport').dialog('close');">@lang('lang.cancel')</a>
			</div>
			<div class="block"></div>
		</form>
	</div>

	<!-- export dialog html -->
	<div id="orderexport" title="@lang('lang.od_export_title')">
		<div class="block"></div>
		<div class="block width85">
			<!-- <span class="fontcolor777 fontsize1p5">已选择服务卡20000张</span>-->
		</div>
		<form id="orderexport_form" ng-submit="submit_export()" method="POST" enctype="multipart/form-data">
			<div class="block width85">
				<label>@lang('lang.email') : <input type="email" name="" ng-model="sendemail"  required /></label>
				<p class="lineheight200"><span class="fontcolorred paddingleft50">@lang('lang.od_export_msg')</span></p>
			</div>
			<div class="block textcenter">
				<input type="submit" class="importbtn ui-button" value="@lang('lang.st_download_servicecard')">
				<a class="cancelbtn ui-button" onclick="$('#orderexport').dialog('close');">@lang('lang.cancel')</a>
			</div>
		</form>
		<div class="block"></div>
	</div>
	
	<script src="{{url('')}}/js/control.js"></script>